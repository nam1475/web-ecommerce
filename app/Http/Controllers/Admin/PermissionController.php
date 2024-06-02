<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Permission\PermissionService;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PermissionController extends Controller
{
    protected $pmsService;

    public function __construct(PermissionService $pmsService){
        $this->pmsService = $pmsService;
    }

    public function list(){
        $permissions = Permission::paginate(15);
        return view('admin.permission.list')->with([
            'permissions' => $permissions,
            'title' => 'Danh Sách Quyền'
        ]);
    }

    public function add(){
        return view('admin.permission.add')->with([
            'title' => 'Thêm Quyền Mới',
            'permissions' => $this->pmsService->getParent()
        ]);
    }

    public function store(Request $request){
        // $input = $request->input('parent_id');
        // $name = $request->input('name');
        // if($input != 0){
        //     $name = '--' . $name;
        // }
    
        $createPermission = $this->pmsService->create($request);
        if($createPermission){
            return redirect()->route('permission.list');
        }
        return redirect()->back();
    }

    public function edit($id){
        $permission = Permission::find($id);

        return view('admin.permission.edit')->with([
            'title' => 'Sửa Quyền',
            'permission' => $permission,
            'permissions' => $this->pmsService->getParent()
        ]);
    }

    public function update(Request $request, $id){
        $updatePms = $this->pmsService->update($request, $id);
        if($updatePms){
            return redirect()->route('permission.list');
        }
        return redirect()->back();
    }

    public function delete($id){
        $this->pmsService->delete($id);

        return redirect()->back();
    }
}
