@extends('admin.layout.main')

@section('header')
    <script src="/ckeditor/ckeditor.js"></script>
@endsection

@section('content')
    <form action="{{ route('role.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Tên vai trò</label>
                        <input type="text" name="name" value="{{ $role->name }}" class="form-control" placeholder="Nhập tên vai trò">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Mô tả vai trò</label>
                        <input type="text" name="display_name" value="{{ $role->display_name }}" class="form-control" placeholder="Nhập mô tả">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Chọn quyền</label>
                    </div>
                </div>
                
            </div>

            <div class="row">
                @foreach ($pmsParents as $pp)
                <div class="card border-primary mb-3 col-md-12">
                    <div class="card-header">
                        <input class="form-check-input checkbox-parent" type="checkbox" id="{{ $pp->id }}">
                        <label for="{{ $pp->id }}">
                            {{ $pp->name }}
                        </label>
                    </div>
                    <div class="row">
                        {{-- Truy cập đến phương thức children trong model Permission, để duyệt qua từng bản ghi con 
                            có parent_id là bản ghi cha hiện tại --}}
                        @foreach($pp->children as $pc)
                        <div class="card-body col-md-3">
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input checkbox-children" name="permission_id[]" type="checkbox" 
                                        value="{{ $pc->id }}" id="{{ $pc->id }}" {{ in_array($pc->id, $rolePms) ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="{{ $pc->id }}">
                                        {{ $pc->name }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Cập Nhật</button>
        </div>
    </form>
@endsection

@section('footer')
    <script>
        CKEDITOR.replace('content');
    </script>
@endsection