<?php

namespace App\Http\Requests;

final class CommentRequest extends DocumentationBasedRequest
{
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'delete_password' => ['nullable', 'present', 'string', 'max:255'],
            'content' => ['required', 'max:4096'],
        ];

        return $rules;
    }
}
