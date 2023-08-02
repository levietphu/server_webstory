<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddRoleRequest extends FormRequest
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
            'name'=>'required|max:255',
            'status'=>'required',
            "id_per" => "required"
        ];
    }
    public function messages()
    {
        return [
           'name.required' => 'Tên vai trò không được bỏ trống',
           'name.max' => 'Tên vai trò không được quá 255 ký tự',
            'status.required' => 'Trạng thái không được bỏ trống',
            'id_per.required' => 'Quyền không được bỏ trống',
        ];
    }
}
