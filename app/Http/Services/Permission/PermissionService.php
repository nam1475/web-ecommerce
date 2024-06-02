<?php

namespace App\Http\Services\Permission;

use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class PermissionService{
    public function getParent(){
        $parentPermissions = Permission::where('parent_id', '=', 0)->get();
        return $parentPermissions;
    }

    public function create($request){
        try{
            DB::beginTransaction();

            $inputPmsParent = $request->input('parent_pms');
            /* Tạo permission cha trước */
            $pmsParent = Permission::create([
                'name' => $inputPmsParent,
                'description' => $inputPmsParent,
                'parent_id' => 0,
                'active' => $request->input('active'),
            ]);
                
            /* Tạo permission con sau */
            $action = $request->input('action');
            foreach($action as $item){
                $joinName = $item . ' ' . $inputPmsParent;
                Permission::create([
                    'name' => $joinName,
                    'description' => $joinName,
                    'parent_id' => $pmsParent->id,
                    'active' => $request->input('active'),
                    'key_code' => $item . '-' . $inputPmsParent,
                ]);
            }

            DB::commit();
            Session::flash('success', 'Thêm Quyền Thành Công');
            return true;
        }catch (\Exception $err) {
            DB::rollBack();
            Session::flash('error', $err->getMessage());
            return false;
        }
    }


    public function update($request, $id){
        try {
            /* Kiểm tra xem có bị trùng id với parent_id ko */
            if($id != $request->input('parent_id')){
                $input = $request->all();
                Permission::find($id)->update($input);
                Session::flash('success', 'Cập Nhật Quyền Thành Công');
                return true;
            }
            else{
                Session::flash('error', 'Ko Được Trùng Lặp Quyền');
                return false;
            }
            
        } catch (\Exception $err) {
            Session::flash('error', $err->getMessage());
            return false;
        }
    }

    public function delete($id){
        try {
            Permission::where('id', '=', $id)
                ->orWhere('parent_id', '=', $id)
                ->delete();
            Session::flash('success', 'Xóa Quyền Thành Công');
            
        } catch (\Exception $err) {
            Session::flash('error', $err->getMessage());
            return false;
        }
        return true;
    }
}