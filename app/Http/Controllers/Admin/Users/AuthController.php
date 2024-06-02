<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index(){
        return view('admin.users.login')->with([
            'title' => 'Login'
        ]);
    }

    public function store(Request $request){
        $this->validate($request, [
            'email' => 'required|email:filter',
            'password' => 'required'
        ]);
        
        /* Nếu đăng nhập thành công thì trả về trang admin */
        if (Auth::attempt([
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ], $request->input('remember'))) {
            // Session::put('adminName', auth()->user()->name);

            return redirect()->route('dashboard');  
        }
        
        Session::flash('error', 'Email hoặc Password không đúng');  
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

        /* - Sau khi đăng xuất, dòng này được sử dụng để vô hiệu hóa phiên của người dùng. 
        - Điều này làm cho tất cả các dữ liệu trong phiên hiện tại của người dùng trở thành 
        không hợp lệ. */
        $request->session()->invalidate();
        // Session::forget('adminName');
        
        return redirect()->route('login');
    }
}
