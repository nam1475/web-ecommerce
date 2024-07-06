<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\Admin\OrderService;
use App\Http\Services\Shop\ShopAuthService;
use App\Http\Requests\Shop\RegisterRequest;
use App\Http\Requests\Shop\LoginRequest;

class ShopAuthController extends Controller
{
    protected $order;
    protected $authService;

    public function __construct(OrderService $order, ShopAuthService $authService)
    {
        $this->order = $order;
        $this->authService = $authService;
    }

    public function register()
    {
        return view('shop.customer.register', [
            'title' => 'Register'
        ]);
    }
  
    public function registerSave(RegisterRequest $request)
    {
        $result = $this->authService->register($request);
        if($result){
            // return redirect()->route('shop.login');
            return redirect()->back();
        }
        return redirect()->back();
    }

    // public function sendVerifyEmail($request){
    //     $result = $this->authService->sendVerifyEmail($request);
    //     if($result){
    //         return redirect()->back();
    //     }
    //     return redirect()->back();
    // }

    public function checkVerifyAccount($token){
        $result = $this->authService->checkVerifyAccount($token);
        if($result){
            return redirect()->route('shop.home');
        }
        return redirect()->back();
    }
  
    public function login()
    {
        return view('shop.customer.login',[
            'title' => 'Login'
        ]);
    }

    public function loginAction(LoginRequest $request){
        $result = $this->authService->login($request);
        if($result){
            return redirect()->route('shop.home');
        }
        return redirect()->back();
    }

    public function logout(Request $request)
    {
        /* Xóa dữ liệu xác thực của người dùng:
        -Laravel sẽ xóa thông tin xác thực của người dùng hiện tại khỏi session.
        -Điều này bao gồm việc xóa user ID và các thông tin xác thực khác đã định sẵn trong model khỏi session.
        -Reset Cookie lưu trữ thông tin đăng nhập 'Remember Me'
        */
        Auth::guard('customer')->logout();  

        $request->session()->invalidate();  
        
        $request->session()->regenerateToken();
        
        return redirect()->route('shop.home');
    }

    public function forgotPassword(Request $request){
        $result = $this->authService->forgotPasswordAction($request);
        if($result){
            return redirect()->route('shop.login');
        }
        return redirect()->back();        
    }

    public function resetPassword($token){
        return view('shop.customer.reset-password', [
            'title' => 'Reset Password',
            'token' => $token
        ]);
    }

    public function resetPasswordAction(Request $request, $token){
        $result = $this->authService->resetPasswordAction($request, $token);
        if($result){
            return redirect()->route('shop.home');
        }
        return redirect()->back();
    }

    // protected function broker()
    // {
    //     return Password::broker('customers');
    // }
}
