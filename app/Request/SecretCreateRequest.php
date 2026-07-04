<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class SecretCreateRequest extends FormRequest
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
            'hook_url' => 'required|url|max:128',
            'white_ip' => 'sometimes|ipv4',
            'remark' => 'sometimes|max:32|alpha_dash:ascii'
        ];
    }

    public function messages(): array
    {
        return [
            'hook_url.required' => 'Hook URL is required.',
            'hook_url.url' => 'Hook URL must be a valid URL.',
            'hook_url.max' => 'Hook URL must not exceed 128 characters.',
            'white_ip.ipv4' => 'White IP must be a valid IPv4 address.',
            'remark.max' => 'Remark must not exceed 32 characters.',
            'remark.alpha_dash' => 'Remark may only contain letters, numbers, dashes and underscores.'
        ];
    }
}
