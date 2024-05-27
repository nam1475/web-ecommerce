@extends('admin.layout.main')

@section('header')
    <script src="/ckeditor/ckeditor.js"></script>
@endsection

@section('content')
    <form action="{{ route('role.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Tên vai trò</label>
                        {{-- old(): Trả về giá trị của trường "description" mà người dùng đã nhập trước đó,
                        để nếu validate error thì sẽ ko cần nhập lại --}}
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control"  placeholder="Nhập tên vai trò">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Mô tả vai trò</label>
                        {{-- old(): Trả về giá trị của trường "description" mà người dùng đã nhập trước đó,
                        để nếu validate error thì sẽ ko cần nhập lại --}}
                        <input type="text" name="display_name" value="{{ old('display_name') }}" class="form-control"  placeholder="Nhập mô tả vai trò">
                    </div>
                </div>
                
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" name="submit" class="btn btn-primary">Thêm Vai Trò</button>
        </div>
    </form>
@endsection

@section('footer')
    <script>
        CKEDITOR.replace('content');
    </script>
@endsection