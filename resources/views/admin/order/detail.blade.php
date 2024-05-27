@extends('admin.layout.main')

@section('content')
    <div class="customer mt-3 d-flex justify-content-around">
        <ul>
            <li>Tên khách hàng: <strong>{{ $customer->name }}</strong></li>
            <li>Số điện thoại: <strong>{{ $customer->phone }}</strong></li>
            <li>Địa chỉ: <strong>{{ $customer->address }}</strong></li>
            <li>Email: <strong>{{ $customer->email }}</strong></li>
            <li>Ghi chú: <strong>{{ $customer->content }}</strong></li>
        </ul>

        <form action="{{ route('order.update', $customer->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Trạng thái đơn hàng</label>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" value="1" id="pending" type="radio" name="status" {{ $customer->status == 1 ? 'checked' : '' }}>
                    <label for="pending" class="custom-control-label">Đang chờ duyệt</label>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" id="delivering" value="2" type="radio" name="status" {{ $customer->status == 2 ? 'checked' : '' }}>
                    <label for="delivering" class="custom-control-label">Đang giao hàng</label>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" id="success" value="3" type="radio" name="status" {{ $customer->status == 3 ? 'checked' : '' }}>
                    <label for="success" class="custom-control-label">Giao hàng thành công</label>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" id="cancel-order" value="4" type="radio" name="status" {{ $customer->status == 4 ? 'checked' : '' }}>
                    <label for="cancel-order" class="custom-control-label">Hủy đơn</label>
                </div>
                <button type="submit" class="btn btn-primary ">Cập Nhật Trạng Thái</button>
            </div>
        </form>
    </div>

    <div class="carts">
        {{-- Khai báo biến toàn cục $total để lưu giá trị --}}
        @php $total = 0; @endphp
        <table class="table">
            <tbody>
            <tr class="table_head">
                <th class="column-1">IMG</th>
                <th class="column-2">Product</th>
                <th class="column-3">Price</th>
                <th class="column-4">Quantity</th>
                <th class="column-5">Total</th>
            </tr>

            @foreach($orders as $order)
                @php
                    $price = $order->price * $order->quantity;
                    $total += $price;
                @endphp
                <tr>
                    <td class="column-1">
                        <div class="how-itemcart1">
                            <img src="{{ $order->product->thumb }}" alt="IMG" style="width: 100px">
                        </div>
                    </td>
                    <td class="column-2">{{ $order->product->name }}</td>
                    <td class="column-3">{{ number_format($order->price, 0, '', '.') }}</td>
                    <td class="column-4">{{ $order->quantity }}</td>
                    <td class="column-5">{{ number_format($price, 0, '', '.') }}</td>
                </tr>
            @endforeach
                <tr>
                    <td colspan="4" class="text-right">Tổng Tiền</td>
                    <td>{{ number_format($total, 0, '', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection