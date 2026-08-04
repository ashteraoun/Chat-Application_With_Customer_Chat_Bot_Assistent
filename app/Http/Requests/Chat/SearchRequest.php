<?php

namespace App\Http\Requests\Chat;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'query' => ['required', 'string', 'min:1'],
            'type' => ['required', Rule::in(['conversations', 'messages'])],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
            'order_by' => ['sometimes', 'string', 'in:created_at,title,last_message_at,updated_at'],
            'order_direction' => ['sometimes', Rule::in(['asc', 'desc'])],
        ];
    }
}
