<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Product\ProductShopService;

class ShopProductController extends Controller
{
    protected $productService;
    
    public function __construct(ProductShopService $productService){
        $this->productService = $productService;
    }
    
    public function index($id, $slug){
        $product = $this->productService->show($id);
        $products = $this->productService->relatedProducts($id);
        return view('shop.product.detail', [
            'title' => $product->name,
            'product' => $product,
            'products' => $products
        ]);
    }
}
