<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Shop\ShopCartService;
use Illuminate\Support\Facades\Session;

class ShopCartController extends Controller
{
    private $cartShopService;
    
    public function __construct(ShopCartService $cartShopService){
        $this->cartShopService = $cartShopService;
    }

    public function add(Request $request){
        $addCart = $this->cartShopService->addToCart($request);
        if($addCart == false){
            return redirect()->back();
        }
        Session::flash('success', 'Đã thêm sản phẩm vào giỏ hàng');
        return redirect()->back();
    }

    public function list(){
        $products = $this->cartShopService->getProduct();
        // dd(Session::get('carts'));

        return view('shop.cart.list', [
            'title' => 'Giỏ Hàng',
            'products' => $products,
            'carts' => Session::get('carts')
        ]);
    }

    public function update(Request $request)
    {
        $result = $this->cartShopService->update($request);
        if ($result == false) {
            return redirect()->back();
        }
        return redirect()->route('shop.cart.list');
    }

    public function remove($id)
    {
        $result = $this->cartShopService->remove($id);
        if ($result == false) {
            return redirect()->back();
        }
        return redirect()->route('shop.cart.list');
    }

    public function addOrder(Request $request){
        // dd($request->input());
        $result = $this->cartShopService->addOrder($request); 
        if($result){
            return redirect()->route('shop.cart.list');
        }
        return redirect()->back();
    }
}
