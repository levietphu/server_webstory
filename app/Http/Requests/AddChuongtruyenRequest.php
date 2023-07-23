<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddChuongtruyenRequest extends FormRequest
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
            'name_chapter'=>'required|max:255',
            'chapter_number'=>'required|max:255',
            'slug'=>'required|max:255',
            "coin"=>"required",
            'content'=>'required',
        ];
    }
    public function messages()
    {
        return [
           'name_chapter.required' => 'Tên chương không được bỏ trống',
           'name_chapter.max' => 'Tên chương không quá 255 ký tự',
           'slug.max' => 'Slug không quá 255 ký tự',
            'slug.required' => 'Slug không được bỏ trống',
            'content.required' => 'Nội dung không được bỏ trống',
            'coin.required' => 'Số tiền không được bỏ trống',
            'chapter_number.required' => 'Số chương không được bỏ trống',
        ];
    }
}
