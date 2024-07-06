<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    @php
        $user = auth()->user();
        $userRoles = $user->roles;  
    @endphp
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link" data-toggle="dropdown" aria-expanded="false">
                <img src="{{ url('/template/admin_asset/profile-image/301648796_1164584951074067_594328778084010935_n (2).jpg') }}" 
                    class="user-image img-circle elevation-2" alt="User Image">
                <span class="d-none d-md-inline">{{ $user->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <li class="user-header bg-primary">
                    <img src="{{ url('/template/admin_asset/profile-image/301648796_1164584951074067_594328778084010935_n (2).jpg') }}" class="img-circle elevation-2" alt="User Image">
                    <div class="d-flex align-items-center justify-content-center">
                        <p>{{ $user->name }}</p>-
                        <p>
                            @foreach ($userRoles as $ur)
                                {{ $ur->name }}
                            @endforeach
                        </p>
                    </div>
                    <small>Thành viên từ: {{ $user->created_at->format('Y-m-d') }}</small>
                </li>
        
                <li class="user-footer">
                    <a href="{{ route('user.profile') }}" class="btn btn-default btn-outline-secondary">Tài khoản</a>
                    <a href="{{ route('admin.user.logout') }}" class="btn btn-default btn-outline-secondary float-right" id="logout-user">Đăng xuất</a>
                </li>
            </ul>
        </li>
    </ul>
</nav>