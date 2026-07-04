<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class SignupRequest extends FormRequest
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
            'email' => 'required|email|max:64',
            'password' => 'required|min:8|max:64|confirmed',
            'password_confirmation' => 'required',
            'referral' => 'sometimes|max:20',
            'terms' => 'required|accepted',
        ];
    }

    public function messages(): array
    {
            return [
                'username.required' => 'Username is required',
                'username.min' => 'Username must be at least 8 characters',
                'username.max' => 'Username must not exceed 64 characters',
                'email.required' => 'Email is required',
                'email.email' => 'Email must be a valid email address',
                'email.max' => 'Email must not exceed 64 characters',
                'password.required' => 'Password is required',
                'password.min' => 'Password must be at least 8 characters',
                'password.max' => 'Password must not exceed 64 characters',
                'password.confirmed' => 'Password confirmation does not match',
                'password_confirmation.required' => 'Password confirmation is required',
                'referral.max' => 'Invite code must not exceed 20 characters',
                'terms.accepted' => 'You must accept the terms and conditions',
            ];
    }
}
