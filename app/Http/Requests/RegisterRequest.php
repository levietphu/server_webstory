<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email'=>'required',
            'name'=>'required|min:5|max:20',
            'password' => 'required|min:8',
            'repassword' => 'required_with:password|same:password|min:8'
        ];
    }
    public function messages()
    {
        return [
           'email.required' => 'Tài khoản email không được bỏ trống',
           'email.max' => 'Tài khoản email không được quá 255 ký tự',
           'name.required' => 'Tên người dùng không được bỏ trống',
           'name.max' => 'Tên người dùng không được quá 255 ký tự',
           'password.required' => 'Mật khẩu không được bỏ trống',
           'password.min' => 'Mật khẩu không được ít hơn 8 ký tự',
           'repassword.required_with' => 'Không được bỏ trống',
           'repassword.same' => 'Phải trùng mật khẩu',
           'repassword.min' => 'Không được ít hơn 8 ký tự',
        ];
    }
}
