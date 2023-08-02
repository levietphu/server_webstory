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
            'email'=>'required|max:255|unique:users',
            'name'=>'required|min:5|max:20|unique:users',
            'password' => 'required|min:8',
        ];
    }
    public function messages()
    {
        return [
           'email.required' => 'Email không được bỏ trống',
           'email.max' => 'Email không được quá 255 ký tự',
           'email.unique' => 'email đã tồn tại',
           'name.required' => 'Tên người dùng không được bỏ trống',
           'name.max' => 'Tên người dùng không được quá 255 ký tự',
           'email.unique' => 'Tên người dùng đã tồn tại',
           'password.required' => 'Mật khẩu không được bỏ trống',
           'password.min' => 'Mật khẩu không được ít hơn 8 ký tự',
        ];
    }
}
