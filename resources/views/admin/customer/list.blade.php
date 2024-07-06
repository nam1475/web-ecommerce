@extends('admin.layout.main')

@section('content')
    @include('admin.search')
    
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th style="width: 50px">ID</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Ngày tạo</th>
                <th>Ngày cập nhật</th>
                <th>&nbsp;</th>
            </tr>
        </thead>

        <tbody>
            @foreach($customers as $ct)
                <tr>
                    <td>{{ $ct->id }}</td>
                    <td>{{ $ct->name }}</td>
                    <td>{{ $ct->email }}</td>
                    <td>{{ $ct->created_at->format('Y-m-d') }}</td>
                    <td>{{ $ct->updated_at->format('Y-m-d') }}</td>
                    <td class="btn-group">
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