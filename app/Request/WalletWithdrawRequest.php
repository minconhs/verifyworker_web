<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class WalletWithdrawRequest extends FormRequest
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
            'amount' => 'required|integer|min:1',
            'method' => 'required|in:polygon,paypal',
            'account' => 'required|max:64',
            'password' => 'required|min:8|max:64',
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => 'Amount is required',
            'amount.integer' => 'Amount must be an integer',
            'amount.min' => 'Amount must be at least 1',
            'method.required' => 'Method is required',
            'method.in' => 'Method must be either polygon or paypal',
            'account.required' => 'Account is required',
            'account.max' => 'Account must not exceed 64 characters',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
            'password.max' => 'Password must not exceed 64 characters',
        ];
    }
}
