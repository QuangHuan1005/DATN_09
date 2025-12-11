<div class="shop_header_placeholder kitify-active">
    <header class="woocommerce-archive-header">
        <div class="woocommerce-archive-header-inside">
            <p class="woocommerce-result-count">
                Hiển thị {{ $products->firstItem() }}&ndash;{{ $products->lastItem() }} / {{ $products->total() }} kết
                quả</p>
            <div class="woocommerce-archive-toolbar sh--color">
                <div class="nova-product-filter" data-breakpoint="1024">
                    <button class="js-column-toggle"><span class="icon-filter"><i class="inova ic-options"></i></span><span
                            class="title-filter">Filters</span></button>
                </div>
                {{-- <div class="nova-custom-view"><label>Show</label>
                    <ul>
                        <li class="active"><a href="index1c07.html?per_page=12">12</a>
                        </li>
                        <li><a href="indexadcc.html?per_page=15">15</a>
                        </li>
                        <li><a href="index779c.html?per_page=30">30</a>
                        </li>
                    </ul>
                </div> --}} <label for="sort" class="nova-custom-view">Sắp xếp:</label>
                <form class="woocommerce-ordering" method="get" action="{{ route('products.index') }}">
                    @foreach (request()->except('sort') as $key => $val)
                        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                    @endforeach

                    <select name="sort" class="orderby" id="sort" aria-label="Shop order"
                        onchange="this.form.submit()">
                        <option value="default" selected='selected'>
                            Mặc định</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                        <option value="bestseller" {{ request('sort') == 'bestseller' ? 'selected' : '' }}>Bán chạy
                        </option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá tăng dần
                        </option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá giảm dần
                        </option>
                    </select>
                    </select>
                    <input type="hidden" name="paged" value="1" />
                </form>
                <div class="shop-display-type">
                    <span class="shop-display-grid active">
                        <svg class="mixtas-grid-icon">
                            <use xlink:href="#mixtas-grid"></use>
                        </svg>
                    </span>
                    <span class="shop-display-list">
                        <svg class="mixtas-list-icon">
                            <use xlink:href="#mixtas-list"></use>
                        </svg>
                    </span>
                </div>
            </div>
        </div>
    </header>
</div>
