@extends('master')
@section('content')

    <body
        class="wp-singular page-template page-template-templates page-template-fullwidth page-template-templatesfullwidth-php page page-id-11 logged-in wp-embed-responsive wp-theme-mixtas ltr theme-mixtas woocommerce-account woocommerce-page woocommerce-orders woocommerce-js woo-variation-swatches wvs-behavior-blur wvs-theme-mixtas wvs-show-label wvs-tooltip elementor-default elementor-kit-6 blog-sidebar-active blog-sidebar-right single-blog-sidebar-active kitify--js-ready body-loaded e--ua-blink e--ua-chrome e--ua-webkit"
        data-elementor-device-mode="laptop">
        <div class="site-wrapper">

            <div class="kitify-site-wrapper elementor-459kitify">
                @include('layouts.header')
                <div id="site-content" class="site-content-wrapper">
                    <div class="container">
                        <div class="grid-x">
                            <div class="cell small-12">
                                <div class="site-content">
                                    <div class="page-header-content">
                                        <nav class="woocommerce-breadcrumb"><a
                                                href="https://mixtas.novaworks.net">Home</a><span
                                                class="delimiter">/</span><a
                                                href="https://mixtas.novaworks.net/my-account/">My account</a><span
                                                class="delimiter">/</span>Orders</nav>
                                        <h1 class="page-title">My account</h1>
                                    </div>
                                    <article id="post-11" class="post-11 page type-page status-publish hentry">
                                        <div class="entry-content">
                                            <div class="woocommerce">
                                                @include('account.partials.navigation')

                                                <div class="woocommerce-MyAccount-content">
                                                    <div class="woocommerce-notices-wrapper"></div>


                                                    <div class="woocommerce-info">
                                                        Chưa có đơn hàng nào. <a
                                                            class="woocommerce-Button wc-forward button"
                                                            href="{{ route('products.index') }}">Xem sản phẩm</a>
                                                    </div>


                                                </div>
                                                <div class="woocommerce-MyAccount-content">
                                                    <div class="woocommerce-notices-wrapper"></div>

                                                    <table
                                                        class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col"
                                                                    class="woocommerce-orders-table__header woocommerce-orders-table__header-order-number">
                                                                    <span class="nobr">Mã đơn hàng</span>
                                                                </th>
                                                                <th scope="col"
                                                                    class="woocommerce-orders-table__header woocommerce-orders-table__header-order-date">
                                                                    <span class="nobr">Ngày mua</span>
                                                                </th>
                                                                <th scope="col"
                                                                    class="woocommerce-orders-table__header woocommerce-orders-table__header-order-status">
                                                                    <span class="nobr">Trạng thái</span>
                                                                </th>
                                                                <th scope="col"
                                                                    class="woocommerce-orders-table__header woocommerce-orders-table__header-order-total">
                                                                    <span class="nobr">Tổng</span>
                                                                </th>
                                                                <th scope="col"
                                                                    class="woocommerce-orders-table__header woocommerce-orders-table__header-order-actions">
                                                                    <span class="nobr">Hành động</span>
                                                                </th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            @foreach ($orders as $order)
                                                                <tr
                                                                class="woocommerce-orders-table__row woocommerce-orders-table__row--status-on-hold order">
                                                                <th class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-number"
                                                                    data-title="Order" scope="row">

                                                                    <a href="https://mixtas.novaworks.net/my-account/view-order/2861/"
                                                                        aria-label="View order number 2861">
                                                                        #{{$order->order_code}} </a>


                                                                </th>
                                                                <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-date"
                                                                    data-title="Date">

                                                                    <time datetime="2025-10-05T05:20:00+00:00">{{$order->created_at}} </time>


                                                                </td>
                                                                <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-status"
                                                                    data-title="Status">

                                                                    On hold

                                                                </td>
                                                                <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-total"
                                                                    data-title="Total">

                                                                    <span class="woocommerce-Price-amount amount"><span
                                                                            class="woocommerce-Price-currencySymbol">$</span>29.90</span>
                                                                    for 1 item

                                                                </td>
                                                                <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-actions"
                                                                    data-title="Actions">

                                                                    <a href="https://mixtas.novaworks.net/my-account/view-order/2861/"
                                                                        class="woocommerce-button button view"
                                                                        aria-label="View order 2861">View</a>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                            <tr
                                                                class="woocommerce-orders-table__row woocommerce-orders-table__row--status-processing order">
                                                                <th class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-number"
                                                                    data-title="Order" scope="row">

                                                                    <a href="https://mixtas.novaworks.net/my-account/view-order/2855/"
                                                                        aria-label="View order number 2855">
                                                                        #2855 </a>


                                                                </th>
                                                                <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-date"
                                                                    data-title="Date">

                                                                    <time datetime="2025-10-05T05:14:22+00:00">October 5,
                                                                        2025</time>


                                                                </td>
                                                                <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-status"
                                                                    data-title="Status">

                                                                    Processing

                                                                </td>
                                                                <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-total"
                                                                    data-title="Total">

                                                                    <span class="woocommerce-Price-amount amount"><span
                                                                            class="woocommerce-Price-currencySymbol">$</span>161.79</span>
                                                                    for 3 items

                                                                </td>
                                                                <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-actions"
                                                                    data-title="Actions">

                                                                    <a href="https://mixtas.novaworks.net/my-account/view-order/2855/"
                                                                        class="woocommerce-button button view"
                                                                        aria-label="View order 2855">View</a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>




                                                </div>
                                            </div>
                                        </div><!-- .entry-content -->

                                    </article><!-- #post-## -->
                                </div>

                            </div>
                        </div>
                    </div>


                </div><!-- .site-content-wrapper -->
                @include('layouts.footer')
                <div class="nova-overlay-global"></div>
            </div><!-- .kitify-site-wrapper -->
            @include('layouts.js')

            <!-- Page cached by LiteSpeed Cache 6.5.2 on 2025-09-30 06:58:27 -->
        @endsection
