<?php

namespace App\Http\Services\Product;

use App\Models\Product;

class ProductShopService{

    const LIMIT = 8;
    public function getProducts($page = null){
        $products = Product::select('id', 'name', 'price', 'price_sale', 'thumb')
            ->orderBy('price')
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

    public function show($id)
    {
        $product = Product::where('id', '=', $id)
                        ->where('active', '=', 1)
                        ->with('menu')
                        ->findOrFail($id);
        return $product;
    }

    public function relatedProducts($id)
    {
        $relatedProducts = Product::select('id', 'name', 'price', 'price_sale', 'thumb')
            ->where('active', 1)
            ->where('id', '!=', $id)
            ->orderByDesc('id')
            ->limit(8)
            ->get();
        return $relatedProducts;
    }

}