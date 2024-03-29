<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuyManyChapterRequest extends FormRequest
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
            'id_user'=>'required',
            'id_truyen'=>'required',
            "toChapter" => 'required',
            'fromChapter'=>'required',
        ];
    }
    public function messages()
    {
        return [
           'id_user.required' => 'Vui lòng đăng nhập',
           'id_truyen.required' => 'Truyện không được trống',
           'toChapter.required' => 'Từ chương không được trống',
           'fromChapter.required' => 'Đến chương không được trống',
           
        ];
    }
}
