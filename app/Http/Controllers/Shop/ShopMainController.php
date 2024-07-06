<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Admin\SliderService;
use App\Http\Services\Admin\MenuService;
use App\Http\Services\Shop\ShopProductService;
use App\Traits\HelperTrait;
use App\Models\Menu;

class ShopMainController extends Controller
{
    protected $slider;
    protected $product;
    
    public function __construct(SliderService $slider, ShopProductService $product)
    {
        $this->slider = $slider;
        $this->product = $product;
    }

    public function index(){
        return view('shop.layout.home', [
            'title' => 'Shop bán quần áo',
            'sliders' => $this->slider->show(),
            'menus' => HelperTrait::getParents(Menu::class),
            'products' => $this->product->getProducts()
        ]); 
    }
    
    public function loadProduct(Request $request)
    {
        $page = $request->input('page'); // Đặt gtri mặc định cho page = 0
        $products = $this->product->getProducts($page);
        /* Đếm số lượng ptu trong 1 mảng hoặc collection */
        if (count($products) != 0) {
            $html = view('shop.product.list', ['products' => $products])->render();

            return response()->json([ 'html' => $html ]);
        }

        return response()->json(['html' => '' ]);
    }
}
