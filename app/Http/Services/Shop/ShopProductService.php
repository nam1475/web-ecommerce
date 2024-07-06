<?php

namespace App\Http\Services\Shop;

use App\Models\Product;

class ShopProductService{

    const LIMIT = 8;
    
    public function getProducts($page = null){
        $products = Product::orderBy('price')
            ->when($page != null, function ($query) use ($page) {
                $query->offset($page * self::LIMIT);
            })
            ->limit(self::LIMIT)
            ->get();
        /* - offset(8): Di chuyển con trỏ đến ptu thứ 9 để mở rộng thêm 1 trang 
        - limit(8): Giới hạn 8 ptu
        - use: Sử dụng để chuyển các biến từ bên ngoài vào hàm callback trong when()
        */
        return $products;
    }

    public function getProductBySlug($slug)
    {
        $product = Product::where('slug', $slug)
                        ->where('active', 1)
                        ->with('menu')
                        ->firstOrFail();
        return $product;
    }

    public function relatedProducts($slug)
    {
        $relatedProducts = Product::where('active', 1)
                                ->where('menu_id', $this->getProductBySlug($slug)->menu_id)
                                ->where('slug', '!=', $slug)
                                ->limit(8)
                                ->get();
        return $relatedProducts;
    }

}