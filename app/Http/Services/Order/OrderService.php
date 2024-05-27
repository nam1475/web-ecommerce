<?php

namespace App\Http\Services\Order;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class OrderService{
    public function getCustomers($request)
    {
        $customers = Customer::paginate(10);
        if($search = $request->search){
            $customers = Customer::where('id', '=', $search)
                            ->orWhere('name', 'like', '%' . $search . '%')
                            ->orWhere('address', 'like', '%' . $search . '%')
                            ->orWhere('status', '=', $search)
                            ->paginate(10);  
        }
        if($status = $request->input('filter-status')){
            $customers = Customer::where('status', '=', $status)
                            ->paginate(10);
        }
        return $customers;
    }

    public function getProductForOrder($customer)
    {
        /* Lấy ra những product mà customer đã đặt hàng */
        return $customer->orders()->with(['product' => function ($query) {
            $query->select('id', 'name', 'thumb');
        }])->get();
    }

    public function delete($id){
        try {
            Customer::find($id)->delete();
            Session::flash('success', 'Xóa Sản Phẩm Thành Công');
        } catch (\Exception $err) {
            Session::flash('error', $err->getMessage());
            return false;
        }
        return true;
    }
}