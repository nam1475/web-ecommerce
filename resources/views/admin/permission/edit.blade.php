@extends('admin.layout.main')

@section('content')
    <form action="{{ route('permission.update', $permission->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Tên quyền</label>
                        <input type="text" name="name" value="{{ $permission->name }}" class="form-control" placeholder="Nhập tên quyền">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Mô tả quyền</label>
                        <input type="text" name="description" value="{{ $permission->description }}" class="form-control" placeholder="Nhập mô tả">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">                        
                        <label>Loại quyền</label>
                        <select class="form-control" name="parent_id">
                            <option value="" {{ $permission->parent_id == "" ? 'selected' : '' }}> Phân Quyền Cha </option>
                            @foreach($permissions as $p)
                                <option value="{{ $p->id }}" 
                                    {{ $permission->parent_id == $p->id ? 'selected' : '' }}>
                                    {{ $p->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Kích Hoạt</label>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" value="1" type="radio" id="active" 
                            name="active" {{ $permission->active == 1 ? 'checked' : '' }}>
                        <label for="active" class="custom-control-label">Có</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" value="0" type="radio" id="no_active" 
                            name="active" {{ $permission->active == 0 ? 'checked' : '' }} >
                        <label for="no_active" class="custom-control-label">Không</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Key Code</label>
                        <input type="text" name="key_code" value="{{ $permission->key_code }}" class="form-control" placeholder="Nhập key code">
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Cập Nhật</button>
        </div>
    </form>
@endsection
