<?php

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class InfoFormRequest extends FormRequest
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
            'password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, auth('customer')->user()->password)) {
                    return $fail(__('Mật khẩu hiện tại không đúng.'));
                }
            }],
            'newPassword' => 'required',
            'confirmPassword' => 'required|same:newPassword'
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'Vui lòng nhập mật khẩu',
            'newPassword.required' => 'Vui lòng nhập mật khẩu mới',
            'confirmPassword.required' => 'Vui lòng nhập lại mật khẩu mới',
            'confirmPassword.same' => 'Mật khẩu mới không khớp'
        ];
    }
}
