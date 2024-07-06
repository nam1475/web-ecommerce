@extends('admin.layout.main')

@section('content')
    <form action="{{ route('size.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Tên Size</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control"  placeholder="Nhập tên size">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Mô Tả</label>
                        <textarea name="description" class="form-control" placeholder="Nhập mô tả">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>
            

            <div class="form-group">
                <label>Kích Hoạt</label>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" value="1" type="radio" id="active" name="active" checked="">
                    <label for="active" class="custom-control-label">Có</label>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" value="0" type="radio" id="no_active" name="active" >
                    <label for="no_active" class="custom-control-label">Không</label>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Thêm Size</button>
        </div>  
    </form>

@endsection