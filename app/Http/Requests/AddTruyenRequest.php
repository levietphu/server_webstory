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
            'vip'=>'required',
            'full'=>'required',
            'recommended'=>'required',
            'id_trans'=>'required',
            'id_tacgia'=>'required',
            'id_user'=>'required',
            'id_cate'=>'required',
        ];
    }
    public function messages()
    {
        return [
           'name.required' => 'Tên truyện không được bỏ trống',
           'name.max' => 'Tên truyện không quá 255 ký tự',
           'slug.max' => 'Slug không quá 255 ký tự',
            'slug.required' => 'Slug không được bỏ trống',
            'slug.unique' => 'Slug không được trùng',
            'introduce.required' => 'Giới thiệu không được bỏ trống',
            'image.required' => 'Ảnh không được bỏ trống',
            'nguon.max' => 'Nguồn không được quá 255 ký tự',
            'status.required' => 'Trạng thái không được bỏ trống',
            'vip.required' => 'Kiểu vip or free không được bỏ trống',
            'full.required' => 'Dạng full không được bỏ trống',
            'recommended.required' => 'Đề xuất không được bỏ trống',
            'id_trans.required' => 'Dịch giả không được bỏ trống',
            'id_tacgia.required' => 'Tác giả không được bỏ trống',
            'id_user.required' => 'người thêm không được bỏ trống',
            'id_cate.required' => 'Thể loại không được bỏ trống',
        ];
    }
}
