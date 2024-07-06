<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\Admin\UserAuthService;
use App\Http\Requests\Shop\LoginRequest;

class UserAuthController extends Controller
{
    public function login(){
        return view('admin.users.login')->with([
            'title' => 'Login',
            'header' => 'Đăng nhập'
        ]);
    }

    public function store(LoginRequest $request){
        $result = UserAuthService::loginAction($request);
        if($result){
            return redirect()->route('dashboard');
        }
        return redirect()->back();
    }

    public function logout(Request $request)
    {
        /* Auth::guard('web')->logout(): 
        - Là cách để đăng xuất người dùng khỏi ứng dụng. 
        - Phương thức logout() được gọi trên guard web, đảm bảo rằng người dùng được đăng 
        xuất khỏi phiên đăng nhập trên route web.php */
        Auth::guard('web')->logout();
        // Auth::logout();

        /* - Sau khi đăng xuất, dòng này được sử dụng để vô hiệu hóa session của người dùng. 
        - Điều này làm cho tất cả các dữ liệu trong session hiện tại của người dùng trở thành 
        không hợp lệ. */
        $request->session()->invalidate();
        // Session::forget('adminName');
        $request->session()->regenerateToken();
        
        return redirect()->route('login');
    }

    public function forgotPassword(){
        return view('admin.users.forgot-password')->with([
            'title' => 'Forgot Password',
            'header' => 'Quên mật khẩu'
        ]);
    }

    public function forgotPasswordAction(Request $request){
        $result = UserAuthService::forgotPasswordAction($request);
        if($result){
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function resetPassword($token){
        return view('admin.users.reset-password', [
            'title' => 'Reset Password',
            'header' => 'Đặt lại mật khẩu',
            'token' => $token
        ]);
    }

    public function resetPasswordAction(Request $request, $token){
        $result = UserAuthService::resetPasswordAction($request, $token);
        if($result){
            return redirect()->route('dashboard');
        }
        return redirect()->back();
    }

    
}
