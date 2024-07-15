<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link text-center">
        {{-- <img src="" alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
        <span class="brand-text font-weight-light ">Trang quản trị Fein Clothing</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link" id="dashboard">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Thống Kê</p>
                    </a>
                </li>

                <li class="nav-item nav-bar" id="menu-container">
                    <a href="" class="nav-link" id="menu">
                        <i class="nav-icon fas fa-bars"></i>
                        <p> Danh Mục
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>            
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('menu.add') }}" class="nav-link" id="menu-add">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm Danh Mục</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('menu.list') }}" class="nav-link" id="menu-list">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh Sách Danh Mục</p>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li class="nav-item nav-bar" id="product-container">
                    <a href="" class="nav-link" id="product">
                        <i class="nav-icon fas fa-store-alt"></i>
                        <p> Sản Phẩm
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('product.add') }}" class="nav-link" id="product-add">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm Sản Phẩm</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('product.list') }}" class="nav-link" id="product-list">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh Sách Sản Phẩm</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item nav-bar" id="slider-container">
                    <a href="" class="nav-link" id="slider">
                        <i class="nav-icon fas fa-images"></i>
                        <p> Slider
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('slider.add') }}" class="nav-link" id="slider-add">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm Slider</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('slider.list') }}" class="nav-link" id="slider-list">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh Sách Slider</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item nav-bar" id="order-container">
                    <a href="" class="nav-link" id="order">
                        <i class="nav-icon fas fa-cart-plus"></i>
                        <p> Đơn Hàng
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('order.list') }}" class="nav-link" id="order-list">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh Sách Đơn Hàng</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item nav-bar" id="user-container">
                    <a href="" class="nav-link" id="user">
                        <i class="nav-icon fas fa-user"></i>
                        <p> User
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('user.add') }}" class="nav-link" id="user-add">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.list') }}" class="nav-link" id="user-list">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh Sách User</p>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li class="nav-item nav-bar" id="role-container">
                    <a href="" class="nav-link" id="role">
                        <i class="nav-icon fas fa-briefcase"></i>
                        <p> Vai Trò
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('role.add') }}" class="nav-link" id="role-add">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm Vai Trò</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('role.list') }}" class="nav-link" id="role-list">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh Sách Vai Trò</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item nav-bar" id="permission-container">
                    <a href="" class="nav-link" id="permission">
                        <i class="nav-icon fas fa-screwdriver-wrench"></i>
                        <p> Phân Quyền
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('permission.add') }}" class="nav-link" id="permission-add">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm Quyền</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('permission.list') }}" class="nav-link" id="permission-list">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh Sách Quyền</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item nav-bar" id="size-container">
                    <a href="" class="nav-link" id="size">
                        <i class="nav-icon fas fa-weight-scale"></i>
                        <p> Size
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('size.add') }}" class="nav-link" id="size-add">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm Size</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('size.list') }}" class="nav-link" id="size-list">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh Sách Size</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('customer.list') }}" class="nav-link" id="customer-list">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Khách hàng</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('user.profile') }}" class="nav-link" id="user-profile">
                        <i class="nav-icon fas fa-gear"></i>
                        <p>Tài khoản</p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

