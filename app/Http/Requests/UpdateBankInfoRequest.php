<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBankInfoRequest extends FormRequest
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
            'owner'=>'required|max:255',
            'slug'=>'required|max:255|unique:bank_infos,slug,'.$this->id,
            "stk" => 'required',
            'type'=>'required',
            'image'=>'required',
        ];
    }
    public function messages()
    {
        return [
           'name_bank.required' => 'Tên ngân hàng không được bỏ trống',
           'name_bank.max' => 'Tên ngân hàng không được quá 255 ký tự',
           'owner.required' => 'Chủ tài khoản không được bỏ trống',
           'owner.max' => 'Chủ tài khoản không được quá 255 ký tự',
           'slug.required' => 'Slug không được bỏ trống',
           'slug.max' => 'Slug không được quá 255 ký tự',
           'slug.unique' => 'Slug không được quá trùng',
           'stk.required' => 'số tài khoản không được bỏ trống',
           'type.required' => 'Kiểu không được bỏ trống',
           'image.required' => 'Ảnh ngân hàng không được bỏ trống',

        ];
    }
}
