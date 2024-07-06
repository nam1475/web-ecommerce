<?php

namespace App\Http\Services\Shop;

use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Order;

class ShopCustomerService{
    public function profilePasswordUpdate($request, $id){
        $request->validated();

        try{
            $customer = Customer::find($id);
            $customer->password = Hash::make($request->newPassword);
            $customer->save();

            Session::flash('success', 'Cập nhật mật khẩu thành công!');
        }catch(\Exception $e){
            Session::flash('error', $e->getMessage());
            return false;
        }
        return true;
    }

    public function profileInfoUpdate($request, $id){
        // $request->validated();

        try{
            $customer = Customer::find($id);
            $customer->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address
            ]);                

            Session::flash('success', 'Cập nhật thông tin thành công!');
        }catch(\Exception $e){
            Session::flash('error', $e->getMessage());
            return false;
        }
        return true;
    }

    public function cancelOrder($id){
        try{
            $order = Order::find($id);
            $order->status = 4;
            $order->save();
            Session::flash('success', 'Đơn hàng đã được hủy!');
        }catch(\Exception $e){
            Session::flash('error', $e->getMessage());
            return false;
        }
        return true;
    }

    public function getCustomerOrders($request){
        $orders = Order::where('customer_id', auth('customer')->user()->id);
        
        if($search = $request->search){
            $orders->where('id', '=', $search)
                            ->orWhere('name', 'like', '%' . $search . '%')
                            ->orWhere('address', 'like', '%' . $search . '%');  
        }
        if($status = $request->input('filter-order')){
            $orders->where('status', '=', $status);
        }
        return $orders->get();
    }
}