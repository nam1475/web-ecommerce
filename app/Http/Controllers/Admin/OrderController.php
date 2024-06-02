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

    public function listCustomer(Request $request)
    {
        $statusPending = Customer::where('status', 1)->count();
        $statusDelivering = Customer::where('status', 2)->count();
        $statusSuccess = Customer::where('status', 3)->count();
        $statusCancelOrder = Customer::where('status', 4)->count();

        /* 
        - distinct(): Lấy ra các giá trị duy nhất (Ko trùng lặp) 
        - pluck(): Lấy ra mảng các giá trị trong cột đó 
        - select(): Trả về 1 collection chứa các giá trị trong cột đó
        */
        // $status = Customer::pluck('status');
        // $status = Customer::select('status')->get();
        $status = Customer::select('status')->distinct()->orderBy('status')->pluck('status');

        // dd($status);

        return view('admin.order.customer', [
            'title' => 'Danh Sách Đặt Hàng',
            'customers' => $this->order->getCustomers($request),
            'statusPending' => $statusPending,
            'statusDelivering' => $statusDelivering,
            'statusSuccess' => $statusSuccess,
            'statusCancelOrder' => $statusCancelOrder,
            'status' => $status
        ]);
    }

    public function customerOrderList($id){
        $customer = Customer::findOrFail($id);
        $orders = $this->order->getProductForOrder($customer);

        return view('admin.order.detail', [
            'title' => 'Chi Tiết Đơn Hàng Của: ' . $customer->name,     
            'customer' => $customer,
            'orders' => $orders
        ]);
    }

    public function updateStatus(Request $request, $id){
        $orderStatus = Customer::findOrFail($id);
        $orderStatus->status = $request->input('status');
        $orderStatus->save();   
        return redirect()->route('customer.list');
    }

    public function delete($id)
    {
        $this->order->delete($id);
        return redirect()->route('customer.list');
    }

    
}
