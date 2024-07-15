@extends('shop.layout.main')

@section('content')
    <!-- Title page -->
	<section class="bg-img1 txt-center m-t-110 p-lr-15 p-tb-85" style="background-image: url('/template/shop/images/bg-01.jpg');">
		<h2 class="ltext-105 cl0 txt-center">
			ĐĂNG NHẬP
		</h2>
	</section>	

	<!-- Content page -->
	<section class="bg0 p-t-80 p-b-116">
		<div class="container">
			<div class="flex-w flex-tr">
				<div class="size-210 bor10 p-lr-70 p-t-55 p-b-70 p-lr-15-lg w-full-md">
					<form action="{{ route('shop.login.action') }}" method="POST">
                        @csrf
						<h4 class="mtext-105 cl2 txt-center p-b-30">
							Đăng Nhập
						</h4>

                        @include('admin.errors.error')
                        
						<div class="bor8 m-b-20 how-pos4-parent">
							<input class="stext-111 cl2 plh3 size-116 p-l-10 p-r-30" type="email" value="{{ old('email') }}" name="email" placeholder="Email">
							{{-- <img class="how-pos4 pointer-none" src="images/icons/icon-email.png" alt="ICON"> --}}
						</div>

						<div class="bor8 m-b-30">
							<input class="stext-111 cl2 plh3 size-116 p-l-10 p-r-30" type="password" value="{{ old('password') }}" name="password" placeholder="Mật khẩu">
						</div>

                        <div class="form-group d-flex justify-content-between">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input checkbox-children" name="remember" type="checkbox" 
                                     id="remember">
                                <label class="custom-control-label pointer" for="remember">
									Ghi nhớ đăng nhập
                                </label>
                            </div>
                        </div>

						<button type="submit" class="flex-c-m stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer">
							Submit
						</button>
					</form>
					<div class="d-flex justify-content-between mt-2">
						<a href="{{ route('shop.register') }}">Đăng ký</a>
						{!! \App\Helpers\Helper::forgotPassword('shop.forgot.password') !!}
					</div>
				</div>

				<div class="size-210 bor10 flex-w flex-col-m p-lr-93 p-tb-30 p-lr-15-lg w-full-md">
					<div class="flex-w w-full p-b-42">
						<span class="fs-18 cl5 txt-center size-211">
							<span class="lnr lnr-map-marker"></span>
						</span>

						<div class="size-212 p-t-2">
							<span class="mtext-110 cl2">
								Address
							</span>

							<p class="stext-115 cl6 size-213 p-t-18">
								Fein Clothing 8th floor, 379 Hudson St, New York, NY 10018 US
							</p>
						</div>
					</div>

					<div class="flex-w w-full p-b-42">
						<span class="fs-18 cl5 txt-center size-211">
							<span class="lnr lnr-phone-handset"></span>
						</span>

						<div class="size-212 p-t-2">
							<span class="mtext-110 cl2">
								Lets Talk
							</span>

							<p class="stext-115 cl1 size-213 p-t-18">
								+1 800 1236879
							</p>
						</div>
					</div>

					<div class="flex-w w-full">
						<span class="fs-18 cl5 txt-center size-211">
							<span class="lnr lnr-envelope"></span>
						</span>

						<div class="size-212 p-t-2">
							<span class="mtext-110 cl2">
								Sale Support
							</span>

							<p class="stext-115 cl1 size-213 p-t-18">
								contact@example.com
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>	
@endsection