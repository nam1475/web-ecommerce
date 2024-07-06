<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PermissionFormRequest extends FormRequest
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
            'parent_pms' =>'required',
            'action' =>'required',
        ];
    }

    public function messages(){
        return [
            'parent_pms.required' => 'Vui lòng chọn phân quyền cha',
            'action.required' => 'Vui lòng chọn action',
            // 'parent_pms.unique' => 'Tên quyền đã tồn tại',
        ];
    }
}
