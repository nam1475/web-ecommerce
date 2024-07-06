<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RoleFormRequest extends FormRequest
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
            'name' =>'required|unique:roles,name',
            'display_name' =>'required',
            'permission_id' =>'required',
        ];
    }

    public function messages(){
        return [
            'name.required' => 'Vui lòng nhập tên',
            'name.unique' => 'Tên vai trò đã tồn tại',
            'display_name.required' => 'Vui lòng nhập mô tả',
            'permission_id.required' => 'Vui lòng chọn quyền',
        ];
    }
}
