<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class VerifyTokenRequest extends FormRequest
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
            'token' => 'required|size:32',
        ];
    }

    public function messages(): array
    {
        return [
            'token.required' => 'Activation token is required.',
            'token.size' => 'Activation token must be exactly 32 characters.',
        ];
    }
}
