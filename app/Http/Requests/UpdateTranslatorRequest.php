<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTranslatorRequest extends FormRequest
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
            'slug'=>'required|max:255|unique:translators,slug,'.$this->id,
            'status'=>'required',
            "id_user" =>"required"
        ];
    }
    public function messages()
    {
        return [
           'name.required' => 'Tên dịch giả không được bỏ trống',
           'name.max' => 'Tên dịch giả không quá 255 ký tự',
           'slug.max' => 'Slug không quá 255 ký tự',
            'slug.required' => 'Slug không được bỏ trống',
            'slug.unique' => 'Slug không được trùng',
            'status.required' => 'Trạng thái không được bỏ trống',
            'id_user.required' => 'user thêm không được bỏ trống',
        ];
    }
}
