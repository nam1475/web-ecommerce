@extends('admin.layout.auth-main')

@section('content')
    <div class="card-body">
        <form action="{{ route('admin.user.reset.password.action', $token) }}" method="post">
            @csrf
            <div class="input-group mb-3">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
                <input type="email" name="email" class="form-control" placeholder="Email">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
                <input type="password" name="new_password" class="form-control" placeholder="Mật khẩu mới">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Xác nhận mật khẩu">
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                </div>
            </div>
        </form>
        <p class="mt-3 mb-1">
            <a href="{{ route('login') }}">Đăng nhập</a>
        </p>
    </div>

@endsection