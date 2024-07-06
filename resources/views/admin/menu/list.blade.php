@extends('admin.layout.main')

@section('content')
    @php
        use App\Helpers\Helper;
    @endphp

    @section('filter')
        {!! Helper::filterParents($menuParents)  !!}
    @endsection

    @include('admin.search')

    <table class="table">
        <thead class="thead-light">
            <tr>
                <th style="width: 50px">ID</th>
                <th>Tên</th>
                <th>Danh mục cha</th>
                <th>Mô tả</th>
                <th>Ảnh</th>
                <th>&nbsp;</th>
                <th>Slug</th>
                <th>Kích hoạt</th>
                <th>Người tạo - Ngày tạo</th>
                <th>Người cập nhật - Ngày cập nhật</th>
                <th>&nbsp;</th>
            </tr>
        </thead>

        <tbody>
            {{-- 
                - Dấu !!: dùng để đọc mã HTML nếu ko có thì sẽ chỉ ra string 
            --}}
            {!! Helper::recursiveListMenu($menus, 'menu') !!}
            {{-- {!! Helper::selectList($menus, 'menu') !!} --}}
        </tbody>
    </table>
    <div class="card-footer clearfix">
        {!! $menus->links() !!}
    </div>
@endsection