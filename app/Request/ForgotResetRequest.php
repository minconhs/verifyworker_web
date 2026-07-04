<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class ForgotResetRequest extends FormRequest
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
            'password' => 'required|min:8|max:64|confirmed',
            'password_confirmation' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
            'password.max' => 'Password must not exceed 64 characters',
            'password.confirmed' => 'Password confirmation does not match',
            'password_confirmation.required' => 'Password confirmation is required',
        ];
    }
}
