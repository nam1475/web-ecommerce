<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Cart\CartShopService;
use Illuminate\Support\Facades\Session;

class ShopCartController extends Controller
{
    private $cartShopService;
    
    public function __construct(CartShopService $cartShopService){
        $this->cartShopService = $cartShopService;
    }

    public function add(Request $request){
        $addCart = $this->cartShopService->add($request);
        if($addCart == false){
            return redirect()->back();
        }
        return redirect()->route('shop.cart.list');
    }

    public function list(){
        $products = $this->cartShopService->getProduct();

        return view('shop.cart.list', [
            'title' => 'Giỏ Hàng',
            'products' => $products,
            'carts' => Session::get('carts')
        ]);
    }

    public function update(Request $request)
    {
        $this->cartShopService->update($request);

        return redirect()->route('shop.cart.list');
    }

    public function remove($id)
    {
        $this->cartShopService->remove($id);

        return redirect()->route('shop.cart.list');
    }

    public function addOrder(Request $request){
        // dd($request->input());
        $this->cartShopService->addOrder($request); 
        return redirect()->back();
    }
}
