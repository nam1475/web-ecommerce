<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $customer = Auth::guard('customer');
        /* Kiểm tra customer đã đăng nhập vào và đã xác thực email chưa */
        if($customer->check() && $customer->user()->email_verified_at != null){
            return $next($request);
        }
        /* Nếu chưa đăng nhập mà cố vào thông qua url */
        return redirect()->route('shop.login');
    }
}
