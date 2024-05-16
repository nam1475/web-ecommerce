<?php

namespace App\Http\Services\Cart;

use App\Jobs\SendMail;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartShopService{
    public function add($request){
        $qty = $request->input('num_product');
        $product_id = $request->input('product_id');

        if ($qty <= 0 || $product_id <= 0) {
            Session::flash('error', 'Số lượng hoặc Sản phẩm không chính xác');
            return false;
        }

        $carts = Session::get('carts');
        if (is_null($carts)) {
            /* Nếu ko có key carts thì sẽ set value mặc định là một mảng bao gồm key-value: $product_id => $quantity,
            để lấy ra value($quantity) thì $carts[$product_id] */
            Session::put('carts', [
                $product_id => $qty
            ]);
            return true;
        }

        /* Nếu tồn tại key $product_id và người dùng thêm quantity */
        $existKey = Arr::exists($carts, $product_id);
        if ($existKey) {
            $carts[$product_id] = $carts[$product_id] + $qty;
            Session::put('carts', $carts);
            return true;
        }

        $carts[$product_id] = $qty;
        Session::put('carts', $carts);
        return true;
    }

    public function getProduct()
    {
        $carts = Session::get('carts');

        /* Nếu ko tồn tại $carts thì sẽ trả về mảng rỗng */
        if (is_null($carts)){
            return [];
        } 

        /* Lấy ra key của mảng carts (Trong TH này sẽ trả về id của product) */
        $productId = array_keys($carts);
        return Product::select('id', 'name', 'price', 'price_sale', 'thumb')
            ->where('active', 1)
            ->whereIn('id', $productId)
            ->get();
    }

    public function update($request){
        try {
            Session::put('carts', $request->input('num_product'));  
            Session::flash('success', 'Cập Nhật Giỏ Hàng Thành Công');
            return true;
        } catch (\Exception $err) {
            Session::flash('error', $err->getMessage());
            return false;
        }
    }
    
    public function remove($id){
        try {
            $carts = Session::get('carts');
            unset($carts[$id]);
            Session::put('carts', $carts);
            Session::flash('success', 'Xóa Khỏi Giỏ Hàng Thành Công');
            return true;
        } catch (\Exception $err) {
            Session::flash('error', $err->getMessage());
            return false;
        }
    }

    public function addOrder($request){
        try {
            /* Đảm bảo rằng tất cả các thao tác này đều thành công trước khi thực sự ghi nhận chúng 
            vào cơ sở dữ liệu */
            DB::beginTransaction();

            $carts = Session::get('carts');

            if (is_null($carts)){
                return false;
            }

            $customer = Customer::create([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'email' => $request->input('email'),
                'content' => $request->input('content')
            ]);

            $this->infoProductCart($carts, $customer->id);

            /* Nếu tất cả các thao tác đều thành công, commit giao dịch */
            DB::commit();
            Session::flash('success', 'Đặt Hàng Thành Công');

            /* Gửi email đi thông qua hàng đợi(Queue) để giảm tải khối lượng request, tách ra đặt hàng riêng, gửi mail riêng
            để tăng hiệu suất web 
            - dispatch(): Chuyển tới default connection's default queue
            */
            #Queue
            SendMail::dispatch($request->input('email'))->delay(now()->addSeconds(2));
            
            /* Xóa các value trong key carts khỏi session, trong TH này là xóa sản phẩm khỏi giỏ hàng */
            Session::forget('carts');
            return true;
        } catch (\Exception $err) {
            /* Nếu có lỗi xảy ra, rollback giao dịch */
            DB::rollBack();
            Session::flash('error', 'Đặt Hàng Lỗi, Vui lòng thử lại sau');
            return false;
        }

    }
    
    protected function infoProductCart($carts, $customer_id)
    {
        $productId = array_keys($carts);
        $products = Product::select('id', 'name', 'price', 'price_sale', 'thumb')
            ->where('active', 1)
            ->whereIn('id', $productId)
            ->get();

        $data = [];
        foreach ($products as $product) {
            $data[] = [
                'customer_id' => $customer_id,
                'product_id' => $product->id,
                'quantity'   => $carts[$product->id],
                'price' => $product->price_sale != 0 ? $product->price_sale : $product->price
            ];
        }

        return Order::insert($data);
    }

    
}