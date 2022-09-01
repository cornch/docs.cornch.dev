<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\DocumentationController;
use Illuminate\Support\Facades\Route;
use Spatie\Honeypot\ProtectAgainstSpam;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/', 'index');

Route::get('{locale}/{doc}/{version}/{page}/comments', [CommentController::class, 'index'])
    ->name('docs.comments.index')
    ->where('doc', 'laravel') // @TODO: support more docs
    ->where('page', '[\w\-_/]+?');

Route::get('{locale}/{doc}/{version}/{page}/comments/new', [CommentController::class, 'form'])
    ->name('docs.comments.form')
    ->where('doc', 'laravel') // @TODO: support more docs
    ->where('page', '[\w\-_/]+?');

Route::post('{locale}/{doc}/{version}/{page}/comments', [CommentController::class, 'store'])
    ->name('docs.comments.store')
    ->middleware([ProtectAgainstSpam::class])
    ->where('doc', 'laravel') // @TODO: support more docs
    ->where('page', '[\w\-_/]+?');

Route::get('{locale}/{doc}/{version}/{page}', DocumentationController::class)
    ->name('docs.show')
    ->where('doc', 'laravel') // @TODO: support more docs
    ->where('page', '[\w\-_/]+?');
