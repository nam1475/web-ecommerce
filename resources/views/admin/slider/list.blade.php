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
                <th>Đường dẫn</th>
                <th>Ảnh</th>
                <th>Kích hoạt</th>
                <th>Người tạo - Ngày tạo</th>
                <th>Người cập nhật - Ngày cập nhật</th>
                <th>&nbsp;</th> 
            </tr>
        </thead>

        <tbody>
            @foreach($sliders as $slider)
                <tr>
                    <td>{{ $slider->id }}</td>
                    <td>{{ $slider->name }}</td>
                    <td>{{ $slider->url }}</td>
                    <td><a href="{{ $slider->thumb }}" target="_blank">
                            <img src="{{ $slider->thumb }}" class="thumb-size-auto">
                        </a>
                    </td>
                    <td>{!! Helper::active($slider->active) !!}</td>
                    <td>
                        {!! Helper::createdAtAndBy($slider) !!}
                    </td>
                    <td>
                        {!! Helper::updatedAtAndBy($slider) !!}
                    </td>
                    <td class="btn-group">
                        @can('edit-slider')
                            {!! Helper::editRow('slider', $slider) !!}
                        @endcan
                        @can('delete-slider')
                            {!! Helper::deleteRow('slider', $slider) !!}
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {!! $sliders->links() !!}
@endsection