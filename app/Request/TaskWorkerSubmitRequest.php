<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class TaskWorkerSubmitRequest extends FormRequest
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
            'order_no' => 'required|max:32',
            'result'   => 'required|max:1024',
        ];
    }

    public function messages(): array
    {
        return [
            'order_no.required' => 'Order number is required.',
            'order_no.max' => 'Order number must not exceed 32 characters.',
            'result.required' => 'Result is required',
            'result.max' => 'Result must not exceed 1024 characters',
        ];
    }
}
