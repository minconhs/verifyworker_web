<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class SettingsNoticeRequest extends FormRequest
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
            'channel_email' => 'required|boolean',
            'notice_security' => 'required|boolean',
            'notice_product' => 'required|boolean',
            'notice_policy' => 'required|boolean',
            'notice_event' => 'required|boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'channel_email.required' => 'Email notification channel is required.',
            'channel_email.boolean' => 'Email notification channel must be a boolean value.',
            'notice_security.required' => 'Security notifications setting is required.',
            'notice_security.boolean' => 'Security notifications setting must be a boolean value.',
            'notice_product.required' => 'Product notifications setting is required.',
            'notice_product.boolean' => 'Product notifications setting must be a boolean value.',
            'notice_policy.required' => 'Policy notifications setting is required.',
            'notice_policy.boolean' => 'Policy notifications setting must be a boolean value.',
            'notice_event.required' => 'Event notifications setting is required.',
            'notice_event.boolean' => 'Event notifications setting must be a boolean value.',
        ];
    }
}
