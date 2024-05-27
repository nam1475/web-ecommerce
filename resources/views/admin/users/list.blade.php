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
                            $result = $us->roles()->pluck('role_id')->toArray();
                            $userRoles = [];
                            foreach ($result as $item) {
                                $userRoles = explode(', ', $item);
                            }
                        @endphp
                        @foreach($userRoles as $ur)
                            @switch($ur)
                                @case(1)
                                    <span class="badge badge-primary">Admin</span>
                                    @break
                                @case(2)
                                    <span class="badge badge-info">Guest</span>
                                    @break
                                @case(3)
                                    <span class="badge badge-success">Developer</span>
                                    @break
                                @case(4)
                                    <span class="badge badge-danger">Content</span>
                                    @break                                    
                            @endswitch
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