<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'postal_code' => ['required', 'string', 'size:8', 'regex:/^\d{3}-\d{4}$/'],
            'address' => ['required', 'string'],
            'building' => ['nullable', 'string'],
        ];
    }
    public function messages(): array
    {
        return [
            'postal_code.required' => '郵便番号は入力必須です',
            'postal_code.size' => '郵便番号はハイフンを含めて8文字で入力してください',
            'postal_code.regex' => '郵便番号は「000-0000」の形式で入力してください',
            'address.required' => '住所は入力必須です',
        ];
    }
}