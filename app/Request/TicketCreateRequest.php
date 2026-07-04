<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class TicketCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'subject' => 'required|string|max:100',
            'description' => 'required|string|max:1000',
            'category' => 'required|in:general,technical,billing,account,other',
            'priority' => 'required|in:low,medium,high'
        ];
    }

    public function messages(): array
    {
        return [
            'subject.required' => 'The subject field is required.',
            'subject.string' => 'The subject must be a string.',
            'subject.max' => 'The subject may not be greater than 100 characters.',
            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description may not be greater than 1000 characters.',
            'category.required' => 'The category field is required.',
            'category.in' => 'The category must be one of the following: general, technical, billing, account, other.',
            'priority.required' => 'The priority field is required.',
            'priority.in' => 'The priority must be one of the following: low, medium, high.'
        ];
    }
}
