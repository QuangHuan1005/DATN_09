<div class="kitify-sidebar kitify-sidebar-layout_01">
    {{-- DANH MỤC --}}
    <h4 class="widget-title">Danh mục sản phẩm</h4>
    <ul class="list-unstyled mb-3">
        @foreach($categories as $cat)
            <li class="d-flex justify-content-between align-items-center">
                <a href="{{ route('products.index', ['category' => $cat->id]) }}"
                   class="{{ request('category') == $cat->id ? 'fw-bold text-primary' : '' }}">
                    {{ $cat->name }}
                </a>
                <span class="text-muted small">({{ $cat->products_count }})</span>
            </li>
        @endforeach
    </ul>

    {{-- GIÁ --}}
    <h4 class="widget-title">Khoảng giá</h4>
    <ul class="list-unstyled mb-3">
        @foreach([[0,50000],[50000,100000],[100000,200000],[200000,300000]] as [$min,$max])
            <li>
                <a href="{{ route('products.index', ['min_price'=>$min,'max_price'=>$max]) }}">
                    {{ number_format($min,0,',','.') }}đ - {{ number_format($max,0,',','.') }}đ
                </a>
            </li>
        @endforeach
    </ul>

    {{-- MÀU --}}
    <h4 class="widget-title">Màu sắc</h4>
    <ul class="list-unstyled mb-3">
        @foreach($colors as $color)
            <li class="d-flex justify-content-between align-items-center">
                <a href="{{ route('products.index', ['color'=>$color->id]) }}">
                    <span class="d-inline-block rounded-circle border me-2"
                          style="width:16px;height:16px;background-color:{{ $color->hex_code }}"></span>
                    {{ $color->name }}
                </a>
                <span class="text-muted small">({{ $color->products_count }})</span>
            </li>
        @endforeach
    </ul>

    {{-- KÍCH CỠ --}}
    <h4 class="widget-title">Kích cỡ</h4>
    <ul class="list-unstyled mb-3">
        @foreach($sizes as $size)
            <li class="d-flex justify-content-between align-items-center">
                <a href="{{ route('products.index', ['size'=>$size->id]) }}">
                    {{ $size->name }}
                </a>
                <span class="text-muted small">({{ $size->products_count }})</span>
            </li>
        @endforeach
    </ul>

    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm w-100">
        Xóa tất cả bộ lọc
    </a>
</div>
