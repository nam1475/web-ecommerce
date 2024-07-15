@extends('shop.layout.main')

@section('content')
    <style>
        .range-input-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .range-input-container input {
            width: 100px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px;
        }
        
        .range-separator {
            margin: 0 10px;
            font-size: 1.5rem;
        }

        /* Custom Styles */
        .irs--flat .irs-bar,
        .irs--flat .irs-from,
        .irs--flat .irs-to,
        .irs--flat .irs-single {
            background-color: #343a40; /* Customize the bar color */
            border-color: #343a40;
        }
        .irs--flat .irs-handle {
            background-color: #ffffff; /* Customize the handle color */
            border-color: #343a40;
            box-shadow: 0 0 0 1px #343a40;
            border-radius: 10px;
            cursor: pointer;
        }
        .irs--flat .irs-line {
            background-color: #dee2e6; /* Customize the line color */
        }
        .irs--flat .irs-min,
        .irs--flat .irs-max {
            color: #343a40; /* Customize the text color */
        }
    </style>

    <div class="bg0 m-t-23 p-b-140 p-t-80">
        <div class="container">
            <div class="flex-w flex-sb-m p-b-52">
                <div class="flex-w flex-l-m filter-tope-group m-tb-10">
                   <h1>{{ $title }}</h1>
                </div>

                <div class="flex-w flex-c-m m-tb-10">
                    {{-- <div class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter">
                        <i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
                        <i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                        Phân loại
                    </div> --}}
                    
                    <div class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-search">
                        <i class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
                        <i class="icon-close-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                        Tìm kiếm
                    </div>
                </div>

                <!-- Search product -->
                <div class="dis-none panel-search w-full p-t-10 p-b-15">
                    <form action="" id="search-form">
                        <div class="bor8 dis-flex p-l-15">
                            <button type="submit" class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
                                <i class="zmdi zmdi-search"></i>
                            </button>

                            <input class="mtext-107 cl2 size-114 plh2 p-r-15" type="text" name="search-products" 
                                value="{{ request()->input('search-products') ? request()->input('search-products') : '' }}" 
                                id="search-products" placeholder="Tìm kiếm sản phẩm...."
                            >
                        </div>
                    </form>
                </div>
                
            </div>
            
            <div class="row">
                <div class="col-lg-3">
                    <form action="{{ route('shop.menu.filter', $slug) }}">
                        <div class="border p-3 mb-4">
                            <h4 class="mb-3"><i class="fa-solid fa-bars"></i> Bộ lọc</h4>

                            <hr>
                            
                            <div class="my-2">
                                <label>Sắp xếp</label>
                                <div class="form-check">
                                    <input class="form-check-input pointer" name="sort-price" type="radio" 
                                        value="asc" id="price-asc" {{ request()->query('sort-price') == 'asc' ? 'checked' : '' }}>
                                    <label class="form-check-label p-0 pointer" for="price-asc">
                                        Giá tăng dần
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input pointer" name="sort-price" type="radio" 
                                        value="desc" id="price-desc" {{ request()->query('sort-price') == 'desc' ? 'checked' : '' }}>
                                    <label class="form-check-label p-0 pointer" for="price-desc">
                                        Giá giảm dần
                                    </label>
                                </div>
                            </div>

                            <hr>

                            @if(!$menuProducts->isEmpty())
                                <div class="my-2 form-group">
                                    <label>Danh mục</label>
                                    @foreach ($menuProducts as $mp)
                                        <div class="form-check">
                                            <input class="form-check-input pointer" type="checkbox" value="{{ $mp->slug }}" 
                                                {{ !empty(request()->query('menu')) && in_array($mp->slug, request()->query('menu')) ? 'checked' : '' }}
                                                id="{{ $mp->slug }}" name="menu[]">
                                            <label class="form-check-label p-0 pointer" for="{{ $mp->slug }}">{{ $mp->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                <hr>
                            @endif
        
                            <div class="my-2">
                                <label>Khoảng giá</label>
                                <div class="range-input-container">
                                    <input type="text" id="min-price" name="min-price" value="{{ request()->query('min-price') ? request()->query('min-price') : '' }}" readonly>
                                    <span class="range-separator">~</span>
                                    <input type="text" id="max-price" name="max-price" value="{{ request()->query('max-price') ? (request()->query('max-price')) : '' }}" readonly>
                                    <input type="hidden" id="price-highest" value="{{ $highestPrice }}">
                                </div>
                                <input type="text" id="price-range">
                            </div>

                            <hr>

                            <div class="my-2">
                                <button type="submit" style="width: 240px;" class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
                                    Áp dụng
                                </button>
                                <a href="{{ request()->url() }}" class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">Xóa bộ lọc</a>
                            </div>
                        </div>
                    </form>
                </div>
                @include('shop.product.list')
            </div>

            {!! $products->links() !!}
        </div>
    </div>

@endsection

@section('footer')
    <script>
        /* Select2 */
        $('.select2').select2();
    </script>
@endsection