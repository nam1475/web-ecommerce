@extends('admin.layout.main')

@section('content')

    @section('filter')
        <div>
            <a href="{{ route('order.list') }}">
                Tất cả
            </a>
            ({{ $orders->count() }}) |

            <a href="?filter-status=1">
                Đang chờ duyệt
            </a>
            ({{ $statusPending }}) |

            <a href="?filter-status=2">
                Đang giao hàng
            </a>
            ({{ $statusDelivering }}) |

            <a href="?filter-status=3">
                Giao hàng thành công
            </a>
            ({{ $statusSuccess }}) |
            
            <a href="?filter-status=4">
                Hủy đơn
            </a>
            ({{ $statusCancelOrder }})
        </div>
    @endsection
    @include('admin.search')

    <table class="table">
        <thead class="thead-light">
            <tr>
                <th style="width: 50px">ID</th>
                <th>Tên</th>
                <th>SĐT</th>
                <th>Địa chỉ</th>
                <th>Email</th>
                <th>Ghi chú</th>
                <th>Ngày tạo</th>
                <th>Ngày cập nhật</th>
                <th>Trạng thái</th>
                <th>&nbsp;</th>
            </tr>
        </thead>

        <tbody>
            @foreach($orders as $od)
                <tr>
                    <td>{{ $od->id }}</td>
                    <td>{{ $od->name }}</td>
                    <td>{{ $od->phone }}</td>
                    <td>{{ $od->address }}</td>
                    <td>{{ $od->email }}</td>
                    <td>{{ $od->content }}</td>
                    <td>{{ $od->created_at->format('Y-m-d') }}</td>
                    <td>{{ $od->updated_at->format('Y-m-d') }}</td>
                    <td>
                        @switch($od->status)
                            @case(1)
                                <span class="badge badge-primary">Đang chờ duyệt</span>
                                @break
                            @case(2)
                                <span class="badge badge-info">Đang giao hàng</span>
                                @break
                            @case(3)
                                <span class="badge badge-success">Giao hàng thành công</span>
                                @break
                            @case(4)
                                <span class="badge badge-danger">Hủy đơn</span>
                                @break
                            @default
                                
                        @endswitch
                    </td>
                    <td class="btn-group">
                        <a href="{{ route('order.detail', $od->id) }}"  type="button" class="btn btn-info">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        {!! \App\Helpers\Helper::deleteRow('order', $od) !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="card-footer clearfix">
        {!! $orders->links() !!}
    </div>
@endsection