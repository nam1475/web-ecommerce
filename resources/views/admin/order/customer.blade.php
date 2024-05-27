@extends('admin.layout.main')

@section('content')

    <form action="">
        <div class="input-group">
        <input type="text" id="searchInput" name="search" class="form-control bg-light border-1 small" placeholder="Tìm kiếm..." aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
            <button class="btn btn-primary" id="searchStudent">
            <i class="fas fa-search fa-sm"></i>      
            </button>
        </div>    
        </div>
    </form>

    <div class="my-2">
        <a href="{{ route('customer.list') }}">
            Tất cả
        </a>
        ({{ $customers->count() }}) |
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
        ({{ $statusSuccess }})
    </div>
    <table class="table">
        <thead>
            <tr>
                <th style="width: 50px">ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Email</th>
                <th>Content</th>
                <th>Date</th>
                <th>Status</th>
                <th>&nbsp;</th>
            </tr>
        </thead>

        <tbody>
            @foreach($customers as $ct)
                <tr>
                    <td>{{ $ct->id }}</td>
                    <td>{{ $ct->name }}</td>
                    <td>{{ $ct->phone }}</td>
                    <td>{{ $ct->address }}</td>
                    <td>{{ $ct->email }}</td>
                    <td>{{ $ct->content }}</td>
                    <td>{{ $ct->created_at }}</td>
                    <td>
                        @switch($ct->status)
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
                        <a href="{{ route('order.detail', $ct->id) }}"  type="button" class="btn btn-info">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        {!! \App\Helpers\Helper::deleteRow('customer', $ct) !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="card-footer clearfix">
        {!! $customers->links() !!}
    </div>
@endsection