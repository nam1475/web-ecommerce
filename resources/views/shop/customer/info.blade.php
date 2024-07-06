@extends('shop.customer.profile')

@section('profile')
<div class="tab-pane d-flex justify-content-center align-items-center card" id="settings">
    <div class="card-header text-center w-50">
        <h3>
            Thông tin cá nhân
        </h3>
    </div>

    <div class="card-body w-50">
        <form action="{{ route('shop.profile.info.update', auth('customer')->user()->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="" class="col-form-label text-secondary">Họ tên</label>
                </div>
                <div class="col-md-6">
                    <label for="" class="col-form-label">{{ auth('customer')->user()->name }}</label>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="" class="col-form-label text-secondary">SĐT</label>
                </div>
                <div class="col-md-6">
                    <label for="" class="col-form-label">{{ auth('customer')->user()->phone }}</label>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="" class="col-form-label text-secondary">Địa chỉ</label>
                </div>
                <div class="col-md-6">
                    <label for="" class="col-form-label">{{ auth('customer')->user()->address }}</label>
                </div>
            </div>
            <div class="form-group row">
                {!! \App\Helpers\Helper::update('shop.profile.info.update', auth('customer')->user()->id, 
                    'Thay đổi thông tin cá nhân ', 'Chỉnh Sửa', 'Cập nhật') !!}
            </div>
        </form>
    </div>

    <div class="card-header text-center w-50">
        <h3>
            Thông tin đăng nhập
        </h3>
    </div>

    <div class="card-body w-50">
        <form action="{{ route('shop.profile.password.update', auth('customer')->user()->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group row">
                <div class="col-sm-6">
                    <label for="inputEmail" class="col-form-label text-secondary">Email</label>
                </div>

                <div class="col-sm-4">
                    <label for="inputEmail" class="col-form-label">{{ auth('customer')->user()->email }}</label>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <label for="inputPassword" class="col-form-label text-secondary">Mật khẩu</label>
                </div>
                <div class="col-sm-4">
                    <label for="inputPassword" class="col-form-label">***************</label>
                </div>
            </div>
            <div class="form-group row">
                {{-- <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div> --}}
                {!! \App\Helpers\Helper::update('shop.profile.password.update', auth('customer')->user()->id, 
                    'Thay đổi mật khẩu', 'Chỉnh Sửa', 'Cập nhật') !!}
            </div>
        </form>
    </div>
</div>
@endsection