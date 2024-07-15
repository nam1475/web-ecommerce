<?php

namespace App\Http\Services\Shop;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Traits\HelperTrait;
use App\Models\Size;

class ShopCartService{
    public function addToCart($request){
        $qty = $request->input('num_product');
        $product_id = $request->input('product_id');
        $sizeId = $request->input('size_id');
        // $size = Size::findOrFail($sizeId);
        $product = Product::findOrFail($product_id);
        $key = $product_id . '_' . $sizeId;
        
        if ($qty <= 0 || $product_id <= 0 || empty($sizeId)) {
            Session::flash('error', 'Số lượng hoặc Size không chính xác');
            return false;
        }

        $carts = Session::get('carts');
        /* Nếu chưa có $carts(Giỏ hàng ko có sản phẩm nào) thì sẽ thêm sản phẩm mới vào */
        if (is_null($carts)) {
            Session::put('carts', [
                $key => [
                    'product_id' => $product_id,
                    'size_id' => $sizeId,
                    'quantity' => $qty,
                    'name' => $product->name,
                    'price' => $product->price,
                    'price_sale' => $product->price_sale,
                    'thumb' => $product->thumb
                ],  
            ]);
            return true;
        }

        /* Nếu sản phẩm tiếp theo thêm vào trùng với sản phẩm trong giỏ hàng và trùng size thì sẽ tăng 
        quantity lên */
        $existKey = Arr::exists($carts, $key);
        if ($existKey) {
            $carts[$key]['quantity'] += $qty;
            Session::put('carts', $carts);
            return true;
        }

        /* Nếu sản phẩm tiếp theo thêm vào ko trùng với sản phẩm trong giỏ hàng thì thêm mới */
        $carts[$key] = [
            'product_id' => $product_id,
            'size_id' => $sizeId,
            'quantity' => $qty,
            'name' => $product->name,
            'price' => $product->price,
            'price_sale' => $product->price_sale,
            'thumb' => $product->thumb,
        ];  
        Session::put('carts', $carts);
        // dd(Session::get('carts'));
        return true;
        
    }

    public function getProduct()
    {
        $carts = Session::get('carts');
        // dd($carts);

        /* Nếu ko tồn tại $carts thì sẽ trả về mảng rỗng */
        if (is_null($carts)){
            return [];
        } 

        /* Lấy ra key của mảng carts (Trong TH này sẽ trả về id của product) */
        $productId = array_keys($carts);
        return Product::where('active', 1)
            ->whereIn('id', $productId)
            ->get();
    }

    public function update($request){
        try {
            $carts = Session::get('carts');

            /* Lặp qua từng key quantity trong $carts và cập nhật lại quantity */
            foreach ($carts as $key => $item) {
                $carts[$key]['quantity'] = $request->num_product[$key];
            }
            Session::put('carts', $carts);  
            // dd(Session::get('carts'));
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

            $customer = auth('customer')->user();
            $order = Order::create([
                'customer_id' => $customer->id,
                'name' => $customer->name,
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'email' => $customer->email,
                'content' => $request->input('content'),
                'status' => 1,  
            ]);

            /* Cập nhật lại info khách hàng nếu có thay đổi */
            Customer::findOrFail($customer->id)->update([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
            ]);
            
            $this->infoProductCart($carts, $order->id);

            /* Nếu tất cả các thao tác đều thành công, commit giao dịch */
            DB::commit();
            Session::flash('success', 'Đặt Hàng Thành Công');

            $data = [
                'title' => 'Order Success',
                'email' => $customer->email,
                'name' => 'Fein Clothing',
                'body' => 'see your order',
                'route' => 'shop.profile.order'
            ];

            HelperTrait::sendMail($data);
            
            /* Xóa các value trong key carts khỏi session, trong TH này là xóa sản phẩm khỏi giỏ hàng */
            Session::forget('carts');
            return true;
        } catch (\Exception $err) {
            /* Nếu có lỗi xảy ra, rollback giao dịch */
            DB::rollBack();
            Session::flash('error', $err->getMessage());
            return false;
        }

    }
    
    protected function infoProductCart($carts, $orderID)
    {
        $data = [];
        foreach ($carts as $item) {
            $data[] = [
                'order_id' => $orderID,
                'product_id' => $item['product_id'],
                'size_id' => $item['size_id'],
                'quantity'   => $item['quantity'],
                'price' => $item['price_sale'] != 0 ? $item['price_sale'] : $item['price'],
                'total' => $item['price_sale'] != 0 ? $item['price_sale'] * $item['quantity'] : $item['price'] * $item['quantity'],
            ];
        }
        // dd($data);

        return OrderProduct::insert($data);
    }

    
}