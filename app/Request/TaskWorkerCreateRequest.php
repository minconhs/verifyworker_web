<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class TaskWorkerCreateRequest extends FormRequest
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
            'task_type' => 'required|string|in:all,simple,high',
        ];
    }

    public function messages(): array
    {
        return [
            'task_type.required' => 'Task type is required.',
            'task_type.string' => 'Task type must be a string.',
            'task_type.in' => 'Task type must be one of the following: all, simple, high.',
        ];
    }
}
