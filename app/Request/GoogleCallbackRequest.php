<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class GoogleCallbackRequest extends FormRequest
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
            'code' => 'required|max:255',
            'state' => 'required|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Code is required',
            'code.max' => 'Code must not exceed 255 characters',
            'state.required' => 'State is required',
            'state.max' => 'State must not exceed 255 characters',
        ];
    }
}
