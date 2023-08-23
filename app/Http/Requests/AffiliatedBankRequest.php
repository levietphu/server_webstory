<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AffiliatedBankRequest extends FormRequest
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
            'name_bank'=>'required|max:255',
            'slug'=>'required|max:255|unique:affiliated_banks',
            "image" => 'required',
            "stk" => 'required',
            "owner_account" => 'required',
        ];
    }
    public function messages()
    {
        return [
           'name_bank.required' => 'Tên quảng cáo không được bỏ trống',
           'name_bank.max' => 'Tên quảng cáo không quá 255 ký tự',
           'slug.max' => 'Slug không quá 255 ký tự',
            'slug.required' => 'Slug không được bỏ trống',
            'slug.unique' => 'Slug không được trùng',
            'image.required' => 'Ảnh không được bỏ trống',
            'stk.required' => 'Số tk không được bỏ trống',
            'owner_account.required' => 'Chủ tk không được bỏ trống',
        ];
    }
}
