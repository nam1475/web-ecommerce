<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Services\Admin\OrderService;
use App\Models\Order;
use App\Http\Requests\Shop\InfoFormRequest;
use App\Http\Services\Shop\ShopCustomerService;

class ShopCustomerController extends Controller
{
    protected $order;
    protected $customerService;

    public function __construct(OrderService $order, ShopCustomerService $customerService)
    {
        $this->order = $order;
        $this->customerService = $customerService;
    }

    public function profileInfo(){
        return view('shop.customer.info', [
            'title' => 'Profile'
        ]);
    }

    public function profileInfoEdit($id){
        $customer = Customer::find($id);
        return view('shop.customer.info.edit', [
            'title' => 'Profile',
            'customer' => $customer
        ]);
    }

    public function profilePasswordUpdate(InfoFormRequest $request, $id){
        $result = $this->customerService->profilePasswordUpdate($request, $id);
        if($result){
            return redirect()->back();
        }
        return redirect()->back();
    }
    
    public function profileInfoUpdate(Request $request, $id){
        $result = $this->customerService->profileInfoUpdate($request, $id);
        if($result){
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function profileOrder(Request $request){
        // $orders = Order::where('customer_id', auth('customer')->user()->id)->get();
        // dd($orders);
        $orders = $this->customerService->getCustomerOrders($request);

        $orderProducts = collect();
        foreach($orders as $od){
            $orderProducts = $orderProducts->push($od->orderProducts()->with('product', 'order')->get());
        }
        // dd($orderProducts);
        
        $status = Order::select('status')->distinct()->orderBy('status')->pluck('status');

        return view('shop.customer.order', [
            'title' => 'Order',     
            'orders' => $orders,
            'orderProducts' => $orderProducts,
            'status' => $status
        ]);
    }

    public function cancelOrder($id){
        $result = $this->customerService->cancelOrder($id);
        if($result){
            return redirect()->route('shop.profile.order');
        }
        return redirect()->back();
    }
}
