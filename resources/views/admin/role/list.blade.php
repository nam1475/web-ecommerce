@extends('admin.layout.main')

@section('content')

    <table class="table">
        <thead>
            <tr>
                <th style="width: 50px">ID</th>
                <th>Name</th>
                <th>Display Name</th>
                <th>Permission</th>
                <th>Created Date</th>
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
                            $rolePms = App\Helpers\Helper::getID($r->permissions(), 'permission_id');
                        @endphp
                        
                        @foreach($rolePms as $rp)
                            @php
                                /* Lấy ra từng permission name thông qua id */
                                $permission = \App\Models\Permission::find($rp);
                            @endphp
                            <span class="badge badge-primary">{{ $permission->name }}</span>
                        @endforeach
                    </td>
                    <td>{{ $r->created_at }}</td>
                    <td class="btn-group">
                        {{-- <a href=""  type="button" class="btn btn-info">
                            <i class="fa-solid fa-eye"></i>
                        </a> --}}
                        {!! \App\Helpers\Helper::editRow('role', $r) !!}
                        {!! \App\Helpers\Helper::deleteRow('role', $r) !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="card-footer clearfix">
        {!! $roles->links() !!}
    </div>
@endsection