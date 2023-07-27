<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'=>'required|max:255',
            'password' => 'required|min:8',
        ];
    }
    public function messages()
    {
        return [
           'email.required' => ' Email không được bỏ trống',
           'email.max' => ' Email không được quá 255 ký tự',
           'password.required' => 'Mật khẩu không được bỏ trống',
           'password.min' => 'Mật khẩu không được ít hơn 8 ký tự',
        ];
    }
}
