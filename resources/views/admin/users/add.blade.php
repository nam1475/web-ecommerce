@extends('admin.layout.main')

@section('header')
    <script src="/ckeditor/ckeditor.js"></script>
@endsection

@section('content')
    <form action="{{ route('user.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Tên user</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control"  placeholder="Nhập tên user">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Email</label>
                        <input type="text" name="email" value="{{ old('email') }}" class="form-control"  placeholder="Nhập email">
                    </div>
                </div>
                
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Mật khẩu</label>
                        <input type="text" name="password" value="{{ old('password') }}" class="form-control"  placeholder="Nhập mật khẩu">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Chọn vai trò</label>
                        @foreach($roles as $r)
                            <div class="form-check">
                                <input class="form-check-input" name="role_id[]" type="checkbox" value="{{ $r->id }}" id="{{ $r->id }}">
                                <label class="form-check-label" for="{{ $r->id }}">
                                    {{ $r->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                {{-- <div class="col-md-6">
                    <div class="form-group">
                        <label>Chọn vai trò</label>
                        <select class="form-control select" name="menu_id">
                            <option value=""></option>
                            @foreach($roles as $r)
                            <option value="{{ $r->id }}">{{ $r->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div> --}}
                
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" name="submit" class="btn btn-primary">Thêm User</button>
        </div>
    </form>
@endsection

@section('footer')
    <script>
        CKEDITOR.replace('content');
        // $('.select').select2();
    </script>
@endsection