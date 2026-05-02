<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'name' => ['required', 'string',],
            'description' => ['required', 'string', 'max:255'],
            'image_url' => ['required', 'image', 'mimes:jpeg,png', 'max:10240'],
            'categories' => ['required', 'array', 'min:1'],
            'condition' => ['required', 'string'],
            'price' => ['required', 'integer', 'min:0'],
        ];
    }
    public function attributes(): array
    {
        return [
            'name' => '商品名',
            'description' => '商品の説明',
            'image_url' => '商品画像',
            'categories' => 'カテゴリー',
            'condition' => '商品の状態',
            'price' => '販売価格',
        ];
    }
    public function messages(): array
    {
        return [
            'required' => ':attributeは入力必須です。',
            'max' => ':attributeは:max文字以内で入力してください。',
            'image' => ':attributeは画像ファイルを選択してください。',
            'mimes' => ':attributeは.jpegまたは.png形式のみアップロード可能です。',
            'array' => ':attributeを選択してください。',
            'integer' => ':attributeは数値で入力してください。',
            'min' => ':attributeは:min円以上に設定してください。',
        ];
    }
}