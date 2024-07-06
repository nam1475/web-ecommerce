<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MenuFormRequest extends FormRequest
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
            
            'name' =>'required|unique:menus,name',
            // 'parent_id' => 'required',   
            'description' => 'required',
            'content' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên',
            'name.unique' => 'Tên danh mục đã tồn tại',
            // 'parent_id.required' => 'Vui lòng chọn loại danh mục',
            'description.required' => 'Vui lòng nhập mô tả',
            'content.required' => 'Vui lòng nhập nội dung',
        ];
    }
}
