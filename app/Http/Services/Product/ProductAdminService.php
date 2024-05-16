<?php

namespace App\Http\Services\Product;

use App\Models\Product;
use App\Models\Menu;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class ProductAdminService{

    public function getMenu()
    {
        return Menu::where('active', '=', 1)->get();
    }

    public function getAll()
    {
        /* Truyền thêm function menu() trong model Product */
        $products = Product::with('menu')->paginate(5);
        return $products;
    }

    /* Kiểm tra điều kiện giá gốc > giá khuyến mại và giá gốc ko đc bỏ trống */
    public function isValidPrice($request){
        if($request->input('price') < $request->input('price_sale') 
        && $request->input('price') != "" && $request->input('price_sale') != ""){
            Session::flash('error', 'Giá gốc phải lớn hơn giá sale!');
            return false;
        }
        if($request->input('price') == "" && $request->input('price_sale') != ""){
            Session::flash('error', 'Vui lòng nhập giá gốc!');
            return false;
        }
        return true;
    }

    public function add($request){
        try {
            $isValidPrice = $this->isValidPrice($request);
            if($isValidPrice == false){
                return false;
            }
            else{
                Product::create($request->all());
            }

            Session::flash('success', 'Thêm Sản Phẩm Thành Công');
        } catch (\Exception $err) {
            Session::flash('error', $err->getMessage());
            return false;
        }
        return true;
    }

    public function edit($id){
        $product = Product::with('menu')->find($id);
        return $product;
    }

    public function update($request, $id){
        try {
            $isValidPrice = $this->isValidPrice($request);
            if($isValidPrice == false){
                return false;
            }
            else{
                $input = $request->all();
                Product::find($id)->update($input);
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
            Product::find($id)->delete();
            Session::flash('success', 'Xóa Sản Phẩm Thành Công');
        } catch (\Exception $err) {
            Session::flash('error', $err->getMessage());
            return false;
        }
        return true;
    }






}