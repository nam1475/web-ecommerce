@extends('admin.layout.main')

@section('content')
    <form action="{{ route('user.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Tên user</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="form-control" placeholder="Nhập tên sản phẩm">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="form-control" placeholder="Nhập email">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Chọn vai trò</label>
                        @foreach($roles as $r)
                            <div class="custom-control custom-checkbox">
                                {{-- contains(): Kiểm tra id có trùng với id trong Collection hiện tại ko (Chỉ dùng cho Collection) --}}
                                <input class="custom-control-input" name="role_id[]" type="checkbox" value="{{ $r->id }}" id="{{ $r->id }}"
                                    {{ $userRoles->contains('id', $r->id) ? 'checked' : ''}} >
                                <label class="custom-control-label pointer" for="{{ $r->id }}">
                                    {{ $r->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Cập Nhật</button>
        </div>
    </form>
@endsection
