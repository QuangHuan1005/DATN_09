@php
    use Illuminate\Support\Arr;

    // 1. Lấy toàn bộ tham số query hiện tại
    $qs = request()->query();

    // 2. Helper: Tạo URL mới bằng cách thêm hoặc ghi đè tham số (Dùng cho Category/Price)
    $with = function (array $extra) use ($qs) {
        $params = array_merge($qs, $extra);
        // Loại bỏ các giá trị null để URL sạch hơn
        foreach ($params as $key => $value) {
            if (is_null($value)) unset($params[$key]);
        }
        unset($params['page']); // Reset về trang 1 khi lọc
        return route('products.index', $params);
    };

    // 3. Helper: Toggle giá trị trong mảng (Dùng cho Colors/Sizes - cho phép chọn nhiều)
    $toggleInArray = function (string $key, $val) use ($qs) {
        $current = (array) ($qs[$key] ?? []);
        if (in_array($val, $current)) {
            $next = array_values(array_diff($current, [$val]));
        } else {
            $next = array_values(array_unique(array_merge($current, [$val])));
        }
        
        $newQs = $qs;
        if (empty($next)) {
            unset($newQs[$key]);
        } else {
            $newQs[$key] = $next;
        }
        unset($newQs['page']);
        return route('products.index', $newQs);
    };

    // 4. Helper: Xóa hoàn toàn 1 tham số (Dùng để bỏ lọc)
    $removeKey = function (string $key) use ($qs) {
        $newQs = $qs;
        unset($newQs[$key]);
        unset($newQs['page']);
        return route('products.index', $newQs);
    };

    // 5. Helper: Xóa 1 giá trị cụ thể trong mảng tham số
    $removeFromArray = function (string $key, $val) use ($qs) {
        $newQs = $qs;
        $arr = (array) ($newQs[$key] ?? []);
        $arr = array_values(array_diff($arr, [$val]));
        if (empty($arr)) {
            unset($newQs[$key]);
        } else {
            $newQs[$key] = $arr;
        }
        unset($newQs['page']);
        return route('products.index', $newQs);
    };

    // Khai báo các biến đã chọn từ Request
    $selectedCategory = request('category');
    $selectedMin      = request('min_price');
    $selectedMax      = request('max_price');
    $selectedColors   = (array) request('colors', []);
    $selectedSizes    = (array) request('sizes', []);
@endphp

<div class="elementor-element elementor-element-36fb1d54 e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
    data-id="36fb1d54" data-element_type="container">
    <div class="elementor-element elementor-element-21e8bcb4 e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child elementor-sticky"
        data-id="21e8bcb4" data-element_type="container"
        data-settings="{&quot;sticky&quot;:&quot;top&quot;,&quot;sticky_on&quot;:[&quot;desktop&quot;,&quot;laptop&quot;],&quot;sticky_offset&quot;:50,&quot;sticky_parent&quot;:&quot;yes&quot;,&quot;sticky_effects_offset&quot;:0}">
        <div class="e-con-inner">
            <div class="elementor-element elementor-element-71c3e12b elementor-widget kitify elementor-kitify-sidebar"
                data-id="71c3e12b" data-element_type="widget" data-widget_type="kitify-sidebar.default">
                <div class="elementor-widget-container">
                    <div class="kitify-sidebar kitify-sidebar-layout_01 kitify-toggle-sidebar" data-breakpoint="1024">
                        <div class="kitify-toggle-sidebar__overlay js-column-toggle"></div>
                        <div class="kitify-toggle-sidebar__container">
                            <a class="kitify-toggle-sidebar__toggle js-column-toggle" href="javascript:void(0)"></a>
                            <div class="toggle-column-btn__wrap"><a class="toggle-column-btn js-column-toggle" href="javascript:void(0)"></a></div>
                            
                            <div class="kitify-toggle-sidebar__inner nova_box_ps ps ps--theme_default">
                                
                                {{-- ASIDE: BỘ LỌC ĐANG ÁP DỤNG --}}
                                <aside class="woocommerce novaapf-ajax-term-filter widget widget_novaapf-active-filters">
                                    <div class="widget-title">Bộ lọc đang áp dụng</div>
                                    <div class="novaapf-active-filters">
                                        @php $hasAny = false; @endphp

                                        {{-- Danh mục --}}
                                        @if ($selectedCategory)
                                            @php $hasAny = true; @endphp
                                            <a href="{{ $removeKey('category') }}">
                                                {{ optional($categories->firstWhere('id', (int) $selectedCategory))->name ?? '#' . $selectedCategory }}
                                            </a>
                                        @endif

                                        {{-- Khoảng giá --}}
                                        @if ($selectedMin || $selectedMax)
                                            @php $hasAny = true; @endphp
                                            <a href="{{ $with(['min_price' => null, 'max_price' => null]) }}">
                                                {{ number_format((int) $selectedMin, 0, ',', '.') }}₫ - {{ number_format((int) $selectedMax, 0, ',', '.') }}₫
                                            </a>
                                        @endif

                                        {{-- Màu sắc --}}
                                        @foreach ($selectedColors as $cid)
                                            @php $hasAny = true; $c = $colors->firstWhere('id', (int) $cid); @endphp
                                            <a href="{{ $removeFromArray('colors', $cid) }}">
                                                {{ $c->name ?? '#' . $cid }}
                                            </a>
                                        @endforeach

                                        {{-- Size --}}
                                        @foreach ($selectedSizes as $sid)
                                            @php $hasAny = true; $s = $sizes->firstWhere('id', (int) $sid); @endphp
                                            <a href="{{ $removeFromArray('sizes', $sid) }}">
                                                {{ $s->name ?? '#' . $sid }}
                                            </a>
                                        @endforeach

                                        @if (!$hasAny)
                                            <span class="text-muted">Chưa có bộ lọc nào.</span>
                                        @else
                                            <a href="{{ route('products.index') }}" class="reset">Xóa tất cả bộ lọc</a>
                                        @endif
                                    </div>
                                </aside>

                                {{-- ASIDE: DANH MỤC --}}
                                <aside class="woocommerce novaapf-ajax-term-filter widget widget_novaapf-category-filter">
                                    <div class="widget-title">Danh Mục Sản Phẩm</div>
                                    <div class="novaapf-layered-nav">
                                        <ul>
                                            @foreach ($categories as $cat)
                                                @php
                                                    $active = (int) $selectedCategory === (int) $cat->id;
                                                    $url = $active ? $removeKey('category') : $with(['category' => $cat->id]);
                                                @endphp
                                                <li class="{{ $active ? 'chosen' : '' }}">
                                                    <a href="{{ $url }}"><span class="name">{{ $cat->name }}</span></a>
                                                    <span class="count">({{ $cat->products_count }})</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </aside>

                                {{-- ASIDE: GIÁ --}}
                                <aside class="woocommerce novaapf-price-filter-widget novaapf-ajax-term-filter widget widget_novaapf-price-filter">
                                    <div class="widget-title">Giá</div>
                                    <div class="novaapf-layered-nav">
                                        <ul>
                                            @foreach ([[0, 100000], [100000, 200000], [200000, 300000], [300000, 400000], [400000, 500000], [500000, 2000000]] as [$min, $max])
                                                @php
                                                    $isActive = (int) $selectedMin === $min && (int) $selectedMax === $max;
                                                    $url = $isActive ? $with(['min_price' => null, 'max_price' => null]) : $with(['min_price' => $min, 'max_price' => $max]);
                                                @endphp
                                                <li class="{{ $isActive ? 'chosen' : '' }}">
                                                    <a href="{{ $url }}">
                                                        <span class="min">{{ number_format($min, 0, ',', '.') }}₫</span>
                                                        <span class="to"> - </span>
                                                        <span class="max">{{ number_format($max, 0, ',', '.') }}₫</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </aside>

                                {{-- ASIDE: MÀU SẮC --}}
                                <aside class="woocommerce novaapf-ajax-term-filter widget widget_novaapf-attribute-filter">
                                    <div class="widget-title">Màu Sắc</div>
                                    <div class="novaapf-layered-nav et-list-novaapf">
                                        <ul>
                                            @foreach ($colors as $color)
                                                @php
                                                    $active = in_array($color->id, $selectedColors);
                                                    $url = $toggleInArray('colors', $color->id);
                                                @endphp
                                                <li class="{{ $active ? 'chosen' : '' }}">
                                                    <a href="{{ $url }}" class="et-color-swatch">
                                                        <span class="et-swatch-circle">
                                                            <span style="background-color:{{ $color->color_code }}; border: 1px solid #eee;"></span>
                                                        </span>
                                                        <span class="name">{{ $color->name }}</span>
                                                    </a>
                                                    <span class="count">({{ $color->products_count }})</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </aside>

                                {{-- ASIDE: SIZE --}}
                                <aside class="woocommerce novaapf-ajax-term-filter widget widget_novaapf-attribute-filter">
                                    <div class="widget-title">Size</div>
                                    <div class="novaapf-layered-nav et-list-novaapf">
                                        <ul>
                                            @foreach ($sizes as $size)
                                                @php
                                                    $active = in_array($size->id, $selectedSizes);
                                                    $url = $toggleInArray('sizes', $size->id);
                                                @endphp
                                                <li class="{{ $active ? 'chosen' : '' }}">
                                                    <a href="{{ $url }}"><span class="name">{{ $size->name }}</span></a>
                                                    <span class="count">({{ $size->products_count }})</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </aside>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>