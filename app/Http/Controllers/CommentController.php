<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Requests\DocumentationBasedRequest;
use App\Models\Comment;
use App\Models\CommentReactionsCounter;
use App\Utils\Fingerprint;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

final class CommentController
{
    public function index(DocumentationBasedRequest $request): View
    {
        $loader = $request->getDocLoader();

        return view('comments.index', [
            'pathInfo' => $loader->pathInfo,
            'page' => $loader->getPage(),
            'comments' => Comment
                ::byPathInfo($loader->pathInfo)
                    ->whereApproved()
                    ->get(),
            'success' => $request->session()->get('success'),
        ]);
    }

    public function form(DocumentationBasedRequest $request): View
    {
        $loader = $request->getDocLoader();

        return view('comments.form', [
            'pathInfo' => $loader->pathInfo,
            'page' => $loader->getPage(),
        ]);
    }

    public function store(CommentRequest $request): RedirectResponse
    {
        $comment = new Comment();
        $comment->fromPathInfo($request->getDocPathInfo());
        $comment->commenter_fingerprint = Fingerprint::fromRequest($request);
        $comment->name = $request->input('name');
        $comment->delete_password = $request->input('delete_password')
            ? Hash::make($request->input('delete_password'))
            : '';
        $comment->content = $request->input('content');
        $comment->reactions_counter = new CommentReactionsCounter();

        $comment->is_approved = false;
        $comment->save();

        return Redirect::route('docs.comments.index', $request->getDocPathInfo()->toRouteParameters())->with('success', __('Comment submitted. In order to prevent SPAM, we need to manually approve it before it is visible.'));
    }
}
