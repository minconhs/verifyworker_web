<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class SettingsPasswordChangeRequest extends FormRequest
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
            'old_password' => 'required|min:8|max:64',
            'password' => 'required|min:8|max:64|confirmed',
            'password_confirmation' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'old_password.required' => 'Old password is required',
            'old_password.min' => 'Old password must be at least 8 characters',
            'old_password.max' => 'Old password must not exceed 64 characters',
            'password.required' => 'New password is required',
            'password.min' => 'New password must be at least 8 characters',
            'password.max' => 'New password must not exceed 64 characters',
            'password.confirmed' => 'New password confirmation does not match',
            'password_confirmation.required' => 'New password confirmation is required',
        ];
    }
}
