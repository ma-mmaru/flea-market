<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
            'payment_method' => ['required', 'in:card,konbini'],
            'shipping_postal_code' => ['required', 'string', 'max:8'],
            'shipping_address' => ['required', 'string', 'max:255'],
            'shipping_building' => ['nullable', 'string', 'max:255'],
        ];
    }
    public function messages(): array
    {
        return [
            'payment_method.required' => '支払い方法を選択してください',
            'shipping_postal_code.required' => '配送先住所を設定してください',
            'shipping_address.required' => '配送先住所を設定してください',
        ];
    }
}