<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Admin\OrderService;
use App\Models\Order;

class ShopOrderController extends Controller
{
    protected $order;
    public function __construct(OrderService $order)
    {
        $this->order = $order;
    }

    public function customerOrderList(){
        // $order = Order::findOrFail(auth('customer')->user()->id);
        $order = Order::where('customer_id', auth('customer')->user()->id)->first();
        $orderProducts = $this->order->getProductForOrder($order);

        return view('shop', [
            'title' => 'Chi Tiết Đơn Hàng Của: ' . $order->name,     
            'order' => $order,
            'orderProducts' => $orderProducts
        ]);
    }
}
