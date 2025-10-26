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
                  <nav class="woocommerce-breadcrumb">
                    <a href="{{ url('/') }}">Home</a><span class="delimiter">/</span>
                    <a href="{{ route('orders.index') }}">My account</a><span class="delimiter">/</span>Orders
                  </nav>
                  <h1 class="page-title">My account</h1>
                </div>

                <article class="hentry">
                  <div class="entry-content">
                    <div class="woocommerce">
                      @include('account.partials.navigation')

                      <div class="woocommerce-MyAccount-content">
                        <div class="woocommerce-notices-wrapper">
                          @if(session('error')) <div class="woocommerce-error">{{ session('error') }}</div> @endif
                          @if(session('success')) <div class="woocommerce-message">{{ session('success') }}</div> @endif
                        </div>

                        {{-- ====================== FILTER BAR ====================== --}}
                        @php
                        // map status id -> class + label màu (giữ để render badge trong bảng)
                        $badgeClass = function($sid) {
                            return match((int)$sid){
                            1 => 'badge-on-hold',     // Chờ xác nhận
                            2 => 'badge-processing',  // Xác nhận
                            3 => 'badge-shipping',    // Đang giao
                            4,5 => 'badge-completed', // Đã giao/Hoàn thành
                            6 => 'badge-cancelled',   // Hủy
                            7 => 'badge-refunded',    // Hoàn hàng
                            default => 'badge-default'
                            };
                        };
                        @endphp

                        <style>
                        /* ========= POLISH: Filter select ========= */
                        .orders-filter-select-wrap{
                            display:flex; justify-content:flex-end; margin:0 0 12px;
                        }
                        .orders-select{
                            appearance:none; -webkit-appearance:none; -moz-appearance:none;
                            padding:10px 38px 10px 14px; border:1px solid #e5e7eb; border-radius:999px;
                            background:#fff url('data:image/svg+xml;utf8,<svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M6 8l4 4 4-4" stroke="%236b7280" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>') no-repeat right 12px center/16px;
                            font-size:.95rem; color:#111827; cursor:pointer;
                            box-shadow:0 1px 0 rgba(17,24,39,.04);
                        }
                        .orders-select:focus{ outline:none; border-color:#111827; box-shadow:0 0 0 3px rgba(17,24,39,.06); }

                        /* ========= POLISH: Table as clean card ========= */
                        .account-orders-table{
                          border:1px solid #eceff3; border-radius:12px; overflow:hidden; background:#fff;
                        }
                        .account-orders-table thead th{
                          background:#fafafa; font-weight:600; letter-spacing:.2px; padding:14px 16px;
                        }
                        .account-orders-table tbody td, 
                        .account-orders-table tbody th{
                          padding:14px 16px; vertical-align:middle; border-top:1px solid #f2f4f6;
                        }
                        .account-orders-table tbody tr{
                          transition:background .15s ease, transform .05s ease;
                        }
                        .account-orders-table tbody tr:hover{ background:#fcfcfd; }

                        /* ========= POLISH: Badges ========= */
                        .badge{
                          display:inline-flex; align-items:center; gap:.4rem;
                          padding:.25rem .6rem; border-radius:999px; font-size:.78rem; font-weight:700
                        }
                        .badge::before{content:""; width:6px; height:6px; border-radius:50%; background:currentColor; opacity:.85}
                        .badge-processing{background:#eaf3ff;color:#1d4ed8}
                        .badge-shipping{background:#e9fdf4;color:#047857}
                        .badge-completed{background:#eafaf0;color:#166534}
                        .badge-cancelled{background:#fff1f1;color:#b91c1c}
                        .badge-on-hold{background:#fff6ea;color:#9a3412}
                        .badge-refunded{background:#f3efff;color:#6d28d9}
                        .badge-default{background:#f3f4f6;color:#374151}

                        /* ========= POLISH: Order code / amount ========= */
                        .woocommerce-orders-table__cell-order-number a{ font-weight:700; text-decoration:none; }
                        .woocommerce-orders-table__cell-order-number a:hover{ text-decoration:underline; }
                        .woocommerce-orders-table__cell-order-total .amount{ font-weight:700; }

                        /* ========= POLISH: Action button ========= */
                        .woocommerce-orders-table__cell-order-actions .button.view{
                          display:inline-flex; align-items:center; gap:6px;
                          padding:8px 12px; border-radius:8px; border:1px solid #e5e7eb;
                          text-decoration:none; font-weight:600;
                        }
                        .woocommerce-orders-table__cell-order-actions .button.view:hover{
                          border-color:#111827; box-shadow:0 1px 0 rgba(17,24,39,.06);
                        }

                        /* ========= POLISH: Pagination ========= */
                        nav[role="navigation"] { display:flex; justify-content:center; margin-top:12px }
                        </style>

                        <div class="orders-filter-select-wrap">
                          <form id="order-filter-form" method="GET" action="{{ route('orders.index') }}">
                            <select name="status_id" class="orders-select" onchange="this.form.submit()">
                              <option value="0" {{ (int)$statusId === 0 ? 'selected' : '' }}>
                                Tất cả ({{ $orders->total() }})
                              </option>
                              @foreach($statuses as $st)
                                <option value="{{ $st->id }}" {{ (int)$statusId === (int)$st->id ? 'selected' : '' }}>
                                  {{ $st->name }} ({{ $counts[$st->id] ?? 0 }})
                                </option>
                              @endforeach
                            </select>
                          </form>
                        </div>

                        {{-- ====================== TABLE ====================== --}}
                        @if($orders->isEmpty())
                          <div class="woocommerce-info">
                            @if($statusId>0)
                              Không có đơn ở trạng thái này.
                              <a class="woocommerce-Button wc-forward button" href="{{ route('orders.index') }}">Xem tất cả</a>
                            @else
                              Chưa có đơn hàng nào.
                              <a class="woocommerce-Button wc-forward button" href="{{ route('products.index') }}">Xem sản phẩm</a>
                            @endif
                          </div>
                        @else
                          <table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
                            <thead>
                              <tr>
                                <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-number"><span class="nobr">Mã đơn hàng</span></th>
                                <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-date"><span class="nobr">Ngày mua</span></th>
                                <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-status"><span class="nobr">Trạng thái</span></th>
                                <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-total"><span class="nobr">Tổng</span></th>
                                <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-actions"><span class="nobr">Hành động</span></th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach ($orders as $order)
                                @php
                                  $itemsCount = optional($order->details)->sum('quantity') ?? 0;
                                  $cls = $badgeClass($order->order_status_id);
                                @endphp
                                <tr class="woocommerce-orders-table__row order">
                                  <th class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-number" data-title="Order" scope="row">
                                    <a href="{{ route('orders.show', $order->id) }}" aria-label="View order {{ $order->order_code }}">
                                      #{{ $order->order_code }}
                                    </a>
                                  </th>
                                  <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-date" data-title="Date">
                                    <time datetime="{{ \Carbon\Carbon::parse($order->created_at)->toAtomString() }}">
                                      {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}
                                    </time>
                                  </td>
                                  <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-status" data-title="Status">
                                    <span class="badge {{ $cls }}">{{ $order->status?->name ?? '—' }}</span>
                                  </td>
                                  <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-total" data-title="Total">
                                    <span class="woocommerce-Price-amount amount">
                                      <span class="woocommerce-Price-currencySymbol">₫</span>{{ number_format($order->total_amount) }}
                                    </span>
                                    @if($itemsCount) cho {{ $itemsCount }} sản phẩm @endif
                                  </td>
                                  <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-actions" data-title="Actions">
                                    <a href="{{ route('orders.show', $order->id) }}" class="woocommerce-button button view" aria-label="View order {{ $order->order_code }}">Xem</a>
                                  </td>
                                </tr>
                              @endforeach
                            </tbody>
                          </table>

                          <div class="mt-3">
                            {{ $orders->links() }}
                          </div>
                        @endif

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
    @include('layouts.js')
  </div>
@endsection
