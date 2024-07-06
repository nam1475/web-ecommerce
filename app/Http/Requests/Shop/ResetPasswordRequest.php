<?php

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    protected $table;

    public function setTable($table)
    {
        $this->table = $table;
    }

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
            'email' => 'required|email|exists:' . $this->table . ',email',
            'new_password' => 'required',
            'password_confirmation' => 'required|same:new_password'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email ko hợp lệ',
            'email.exists' => 'Email không tồn tại',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới',
            'password_confirmation.required' => 'Vui lòng nhập lại mật khẩu',
            'password_confirmation.same' => 'Mật khẩu không khớp'
        ];
    }
}
