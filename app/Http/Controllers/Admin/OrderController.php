<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Admin\OrderService;
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

    public function orderList(Request $request)  
    {
        $statusPending = Order::where('status', 1)->count();
        $statusDelivering = Order::where('status', 2)->count();
        $statusSuccess = Order::where('status', 3)->count();
        $statusCancelOrder = Order::where('status', 4)->count();
        
        /* 
        - distinct(): Lấy ra các giá trị duy nhất (Ko trùng lặp) 
        - pluck(): Lấy ra mảng các giá trị trong cột đó 
        - select(): Trả về 1 collection chứa các giá trị trong cột đó
        */
        // $status = Order::pluck('status');
        // $status = Order::select('status')->get();
        $status = Order::select('status')->distinct()->orderBy('status')->pluck('status');
        // dd($status);

        return view('admin.order.list', [
            'title' => 'Danh Sách Đơn Hàng',
            'orders' => $this->order->getOrders($request),
            'statusPending' => $statusPending,
            'statusDelivering' => $statusDelivering,
            'statusSuccess' => $statusSuccess,
            'statusCancelOrder' => $statusCancelOrder,
            'status' => $status
        ]);
    }

    public function orderDetail($id){
        $order = Order::find($id);
        $orderProducts = $this->order->getProductForOrder($order);

        return view('admin.order.detail', [
            'title' => 'Chi Tiết Đơn Hàng Của: ' . $order->name,     
            'order' => $order,
            'orderProducts' => $orderProducts
        ]);
    }

    public function updateStatus(Request $request, $id){
        $orderStatus = Order::find($id);
        $orderStatus->status = $request->input('status');
        $orderStatus->save();   
        Session::flash('success', 'Cập nhật trạng thái thành công');
        return redirect()->route('order.list');
    }

    public function delete($id)
    {
        $result = $this->order->delete($id);
        if($result){
            return redirect()->route('order.list');
        }
        return redirect()->back();
    }

    
}
