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
                <th>Quyền</th>
                <th>Người tạo - Ngày tạo</th>
                <th>Người cập nhật - Ngày cập nhật</th>
                <th>&nbsp;</th>
            </tr>
        </thead>

        <tbody>
            @foreach($roles as $r)
                <tr>
                    <td>{{ $r->id }}</td>
                    <td>{{ $r->name }}</td>
                    <td>{{ $r->display_name }}</td>
                    <td width="300px">
                        @php
                            $rolePms = $r->permissions
                        @endphp
                        
                        @foreach($rolePms as $rp)
                            <span class="badge badge-primary">{{ $rp->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        {!! Helper::createdAtAndBy($r) !!}
                    </td>
                    <td>
                        {!! Helper::updatedAtAndBy($r) !!}
                    </td>
                    <td class="btn-group">
                        {!! Helper::editRow('role', $r) !!}
                        {!! Helper::deleteRow('role', $r) !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="card-footer clearfix">
        {!! $roles->links() !!}
    </div>
@endsection