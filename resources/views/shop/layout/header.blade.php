<style>
    .dropdown-item:active{
        background-color: #6c7ae0;
    }
</style>

<header>
    @php $menusHtml = \App\Helpers\Helper::mainMenu($menus); @endphp
    {{-- {{ dd($menus) }} --}}
    <!-- Header desktop -->
    <div class="container-menu-desktop">    
        <div class="wrap-menu-desktop">
            <nav class="limiter-menu-desktop container">
                <!-- Logo desktop -->
                <a href="{{ route('shop.home') }}" class="logo">
                    <img src="{{ asset('template/shop/images/icons/cooltext461671874962170.png') }}" alt="IMG-LOGO">
                </a>

                <!-- Menu desktop -->
                <div class="menu-desktop">
                    <ul class="main-menu">  
                        <li>
                            <a href="{{ route('shop.home') }}" id="home" class="nav-link">Trang Chủ</a> 
                        </li>

                        {!! $menusHtml !!}
                    </ul>
                </div>

                <!-- Icon header -->
                <div class="wrap-icon-header flex-w flex-r-m">
                    {{-- <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
                        <i class="zmdi zmdi-search"></i>
                    </div> --}}
                    
                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart"
                        data-notify="{{ !is_null(\Session::get('carts')) ? count(\Session::get('carts')) : 0 }}">
                        <a href="{{ route('shop.cart.list') }}" style="color: initial">
                            <i class="zmdi zmdi-shopping-cart"></i>
                        </a>
                    </div>

                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-cart"
                        data-notify="">
                        <li class="nav-item dropdown">
                            <a class="p-0" data-toggle="dropdown" style="color: initial" href="">
                                <i class="zmdi zmdi-account"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                @if(!auth('customer')->check())
                                    <a href="{{ route('shop.login') }}" class="dropdown-item">
                                        <i class="fa-solid fa-right-to-bracket"></i> Đăng nhập
                                    </a>
    
                                    <div class="dropdown-divider"></div>
    
                                    <a href="{{ route('shop.register') }}" class="dropdown-item">
                                        <i class="fa-solid fa-user-plus"></i> Đăng ký
                                    </a>
                                @else
                                    <span class="dropdown-item dropdown-header">
                                        <h6>
                                            {{ auth('customer')->user()->name }}
                                        </h6>
                                    </span>
                                    <a href="{{ route('shop.profile.info') }}" class="dropdown-item">
                                        <i class="fas fa-gear mr-2"></i> Tài khoản
                                    </a>

                                    <div class="dropdown-divider"></div>

                                    <a href="{{ route('shop.logout') }}" class="dropdown-item" id="logout-customer">
                                        <i class="fas fa-power-off mr-2"></i> Đăng xuất
                                    </a>
                                @endif
                            </div>
                        </li>
                    </div>

                </div>
            </nav>
        </div>
    </div>

    <!-- Modal Search -->
    {{-- <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
        <div class="container-search-header">
            <button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
                <img src="/template/shop/images/icons/icon-close2.png" alt="CLOSE">
            </button>

            <form action="{{ route('shop.menu.list', ['slug' => request()->input('search-products')]) }}" class="wrap-search-header flex-w p-l-15">
                <button class="flex-c-m trans-04">
                    <i class="zmdi zmdi-search"></i>
                </button>
                <input class="plh3" type="text" name="search-products" placeholder="Tìm kiếm sản phẩm...">
            </form>
        </div>
    </div> --}}
</header>