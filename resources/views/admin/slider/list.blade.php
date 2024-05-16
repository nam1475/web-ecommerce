@extends('admin.layout.main')

@section('content')
    <table class="table">
        <thead>
            <tr>
                <th style="width: 50px">ID</th>
                <th>Title</th>
                <th>Link</th>
                <th>Thumb</th>
                <th>Active</th>
                <th>Update</th>
                <th style="width: 100px">Handle</th>
            </tr>
        </thead>

        <tbody>
            @foreach($sliders as $slider)
                <tr>
                    <td>{{ $slider->id }}</td>
                    <td>{{ $slider->name }}</td>
                    <td>{{ $slider->url }}</td>
                    <td><a href="{{ $slider->thumb }}" target="_blank">
                            <img src="{{ $slider->thumb }}" height="50px" width="50px">
                        </a>
                    </td>
                    <td>{!! \App\Helpers\Helper::active($slider->active) !!}</td>
                    <td>{{ $slider->updated_at }}</td>
                    <td class="btn-group">
                        {!! \App\Helpers\Helper::editRow('slider', $slider) !!}
                        {!! \App\Helpers\Helper::deleteRow('slider', $slider) !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {!! $sliders->links() !!}
@endsection