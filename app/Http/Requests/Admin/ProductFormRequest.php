<?php

namespace App\Http\Requests\Admin;

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
            'name' =>'required|unique:products,name',
            'description' =>'required',
            'menu_id' =>'required',
            'price' =>'required',
            'thumb' => 'required|max:5048',
            // 'size' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên',
            'name.unique' => 'Tên sản phẩm đã tồn tại',
            'thumb.required' => 'Vui lòng chọn ảnh sản phẩm',
            // 'thumb.mimes' => 'Kiểu file ảnh phải là jpg, png, gif',
            'thumb.max' => 'File ảnh vượt quá kích cỡ',
            'description.required' => 'Vui lòng nhập mô tả',
            'price.required' => 'Vui lòng nhập giá gốc',
            'menu_id.required' => 'Vui lòng chọn loại danh mục',
            // 'size.required' => 'Vui lòng chọn size',
        ];
    }
}
