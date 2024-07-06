<?php

namespace App\Http\Services\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\UserResetPassword;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Traits\HelperTrait;
use App\Http\Requests\Shop\ForgotPasswordRequest;
use App\Http\Requests\Shop\ResetPasswordRequest;

class UserAuthService{
    public static function loginAction($request){
        $request->validated();
        try{
            /* Nếu đăng nhập thành công thì trả về trang dashboard */
            if (Auth::guard('web')->attempt([
                    'email' => $request->input('email'),
                    'password' => $request->input('password')
                ], $request->input('remember'))) {
                // Session::put('adminName', auth()->user()->name);    
                return true;
            }
            Session::flash('error', 'Email hoặc Password không đúng');  
            return false;
            
        }catch(\Exception $e){
            Session::flash('error', $e->getMessage());
            return false;
        }
    }

    public static function forgotPasswordAction($request){
        HelperTrait::validateAuthPassword($request, 'users', ForgotPasswordRequest::class);

        try{
            $array = [
                'name' => 'Admin Coza Store',
                'title' => 'Forgot password email',
                'email' => $request->email,
                'body' => 'reset your password',
                'route' => 'admin.user.reset.password',
            ];

            HelperTrait::forgotPasswordAction(UserResetPassword::class, $array);

        }catch(\Exception $e){
            DB::rollBack();
            Session::flash('error', $e->getMessage());
            return false;
        }
        return true;
    }

    public static function resetPasswordAction($request, $token){
        HelperTrait::validateAuthPassword($request, 'users', ResetPasswordRequest::class);

        try{
            $data = [
                'modelResetPw' => UserResetPassword::class,
                'modelMain' => User::class,
                'request' => $request,
                'token' => $token,
                'guardName' => 'web',
            ];
            $result = HelperTrait::resetPasswordAction($data);
            if($result){
                return true;
            }
            return false;

        }catch(\Exception $e){
            DB::rollBack();
            Session::flash('error', $e->getMessage());
            return false;
        }
    }


}