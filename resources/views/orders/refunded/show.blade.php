@extends('master')
@section('content')
    @php
        // Trạng thái hiện tại của đơn
        $currentStatus = (int) $order->order_status_id;

        // Thông tin cho từng bước trên thanh trạng thái - cập nhật cho đơn hoàn tiền
        $stepMeta = [
            1 => ['label' => 'Chờ xác nhận', 'desc' => 'Đặt hàng thành công'],
            2 => ['label' => 'Đã xác nhận', 'desc' => 'Cửa hàng đã xác nhận'],
            3 => ['label' => 'Đang giao hàng', 'desc' => 'Đơn đang được giao'],
            4 => ['label' => 'Đã giao hàng', 'desc' => 'Hàng đã tới địa chỉ nhận'],
            5 => ['label' => 'Hoàn thành', 'desc' => 'Khách xác nhận đã nhận'],
            6 => ['label' => 'Hoàn tiền', 'desc' => 'Đã hoàn tiền cho khách hàng'],
        ];

        // Gom log theo trạng thái: [status_id => collection các log]
        $logsByStatus = $order->statusLogs->groupBy('order_status_id');

        // Thông tin hiển thị badge trạng thái - cập nhật cho đơn hoàn tiền
        $statusId = $currentStatus;
        $statusName = 'Hoàn tiền'; // Trạng thái mới cho đơn hoàn tiền
        $tagClass = 'tag-green'; // Màu xanh cho trạng thái hoàn tiền thành công

        // Map trạng thái đơn vào mốc 1..6 trên thanh tiến trình
        $activeStep = 6; // Đơn hoàn tiền luôn ở bước cuối cùng
    @endphp



    <body
        class="wp-singular page-template page-template-templates page-template-fullwidth page-template-templatesfullwidth-php page page-id-11 logged-in wp-embed-responsive wp-theme-mixtas ltr theme-mixtas woocommerce-account woocommerce-page woocommerce-view-order woocommerce-js woo-variation-swatches wvs-behavior-blur wvs-theme-mixtas wvs-show-label wvs-tooltip elementor-default elementor-kit-6 blog-sidebar-active blog-sidebar-right single-blog-sidebar-active kitify--js-ready body-loaded e--ua-blink e--ua-chrome e--ua-webkit"
        data-elementor-device-mode="laptop">

        <style>
            /* ====== cosmetic nâng cấp nhé ====== */
            .order-header {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                padding: 14px 16px;
                border: 1px solid #e5e7eb;
                border-radius: 12px;
                background: #fff
            }

            .order-header .meta {
                display: flex;
                flex-wrap: wrap;
                gap: 12px;
                color: #6b7280;
                font-size: .92rem
            }

            .tag {
                display: inline-flex;
                align-items: center;
                gap: .35rem;
                padding: .28rem .55rem;
                border-radius: 999px;
                font-weight: 600;
                font-size: .78rem
            }

            .tag-primary {
                background: #eef2ff;
                color: #3730a3
            }

            .tag-green {
                background: #ecfdf5;
                color: #047857
            }

            .tag-amber {
                background: #fff7ed;
                color: #9a3412
            }

            .tag-red {
                background: #fef2f2;
                color: #b91c1c
            }

            .tag-gray {
                background: #f3f4f6;
                color: #374151
            }

            /* progress trạng thái */
            .order-progress {
                display: flex;
                align-items: center;
                gap: 10px;
                margin: 10px 0 0
            }

            .order-progress .step {
                display: flex;
                align-items: center;
                gap: 8px
            }

            .order-progress .dot {
                width: 10px;
                height: 10px;
                border-radius: 50%;
                background: #e5e7eb
            }

            .order-progress .dot.active {
                background: #111827
            }

            .order-progress .bar {
                height: 2px;
                width: 46px;
                background: #e5e7eb
            }

            .order-progress .bar.active {
                background: #111827
            }

            /* bảng sản phẩm */
            .order_details tbody tr:hover {
                background: #fafafa
            }

            .product-name .thumb {
                width: 64px;
                height: 64px;
                border-radius: 8px;
                object-fit: cover;
                border: 1px solid #eee
            }

            .product-name .meta {
                color: #6b7280;
                font-size: .85rem
            }

            /* card chung */
            .card {
                border: 1px solid #e5e7eb;
                border-radius: 12px;
                background: #fff
            }

            .card .card-hd {
                padding: 12px 14px;
                border-bottom: 1px solid #e5e7eb;
                font-weight: 600
            }

            .card .card-bd {
                padding: 14px
            }

            .sum-row {
                display: flex;
                justify-content: space-between;
                margin: .25rem 0
            }

            .sum-row.total {
                font-weight: 700;
                border-top: 1px dashed #e5e7eb;
                padding-top: .5rem
            }

            /* invoice / tool buttons */
            .order-tools {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                margin-top: 10px
            }

            .btn-lite {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 8px 12px;
                border: 1px solid #e5e7eb;
                border-radius: 8px;
                background: #fff;
                text-decoration: none
            }

            .btn-danger-outline {
                border: 1px solid #ef4444;
                color: #b91c1c;
                background: #fff;
                padding: 9px 12px;
                border-radius: 8px
            }

            .btn-danger-outline:hover {
                background: #fef2f2
            }

            /* Override capitalize for cancel button */
            #btnOpenCancelModal {
                text-transform: none !important;
            }

            /* mobile spacing */
            @media (max-width: 768px) {
                .order-header {
                    padding: 12px
                }
            }

            /* ===== Bố cục mới: 2 box dưới thanh trạng thái ===== */
            .order-info-grid {
                display: grid;
                grid-template-columns: 1fr;
                gap: 16px;
                margin-top: 18px;
            }

            @media (min-width: 768px) {
                .order-info-grid {
                    grid-template-columns: minmax(0, 1.1fr) minmax(0, 1fr);
                }
            }

            /* Footer: tổng tiền góc phải */
            .order-bottom {
                display: flex;
                flex-wrap: wrap;
                gap: 16px;
                margin-top: 18px;
                align-items: flex-start;
            }

            .order-bottom-left {
                flex: 1 1 auto;
                min-width: 0;
            }

            .order-total-card {
                min-width: 260px;
                margin-left: auto;
            }

            /* Gom badge + các nút trên 1 hàng, căn phải gọn gàng */
            .order-header>div:last-child {
                display: flex;
                align-items: center;
                justify-content: flex-end;
                gap: 8px;
                flex-wrap: wrap;
                text-align: right;
            }

            .order-header>div:last-child .order-tools {
                margin-top: 0;
            }

            .order-header .tag {
                margin: 0 2px 0 0;
            }

            /* ==== Giảm khoảng trắng phần My account & đơn hàng ==== */

            /* Thu bớt padding trên container của trang xem đơn */
            body.woocommerce-view-order .site-content-wrapper .container {
                padding-top: 18px;
            }

            /* Thu khoảng trắng giữa breadcrumb / title và nội dung */
            body.woocommerce-view-order .page-header-content {
                margin-bottom: 0px !important;
                padding-bottom: 0 !important;
            }

            /* Tiêu đề "My account" không cách quá xa breadcrumb */
            body.woocommerce-view-order .page-header-content .page-title {
                margin-top: 6px !important;
                margin-bottom: 0 !important;
            }

            /* Nội dung tài khoản sát lên một chút */
            body.woocommerce-MyAccount-content {
                margin-top: 0px !important;
            }

            /* Header đơn hàng dính nhẹ lên trên cho gọn hơn */
            body.woocommerce-view-order .order-header {
                margin-top: 0px;
            }
        </style>

        <div class="site-wrapper">
            <div class="kitify-site-wrapper elementor-459kitify">
                @include('layouts.header')

                <div id="site-content" class="site-content-wrapper">
                    <div class="container">
                        <div class="grid-x">
                            <div class="cell small-12">
                                <div class="site-content">
                                    <div class="page-header-content">
                                        <nav class="woocommerce-breadcrumb">
                                            <a href="{{ url('/') }}">Home</a><span class="delimiter">/</span>
                                            <a href="{{ route('orders.index') }}">My account</a><span
                                                class="delimiter">/</span>
                                            Order #{{ $order->order_code }}
                                        </nav>
                                        <h1 class="page-title">Đơn hàng đã hoàn tiền</h1>
                                    </div>

                                    <article class="hentry">
                                        <div class="entry-content">
                                            <div class="woocommerce">
                                                @include('account.partials.navigation')

                                                <div class="woocommerce-MyAccount-content">
                                                    <div class="woocommerce-notices-wrapper">
                                                        @if (session('error'))
                                                            <div class="woocommerce-error">{{ session('error') }}</div>
                                                        @endif
                                                        @if (session('success'))
                                                            <div class="woocommerce-message">{{ session('success') }}</div>
                                                        @endif
                                                    </div>

                                                    {{-- ======= HEADER TÓM TẮT ======= --}}

                                                    <div class="order-header">
                                                        <div>
                                                            <div style="font-weight:700;font-size:1.05rem">Đơn hàng
                                                                #{{ $order->order_code }}</div>
                                                            <div class="meta">
                                                                <span>Đặt lúc
                                                                    {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}</span>
                                                                <span>•</span>
                                                                <span>Tổng:
                                                                    <strong>₫{{ number_format($calc_total) }}</strong></span>
                                                            </div>

                                                            {{-- progress dùng log: hiển thị Người dùng / Hệ thống + thời gian --}}
                                                            <div class="order-progress" aria-label="Tiến trình đơn hàng">
                                                                @foreach ($stepMeta as $sid => $meta)
                                                                    @php
                                                                        // Bước này đã được đi qua chưa?
                                                                        $isReached = $activeStep >= $sid;

                                                                        // Lấy log đầu tiên của trạng thái này (thời điểm chuyển sang trạng thái)
                                                                        $logsForStep = $logsByStatus->get($sid);
                                                                        $firstLog = $logsForStep
                                                                            ? $logsForStep->first()
                                                                            : null;
                                                                    @endphp

                                                                    <div class="step">
                                                                        <span
                                                                            class="dot {{ $isReached ? 'active' : '' }}"></span>

                                                                        <div
                                                                            style="display:flex;flex-direction:column;align-items:flex-start">
                                                                            {{-- Tiêu đề + mô tả --}}
                                                                            <span
                                                                                style="font-size:.83rem;color:#374151">{{ $meta['label'] }}</span>
                                                                            <span
                                                                                style="font-size:.78rem;color:#6b7280">{{ $meta['desc'] }}</span>

                                                                            {{-- Người dùng / Hệ thống + thời gian --}}
                                                                            @if ($firstLog)
                                                                                <span
                                                                                    style="font-size:.75rem;color:#9ca3af">
                                                                                    {{ $firstLog->actor_label }}
                                                                                    •
                                                                                    {{ $firstLog->created_at->format('H:i d/m/Y') }}
                                                                                </span>
                                                                            @endif
                                                                        </div>
                                                                    </div>

                                                                    @if ($sid < count($stepMeta))
                                                                        <span
                                                                            class="bar {{ $sid < $activeStep ? 'active' : '' }}"></span>
                                                                    @endif
                                                                @endforeach
                                                            </div>

                                                        </div>

                                                        <div style="text-align:right">
                                                            <span
                                                                class="tag {{ $tagClass }}">{{ $statusName }}</span>
                                                            <div class="order-tools">
                                                                @if ($order->invoice)
                                                                    <a href="#" class="btn-lite">In hoá đơn:
                                                                        {{ $order->invoice->invoice_code }}</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- ======= 2 BOX: ĐƠN HÀNG & THÔNG TIN NGƯỜI NHẬN ======= --}}
                                                    <div class="order-info-grid">
                                                        {{-- Box Đơn hàng --}}
                                                        <div class="card">
                                                            <div class="card-hd">Đơn hàng</div>
                                                            <div class="card-bd">
                                                                <div class="sum-row">
                                                                    <span>Mã đơn</span>
                                                                    <span>#{{ $order->order_code }}</span>
                                                                </div>
                                                                <div class="sum-row">
                                                                    <span>Trạng thái đơn</span>
                                                                    <span>{{ $statusName }}</span>
                                                                </div>
                                                                <div class="sum-row">
                                                                    <span>Trạng thái thanh toán</span>
                                                                    <span>{{ $order->paymentStatus?->name }}</span>
                                                                </div>

                                                                <div class="sum-row">
                                                                    <span>Phương thức thanh toán</span>
                                                                    <span>{{ $order->payment?->paymentMethod?->name ?? '—' }}</span>
                                                                </div>

                                                                <div class="sum-row">
                                                                    <span>Thời gian đặt</span>
                                                                    <span>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- Box Thông tin người nhận --}}
                                                        <div class="card">
                                                            <div class="card-hd">Thông tin người nhận</div>
                                                            <div class="card-bd">
                                                                <address style="margin:0">
                                                                    <strong>{{ $order->name }}</strong><br>
                                                                    {{ $order->phone }}<br>
                                                                    {{ $order->address }}<br>
                                                                    @if ($order->user?->email)
                                                                        <a
                                                                            href="mailto:{{ $order->user->email }}">{{ $order->user->email }}</a>
                                                                    @endif
                                                                </address>
                                                                @if ($order->note)
                                                                    <div style="margin-top:8px;color:#6b7280">Ghi chú:
                                                                        {{ $order->note }}</div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- ======= CHI TIẾT ĐƠN HÀNG (BẢNG SẢN PHẨM) ======= --}}
                                                    <section class="woocommerce-order-details card" style="margin-top:18px">
                                                        <div class="card-hd">Chi tiết đơn hàng</div>
                                                        <div class="card-bd" style="padding:0">
                                                            <table
                                                                class="woocommerce-table woocommerce-table--order-details shop_table order_details"
                                                                style="margin:0">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width:60px">STT</th>
                                                                        <th class="product-name">Sản phẩm</th>
                                                                        <th class="product-quantity" style="width:90px">SL
                                                                        </th>
                                                                        <th class="product-total" style="width:150px">Thành
                                                                            tiền</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($lines as $it)
                                                                        <tr class="order_item">
                                                                            <td style="text-align:center">
                                                                                {{ $loop->iteration }}</td>
                                                                            <td class="product-name">
                                                                                <div
                                                                                    style="display:flex;gap:12px;align-items:center">
                                                                                    @if ($it->image)
                                                                                        <img class="thumb"
                                                                                            src="{{ asset($it->image) }}"
                                                                                            alt="">
                                                                                    @endif
                                                                                    <div>
                                                                                        <a
                                                                                            href="{{ route('products.show', ['id' => $it->product_id]) }}">
                                                                                            <strong>{{ $it->product_name }}</strong>
                                                                                        </a>
                                                                                        <div class="meta">
                                                                                            @if ($it->variant_text)
                                                                                                {{ $it->variant_text }} ·
                                                                                            @endif
                                                                                            Đơn giá:
                                                                                            ₫{{ number_format($it->unit_price) }}
                                                                                            @if ($it->eta)
                                                                                                · Dự kiến:
                                                                                                {{ \Carbon\Carbon::parse($it->eta)->format('d/m') }}
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td class="product-quantity"
                                                                                style="text-align:center">
                                                                                {{ $it->qty }}</td>
                                                                            <td class="product-total"
                                                                                style="text-align:right">
                                                                                <span
                                                                                    class="woocommerce-Price-amount amount">
                                                                                    <span
                                                                                        class="woocommerce-Price-currencySymbol">₫</span>{{ number_format($it->line_total) }}
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </section>

                                                    {{-- ======= FOOTER: THÔNG ĐIỆP + TỔNG TIỀN GÓc PHẢI ======= --}}
                                                    <div class="order-bottom">
                                                        <div class="order-bottom-left">
                                                            <div class="woocommerce-message" style="margin-top:14px">
                                                                Đơn hàng đã được hoàn tiền thành công.
                                                                <strong>Số tiền hoàn: ₫{{ number_format($calc_total) }}</strong>
                                                            </div>
                                                        </div>

                                                        <div class="order-total-card card">
                                                            <div class="card-hd">Tổng hoàn tiền</div>
                                                            <div class="card-bd">
                                                                <div class="sum-row">
                                                                    <span>Tạm tính</span>
                                                                    <span>₫{{ number_format($calc_subtotal) }}</span>
                                                                </div>
                                                                @if ($calc_shipping_fee > 0)
                                                                    <div class="sum-row">
                                                                        <span>Phí vận chuyển</span>
                                                                        <span>₫{{ number_format($calc_shipping_fee) }}</span>
                                                                    </div>
                                                                @endif
                                                                @if ($calc_discount > 0)
                                                                    <div class="sum-row">
                                                                        <span>Giảm giá</span>
                                                                        <span>-₫{{ number_format($calc_discount) }}</span>
                                                                    </div>
                                                                @endif
                                                                @if ($order->voucher)
                                                                    <div class="sum-row" style="color:#6b7280">
                                                                        <span>Voucher</span>
                                                                        <span>{{ $order->voucher->voucher_code }}</span>
                                                                    </div>
                                                                @endif
                                                                <div class="sum-row">
                                                                    <span>TT hoàn tiền</span>
                                                                    <span>Đã hoàn tiền</span>
                                                                </div>
                                                                <div class="sum-row total">
                                                                    <span>Tổng hoàn tiền</span>
                                                                    <span>₫{{ number_format($calc_total) }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div><!-- /.woocommerce-MyAccount-content -->
                                            </div><!-- /.woocommerce -->
                                        </div><!-- .entry-content -->
                                    </article>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- .site-content-wrapper -->

                @include('layouts.footer')
                <div class="nova-overlay-global"></div>
            </div><!-- .kitify-site-wrapper -->

        </div>
    @endsection

