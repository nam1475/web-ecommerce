@extends('admin.layout.auth-main')

@section('content')
    <div class="card-body">
        <p class="login-box-msg">Gửi email để cấp lại mật khẩu!</p>
        <form action="{{ route('admin.user.forgot.password.action') }}" method="POST">
            @csrf
            <div class="input-group mb-3">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
                <input type="email" name="email" class="form-control" placeholder="Email">
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-block">Gửi email</button>
                </div>
            </div>
        </form>
        <p class="mt-3 mb-1">
            <a href="{{ route('login') }}">Đăng nhập</a>
        </p>
    </div>
@endsection


