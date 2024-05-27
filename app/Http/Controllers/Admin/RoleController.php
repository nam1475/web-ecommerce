<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class RoleController extends Controller
{
    public function list(){
        $roles = Role::paginate(10);
        return view('admin.role.list')->with([
            'roles' => $roles,
            'title' => 'Danh Sách Vai Trò'
        ]);
    }
    public function add(){
        return view('admin.role.add')->with([
            'title' => 'Thêm Vai Trò Mới'
        ]);
    }

    public function store(Request $request){
        Role::create([
            'name' => $request->input('name'),
            'display_name' => $request->input('display_name'),
        ]);
        Session::flash('success', 'Thêm Vai Trò Thành Công');
        
        return redirect()->route('role.list');
    }

    public function edit($id){
        $role = Role::find($id);
        return view('admin.role.edit')->with([
            'role' => $role,
            'title' => 'Sửa Role'
        ]);
    }
    public function update(Request $request, $id){
        $role = Role::find($id);
        $role->name = $request->name;
        $role->display_name = $request->display_name;
        $role->save();
        Session::flash('success', 'Cập Nhật Role Thành Công');

        return redirect()->route('role.list');
    }

    public function delete($id){
        $role = Role::find($id);
        $role->delete();
        return redirect()->route('role.list');
    }
}
