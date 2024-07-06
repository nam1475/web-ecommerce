@extends('admin.layout.main')

@section('content')
    <form action="{{ route('role.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Tên vai trò</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control"  placeholder="Nhập tên vai trò">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Mô tả vai trò</label>
                        <input type="text" name="display_name" value="{{ old('display_name') }}" class="form-control"  placeholder="Nhập mô tả vai trò">
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
                <div class="card border-primary mb-3 col-md-12">
                    <div class="card-header">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input checkbox-all" name="action" type="checkbox" id="cb-all">
                            <label for="cb-all" class="custom-control-label pointer">Chọn tất cả</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach ($pmsParents as $pp)
                    <div class="card border-primary mb-3 col-md-12">
                        <div class="card-header">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input checkbox-parent" type="checkbox" id="{{ $pp->id }}">
                                <label for="{{ $pp->id }}" class="custom-control-label pointer">
                                    {{ ucwords($pp->name) }}
                                </label>
                            </div>
                        </div>
                        
                        <div class="row">
                            {{-- Truy cập đến phương thức children trong model Permission, để duyệt qua từng bản ghi con 
                                có parent_id là bản ghi cha hiện tại --}}
                            @foreach($pp->children as $pc)
                                <div class="card-body col-md-3">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input checkbox-children" name="permission_id[]" type="checkbox" 
                                                value="{{ $pc->id }}" id="{{ $pc->id }}">
                                            <label class="custom-control-label pointer" for="{{ $pc->id }}">
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
        
        {{-- <table class="table table-striped">
            <thead>
              <tr>
                <th>
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input checkbox-all" name="action" type="checkbox" id="cb-all">
                        <label for="cb-all" class="custom-control-label pointer">Chọn tất cả</label>
                    </div>
                </th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
              </tr>
            </thead>

            <tbody>
                @foreach ($pmsParents as $pp)
                <tr class="wrapper">
                    <th>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input checkbox-parent" type="checkbox" id="{{ $pp->id }}">
                            <label for="{{ $pp->id }}" class="custom-control-label pointer">
                                {{ ucwords($pp->name) }}
                            </label>
                        </div>
                    </th>

                    @foreach($pp->children as $pc)
                        <td>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input checkbox-children" name="permission_id[]" type="checkbox" 
                                    value="{{ $pc->id }}" id="{{ $pc->id }}">
                                <label class="custom-control-label pointer" for="{{ $pc->id }}">
                                    {{ $pc->name }}
                                </label>
                            </div>
                        </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
          </table> --}}

        <div class="card-footer">
            <button type="submit" name="submit" class="btn btn-primary">Thêm Vai Trò</button>
        </div>
    </form>
@endsection
