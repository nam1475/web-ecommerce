<?php

namespace App\Http\Services\Admin;

use App\Models\Order;
use Illuminate\Support\Facades\Session;

class OrderService{
    public function getOrders($request)
    {
        /* Lấy ra 10 bản ghi mỗi trang */
        $orders = Order::paginate(10);
        // dd($orders);
        if($search = $request->search){
            $orders = Order::where('id', '=', $search)
                            ->orWhere('name', 'like', '%' . $search . '%')
                            ->orWhere('address', 'like', '%' . $search . '%')
                            ->paginate(10);  
        }
        if($status = $request->input('filter-status')){
            $orders = Order::where('status', '=', $status)
                            ->paginate(10);
        }
        return $orders;
    }

    public function getProductForOrder($order)
    {
        /* Lấy ra những product ở trong 1 order */
        $orderProducts = $order->orderProducts()->with(['product' => function ($query) {
            $query->select('id', 'name', 'thumb');
        }])->get();
        return $orderProducts;
    }

    public function delete($id){
        try {
            Order::find($id)->delete();
            Session::flash('success', 'Xóa Đon Hàng Thành Công');
        } catch (\Exception $err) {
            Session::flash('error', $err->getMessage());
            return false;
        }
        return true;
    }
}