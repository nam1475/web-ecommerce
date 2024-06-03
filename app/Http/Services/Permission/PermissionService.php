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

            // $pmsParent = "";
            $inputPmsParent = $request->input('parent_pms');
            /* - exist(): Trả về true nếu đã tồn tại, false nếu chưa 
            Kiểm tra tên pms cha đã tồn tại trong db chưa */
            $nameExist = Permission::where('name', '=', $inputPmsParent)->exists();
            // dd($nameExist);

            /* Nếu chưa tồn tại tên permission cha */
            if(!$nameExist){
                /* Tạo permission cha trước */
                $pmsParent = Permission::create([
                    'name' => $inputPmsParent,
                    'description' => $inputPmsParent,
                    'parent_id' => 0,
                    'active' => $request->input('active'),
                ]);
                // dd($pmsParent);
            }
            /* Nếu đã tồn tại */
            else{
                /* first(): Trả về bản ghi đầu tiên trùng khớp, nếu ko có bản ghi nào trùng khớp sẽ trả
                về null
                - Đoạn lệnh dưới sẽ trả về 1 đối tượng của class Permission đại diện cho bản ghi đó. 
                Đối tượng này sẽ chứa tất cả các thuộc tính của bản ghi, cũng như các phương thức của 
                model Eloquent.
                */
                $pmsParent = Permission::where('name', '=', $inputPmsParent)->first();
                // dd($pmsParent);
            }

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
            /* Kiểm tra xem id hiện tại có bị trùng với parent_id ko */
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