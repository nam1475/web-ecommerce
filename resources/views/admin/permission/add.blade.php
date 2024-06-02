@extends('admin.layout.main')

@section('header')
    <script src="/ckeditor/ckeditor.js"></script>
@endsection

@section('content')
    <form action="{{ route('permission.store') }}" method="POST">
        @csrf
        <div class="card-body">
            {{-- <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Tên quyền</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control"  placeholder="Nhập tên quyền">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Mô tả quyền</label>
                        <input type="text" name="description" value="{{ old('description') }}" class="form-control"  placeholder="Nhập mô tả quyền">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">                        
                        <label>Loại quyền</label>
                        <select class="form-control" name="parent_id">
                            <option value="0"> Phân Quyền Cha </option>
                            @foreach($permissions as $p)    
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Kích Hoạt</label>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" value="1" type="radio" id="active" name="active">
                        <label for="active" class="custom-control-label">Có</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" value="0" type="radio" id="no_active" name="active" >
                        <label for="no_active" class="custom-control-label">Không</label>
                    </div>
                </div>
            </div> --}}
            

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">                        
                        <label>Chọn phân quyền cha</label>
                        <select class="form-control" name="parent_pms">
                            <option value=""></option>
                            @foreach(config('permission.table') as $item)
                                <option value="{{ $item }}">{{ ucwords($item) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <label>Chọn action</label>
            <div class="row">
                @foreach(config('permission.action') as $ac)
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" name="action[]" type="checkbox" id="{{ $ac }}" value="{{ $ac }}">
                                <label for="{{ $ac }}" class="custom-control-label">{{ ucwords($ac) }}</label>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row">
                <div class="form-group">
                    <label>Kích Hoạt</label>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" value="1" type="radio" id="active" name="active">
                        <label for="active" class="custom-control-label">Có</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" value="0" type="radio" id="no_active" name="active" >
                        <label for="no_active" class="custom-control-label">Không</label>
                    </div>
                </div>
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" name="submit" class="btn btn-primary">Thêm Quyền</button>
        </div>
    </form>
@endsection

@section('footer')
    <script>
        CKEDITOR.replace('content');
    </script>
@endsection