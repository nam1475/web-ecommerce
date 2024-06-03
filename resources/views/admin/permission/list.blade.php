@extends('admin.layout.main')

@section('content')

    <table class="table">
        <thead>
            <tr>
                <th style="width: 50px">ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Parent ID</th>
                <th>Key Code</th>
                <th>Active</th>
                <th>Created Date</th>
                <th>&nbsp;</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($permissions as $pm)
                <tr>
                    <td>{{ $pm->id }}</td>
                    <td>
                        @if($pm->parent_id == 0)
                            <span class="badge badge-primary">
                                {{ $pm->name }}
                            </span>
                        @else
                            {{ $pm->name }}
                        @endif
                    </td>
                    <td>{{ $pm->description }}</td>
                    <td>{{ $pm->parent_id }}</td>
                    <td>{{ $pm->key_code }}</td>
                    <td>{!! App\Helpers\Helper::active($pm->active) !!}</td>
                    <td>{{ $pm->created_at }}</td>
                    <td class="btn-group">
                        {!! \App\Helpers\Helper::editRow('permission', $pm) !!}
                        {!! \App\Helpers\Helper::deleteRow('permission', $pm) !!}
                    </td>
                </tr>
            @endforeach
            {{-- {!! App\Helpers\Helper::menu($permissions, 'permission') !!} --}}
        </tbody>
    </table>

    <div class="card-footer clearfix">
        {!! $permissions->links() !!}
    </div>
@endsection