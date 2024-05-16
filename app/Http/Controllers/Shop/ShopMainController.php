<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Slider\SliderService;
use App\Http\Services\Menu\MenuService;
use App\Http\Services\Product\ProductShopService;

class ShopMainController extends Controller
{
    protected $slider;
    protected $menu;
    protected $product;
    

    public function __construct(SliderService $slider, MenuService $menu, ProductShopService $product)
    {
        $this->slider = $slider;
        $this->menu = $menu;
        $this->product = $product;
    }

    public function index(){
        return view('shop.layout.home', [
            'title' => 'Shop bán quần áo',
            'sliders' => $this->slider->show(),
            'menus' => $this->menu->show(),
            'products' => $this->product->getProducts()
        ]); 
    }
    
    public function loadProduct(Request $request)
    {
        $page = $request->input('page'); // Đặt gtri mặc định cho page = 0
        $result = $this->product->getProducts($page);
        /* Đếm số lượng ptu trong 1 mảng hoặc collection */
        if (count($result) != 0) {
            $html = view('shop.product.list', ['products' => $result])->render();

            return response()->json([ 'html' => $html ]);
        }

        return response()->json(['html' => '' ]);
    }
}
