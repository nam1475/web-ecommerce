<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Admin\UserFormRequest;
use App\Http\Services\Admin\UserService;
use App\Traits\HelperTrait;

class UserController extends Controller
{
    public function list(Request $request){
        return view('admin.users.list')->with([
            'users' => HelperTrait::getAll($request, User::class),
            'title' => 'Danh Sách User'
        ]);
    }
    
    public function add(){
        $roles = UserService::getRoles();
        // dd($roles);
        return view('admin.users.add')->with([
            'title' => 'Thêm User',
            'roles' => $roles,
        ]);
    }

    public function store(UserFormRequest $request){
        $result = UserService::add($request);
        if($result){
            return redirect()->route('user.list');
        }
        return redirect()->back();
    }

    public function edit($id){
        $roles = UserService::getRoles(); // Trả về 1 collection bao gồm nhiều bản ghi
        $user = User::findOrFail($id);

        /* Lấy ra dữ liệu cột role_id theo user_id */
        $userRoles = $user->roles;
        // dd($userRoles);

        return view('admin.users.edit')->with([
            'title' => 'Sửa User',
            'user' => $user,
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

        if(isset($request->role_id)){
            /* sync(): Sẽ xóa hết dữ liệu cũ ở mọi cột trong bảng và thêm dữ liệu mới vào */
            $user->roles()->sync($request->role_id);
            Session::flash('success', 'Cập Nhật User Thành Công');
            
            return redirect()->route('user.list');
        }
        
        /* Cập nhật profile */
        Session::flash('success', 'Cập Nhật Profile Thành Công');
        return redirect()->back();
    }

    public function delete($id){
        $result = UserService::delete($id);
        if($result){
            return redirect()->route('user.list');
        }
        return redirect()->back();
    }

    public function profile(){
        $user = auth()->user();
        $userRoles = $user->roles;
        
        return view('admin.users.profile', [
            'title' => 'Thông Tin Cá Nhân',
            'user' => $user,
            'userRoles' => $userRoles,
        ]);
    }


}
