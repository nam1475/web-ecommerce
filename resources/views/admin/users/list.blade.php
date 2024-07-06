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
                <th>Email</th>
                <th>Vai trò</th>
                <th>Người tạo - Ngày tạo</th>
                <th>Người cập nhật - Ngày cập nhật</th>
                <th>&nbsp;</th>
            </tr>
        </thead>

        <tbody>
            @foreach($users as $us)
                <tr>
                    <td>{{ $us->id }}</td>
                    <td>{{ $us->name }}</td>
                    <td>{{ $us->email }}</td>
                    <td>
                        @php
                            // $userRoles = Helper::getID($us->roles(), 'role_id');
                            $userRoles = $us->roles; // Trả về mảng các bản ghi Model chứa role_id tương ứng
                            // dd($userRoles);
                        @endphp
                        @foreach($userRoles as $ur)
                            {{-- @php
                                /* Lấy ra từng role name thông qua id */
                                $role = \App\Models\Role::find($ur);
                            @endphp --}}
                            {{-- <span class="badge badge-primary">{{ $role->name }}</span> --}}
                            <span class="badge badge-primary">{{ $ur->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        {!! Helper::createdAtAndBy($us) !!}
                    </td>
                    <td>
                        {!! Helper::updatedAtAndBy($us) !!}
                    </td>
                    <td class="btn-group">
                        {{-- <a href=""  type="button" class="btn btn-info">
                            <i class="fa-solid fa-eye"></i>
                        </a> --}}
                        {!! Helper::editRow('user', $us) !!}
                        {!! Helper::deleteRow('user', $us) !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="card-footer clearfix">
        {!! $users->links() !!}
    </div>
@endsection