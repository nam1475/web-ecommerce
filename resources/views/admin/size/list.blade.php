@extends('admin.layout.main')

@section('content')
    @include('admin.search')
    
    @php
        use App\Helpers\Helper;
    @endphp
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th style="width: 50px">ID</th>
                <th>Tên</th>
                <th>Mô tả</th>
                <th>Kích hoạt</th>
                <th>Người tạo - Ngày tạo</th>
                <th>Người cập nhật - Ngày cập nhật</th>
                <th>&nbsp;</th>
            </tr>
        </thead>

        <tbody>
            @foreach($sizes as $s)
                <tr>
                    <td>{{ $s->id }}</td>
                    <td>{{ $s->name }}</td>
                    <td>{{ $s->description }}</td>
                    <td>{!! Helper::active($s->active) !!}</td>
                    <td>
                        {!! Helper::createdAtAndBy($s) !!}
                    </td>
                    <td>
                        {!! Helper::updatedAtAndBy($s) !!}
                    </td>
                    <td class="btn-group">
                        {!! Helper::editRow('size', $s) !!}
                        {!! Helper::deleteRow('size', $s) !!} 
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="card-footer clearfix">
        {!! $sizes->links() !!}
    </div>

@endsection
    