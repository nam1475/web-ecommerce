<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductFormRequest extends FormRequest
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
            'name' =>'required',
            'thumb' => 'required|max:5048',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập trường name',
            'thumb.required' => 'Vui lòng chọn ảnh sản phẩm',
            // 'thumb.mimes' => 'Kiểu file ảnh phải là jpg, png, gif',
            'thumb.max' => 'File ảnh vượt quá kích cỡ',
        ];
    }
}
