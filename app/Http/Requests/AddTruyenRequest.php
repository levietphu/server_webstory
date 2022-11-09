<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddTruyenRequest extends FormRequest
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
            'slug'=>'required|max:255|unique:truyens',
            'introduce'=>'required',
            'image'=>'required',
            'nguon'=>'max:255',
            'status'=>'required',
        ];
    }
    public function messages()
    {
        return [
           'name.required' => 'Thể loại không được bỏ trống',
           'name.max' => 'Thể loại không quá 255 ký tự',
           'slug.max' => 'Slug không quá 255 ký tự',
            'slug.required' => 'Slug không được bỏ trống',
            'slug.unique' => 'Slug không được trùng',
            'introduce.required' => 'Giới thiệu không được bỏ trống',
            'image.required' => 'Ảnh không được bỏ trống',
            'nguon.max' => 'Nguồn không được quá 255 ký tự',
            'status.required' => 'Trạng thái không được bỏ trống',
        ];
    }
}
