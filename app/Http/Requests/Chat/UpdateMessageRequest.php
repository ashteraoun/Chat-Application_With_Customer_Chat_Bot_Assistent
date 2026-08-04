<?php

namespace App\Http\Requests\Chat;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'body' => ['sometimes', 'nullable', 'string'],
            'type' => ['sometimes', Rule::in(['text', 'image', 'file', 'system'])],
            'metadata' => ['sometimes', 'nullable', 'array'],
        ];
    }
}
