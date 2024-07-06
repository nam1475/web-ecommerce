<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SliderFormRequest extends FormRequest
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
            'name' =>'required|unique:sliders,name',
            'url' =>'required',
            'thumb' =>'required|max:5048',
        ];
    }

    public function messages(){
        return [
            'name.required' => 'Vui lòng nhập tiêu đề',
            'name.unique' => 'Tên tiêu đề đã tồn tại',
            'url.required' => 'Vui lòng nhập url',
            'thumb.required' => 'Vui lòng chọn ảnh',
            'thumb.max' => 'File ảnh vượt quá kích cỡ',

        ];
    }
}
