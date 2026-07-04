<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class WalletTransferRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required|min:8|max:64',
            'amount' => 'required|numeric|min:1.00',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'The recipient email is required.',
            'email.email' => 'The recipient email must be a valid email address.',
            'password.required' => 'The payment password is required.',
            'password.min' => 'The payment password must be at least 8 characters.',
            'password.max' => 'The payment password may not be greater than 64 characters.',
            'amount.required' => 'The transfer amount is required.',
            'amount.numeric' => 'The transfer amount must be a number.',
            'amount.min' => 'The transfer amount must be greater than or equal to 1.00.'
        ];
    }
}
