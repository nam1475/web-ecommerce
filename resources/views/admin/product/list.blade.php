@extends('admin.layout.main')

@section('content')
    <table class="table">
        <thead>
            <tr>
                <th style="width: 50px">ID</th>
                <th>Name</th>
                <th>Menu</th>
                <th>Origin price</th>
                <th>Promotional price</th>
                <th>Thumb</th>
                <th>Active</th>
                <th>Update</th>
                <th>&nbsp;</th>
            </tr>
        </thead>

        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->menu->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->price_sale }}</td>
                    <td><a href="{{ $product->thumb }}" target="_blank">
                        <img src="{{ $product->thumb }}" width="70px" height="50px">
                    </a></td>
                    <td>{!! \App\Helpers\Helper::active($product->active) !!}</td>
                    <td>{{ $product->updated_at }}</td>
                    <td class="btn-group">
                        @can('edit-product')
                            {!! \App\Helpers\Helper::editRow('product', $product) !!}
                        @elsecan('delete-product')
                            {!! \App\Helpers\Helper::deleteRow('product', $product) !!}
                        @else
                            {{-- Nếu ko thỏa mãn điều kiện nào thì để rỗng --}}
                            &nbsp; 
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="card-footer clearfix">
        {!! $products->links() !!}
    </div>
@endsection