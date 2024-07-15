<?php

namespace App\Http\Services\Shop;

use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerResetPassword;
use App\Traits\HelperTrait;
use App\Http\Requests\Shop\ForgotPasswordRequest;
use App\Http\Requests\Shop\ResetPasswordRequest;
use Illuminate\Support\Str;

class ShopAuthService{
    public function register($request){
        $request->validated();

        try{
            DB::beginTransaction();
            $customer = Customer::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'remember_token' => Str::random(64),
            ]);

            $data = [
                'title' => 'Verify account',
                'name' => 'Fein Clothing',
                'email' => $request->email,
                'body' => 'verify your account',
                'route' => 'shop.verify.account',
                'token' => $customer->remember_token,
            ];
            HelperTrait::sendMail($data);
            Session::flash('success', 'Đã gửi một email để xác thực');
            DB::commit();

        }catch(\Exception $e){
            DB::rollBack();
            Session::flash('error', $e->getMessage());
            return false;
        }
        return true;
    }

    public function checkVerifyAccount($token){
        try{
            $customer = Customer::where('remember_token', $token)->first();
            $customer->email_verified_at = date('Y-m-d H:i:s');
            $customer->save();
            Auth::guard('customer')->login($customer);
        }catch(\Exception $e){
            Session::flash('error', $e->getMessage());
            return false;
        }
        return true;
    }

    public function login($request){
        $request->validated();
        try{
            $data = [
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ];
            if (Auth::guard('customer')->attempt($data, $request->input('remember'))) {
                return true;
            }
        
            Session::flash('error', 'Email hoặc Password không đúng');
            return false;  
        }catch(\Exception $e){
            Session::flash('error', $e->getMessage());
            return false;
        }
    }

    public function forgotPasswordAction($request){
        HelperTrait::validateAuthPassword($request, 'customers', ForgotPasswordRequest::class);
        
        try{
            $array = [
                'name' => 'Fein Clothing',
                'title' => 'Forgot password email',
                'email' => $request->email,
                'body' => 'reset your password',
                'route' => 'shop.reset.password',
            ];

            HelperTrait::forgotPasswordAction(CustomerResetPassword::class, $array);

        }catch(\Exception $e){
            DB::rollBack();
            Session::flash('error', $e->getMessage());
            return false;
        }
        return true;
    }

    public function resetPasswordAction($request, $token){
        HelperTrait::validateAuthPassword($request, 'customers', ResetPasswordRequest::class);
        
        try{
            $data = [
                'modelResetPw' => CustomerResetPassword::class,
                'modelMain' => Customer::class,
                'request' => $request,
                'token' => $token,
                'guardName' => 'customer',
            ];
            $result = HelperTrait::resetPasswordAction($data);
            if($result){
                return true;
            }
            return false;

        }catch(\Exception $e){
            Session::flash('error', $e->getMessage());
            return false;
        }
    }
}