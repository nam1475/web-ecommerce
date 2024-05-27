<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Order\OrderService;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DashBoardController extends Controller
{
    public function index()
    {
        $statusPending = Customer::where('status', 1)->count();
        $statusDelivering = Customer::where('status', 2)->count();
        $statusSuccess = Customer::where('status', 3)->count(); 
        $statusCancel = Customer::where('status', 4)->count(); 
        $totalRevenue = DB::table('customers')
                            ->join('orders', 'orders.customer_id', '=', 'customers.id')
                            ->where('customers.status', 3)
                            ->sum('orders.total');
        
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