<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Menu\MenuService;

class ShopMenuController extends Controller
{
    protected $menuService;

    public function __construct(MenuService $menuService){
        $this->menuService = $menuService;
    }

    public function index(Request $request, $id, $slug = ''){
        $menu = $this->menuService->getId($id);
        $products = $this->menuService->getProducts($menu, $request);
        return view('shop.menu.list', [
            'title' => $menu->name,
            'products' => $products,
            'menu' => $menu,
        ]);
    }
}
