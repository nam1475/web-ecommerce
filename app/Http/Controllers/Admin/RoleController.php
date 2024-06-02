<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Services\Role\RoleService;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class RoleController extends Controller
{
    public function list(){
        // if(Gate::allows('admin')){
        //     return redirect()->route('dashboard');
        // }
        // else{
        //     abort(403, 'You are not allowed to access this page');
        // }
        $roles = Role::paginate(10);
        return view('admin.role.list')->with([
            'roles' => $roles,
            'title' => 'Danh Sách Vai Trò'
        ]);
    }
    
    public function add(){
        $pmsParents = RoleService::getPmsParent();
        
        return view('admin.role.add')->with([
            'title' => 'Thêm Vai Trò Mới',
            'pmsParents' => $pmsParents,
        ]);
    }

    public function store(Request $request){
        $createRole = RoleService::create($request);
        if($createRole){
            return redirect()->route('role.list');
        }
        return redirect()->back();   
    }

    public function edit($id){
        $role = Role::find($id);
        // $permissions = Permission::all();
        $pmsParents = RoleService::getPmsParent();
        $rolePms = Helper::getID($role->permissions(), 'permission_id');  

        return view('admin.role.edit')->with([
            'title' => 'Sửa Role',
            'role' => $role,
            'rolePms' => $rolePms,     
            'pmsParents' => $pmsParents,       
        ]);
    }

    public function update(Request $request, $id){
        $updateRole = RoleService::update($request, $id);
        if($updateRole){
            return redirect()->route('role.list');
        }
        return redirect()->back();
    }

    public function delete($id){
        $role = Role::find($id);
        $role->delete();
        return redirect()->route('role.list');
    }
}
