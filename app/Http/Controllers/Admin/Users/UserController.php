<?php

namespace App\Http\Controllers\Admin\Users;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\User_Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;



class UserController extends Controller
{
    public function list(){
        $users = User::paginate(10);

        return view('admin.users.list')->with([
            'users' => $users,
            'title' => 'Danh Sách User'
        ]);
    }
    
    public function add(){
        $roles = Role::all();
        // dd($roles);
        return view('admin.users.add')->with([
            'title' => 'Thêm User',
            'roles' => $roles,
        ]);
    }

    public function store(Request $request){
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
    
            // User_Role::create([
            //     'user_id' => $user->id,
            //     'role_id' => implode(', ', $roles), // Tách các ptu trong mảng -> chuỗi cách nhau bởi dấu ','    
            // ]);
            DB::commit();
            Session::flash('success', 'Thêm User Thành Công');
            return redirect()->route('user.list');
        } catch (\Exception $err) {
            DB::rollBack();
            Session::flash('error', $err->getMessage());
        }
        
    }

    public function edit($id){
        $roles = Role::all(); // Trả về 1 collection bao gồm nhiều bản ghi
        $user = User::findOrFail($id);

        /* Lấy ra dữ liệu cột role_id theo user_id */
        $userRoles = $user->roles;
        // dd($userRoles);

        return view('admin.users.edit')->with([
            'user' => $user,
            'title' => 'Sửa User',
            'roles' => $roles,
            'userRoles' => $userRoles, 
        ]);
    }

    public function update(Request $request, $id){
        $user = User::find($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        /* sync(): Sẽ xóa hết dữ liệu cũ ở mọi cột trong bảng và thêm dữ liệu mới vào */
        $user->roles()->sync($request->role_id);
        Session::flash('success', 'Cập Nhật User Thành Công');

        return redirect()->route('user.list');
    }

    public function delete($id){
        $user = User::find($id);
        $user->delete();
        Session::flash('success', 'Xóa User Thành Công');
        return redirect()->route('user.list');
    }
}
