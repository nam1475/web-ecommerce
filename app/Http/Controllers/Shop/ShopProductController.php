<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Shop\ShopProductService;
use App\Http\Services\Admin\ProductAdminService;

class ShopProductController extends Controller
{
    protected $productService;
    protected $producAdmintService;

    
    public function __construct(ShopProductService $productService, ProductAdminService $producAdmintService){
        $this->productService = $productService;
        $this->producAdmintService = $producAdmintService;
    }
    
    public function index($slug){
        $product = $this->productService->getProductBySlug($slug);
        $products = $this->productService->relatedProducts($slug);
        $productSizes = $this->producAdmintService->getProductSizes($slug);
        // dd($productSizes);
        return view('shop.product.detail', [
            'title' => $product->name,
            'product' => $product,
            'products' => $products,
            'productSizes' => $productSizes
        ]);
    }
}
