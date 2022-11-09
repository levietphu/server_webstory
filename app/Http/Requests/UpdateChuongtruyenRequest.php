<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateChuongtruyenRequest extends FormRequest
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
            'content'=>'required',
        ];
    }
    public function messages()
    {
        return [
           'name_chapter.required' => 'Thể loại không được bỏ trống',
           'name_chapter.max' => 'Thể loại không quá 255 ký tự',
           'slug.max' => 'Slug không quá 255 ký tự',
            'slug.required' => 'Slug không được bỏ trống',
            'content.required' => 'Nội dung không được bỏ trống',
            'chapter_number.required' => 'Số chương không được bỏ trống',
        ];
    }
}
