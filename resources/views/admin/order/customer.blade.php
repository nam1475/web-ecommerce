@extends('admin.layout.main')

@section('content')
    <table class="table">
        <thead>
            <tr>
                <th style="width: 50px">ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Email</th>
                <th>Content</th>
                <th></th>
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