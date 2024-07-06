<!DOCTYPE html>
<html lang="en">
    <head>
        @include('admin.layout.header')
    </head>

    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <h2><b>{{ $header }}</b></h2>
                </div>

                @include("admin.errors.error")
                
                @yield('content')      

            </div>
        </div>
        @include('admin.layout.footer')
    </body>
</html>