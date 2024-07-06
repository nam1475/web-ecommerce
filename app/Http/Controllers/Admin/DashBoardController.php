<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DashBoardController extends Controller
{
    public function index()
    {
        $statusPending = Order::where('status', 1)->count();
        $statusDelivering = Order::where('status', 2)->count();
        $statusSuccess = Order::where('status', 3)->count(); 
        $statusCancel = Order::where('status', 4)->count(); 
        $totalRevenue = DB::table('orders')
                            ->join('order_product', 'order_product.order_id', '=', 'orders.id')
                            ->where('orders.status', 3)
                            ->sum('order_product.total');
        
        return view('admin.layout.dashboard', [
            'title' => 'Thống Kê',
            'statusPending' => $statusPending,
            'statusDelivering' => $statusDelivering,
            'statusSuccess' => $statusSuccess,
            'statusCancel' => $statusCancel,
            'totalRevenue' => $totalRevenue,    
        ]);
    }
}

?>