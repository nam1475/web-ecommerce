<?php

namespace App\Http\Services\Admin;

use App\Models\Menu;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Traits\HelperTrait;
use Illuminate\Support\Collection;

class MenuService{
    public function create($request){
        try {
            $input = $request->all();
            /* Str::slug(): Dùng để tạo ra 1 url thân thiện ngăn cách các chuỗi bởi dấu '-' 
            (VD: giày thể thao -> giay-the-thao,...) */
            $input['slug'] = Str::slug($request->name, '-');
            Menu::create($input);

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
                $input['slug'] = Str::slug($request->name, '-');
                Menu::find($id)->update($input);
                Session::flash('success', 'Cập Nhật Danh Mục Thành Công');
                return true;
            }
            Session::flash('error', 'Không Được Trùng Danh Mục');
            return false;
        } catch (\Exception $err) {
            Session::flash('error', $err->getMessage());
            return false;
        }
    }

    public function delete($id){
        try {
            $menu = Menu::where('id', '=', $id)->first();
            HelperTrait::deleteFile($menu);
            $menu->delete();
            Session::flash('success', 'Xóa Danh Mục Thành Công');
            
        } catch (\Exception $err) {
            Session::flash('error', $err->getMessage());
            return false;
        }
        return true;
    }

    public function getMenuBySlug($slug){
        $menu = Menu::where('slug', $slug)->first();
        return $menu;
    }
    
    public function getMenuProducts($menuParent)
    {
        return Menu::where('parent_id', $menuParent->id)->get();
    }

    public function getHighestProductPriceByMenu($menu)
    {
        $productIds = $this->getAllProductIds($menu);
        return Product::whereIn('id', $productIds)->max('price');
    }

    public function getAllProductIds($menu)
    {
        // Tạo một mảng để chứa tất cả các ID sản phẩm
        $productIds = collect($menu->products->pluck('id'));

        // Lặp qua tất cả các danh mục con và gọi đệ quy
        foreach ($menu->childrenRecursive as $childMenu) {
            $productIds = $productIds->merge($this->getAllProductIds($childMenu));
        }

        return $productIds;
    }
    
    public function filterMenuSlug($menu, $menuSlug){
        foreach($menu->children as $child){
            foreach($menuSlug as $value){
                if($child->slug == $value){
                    $menuSlug = array_merge($menuSlug, $child->children()->pluck('slug')->toArray());
                }
            }
        } 
        // dd($menuSlug);
        
        // $asd = [];
        // /* Gộp thành 1 mảng phẳng(flatten - VD: [1, 2, [3, 4], 5] => [1, 2, 3, 4, 5]) */
        // foreach($menuSlug as $value){
        //     if(is_array($value)){
        //         $asd = array_merge($asd, $value);
        //     }
        //     else{
        //         array_push($asd, $value);
        //     }
        // }

        return $menuSlug;
    }

    public function getProductsByMenu($menu, $request)
    {
        /* Lấy ra các products dựa theo 1 menu chỉ định thông qua hàm products() trong model Menu */
        $query = $menu->products()->where('products.active', 1);
        // dd($query->toSql());

        /** Kiểm tra xem menu hiện tại có menu con hay ko 
         * Nếu có thì lấy ra tất cả những sản phẩm thuộc menu con, cháu của menu hiện tại
        */
        if($menu->children()->exists()) {
            // $query = Product::join('menus as m', 'products.menu_id', '=', 'm.id')
            //             ->select('products.*')
            //             ->where('m.parent_id', $menu->id)
            //             // ->where('products.menu_id', $menu->id)
            //             ->where('products.active', 1);  
    
            // $query = Product::whereHas('menu', function ($q) use ($menu, $products, $childMenuIds) {
            //     $q->where('parent_id', $menu->id);
            // }); 

            // Lấy tất cả danh mục con, cháu của danh mục cha hiện tại
            $menu = Menu::with('childrenRecursive')->find($menu->id);
            // dd($menu);

            // Hàm đệ quy để lấy ID sản phẩm từ tất cả các danh mục con
            $productIds = $this->getAllProductIds($menu);

            // Query để lấy các sản phẩm dựa trên các ID sản phẩm
            $query = Product::join('menus as m', 'products.menu_id', '=', 'm.id')
                        ->select('products.*')
                        ->whereIn('products.id', $productIds)
                        ->where('products.active', 1);

            // dd($query);
        }

        /* Nếu có query string ở trên url */
        if (!empty(request()->query())) {
            $sortPrice = $request->query('sort-price');
            $priceMin = $request->query('min-price');
            $priceMax = $request->query('max-price');
            $menuSlug = $request->query('menu');
            $search = $request->query('search-products');
            
            $query->when(isset($menuSlug), function ($query) use ($menu, $menuSlug) {
                $result = $this->filterMenuSlug($menu, $menuSlug);
                return $query->whereIn('m.slug', $result);  
            })->when(isset($priceMin) && isset($priceMax), function ($query) use ($priceMin, $priceMax) {
                $query->whereBetween('products.price', [$priceMin, $priceMax]);
            })->when(isset($search), function ($query) use ($search) {
                $query->where('products.name', 'like', '%' . $search . '%');
            })->when(isset($sortPrice), function ($query) use ($sortPrice) {
                $query->orderBy('products.price', $sortPrice);
            });
        }

        /* withQueryString(): Dùng để giữ nguyên query string ở trang trước đó khi sang trang url khác */
        return $query->paginate(10)
                    ->withQueryString();
    }







}