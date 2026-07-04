<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class ProfileChangeRequest extends FormRequest
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
            'first_name'   => 'required|string|min:1|max:64',
            'last_name'    => 'required|string|min:1|max:64',
            'country'      => 'sometimes|required|string|size:2',              // ISO 3166-1 两位国家码 US/CN/GB
            'state'        => 'sometimes|required|string|max:128',             // 州/省名称有空格，不能用 alpha_dash
            'city'         => 'sometimes|required|string|max:128',             // 同上
            'postal_code'  => 'sometimes|required|string|max:16',              // 各国格式不同，只限长度
            'address_line1'=> 'sometimes|required|string|max:255',             // 地址有空格/逗号/符号
            'address_line2'=> 'sometimes|nullable|string|max:255',             // 选填，用 nullable
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required',
            'first_name.string'   => 'First name must be a string',
            'first_name.min'      => 'First name must be at least 1 character',
            'first_name.max'      => 'First name must not exceed 64 characters',
            'last_name.required'  => 'Last name is required',
            'last_name.string'    => 'Last name must be a string',
            'last_name.min'       => 'Last name must be at least 1 character',
            'last_name.max'       => 'Last name must not exceed 64 characters',
            'country.required'    => 'Country code is required',
            'country.string'      => 'Country code must be a string',
            'country.size'        => 'Country code must be exactly 2 characters',
            'state.required'      => 'State/Province is required',
            'state.string'        => 'State/Province must be a string',
            'state.max'           => 'State/Province must not exceed 128 characters',
            'city.required'       => 'City is required',
            'city.string'         => 'City must be a string',
            'city.max'            => 'City must not exceed 128 characters',
            'postal_code.required'=> 'Postal code is required',
            'postal_code.string'  => 'Postal code must be a string',
            'postal_code.max'     => 'Postal code must not exceed 16 characters',
            'address_line1.required' => 'Address line 1 is required',
            'address_line1.string'   => 'Address line 1 must be a string',
            'address_line1.max'      => 'Address line 1 must not exceed 255 characters',
            'address_line2.string'   => 'Address line 2 must be a string',
            'address_line2.max'      => 'Address line 2 must not exceed 255 characters',
        ];
    }
}
