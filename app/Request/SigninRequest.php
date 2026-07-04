<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class SigninRequest extends FormRequest
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
            'username' => 'required|min:8|max:64',
            'password' => 'required|min:8|max:64',
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => 'Username is required',
            'username.min' => 'Username must be at least 8 characters',
            'username.max' => 'Username must not exceed 64 characters',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
            'password.max' => 'Password must not exceed 64 characters',
        ];
    }
}
