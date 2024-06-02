@extends('admin.layout.main')

@section('content')
    <table class="table">
        <thead>
            <tr>
                <th style="width: 50px">ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Parent ID</th>
                <th>Active</th>
                <th>Update</th>
                <th>&nbsp;</th>
            </tr>
        </thead>

        <tbody>
            {{-- 
                - Dấu !!: dùng để đọc mã HTML nếu ko có trong phần dưới thì sẽ ra text 
                - Dùng nnay để có thể tái sử dụng
            --}}
            {!! App\Helpers\Helper::menu($menus, 'menu') !!}
        </tbody>
    </table>
    <div class="card-footer clearfix">
        {!! $menus->links() !!}
    </div>
@endsection