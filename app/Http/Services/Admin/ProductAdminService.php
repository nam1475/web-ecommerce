<?php

namespace App\Http\Services\Admin;

use App\Models\Product;
use App\Models\Menu;
use App\Models\Size;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use App\Traits\HelperTrait;
use Illuminate\Support\Facades\DB;

class ProductAdminService{
    public function getMenuProducts()
    {
        return Product::select('menu_id')->distinct()->get();
    }

    public function getSizes()
    {
        return Size::where('active', '=', 1)->get();
    }

    public function getHighestProductPrice()
    {
        return Product::max('price');
    }

    /* Kiểm tra điều kiện giá gốc > giá khuyến mại và giá gốc ko đc bỏ trống nhưng giá sale có thể bỏ trống */
    public function isValidPrice($request){
        $originPrice = $request->input('price');
        $salePrice = $request->input('price_sale');
        if($originPrice < $salePrice && !empty($originPrice) && !empty($salePrice)){
            Session::flash('error', 'Giá gốc phải lớn hơn giá sale!');
            return false;
        }
        if(empty($originPrice) && !empty($salePrice)){
            Session::flash('error', 'Vui lòng nhập giá gốc!');
            return false;
        }
        return true;
    }

    public function add($request){
        // dd($request->all());
        try {
            $isValidPrice = $this->isValidPrice($request);
            if($isValidPrice){
                DB::beginTransaction();
                $input = $request->all();
                $input['slug'] = Str::slug($request->name, '-');
                $product = Product::create($input);
                $product->sizes()->attach($request->size);
                DB::commit();
            }
            else{
                return false;
            }

            Session::flash('success', 'Thêm Sản Phẩm Thành Công');
        } catch (\Exception $err) {
            DB::rollBack();
            Session::flash('error', $err->getMessage());
            return false;
        }
        return true;
    }

    public function getProductById($id){
        $product = Product::find($id);
        return $product;
    }

    public function getProductSizes($slug, $id = 0){
        $productSizes = Product::where('slug', $slug)
                            ->orWhere('id', $id)
                            ->first()
                            ->sizes()
                            ->orderBy('size_id', 'asc')
                            ->get();
        return $productSizes;
    }

    public function update($request, $id){
        try {
            $isValidPrice = $this->isValidPrice($request);
            if($isValidPrice == false){
                return false;
            }
            else{
                DB::beginTransaction();
                $product = Product::find($id);
                $input = $request->all();
                $input['slug'] = Str::slug($request->name, '-');
                $product->update($input);
                $product->sizes()->sync($request->size);
                DB::commit();
                Session::flash('success', 'Cập Nhật Danh Mục Thành Công');
            }
            
        } catch (\Exception $err) {
            DB::rollBack();
            Session::flash('error', $err->getMessage());
            return false;
        }
        return true;
    }

    public function delete($id){
        try {
            $product = Product::find($id);
            HelperTrait::deleteFile($product);
            $product->delete();
            Session::flash('success', 'Xóa Sản Phẩm Thành Công');
        } catch (\Exception $err) {
            Session::flash('error', $err->getMessage());
            return false;
        }
        return true;
    }






}