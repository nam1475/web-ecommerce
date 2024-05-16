<?php

namespace App\Http\Services\Menu;

use App\Models\Menu;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class MenuService{

    public function getAll(){
        $menus = Menu::paginate(10);
        return $menus;
    }

    public function show(){
        $menus = Menu::select('id', 'name')->where('parent_id', '=', 0)->orderByDesc('id')->get();
        return $menus;
    }

    public function getParent(){
        $parentMenus = Menu::where('parent_id', '=', 0)->get();
        return $parentMenus;
    }

    public function create($request){
        try {
            Menu::create([
                'name' => (string)$request->input('name'),
                'parent_id' => (int)$request->input('parent_id'),
                'description' => (string)$request->input('description'),
                'content' => (string)$request->input('content'),
                'active' => (string)$request->input('active'),
                // 'slug' => Str::slug($request->input('name'), '-')
                /* Mục đích của việc tạo slug là chuyển đổi chuỗi văn bản thành một chuỗi thân thiện với URL,
                thường được sử dụng để tạo các liên kết thân thiện với SEO. */
            ]);

            Session::flash('success', 'Tạo Danh Mục Thành Công');
        } catch (\Exception $err) {
            Session::flash('error', $err->getMessage());
            return false;
        }
        return true;
    }

    public function edit($id){
        $menu = Menu::find($id);
        return $menu;
    }

    public function update($request, $id){
        try {
            /* Kiểm tra xem có bị trùng id với parent_id ko */
            if($id != $request->input('parent_id')){
                $input = $request->all();
                Menu::find($id)->update($input);
                Session::flash('success', 'Cập Nhật Danh Mục Thành Công');
            }
            
        } catch (\Exception $err) {
            Session::flash('error', $err->getMessage());
            return false;
        }
        return true;
    }

    public function delete($id){
        try {
            Menu::where('id', '=', $id)
                ->orWhere('parent_id', '=', $id)
                ->delete();
            Session::flash('success', 'Xóa Danh Mục Thành Công');
            
        } catch (\Exception $err) {
            Session::flash('error', $err->getMessage());
            return false;
        }
        return true;
    }

    public function getId($id){
        $menu = Menu::where('id', '=', $id)->where('active', '=', 1)->findOrFail($id);
        return $menu;
    }

    public function getProducts($menu, $request)
    {
        /* Join với bảng products thông qua hàm products() trong model Menu */
        $query = $menu->products()
                    ->select('id', 'name', 'price', 'price_sale', 'thumb')
                    ->where('active', 1);

        if ($request->input('price')) {
            $query->orderBy('price', $request->input('price'));
        }

        /* withQueryString(): Dùng để nối thêm query string trước đó khi sang trang url khác */
        return $query->orderByDesc('id')
                    ->paginate(12)
                    ->withQueryString();
    }








}