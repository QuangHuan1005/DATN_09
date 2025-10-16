@extends('master')
@section('content')

    <body
        class="wp-singular page-template page-template-templates page-template-fullwidth page-template-templatesfullwidth-php page page-id-11 logged-in wp-embed-responsive wp-theme-mixtas ltr theme-mixtas woocommerce-account woocommerce-page woocommerce-orders woocommerce-js woo-variation-swatches wvs-behavior-blur wvs-theme-mixtas wvs-show-label wvs-tooltip elementor-default elementor-kit-6 blog-sidebar-active blog-sidebar-right single-blog-sidebar-active kitify--js-ready body-loaded e--ua-blink e--ua-chrome e--ua-webkit"
        data-elementor-device-mode="laptop">
        <div class="site-wrapper">

            <div class="kitify-site-wrapper elementor-459kitify">
                @include('layouts.header')
                <div id="site-content" class="site-content-wrapper">
                    <div class="nova-container">
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
                                                <nav class="woocommerce-MyAccount-navigation" aria-label="Account pages">
                                                    <ul>
                                                        <li
                                                            class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--dashboard">
                                                            <a href="https://mixtas.novaworks.net/my-account/">
                                                                Dashboard </a>
                                                        </li>
                                                        <li
                                                            class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--orders is-active">
                                                            <a href="https://mixtas.novaworks.net/my-account/orders/"
                                                                aria-current="page">
                                                                Orders </a>
                                                        </li>
                                                        <li
                                                            class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--downloads">
                                                            <a href="https://mixtas.novaworks.net/my-account/downloads/">
                                                                Downloads </a>
                                                        </li>
                                                        <li
                                                            class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--edit-address">
                                                            <a href="https://mixtas.novaworks.net/my-account/edit-address/">
                                                                Addresses </a>
                                                        </li>
                                                        <li
                                                            class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--edit-account">
                                                            <a href="https://mixtas.novaworks.net/my-account/edit-account/">
                                                                Account details </a>
                                                        </li>
                                                        <li
                                                            class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--customer-logout">
                                                            <a
                                                                href="https://mixtas.novaworks.net/my-account/customer-logout/?_wpnonce=57ea63a15e">
                                                                Log out </a>
                                                        </li>
                                                    </ul>
                                                </nav>

                                                <div class="woocommerce-MyAccount-content">
                                                    <div class="woocommerce-notices-wrapper"></div>


                                                    <div class="woocommerce-info">
                                                        No order has been made yet. <a
                                                            class="woocommerce-Button wc-forward button"
                                                            href="https://mixtas.novaworks.net/shop/">Browse products</a>
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
                                                                    <span class="nobr">Order</span>
                                                                </th>
                                                                <th scope="col"
                                                                    class="woocommerce-orders-table__header woocommerce-orders-table__header-order-date">
                                                                    <span class="nobr">Date</span>
                                                                </th>
                                                                <th scope="col"
                                                                    class="woocommerce-orders-table__header woocommerce-orders-table__header-order-status">
                                                                    <span class="nobr">Status</span>
                                                                </th>
                                                                <th scope="col"
                                                                    class="woocommerce-orders-table__header woocommerce-orders-table__header-order-total">
                                                                    <span class="nobr">Total</span>
                                                                </th>
                                                                <th scope="col"
                                                                    class="woocommerce-orders-table__header woocommerce-orders-table__header-order-actions">
                                                                    <span class="nobr">Actions</span>
                                                                </th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <tr
                                                                class="woocommerce-orders-table__row woocommerce-orders-table__row--status-on-hold order">
                                                                <th class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-number"
                                                                    data-title="Order" scope="row">

                                                                    <a href="https://mixtas.novaworks.net/my-account/view-order/2861/"
                                                                        aria-label="View order number 2861">
                                                                        #2861 </a>


                                                                </th>
                                                                <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-date"
                                                                    data-title="Date">

                                                                    <time datetime="2025-10-05T05:20:00+00:00">October 5,
                                                                        2025</time>


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
                                                            <tr
                                                                class="woocommerce-orders-table__row woocommerce-orders-table__row--status-on-hold order">
                                                                <th class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-number"
                                                                    data-title="Order" scope="row">

                                                                    <a href="https://mixtas.novaworks.net/my-account/view-order/2860/"
                                                                        aria-label="View order number 2860">
                                                                        #2860 </a>


                                                                </th>
                                                                <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-date"
                                                                    data-title="Date">

                                                                    <time datetime="2025-10-05T05:19:29+00:00">October 5,
                                                                        2025</time>


                                                                </td>
                                                                <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-status"
                                                                    data-title="Status">

                                                                    On hold

                                                                </td>
                                                                <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-total"
                                                                    data-title="Total">

                                                                    <span class="woocommerce-Price-amount amount"><span
                                                                            class="woocommerce-Price-currencySymbol">$</span>120.00</span>
                                                                    for 1 item

                                                                </td>
                                                                <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-actions"
                                                                    data-title="Actions">

                                                                    <a href="https://mixtas.novaworks.net/my-account/view-order/2860/"
                                                                        class="woocommerce-button button view"
                                                                        aria-label="View order 2860">View</a>
                                                                </td>
                                                            </tr>
                                                            <tr
                                                                class="woocommerce-orders-table__row woocommerce-orders-table__row--status-on-hold order">
                                                                <th class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-number"
                                                                    data-title="Order" scope="row">

                                                                    <a href="https://mixtas.novaworks.net/my-account/view-order/2859/"
                                                                        aria-label="View order number 2859">
                                                                        #2859 </a>


                                                                </th>
                                                                <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-date"
                                                                    data-title="Date">

                                                                    <time datetime="2025-10-05T05:18:48+00:00">October 5,
                                                                        2025</time>


                                                                </td>
                                                                <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-status"
                                                                    data-title="Status">

                                                                    On hold

                                                                </td>
                                                                <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-total"
                                                                    data-title="Total">

                                                                    <span class="woocommerce-Price-amount amount"><span
                                                                            class="woocommerce-Price-currencySymbol">$</span>39.90</span>
                                                                    for 1 item

                                                                </td>
                                                                <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-actions"
                                                                    data-title="Actions">

                                                                    <a href="https://mixtas.novaworks.net/my-account/view-order/2859/"
                                                                        class="woocommerce-button button view"
                                                                        aria-label="View order 2859">View</a>
                                                                </td>
                                                            </tr>
                                                            <tr
                                                                class="woocommerce-orders-table__row woocommerce-orders-table__row--status-on-hold order">
                                                                <th class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-number"
                                                                    data-title="Order" scope="row">

                                                                    <a href="https://mixtas.novaworks.net/my-account/view-order/2858/"
                                                                        aria-label="View order number 2858">
                                                                        #2858 </a>


                                                                </th>
                                                                <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-date"
                                                                    data-title="Date">

                                                                    <time datetime="2025-10-05T05:18:14+00:00">October 5,
                                                                        2025</time>


                                                                </td>
                                                                <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-status"
                                                                    data-title="Status">

                                                                    On hold

                                                                </td>
                                                                <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-total"
                                                                    data-title="Total">

                                                                    <span class="woocommerce-Price-amount amount"><span
                                                                            class="woocommerce-Price-currencySymbol">$</span>35.90</span>
                                                                    for 1 item

                                                                </td>
                                                                <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-actions"
                                                                    data-title="Actions">

                                                                    <a href="https://mixtas.novaworks.net/my-account/view-order/2858/"
                                                                        class="woocommerce-button button view"
                                                                        aria-label="View order 2858">View</a>
                                                                </td>
                                                            </tr>
                                                            <tr
                                                                class="woocommerce-orders-table__row woocommerce-orders-table__row--status-on-hold order">
                                                                <th class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-number"
                                                                    data-title="Order" scope="row">

                                                                    <a href="https://mixtas.novaworks.net/my-account/view-order/2857/"
                                                                        aria-label="View order number 2857">
                                                                        #2857 </a>


                                                                </th>
                                                                <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-date"
                                                                    data-title="Date">

                                                                    <time datetime="2025-10-05T05:17:06+00:00">October 5,
                                                                        2025</time>


                                                                </td>
                                                                <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-status"
                                                                    data-title="Status">

                                                                    On hold

                                                                </td>
                                                                <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-total"
                                                                    data-title="Total">

                                                                    <span class="woocommerce-Price-amount amount"><span
                                                                            class="woocommerce-Price-currencySymbol">$</span>27.90</span>
                                                                    for 1 item

                                                                </td>
                                                                <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-actions"
                                                                    data-title="Actions">

                                                                    <a href="https://mixtas.novaworks.net/my-account/view-order/2857/"
                                                                        class="woocommerce-button button view"
                                                                        aria-label="View order 2857">View</a>
                                                                </td>
                                                            </tr>
                                                            <tr
                                                                class="woocommerce-orders-table__row woocommerce-orders-table__row--status-on-hold order">
                                                                <th class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-number"
                                                                    data-title="Order" scope="row">

                                                                    <a href="https://mixtas.novaworks.net/my-account/view-order/2856/"
                                                                        aria-label="View order number 2856">
                                                                        #2856 </a>


                                                                </th>
                                                                <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-date"
                                                                    data-title="Date">

                                                                    <time datetime="2025-10-05T05:16:29+00:00">October 5,
                                                                        2025</time>


                                                                </td>
                                                                <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-status"
                                                                    data-title="Status">

                                                                    On hold

                                                                </td>
                                                                <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-total"
                                                                    data-title="Total">

                                                                    <span class="woocommerce-Price-amount amount"><span
                                                                            class="woocommerce-Price-currencySymbol">$</span>55.80</span>
                                                                    for 2 items

                                                                </td>
                                                                <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-actions"
                                                                    data-title="Actions">

                                                                    <a href="https://mixtas.novaworks.net/my-account/view-order/2856/"
                                                                        class="woocommerce-button button view"
                                                                        aria-label="View order 2856">View</a>
                                                                </td>
                                                            </tr>
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
