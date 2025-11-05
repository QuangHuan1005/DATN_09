@php
    use Illuminate\Support\Arr;

    // Toàn bộ query hiện tại
    $qs = request()->query();

    // Helper: tạo URL thêm/ghi đè tham số (giữ nguyên các tham số khác)
    $with = fn(array $extra) => route('products.index', array_merge($qs, $extra));

    // Helper: toggle 1 giá trị trong mảng tham số (colors[], sizes[])
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
        return route('products.index', $newQs);
    };

    // Helper: remove 1 tham số
    $removeKey = function (string $key) use ($qs) {
        $newQs = $qs;
        unset($newQs[$key]);
        return route('products.index', $newQs);
    };

    // Helper: remove 1 giá trị trong mảng tham số
    $removeFromArray = function (string $key, $val) use ($qs) {
        $newQs = $qs;
        $arr = (array) ($newQs[$key] ?? []);
        $arr = array_values(array_diff($arr, [$val]));
        if (empty($arr)) {
            unset($newQs[$key]);
        } else {
            $newQs[$key] = $arr;
        }
        return route('products.index', $newQs);
    };

    $selectedCategory = request('category');
    $selectedMin = request('min_price');
    $selectedMax = request('max_price');
    $selectedColors = (array) request('colors', []);
    $selectedSizes = (array) request('sizes', []);
@endphp

<div class="elementor-element elementor-element-36fb1d54 e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
    data-id="36fb1d54" data-element_type="container">
    <div class="elementor-element elementor-element-21e8bcb4 e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child elementor-sticky"
        data-id="21e8bcb4" data-element_type="container"
        data-settings="{&quot;sticky&quot;:&quot;top&quot;,&quot;sticky_on&quot;:[&quot;desktop&quot;,&quot;laptop&quot;],&quot;sticky_offset&quot;:50,&quot;sticky_parent&quot;:&quot;yes&quot;,&quot;sticky_effects_offset&quot;:0}"
        style="">
        <div class="e-con-inner">
            <div class="elementor-element elementor-element-71c3e12b elementor-widget kitify elementor-kitify-sidebar"
                data-id="71c3e12b" data-element_type="widget" data-widget_type="kitify-sidebar.default">
                <div class="elementor-widget-container">
                    <div class="kitify-sidebar kitify-sidebar-layout_01 kitify-toggle-sidebar" data-breakpoint="1024">
                        <div class="kitify-toggle-sidebar__overlay js-column-toggle"></div>
                        <div class="kitify-toggle-sidebar__container"><a
                                class="kitify-toggle-sidebar__toggle js-column-toggle" href="javascript:void(0)"></a>
                            <div class="toggle-column-btn__wrap"><a class="toggle-column-btn js-column-toggle"
                                    href="javascript:void(0)"></a></div>
                            <div class="kitify-toggle-sidebar__inner nova_box_ps ps ps--theme_default"
                                data-ps-id="e5ca9d68-7638-a48c-e4c8-434062a0d4ed">
                                <aside id="novaapf-active-filters-2"
                                    class="woocommerce novaapf-ajax-term-filter widget widget_novaapf-active-filters">
                                    <div class="widget-title">Bộ lọc đang áp dụng</div>
                                    <div class="novaapf-active-filters">
                                        @php
                                            $hasAny = false;
                                        @endphp
                                        @if ($selectedCategory)
                                            @php
                                                $hasAny = true;
                                            @endphp

                                            <a href="{{ $removeKey('category') }}">
                                                {{ optional($categories->firstWhere('id', (int) $selectedCategory))->name ?? '#' . $selectedCategory }}
                                            </a>
                                        @endif
                                        @if ($selectedMin || $selectedMax)
                                            @php
                                                $hasAny = true;
                                            @endphp
                                            <a href="{{ $removeKey('min_price') }}">
                                                {{ number_format((int) $selectedMin, 0, ',', '.') }}₫
                                            </a>
                                            <a href="{{ $removeKey('max_price') }}">
                                                {{ number_format((int) $selectedMax, 0, ',', '.') }}
                                            </a>
                                        @endif
                                        @foreach ($selectedColors as $cid)
                                            @php
                                                $c = $colors->firstWhere('id', (int) $cid);
                                                $hasAny = true;
                                            @endphp
                                            <a href="{{ $removeFromArray('colors', $cid) }}">
                                                {{ $c->name ?? '#' . $cid }}
                                            </a>
                                        @endforeach
                                        @foreach ($selectedSizes as $sid)
                                            @php
                                                $s = $sizes->firstWhere('id', (int) $sid);
                                                $hasAny = true;
                                            @endphp
                                            <a href="{{ $removeFromArray('sizes', $sid) }}">
                                                {{ $s->name ?? '#' . $sid }}
                                            </a>
                                        @endforeach
                                        @if (!$hasAny)
                                            <span class="text-muted">Chưa có bộ lọc nào.</span>
                                        @endif
                                        @if ($hasAny)
                                            <a href="{{ route('products.index') }}" class="reset"
                                                data-location="{{ route('products.index') }}">Xóa tất cả bộ lọc</a>
                                        @endif
                                    </div>
                                </aside>
                                <aside id="novaapf-category-filter-2"
                                    class="woocommerce novaapf-ajax-term-filter widget widget_novaapf-category-filter">
                                    <div class="widget-title">Danh Mục Sản Phẩm</div>
                                    <div class="novaapf-layered-nav">
                                        <ul>
                                            @foreach ($categories as $cat)
                                                @php
                                                    $active = (int) $selectedCategory === (int) $cat->id;
                                                    $url = $with(['category' => $cat->id]); // giữ các filter khác
                                                @endphp
                                                <li class="{{ $active ? 'chosen' : '' }}"><a
                                                        href="{{ $url }}"><span class="name">
                                                            {{ $cat->name }}
                                                        </span></a><span
                                                        class="count">({{ $cat->products_count }})</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </aside>
                                <aside id="novaapf-price-filter-2"
                                    class="woocommerce novaapf-price-filter-widget novaapf-ajax-term-filter widget widget_novaapf-price-filter">
                                    <div class="widget-title">Giá</div>
                                    <div class="novaapf-layered-nav">
                                        <ul>
                                            @foreach ([[0, 100000], [100000, 200000], [200000, 300000], [300000, 400000], [400000, 500000], [500000, 600000]] as [$min, $max])
                                                @php
                                                    $isActive =
                                                        (int) $selectedMin === $min && (int) $selectedMax === $max;
                                                    $url = $with(['min_price' => $min, 'max_price' => $max]);
                                                @endphp
                                                <li class="{{ $active ? 'chosen' : '' }}"><a
                                                        href="{{ $url }}">
                                                        <span
                                                            class="min">{{ number_format($min, 0, ',', '.') }}₫</span>
                                                        <span class="to"> - </span>
                                                        <span
                                                            class="max">{{ number_format($max, 0, ',', '.') }}₫</span></a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </aside>
                                <aside id="novaapf-attribute-filter-2"
                                    class="woocommerce novaapf-ajax-term-filter widget widget_novaapf-attribute-filter">
                                    <div class="widget-title">Màu Sắc</div>
                                    <div class="novaapf-layered-nav et-list-novaapf">
                                        <ul>
                                            {{-- @foreach ($colors as $color)
                                                @php
                                                    $active = in_array($color->id, $selectedColors);
                                                    $url = $toggleInArray('colors', $color->id);
                                                @endphp
                                                <li class="{{ $active ? 'chosen' : '' }}"><a
                                                        href="{{ $url }}" class="et-color-swatch">
                                                        <span class="et-swatch-circle"><span
                                                                style="background-color:{{ $color->color_code }}"></span></span><span
                                                            class="name">{{ $color->name }}</span></a><span
                                                        class="count">({{ $color->products_count }})</span>
                                                </li>
                                            @endforeach --}}
                                            @foreach ($colors as $color)
                                                @php
                                                    $active = in_array($color->id, $selectedColors);
                                                    // $url = $toggleInArray('colors', $color->id);
                                                    $url = route('products.index', ['color' => $color->id]);

                                                @endphp
                                                <li class="{{ $active ? 'chosen' : '' }}"><a
                                                        href="{{ $url }}" class="et-color-swatch">
                                                        <span class="et-swatch-circle"><span
                                                                style="background-color:{{ $color->color_code }}"></span></span><span
                                                            class="name">{{ $color->name }}</span></a><span
                                                        class="count">({{ $color->products_count }})</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </aside>
                                <aside id="novaapf-attribute-filter-3"
                                    class="woocommerce novaapf-ajax-term-filter widget widget_novaapf-attribute-filter">
                                    <div class="widget-title">Size</div>
                                    <div class="novaapf-layered-nav et-list-novaapf">
                                        <ul>
                                            @foreach ($sizes as $size)
                                                @php
                                                    $active = in_array($size->id, $selectedSizes);
                                                    // $url = $toggleInArray('sizes', $size->id);
                                                    $url = route('products.index', ['size' => $size->id]);

                                                @endphp
                                                <li class="{{ $active ? 'chosen' : '' }}">
                                                    <a href="{{ $url }}"><span
                                                            class="name">{{ $size->name }}</span></a><span
                                                        class="count">({{ $size->products_count }})</span>
                                                </li>
                                            @endforeach

                                        </ul>
                                    </div>
                                </aside>
                                {{-- <aside id="woocommerce_product_tag_cloud-2"
                                    class="widget woocommerce widget_product_tag_cloud">
                                    <h4 class="widget-title">Tags</h4>
                                    <div class="tagcloud"><a href="https://mixtas.novaworks.net/product-tag/clothing/"
                                            class="tag-cloud-link tag-link-38 tag-link-position-1"
                                            style="font-size: 22pt;" aria-label="clothing (47 products)">clothing</a>
                                        <a href="https://mixtas.novaworks.net/product-tag/etc/"
                                            class="tag-cloud-link tag-link-39 tag-link-position-2"
                                            style="font-size: 22pt;" aria-label="etc (47 products)">etc</a>
                                        <a href="https://mixtas.novaworks.net/product-tag/fashion/"
                                            class="tag-cloud-link tag-link-37 tag-link-position-3"
                                            style="font-size: 22pt;" aria-label="fashion (47 products)">fashion</a>
                                        <a href="https://mixtas.novaworks.net/product-tag/m11/"
                                            class="tag-cloud-link tag-link-34 tag-link-position-4"
                                            style="font-size: 11.5pt;" aria-label="m11 (5 products)">m11</a>
                                        <a href="https://mixtas.novaworks.net/product-tag/m12/"
                                            class="tag-cloud-link tag-link-42 tag-link-position-5"
                                            style="font-size: 13.483333333333pt;"
                                            aria-label="m12 (8 products)">m12</a>
                                        <a href="https://mixtas.novaworks.net/product-tag/m31/"
                                            class="tag-cloud-link tag-link-60 tag-link-position-6"
                                            style="font-size: 10.566666666667pt;"
                                            aria-label="m31 (4 products)">m31</a>
                                        <a href="https://mixtas.novaworks.net/product-tag/m32/"
                                            class="tag-cloud-link tag-link-61 tag-link-position-7"
                                            style="font-size: 13.483333333333pt;"
                                            aria-label="m32 (8 products)">m32</a>
                                        <a href="https://mixtas.novaworks.net/product-tag/m41/"
                                            class="tag-cloud-link tag-link-64 tag-link-position-8"
                                            style="font-size: 13.483333333333pt;"
                                            aria-label="m41 (8 products)">m41</a>
                                        <a href="https://mixtas.novaworks.net/product-tag/m71/"
                                            class="tag-cloud-link tag-link-67 tag-link-position-9"
                                            style="font-size: 13.483333333333pt;"
                                            aria-label="m71 (8 products)">m71</a>
                                        <a href="https://mixtas.novaworks.net/product-tag/m72/"
                                            class="tag-cloud-link tag-link-68 tag-link-position-10"
                                            style="font-size: 8pt;" aria-label="m72 (2 products)">m72</a>
                                        <a href="https://mixtas.novaworks.net/product-tag/m81/"
                                            class="tag-cloud-link tag-link-69 tag-link-position-11"
                                            style="font-size: 13.483333333333pt;"
                                            aria-label="m81 (8 products)">m81</a>
                                        <a href="https://mixtas.novaworks.net/product-tag/men/"
                                            class="tag-cloud-link tag-link-35 tag-link-position-12"
                                            style="font-size: 18.5pt;" aria-label="men (23 products)">men</a>
                                        <a href="https://mixtas.novaworks.net/product-tag/products/"
                                            class="tag-cloud-link tag-link-36 tag-link-position-13"
                                            style="font-size: 22pt;" aria-label="products (47 products)">products</a>
                                        <a href="https://mixtas.novaworks.net/product-tag/women/"
                                            class="tag-cloud-link tag-link-59 tag-link-position-14"
                                            style="font-size: 18.733333333333pt;"
                                            aria-label="women (24 products)">women</a>
                                    </div>
                                </aside> --}}
                                <div class="ps__scrollbar-x-rail" style="left: 0px; bottom: 0px;">
                                    <div class="ps__scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                                </div>
                                <div class="ps__scrollbar-y-rail" style="top: 0px; right: 0px;">
                                    <div class="ps__scrollbar-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@php

    // Toàn bộ query hiện tại
    $qs = request()->query();

    // Helper: tạo URL thêm/ghi đè tham số (giữ nguyên các tham số khác)
    $with = fn(array $extra) => route('products.index', array_merge($qs, $extra));

    // Helper: toggle 1 giá trị trong mảng tham số (colors[], sizes[])
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
        return route('products.index', $newQs);
    };

    // Helper: remove 1 tham số
    $removeKey = function (string $key) use ($qs) {
        $newQs = $qs;
        unset($newQs[$key]);
        return route('products.index', $newQs);
    };

    // Helper: remove 1 giá trị trong mảng tham số
    $removeFromArray = function (string $key, $val) use ($qs) {
        $newQs = $qs;
        $arr = (array) ($newQs[$key] ?? []);
        $arr = array_values(array_diff($arr, [$val]));
        if (empty($arr)) {
            unset($newQs[$key]);
        } else {
            $newQs[$key] = $arr;
        }
        return route('products.index', $newQs);
    };

    $selectedCategory = request('category');
    $selectedMin = request('min_price');
    $selectedMax = request('max_price');
    $selectedColors = (array) request('colors', []);
    $selectedSizes = (array) request('sizes', []);
@endphp































