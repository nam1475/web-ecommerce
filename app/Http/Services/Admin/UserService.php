<?php

namespace App\Http\Services\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Admin\UserFormRequest;

class UserService{
    public static function getRoles(){
        $roles = Role::all();
        return $roles;
    }

    public static function add($request){
        /* $request->validated(): Trả về một mảng chứa tất cả các giá trị của request đã 
        được xác thực được định nghĩa trong phương thức rules()
        - VD: Nếu bạn có một request với các trường name, email, và password đã vượt qua xác 
        thực, $request->validated() sẽ trả về một mảng với các giá trị của các trường đó.
        */
        $request->validated();

        $checkEmail = self::isExistEmail($request);
        if($checkEmail){
            Session::flash('error', 'Email đã tồn tại');
            return false;
        }
        
        try {
            /* Đảm bảo rằng tất cả các thao tác này đều thành công trước khi thực sự ghi nhận chúng 
            vào cơ sở dữ liệu */
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            
            /* attach(): Hàm insert các bản ghi vào bảng trung gian(user_role) trong quan hệ nhiều-nhiều */
            $user->roles()->attach($request->role_id);

            // $user->roles()->createMany([
            //     'user_id' => $user->id,
            //     'role_id' => implode(', ', $roles),
            // ]);
    
            DB::commit();
            Session::flash('success', 'Thêm User Thành Công');
        } catch (\Exception $err) {
            DB::rollBack();
            Session::flash('error', $err->getMessage());
            return false;
        }
        return true;
    }

    public static function isExistEmail($request){
        $checkEmail = User::where('email', '=', $request->email)->first();
        if($checkEmail){
            return true;
        }
        return false;
    }

    public static function delete($id){
        try {
            User::find($id)->delete();
            Session::flash('success', 'Xóa User Thành Công');
        } catch (\Exception $err) {
            Session::flash('error', $err->getMessage());
            return false;
        }
        return true;
    }


}