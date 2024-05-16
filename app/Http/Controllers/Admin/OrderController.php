<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Order\OrderService;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    protected $order;
    public function __construct(OrderService $order)
    {
        $this->order = $order;
    }

    public function listCustomer()
    {
        return view('admin.order.customer', [
            'title' => 'Danh Sách Khách Hàng',
            'customers' => $this->order->getCustomers()
        ]);
    }

    public function listOrder($id){
        $customer = Customer::findOrFail($id);
        $orders = $this->order->getProductForOrder($customer);

        return view('admin.order.detail', [
            'title' => 'Chi Tiết Đơn Hàng Của: ' . $customer->name,     
            'customer' => $customer,
            'orders' => $orders
        ]);
    }

    public function delete($id)
    {
        $this->order->delete($id);
        return redirect()->route('customer.list');
    }

    
}
