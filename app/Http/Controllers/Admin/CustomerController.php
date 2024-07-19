<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Session;
use App\Traits\HelperTrait;

class CustomerController extends Controller
{
    use HelperTrait;

    public function list(Request $request){
        return view('admin.customer.list', [
            'title' => 'Danh sách khách hàng',
            'customers' => self::getAll($request, Customer::class),
        ]);
    }

    public function delete($id){
        $customer = Customer::find($id);
        $customer->delete();
        Session::flash('success', 'Xóa khách hàng thành công');
        return redirect()->back();
    }
}
