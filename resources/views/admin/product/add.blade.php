@extends('admin.layout.main')

@section('header')
    <script src="/ckeditor/ckeditor.js"></script>
@endsection

@section('content')
    <form action="{{ route('product.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Tên Sản Phẩm</label>
                        {{-- old(): Trả về giá trị của trường "description" mà người dùng đã nhập trước đó,
                        để nếu validate error thì sẽ ko cần nhập lại --}}
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control"  placeholder="Nhập tên sản phẩm">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Danh Mục</label>
                        <select class="form-control" name="menu_id">
                            <option value="">---Chọn---</option>
                                {!! App\Helpers\Helper::recursiveSelectMenu($menus) !!}
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Giá Gốc</label>
                        <input type="number" name="price" value="{{ old('price') }}"  class="form-control" >
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Giá Giảm</label>
                        <input type="number" name="price_sale" value="{{ old('price_sale') }}"  class="form-control" >
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <label>Size</label>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input checkbox-all" type="checkbox" id="cb-all">
                                <label for="cb-all" class="custom-control-label pointer">Chọn tất cả</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        @foreach ($sizes as $s)                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input checkbox-children" name="size[]" type="checkbox" id="{{ $s->id }}" 
                                            value="{{ $s->id }}" {{ in_array($s->id, old('size', [])) ? 'checked' : '' }}>
                                        <label for="{{ $s->id }}" class="custom-control-label pointer">{{ $s->name }}</label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label>Mô Tả </label>
                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label>Mô Tả Chi Tiết</label>
                <textarea name="content" id="content" class="form-control">{{ old('content') }}</textarea>
            </div>

            <div class="form-group">
                <label for="menu">Ảnh Sản Phẩm</label>
                <input type="file" class="form-control" name="file" id="upload">
                <div id="image_show"></div>
                <input type="hidden" name="thumb" id="thumb">
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
            <button type="submit" name="submit" id="uploadButton" class="btn btn-primary">Thêm Sản Phẩm</button>
        </div>  
    </form>

@endsection

@section('footer')
    <script>
        CKEDITOR.replace('content');
    </script>

@endsection