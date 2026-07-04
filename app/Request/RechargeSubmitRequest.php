<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class RechargeSubmitRequest extends FormRequest
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
            'amount' => 'required|numeric',
            'method' => 'required|string|in:paypal,minx',
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => 'Amount is required',
            'amount.numeric' => 'Amount must be a number',
            'method.required' => 'Method is required',
            'method.in' => 'Method must be either minx or paypal',
        ];
    }
}
