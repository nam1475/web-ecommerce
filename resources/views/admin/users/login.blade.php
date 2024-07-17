@extends('admin.layout.auth-main')

@section('content')
    <div class="card-body login-card-body">
        <form action="{{ route("login.store") }}" method="post">
            @csrf
            <div class="input-group mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" value="phanhainam18122003@gmail.com">
                <div class="input-group-append">    
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>  
            </div>
            <div class="input-group mb-3">
                <input type="password" name="password" class="form-control" placeholder="Mật khẩu" value="1">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <div class="icheck-primary">
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember">
                            Ghi nhớ đăng nhập
                        </label>
                    </div>
                </div>

                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                </div>

            </div>
        </form>

        <div class="mt-2 d-flex justify-content-end">
            <a href="{{ route("admin.user.forgot.password") }}">Quên mật khẩu ?</a>
        </div>
    </div>

@endsection