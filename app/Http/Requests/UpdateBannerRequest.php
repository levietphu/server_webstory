<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBannerRequest extends FormRequest
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
            'image' => 'required|dimensions:min_width=1300,min_height=450||mimes:jpeg,bmp,png,jpg',
        ];
    }
    public function messages()
    {
        return [
           'name.required' => 'Tên Banner không được bỏ trống',
           'name.max' => 'Tên Banner không vượt quá 255 ký tự',
           'image.required' => 'Ảnh không được bỏ trống',
           'image.dimensions' => 'Ảnh có độ phân giải là 1300 x 450 pixels',
           'image.mimes' => 'Ảnh phải có định dạng jpeg,bmp,png,jpg',
           "status.required" => "Trạng thái không được bỏ trống"
        ];
    }
}
