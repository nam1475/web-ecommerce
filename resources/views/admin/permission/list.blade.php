@extends('admin.layout.main')

@section('content')    
    @php
        use App\Helpers\Helper;
    @endphp

    @section('filter')
        {!! Helper::filterParents($pmsParents)  !!}
    @endsection
    @include('admin.search')

    <table class="table">
        <thead class="thead-light">
            <tr>
                <th style="width: 50px">ID</th>
                <th>Tên</th>
                <th>Phân quyền cha</th>
                <th>Mô tả</th>
                <th>&nbsp;</th>
                <th>Mã khóa</th>
                <th>&nbsp;</th>
                <th>Kích hoạt</th>
                <th>Người tạo - Ngày tạo</th>
                <th>Người cập nhật - Ngày cập nhật</th>
                <th>&nbsp;</th>
            </tr>
        </thead>

        <tbody>
            {!! Helper::recursiveListMenu($permissions, 'permission') !!}
            {{-- {!! Helper::selectList($permissions, 'permission') !!} --}}
        </tbody>
    </table>

    <div class="card-footer clearfix">
        {!! $permissions->links() !!}
    </div>
@endsection