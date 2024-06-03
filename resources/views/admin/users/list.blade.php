@extends('admin.layout.main')

@section('content')

    {{-- <form action="">
        <div class="input-group">
        <input type="text" id="searchInput" name="search" class="form-control bg-light border-1 small" placeholder="Tìm kiếm..." aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
            <button class="btn btn-primary" id="searchStudent">
            <i class="fas fa-search fa-sm"></i>      
            </button>
        </div>    
        </div>
    </form> --}}

    <table class="table">
        <thead>
            <tr>
                <th style="width: 50px">ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created Date</th>
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
                            // $userRoles = App\Helpers\Helper::getID($us->roles(), 'role_id');
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
                    <td>{{ $us->created_at }}</td>
                    <td class="btn-group">
                        {{-- <a href=""  type="button" class="btn btn-info">
                            <i class="fa-solid fa-eye"></i>
                        </a> --}}
                        {!! \App\Helpers\Helper::editRow('user', $us) !!}
                        {!! \App\Helpers\Helper::deleteRow('user', $us) !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="card-footer clearfix">
        {!! $users->links() !!}
    </div>
@endsection