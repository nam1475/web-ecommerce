@extends('shop.customer.profile')

@section('profile')

<div class="container">
    <ul class="nav justify-content-center text-uppercase">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('shop.profile.order') }}" id="all">Tất cả</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="?filter-order=1" id="pending">Đang chờ duyệt</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="?filter-order=2" id="delivering">Đang giao hàng</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="?filter-order=3" id="success">Giao hàng thành công</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="?filter-order=4" id="cancel">Đơn đã hủy</a>
        </li>
    </ul>
</div>

@if(!$orderProducts->isEmpty())
    @foreach($orderProducts as $item)
        @if(!$item->isEmpty()) 
        <div class="card mt-5 p-3">
            @php
                $uniqueOrderStatus = [];
                $uniqueOrderID = [];
                $total = 0; 
                $orderID = 0;
                $status = 0;
            @endphp    
            @foreach ($item as $i)
                @php
                    $subtotal = $i->total;
                    $total += $subtotal;
                @endphp 
                <div class="mb-1">
                    <div class="d-flex justify-content-between align-items-center my-3">
                        {{-- Loại bỏ order id bị trùng --}}
                        @if(!in_array($i->order->id, $uniqueOrderID))
                            @php
                                array_push($uniqueOrderID, $i->order->id);
                                $orderID = $i->order->id;
                            @endphp

                            <div>
                                <h5><i class="fa-solid fa-circle-info"></i>Thông tin đặt hàng</h5>
                                {{ $i->order->name }}<br>
                                {{ $i->order->phone }}<br>
                                {{ $i->order->address }}<br>
                                {{ $i->order->email }}<br>
                                {{ $i->order->created_at->format('Y-m-d') }}<br>
                                <b>Ghi chú:</b> {{ $i->order->content }}
                            </div>
                            
                            <p><i class="fa-solid fa-cube"></i>Mã đơn hàng: #{{ $i->order->id }}</p>
                        @endif

                        {{-- Loại bỏ order status bị trùng --}}
                        @if(!in_array($i->order->status, $uniqueOrderStatus))
                            @php
                                array_push($uniqueOrderStatus, $i->order->status);
                                $status = $i->order->status;
                            @endphp
                            
                            @switch($i->order->status)
                                @case(1)
                                    <h5 class="text-primary text-center"><i class="fa-solid fa-clock-rotate-left"></i>Đang chờ duyệt</h5>
                                    @break
                                @case(2)
                                    <h5 class="text-info text-center"><i class="fa-solid fa-truck-fast"></i>Đang giao hàng</h5>
                                    @break
                                @case(3)
                                    <h5 class="text-success text-center"><i class="fa-solid fa-circle-check"></i>Giao hàng thành công</h5>
                                    @break
                                @case(4)
                                    <h5 class="text-danger text-center"><i class="fa-solid fa-circle-xmark"></i>Đã hủy đơn</h5>
                                    @break
                                @default
                            @endswitch
                        @endif
                    </div>
                    
                    <hr>    

                    <div class="row g-0">   
                        <div class="col-md-2">
                            <img src="{{ $i->product->thumb }}" class="img-fluid rounded-start" alt="Product Image">
                        </div>
                        <div class="col-md-10">
                            <div class="card-body">
                                <h5 class="card-title">{{ $i->product->name }}</h5>
                                <div class="card-text text-black">Số lượng: x{{ $i->quantity }}</div>
                                <div class="card-text text-black">Size: {{ $i->size->name }}</div>
                                <div class="d-flex justify-content-end">
                                    <p class="card-text">{{ number_format($i->price, 0, '', '.') }}đ</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach


            <div style="background-color: #f2f2f2f4" class="mt-2">
                <div class="d-flex justify-content-end my-2 mr-2">
                    <div>
                        <span><i class="fa-solid fa-dollar-sign"></i>Thành tiền:</span>
                        <span class="fs-25"><b>{{ number_format($total, 0, '', '.') }}đ</b></span>
                    </div>
                </div>
                @if($status == 1 || $status == 2)
                    <!-- Total Price Section -->
                    <div class="d-flex justify-content-end my-2 mx-3">
                        <div>
                            {{-- <button class="btn btn-secondary btn-lg cancel-order" data-route="{{ route('shop.profile.order.cancel', $orderID) }}">Hủy đơn</button> --}}
                            {!! \App\Helpers\Helper::update('shop.profile.order.cancel', $orderID, 'Bạn có chắc muốn hủy đơn ?', 'Hủy đơn') !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @endif
    @endforeach
@else
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="text-center"><i class="fa-solid fa-clipboard"></i>Không có đơn hàng nào!</h5>
        </div>
    </div>
@endif

@section('footer')
<script>
// function cancelOrder(){
    // $('.cancel-order').on('click', function() {
    // /* Thay đổi trạng thái hủy đơn */
    // // var route = $('#cancel-order').data('route');
    // var route = $(this).data('route');
    // console.log(route);
    // $.ajax({
    //     type: 'PUT',
    //     data: { 
    //         _token: $('meta[name="csrf-token"]').attr('content'),
    //     },
    //     url: route,
    //     success: function (result) {
    //         if (result.error == false) {
    //             location.reload();
    //         } else {
    //             alert('Xóa lỗi vui lòng thử lại');
    //         }
    //     },
    //     error: function(jqXHR, textStatus, errorThrown) {
    //         console.error('AJAX error:', textStatus, errorThrown);
    //     }
    // });
    // });
// }

</script>
@endsection

@endsection