<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Admin\PermissionService;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Admin\PermissionFormRequest;
use App\Traits\HelperTrait;

class PermissionController extends Controller
{
    protected $pmsService;

    public function __construct(PermissionService $pmsService){
        $this->pmsService = $pmsService;
    }

    public function list(Request $request){        
        return view('admin.permission.list')->with([
            'title' => 'Danh Sách Quyền',
            'permissions' => HelperTrait::getAll($request, Permission::class),
            'pmsParents' => HelperTrait::getParents(Permission::class)
        ]);
    }

    public function add(){
        return view('admin.permission.add')->with([
            'title' => 'Thêm Quyền Mới',
            'permissions' => HelperTrait::getParents(Permission::class)
        ]);
    }

    public function store(PermissionFormRequest $request){
        // $input = $request->input('parent_id');
        // $name = $request->input('name');
        // if($input != 0){
        //     $name = '--' . $name;
        // }
        
        $result = $this->pmsService->create($request);
        if($result){
            return redirect()->route('permission.list');
        }
        return redirect()->back();
    }

    public function edit($id){
        $permission = Permission::find($id);

        return view('admin.permission.edit')->with([
            'title' => 'Sửa Quyền',
            'permission' => $permission,
            'permissions' => HelperTrait::getParents(Permission::class)
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
        $result = $this->pmsService->delete($id);
        if($result){
            return redirect()->route('permission.list');
        }
        return redirect()->back();}
}
