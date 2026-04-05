<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            //プロフィール画像
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png', 'max:2048'],
            //ユーザー名
            'name' => ['required', 'string', 'max:20'],
            //郵便番号
            'postal_code' => ['required', 'string', 'regex:/^\d{3}-\d{4}$/'],
            //住所
            'address' => ['required', 'string', 'max:255'],
            //建物名
            'building' => ['nullable', 'string', 'max:255'],
        ];
    }
    
    public function messages(): array
    {
        return [
            //プロフィール画像
            'profile_image.image' => '指定されたファイルが画像ではありません',
            'profile_image.mimes' => '画像の拡張子は.jpegまたは.pngを指定してください',
            //ユーザー名
            'name.required' => 'お名前を入力してください',
            'name.max' => 'お名前は20文字以内で入力してください',
            //郵便番号
            'postal_code.required' => '郵便番号を入力してください',
            'postal_code.regex' => '郵便番号はハイフンありの8文字で入力してください',
            //住所
            'address.required' => '住所を入力してください',
        ];
    }
}