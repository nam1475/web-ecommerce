<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Admin\RoleService;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Admin\RoleFormRequest;
use App\Traits\HelperTrait;

class RoleController extends Controller
{
    use HelperTrait;

    public function list(Request $request){
        // if(Gate::allows('admin')){
        //     return redirect()->route('dashboard');
        // }
        // else{
        //     abort(403, 'You are not allowed to access this page');
        // }
        return view('admin.role.list')->with([
            'roles' => self::getAll($request, Role::class),
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

    public function store(RoleFormRequest $request){
        $result = RoleService::create($request);
        if($result){
            return redirect()->route('role.list');
        }
        return redirect()->back();   
    }

    public function edit($id){
        $role = Role::find($id);
        $pmsParents = RoleService::getPmsParent();
        $rolePms = $role->permissions; 

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
        $result = RoleService::delete($id);
        if($result){
            return redirect()->route('role.list');
        }
        return redirect()->back();
    }
}
