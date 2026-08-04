<?php

namespace App\Http\Requests\Chat;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'body' => ['nullable', 'string'],
            'type' => ['required', Rule::in(['text', 'image', 'file', 'system'])],
            'metadata' => ['nullable', 'array'],
            'attachments' => ['nullable', 'array'],
            'attachments.*.filename' => ['required_with:attachments', 'string', 'max:255'],
            'attachments.*.content_type' => ['required_with:attachments', 'string', 'max:100'],
            'attachments.*.size' => ['required_with:attachments', 'integer', 'min:0'],
            'attachments.*.url' => ['required_with:attachments', 'string', 'max:1024'],
        ];
    }

    public function prepareForValidation(): void
    {
        if ($this->type === 'text' && $this->filled('body') === false) {
            $this->merge(['body' => null]);
        }
    }
}
