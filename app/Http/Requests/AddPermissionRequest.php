<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddPermissionRequest extends FormRequest
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
            'name_per'=>'required',
            'slug'=>'required|max:255|unique:permissions',
            'status'=>'required',
        ];
    }
    public function messages()
    {
        return [
           'name_per.required' => 'Tên quyền không được bỏ trống',
           'slug.max' => 'Slug không quá 255 ký tự',
            'slug.required' => 'Slug không được bỏ trống',
            'slug.unique' => 'Slug không được trùng',
            'status.required' => 'Trạng thái không được bỏ trống',
        ];
    }
}
