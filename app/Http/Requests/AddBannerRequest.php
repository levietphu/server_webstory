<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddBannerRequest extends FormRequest
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
            'image' => 'required',
            "status" => "required",
            "id_truyen" => "required",
        ];
    }
    public function messages()
    {
        return [
           'name.required' => 'Tên Banner không được bỏ trống',
           'name.max' => 'Tên Banner không vượt quá 255 ký tự',
           'image.required' => 'Ảnh không được bỏ trống',

           "status.required" => "Trạng thái không được bỏ trống",
           "id_truyen.required" => "Truyện không được bỏ trống"
        ];
    }
}
