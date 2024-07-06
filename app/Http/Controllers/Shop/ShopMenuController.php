<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Admin\MenuService;
use App\Http\Services\Admin\ProductAdminService;
use App\Traits\HelperTrait;

class ShopMenuController extends Controller
{
    protected $menuService;
    protected $productAdminService;

    public function __construct(MenuService $menuService, ProductAdminService $productAdminService){
        $this->menuService = $menuService;
        $this->productAdminService = $productAdminService;
    }

    public function index(Request $request, $slug){
        $menu = $this->menuService->getMenuBySlug($slug);
        $products = $this->menuService->getProductsByMenu($menu, $request);
        $highestPrice = $this->menuService->getHighestProductPriceByMenu($menu);  
        $menuProducts = $this->menuService->getMenuProducts($menu);

        return view('shop.menu.list', [
            'title' => $menu->name,
            'products' => $products,
            'highestPrice' => $highestPrice,
            'menu' => $menu,
            'menuProducts' => $menuProducts,
            'slug' => $slug
        ]);
    }

    public function filterQueryString(Request $request, $slug)
    {
        return HelperTrait::filterQueryString($request, 'shop.menu.list',  $slug);
    }
}
