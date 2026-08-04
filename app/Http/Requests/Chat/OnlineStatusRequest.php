<?php

namespace App\Http\Requests\Chat;

use Illuminate\Foundation\Http\FormRequest;

class OnlineStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'conversation_id' => ['sometimes', 'nullable', 'integer', 'exists:conversations,id'],
            'is_online' => ['required', 'boolean'],
        ];
    }
}
