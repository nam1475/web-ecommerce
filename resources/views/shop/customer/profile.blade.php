@extends('shop.layout.main')

@section('content')
<!-- Title page -->
<section class="bg-img1 txt-center m-t-110 p-lr-15 p-tb-85" style="background-image: url('/template/shop/images/bg-02.jpg');">
    <h2 class="ltext-105 cl0 txt-center">
        Profile
    </h2>
</section>	

<!-- Content page -->
<section class="bg0 p-t-62 p-b-60" style="background-color: #f4f4f4">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-lg-9 p-b-80">
                <div class="p-r-45 p-r-0-lg">
                    @include('admin.errors.error')
                    
                    @yield('profile')
                    
                </div>
            </div>

            <div class="col-md-4 col-lg-3 p-b-80">
                <div class="side-menu">
                    <div class="p-t-55">
                        <ul class="nav flex-column">
                            <li class="nav-item bor18">
                                <a href="{{ route('shop.profile.info') }}" 
                                    class="nav-link dis-block stext-115 cl6 hov-cl1 p-tb-8 p-lr-4"
                                    id="info">
                                    <i class="fa-solid fa-circle-info"></i>
                                    Info
                                </a>
                            </li>

                            <li class="nav-item bor18">
                                <a href="{{ route('shop.profile.order') }}" 
                                    class="nav-link dis-block stext-115 cl6 hov-cl1 p-tb-8 p-lr-4"
                                    id="order">
                                    <i class="fa-solid fa-truck"></i>
                                    Order
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
@endsection