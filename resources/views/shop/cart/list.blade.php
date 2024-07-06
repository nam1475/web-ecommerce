@extends('shop.layout.main')

@section('content')
    {{-- action để rỗng thì sẽ submit ở chính trang đấy --}}
    <form class="bg0 p-t-130 p-b-85" method="POST" action="">
        @if (count($products) != 0)
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                        <div class="m-l-25 m-r--38 m-lr-0-xl">
                            <div class="wrap-table-shopping-cart">
                                <table class="table-shopping-cart">
                                    <tbody>
                                    <tr class="table_head">
                                        <th class="column-1">Sản phẩm</th>
                                        <th class="column-2"></th>
                                        <th class="column-3">Giá</th>
                                        <th class="column-3">Size</th>
                                        <th class="column-4">Số lượng</th>
                                        <th class="column-5">Tổng phụ</th>
                                        <th class="column-6"></th>   
                                    </tr>

                                    @php 
                                        $total = 0; 
                                        // $priceEnd = 0;
                                    @endphp
                                    @foreach($carts as $key => $item)
                                        @php
                                            $price = $item['price_sale'] != 0 ? $item['price_sale'] : $item['price'];
                                            $priceEnd = $price * $item['quantity'];
                                            // dd($carts);
                                            $total += $priceEnd;
                                            $size = App\Models\Size::findOrFail($item['size_id']); 
                                        @endphp
                                        
                                        <tr class="table_row">
                                            <td class="column-1">
                                                <div class="how-itemcart1">
                                                    <img src="{{ $item['thumb'] }}" alt="IMG">
                                                </div>
                                            </td>
                                            <td class="column-2">{{ $item['name'] }}</td>
                                            <td class="column-3">{{ number_format($price, 0, '', '.') }}</td>
                                            <td>{{ $size->name }}</td>
                                            <td class="column-4">
                                                <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                                    <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                                        <i class="fs-16 zmdi zmdi-minus"></i>
                                                    </div>

                                                    <input class="mtext-104 cl3 txt-center num-product" type="number"
                                                           name="num_product[{{ $key }}]" value="{{ $item['quantity'] }}">
                                                    
                                                    <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                                        <i class="fs-16 zmdi zmdi-plus"></i>
                                                    </div>

                                                    <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                                                </div>
                                            </td>
                                            <td class="column-5">{{ number_format($priceEnd, 0, '', '.') }}đ</td>
                                            <td class="column-6">
                                                <a href="{{ route('shop.cart.remove', $key) }}">Xóa</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm d-flex justify-content-end">
                                {{-- <form action="{{ route('shop.cart.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                        class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
                                        Update Cart 
                                    </button>
                                </form> --}}
                                
                                <input type="submit" value="Cập Nhật Giỏ Hàng" formaction="{{ route('shop.cart.update') }}"
                                    class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
                                    @csrf
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                        <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                            <div class="flex-w flex-t p-t-27">
                                <div class="size-208">
                                    <h4 class="mtext-109 cl2 p-b-30">
                                        Tổng:
                                    </h4>
                                </div>

                                <div class="size-209 p-t-1">
                                    <span class="mtext-110 cl2">
                                        {{ number_format($total, 0, '', '.') }}đ
                                    </span>
                                </div>
                            </div>

                            <div class="flex-w flex-t bor12 p-t-15 p-b-30">
                                <div class="size-100 p-r-18 p-r-0-sm w-full-ssm">
                                    @php
                                        $customer = auth('customer')->user();
                                    @endphp

                                    <div class="p-t-15">
                                        <h6 class="mtext-109 cl2 p-b-10">
                                            Thông Tin Khách Hàng
                                        </h6>
                                        <div class="bor8 bg0 m-b-12">
                                            <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="name" value="{{ $customer->name }}" placeholder="Họ tên">
                                        </div>
                                        
                                        <div class="bor8 bg0 m-b-12">
                                            <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="phone" value="{{ $customer->phone }}" placeholder="Số Điện Thoại">
                                        </div>

                                        <div class="bor8 bg0 m-b-12">
                                            <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="address" value="{{ $customer->address }}" placeholder="Địa Chỉ Giao Hàng">
                                        </div>

                                        <div class="bor8 bg0 m-b-12">
                                            <textarea class="stext-111 cl8 plh3 size-111 p-lr-15" name="content" value="{{ old('content') }}" placeholder="Ghi Chú"></textarea>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <button class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer" type="submit">
                               Đặt Hàng
                            </button>
                        </div>
                    </div>
                </div>
            </div>
    </form>
    @else
        <div class="text-center"><h2>Giỏ hàng trống</h2></div>
    @endif
@endsection