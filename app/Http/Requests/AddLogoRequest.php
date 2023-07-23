<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddLogoRequest extends FormRequest
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
            'slug'=>'required|max:255|unique:configs',
            "value" => 'required',
            'status'=>'required',
        ];
    }
    public function messages()
    {
        return [
           'name.required' => 'Tên logo không được bỏ trống',
           'name.max' => 'Tên logo không quá 255 ký tự',
           'slug.max' => 'Slug không quá 255 ký tự',
            'slug.required' => 'Slug không được bỏ trống',
            'slug.unique' => 'Slug không được trùng',
            'value.required' => 'Ảnh không được bỏ trống',
            'status.required' => 'Trạng thái không được bỏ trống',
        ];
    }
}
