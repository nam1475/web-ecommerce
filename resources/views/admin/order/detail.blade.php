@extends('admin.layout.main')

@section('content')
    <div class="invoice p-3 mb-3">
        <div class="row">
            <div class="col-12">
                <h4>
                    <small class="float-right">Ngày tạo: {{ $order->created_at->format('Y-m-d') }}</small>
                </h4>
            </div>
        </div>
        
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col mr-3">
                <h4><i class="fa-solid fa-circle-info"></i> Thông tin khách hàng</h4>
                <hr>
                <b>Tên khách hàng:</b> {{ $order->name }}<br>
                <b>Số điện thoại:</b> {{ $order->phone }}<br>
                <b>Địa chỉ:</b> {{ $order->address }}<br>
                <b>Email:</b> {{ $order->email }}<br>
                <b>Ghi chú:</b> {{ $order->content }}
            </div>
            
            <div class="col-sm-4 invoice-col">
                <form action="{{ route('order.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <h4><i class="fa-solid fa-bookmark"></i> Trạng thái đơn hàng</h4>
                        <hr>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" value="1" id="pending" type="radio" name="status" {{ $order->status == 1 ? 'checked' : '' }}>
                            <label for="pending" class="custom-control-label pointer">Đang chờ duyệt</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" id="delivering" value="2" type="radio" name="status" {{ $order->status == 2 ? 'checked' : '' }}>
                            <label for="delivering" class="custom-control-label pointer">Đang giao hàng</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" id="success" value="3" type="radio" name="status" {{ $order->status == 3 ? 'checked' : '' }}>
                            <label for="success" class="custom-control-label pointer">Giao hàng thành công</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" id="cancel-order" value="4" type="radio" name="status" {{ $order->status == 4 ? 'checked' : '' }}>
                            <label for="cancel-order" class="custom-control-label pointer">Hủy đơn</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Cập Nhật Trạng Thái</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="carts">
        {{-- Khai báo biến toàn cục $total để lưu giá trị --}}
        @php $total = 0; @endphp
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Ảnh</th>
                    <th>Tên</th>
                    <th>Size</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Tổng phụ</th>
                </tr>
            </thead>

            <tbody>
            @foreach($orderProducts as $item)
                @php
                    $price = $item->price * $item->quantity;
                    $total += $price;
                @endphp
                <tr>
                    <td>
                        <img src="{{ $item->product->thumb }}" alt="IMG" style="width: 100px">
                    </td>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->size->name }}</td>
                    <td>{{ number_format($item->price, 0, '', '.') }}đ</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($price, 0, '', '.') }}đ</td>
                </tr>
            @endforeach
                <tr>
                    <td colspan="5" class="text-right"><h3><b>Tổng hóa đơn:</b></h3></td>
                    <td><h4>{{ number_format($total, 0, '', '.') }}đ</h4></td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- <div class="row no-print">
        <div class="col-12">
            <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i
                    class="fas fa-print"></i> Print</a>
            <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                Payment
            </button>
            <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                <i class="fas fa-download"></i> Generate PDF
            </button>
        </div>
    </div> --}}
@endsection