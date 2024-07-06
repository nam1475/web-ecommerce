@extends('admin.layout.main')

@section('content')

    @php
        use App\Helpers\Helper; 
    @endphp
    
    @section('filter')
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default"> 
            <i class="fa-solid fa-filter"></i>Lọc   
        </button>

        {{-- @if(!empty(request()->query()))
            @foreach (request()->query() as $key => $item)
                @if (is_array($item))
                    @foreach ($item as $k => $v) --}}
                        {{-- <a href="{{ request()->fullUrlWithQuery([$item[$k] => null]) }}" class="filter-link stext-106 trans-04">
                            @php
                                $menu = \App\Models\Menu::where('slug', $v)->first();
                            @endphp                                                                         
                            {{ $menu->name }}
                        </a> --}}

                        {{-- -url()->current(): Lấy ra url hiện tại mà ko có query string
                        -http_build_query(): Chuyển mảng associative thành một chuỗi query string 
                        -array_diff(): Hàm so sánh các giá trị của mảng đầu tiên với các giá trị của các mảng khác và trả 
                        về những giá trị chỉ có trong mảng đầu tiên.
                        --}}
                        {{-- <a href="{{ url()->current() . '?' . http_build_query(array_merge(request()->query(), [$key => array_diff($item, [$v])])) }}">
                            @php
                                $menu = \App\Models\Menu::where('slug', $v)->first();
                            @endphp                                                                         
                            {{ $menu->name }} &times;
                        </a>
                    @endforeach
                @else   
                    @if($key == 'price-min' || $key == 'price-max')
                        <a href="{{ request()->fullUrlWithQuery(['price-min' => null, 'price-max' => null]) }}" class="filter-link stext-106 trans-04">
                            {{ $item }} &times;
                        </a>
                    @elseif($key == 'sort-price')
                        @if($item == 'asc')
                            <a href="{{ request()->fullUrlWithQuery([$key => null]) }}" class="filter-link stext-106 trans-04">
                                Tăng dần &times;
                            </a>
                        @elseif($item == 'desc')
                            <a href="{{ request()->fullUrlWithQuery([$key => null]) }}" class="filter-link stext-106 trans-04">
                                Giảm dần &times;
                            </a>
                        @endif
                    @endif
                @endif
            @endforeach
        @endif --}}

        <div class="modal fade" id="modal-default">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-default">
                    <form action="{{ route('product.list.filter') }}">
                        <div class="modal-header">
                            <h4 class="modal-title">Lọc sản phẩm</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {!! Helper::filterProducts($menuProducts, $highestPrice) !!}
                        </div>

                        <div class="modal-footer justify-content-between">
                            <a href="{{ request()->url() }}" class="btn btn-default">Xóa bộ lọc</a>
                            <button type="submit" class="btn btn-primary">Áp dụng</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>  
    @endsection
    
    @include('admin.search')

    <table class="table">
        <thead class="thead-light">
            <tr class="text-nowrap">
                <th style="width: 50px">ID</th>
                <th>Tên</th>
                <th>Danh mục</th>
                <th>Giá gốc</th>    
                <th>Giá khuyến mại</th>
                <th>Size</th>
                <th>Ảnh</th>
                <th>Kích hoạt</th>
                <th>Slug</th>
                <th>
                    <div>Người tạo</div>
                    <div>Ngày tạo</div>
                </th>
                <th>
                    <div>Người cập nhật</div>
                    <div>Ngày cập nhật</div>
                </th>
                <th>&nbsp;</th>
            </tr>
        </thead>

        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->menu->name }}</td>
                    <td>{{ number_format($product->price, 0, '', '.') }}đ</td>
                    @if(isset($product->price_sale))
                        <td>{{ number_format($product->price_sale, 0, '', '.') }}đ</td>
                    @else
                        <td>&nbsp;</td>
                    @endif
                    <td>
                        @php
                            $productSizes = $product->sizes()->orderBy('size_id', 'asc')->get();
                        @endphp

                        @foreach($productSizes as $ps)
                            <span class="badge badge-primary">{{ $ps->name }}</span>
                        @endforeach
                    </td>
                    <td><a href="{{ $product->thumb }}" target="_blank">
                        <img src="{{ $product->thumb }}" class="thumb-size-auto">
                    </a></td>
                    <td>{!! Helper::active($product->active) !!}</td>
                    <td>{{ $product->slug }}</td>
                    <td>
                        {!! Helper::createdAtAndBy($product) !!}
                    </td>
                    <td>
                        {!! Helper::updatedAtAndBy($product) !!}
                    </td>
                    <td class="btn-group">
                        @can('edit-product')
                            {!! Helper::editRow('product', $product) !!}
                        @endcan
                        @can('delete-product')
                            {!! Helper::deleteRow('product', $product) !!} 
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="card-footer clearfix">
        {!! $products->links() !!}
    </div>

@endsection
