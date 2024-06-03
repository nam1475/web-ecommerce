<?php

namespace App\Http\Services\Role;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class RoleService{
    public static function getPmsParent(){
        $pmsParents = Permission::where([
            ['parent_id', '=', 0],
            ['active', '=', 1]
        ])->get();
        return $pmsParents;
    }

    public static function create($request){
        try {
            DB::beginTransaction();
            
            $role = Role::create($request->all());
            
            /* Thêm dữ liệu vào bảng permission_role với id role hiện tại và mảng các permission_id đã chọn */
            $role->permissions()->attach($request->input('permission_id'));

            DB::commit();
            Session::flash('success', 'Thêm Vai Trò Thành Công');

            return true;
        }catch (\Exception $err) {
            DB::rollBack();
            Session::flash('error', $err->getMessage());
            return false;
        }
    }

    public static function update($request, $id){
        try{
            DB::beginTransaction();
            $role = Role::find($id);
            $role->update($request->all());
            $role->permissions()->sync($request->permission_id);
            
            DB::commit();   
            Session::flash('success', 'Cập Nhật Role Thành Công');
            return true;
        }catch (\Exception $err) {
            DB::rollBack();
            Session::flash('error', $err->getMessage());
            return false;
        }
    }
    
}