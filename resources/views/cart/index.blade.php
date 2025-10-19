@extends('master')
@section('content')
@include('layouts.header')
@php
 use Illuminate\Support\Str;
@endphp


<style>
  :root { --brand-gold:#c1995a; --card-border:#e9e9e9; }

  /* Khung trang giỏ hàng thu hẹp & căn giữa */
  .cart-page { max-width: 1100px; margin: 0 auto; }

  /* BREADCRUMB */
  .breadcrumb-area { background:#f7f7f7; padding:14px 0; margin-bottom:22px; }
  .breadcrumb { margin:0; }
  .breadcrumb a { color:#333; text-decoration:none; }
  .breadcrumb .active { color:#7a7a7a; }

  /* THẺ/BOX bao quanh bảng – rõ ràng, có bóng nhẹ */
  .cart-box{
    border:1px solid var(--card-border);
    border-radius:10px;
    overflow:hidden;
    box-shadow:0 2px 12px rgba(0,0,0,.04);
  }

  /* BẢNG GIỎ HÀNG */
  .cart-table table{ width:100%; background:#fff; border-collapse:separate; border-spacing:0; }
  .cart-table .table thead th{
    background:var(--brand-gold); color:#fff; font-weight:600; border:none!important; padding:14px 16px;
  }
  .cart-table .table tbody td{
    vertical-align:middle; border-color:#eee!important; padding:18px 16px; background:#fff;
  }
  .cart-table .pro-thumbnail img{
    width:120px; height:120px; object-fit:cover; border-radius:6px; border:1px solid #eee;
  }
  .pro-title .name{ font-weight:600; color:#222; }
  .pro-title .meta{ color:#666; }

  /* CỤM SỐ LƯỢNG – căn giữa trong ô */
  .pro-quantity { text-align: center; }

  .qty-wrap{
    display: inline-flex;
    align-items: center;
    border: 1px solid #d0d0d0;
    border-radius: 6px;
    overflow: hidden;
    background: #fff;
  }

  .qty-wrap button{
    width: 28px;                 /* nhỏ hơn */
    height: 34px;
    line-height: 34px;
    padding: 0;
    border: 0;
    font-size: 18px;             /* kí hiệu rõ nét */
    font-weight: 700;
    background: #f3f3f3 !important;   /* luôn nền sáng */
    color: #222 !important;            /* luôn thấy dấu ± */
    user-select: none;
    cursor: pointer;
  }
  .qty-wrap button:hover{ background:#e7e7e7 !important; }
  .qty-wrap button:active{ transform: translateY(1px); }

  .qty-wrap input[type="number"]{
    width: 52px;                 /* nhỏ gọn */
    height: 34px;
    border: 0;
    text-align: center;
    outline: none;
    font-size: 14px;
    background: #fff;
  }

  /* Ẩn spinner của input number để gọn gàng */
  .qty-wrap input[type="number"]::-webkit-outer-spin-button,
  .qty-wrap input[type="number"]::-webkit-inner-spin-button{ -webkit-appearance: none; margin:0; }
  .qty-wrap input[type="number"]{ -moz-appearance: textfield; }

  /* Nút xoá */
  .btn-remove{ background:#000; color:#fff; border-radius:8px; padding:10px 14px; }
  .btn-remove i{ pointer-events:none; }

  /* ===== Khoảng cách nguyên khối dưới bảng giỏ hàng ===== */
.totals-row{ margin-top:24px; }

/* Box tổng đơn hàng (bảng bên phải) */
.cart-summary{
  width:100%;
  max-width:520px;
  border:1px solid var(--card-border);
  border-radius:10px;
  background:#fff;
  box-shadow:0 2px 12px rgba(0,0,0,.04);
  overflow:hidden;
}
.cart-summary table{ width:100%; margin:0; border-collapse:separate; border-spacing:0; }
.cart-summary thead th{
  background:#000; color:#fff; font-weight:700; padding:12px 16px; border:none;
}
.cart-summary tbody td{ border:none; padding:12px 16px; color:#333; }
.cart-summary tbody tr:nth-child(2){ background:#fafafa; } /* dòng vận chuyển */
.cart-summary .total td{ border-top:1px solid #eee; padding-top:14px; font-weight:700; }

/* Nút Thanh toán: thêm khoảng cách với bảng */
/* Checkout button – đứng sau bảng có khoảng cách rõ ràng */
a.btn-checkout{
  display:block;              /* d-block trong HTML cũng OK, thêm ở đây để chắc */
  width:100%;
  margin-top:16px !important; /* ép khoảng cách với bảng */
  background:#000 !important; /* màu đen như bạn đang dùng */
  border:none;
  padding:12px 16px;
  border-radius:6px;
  font-weight:700;
  color:#fff;
}
a.btn-checkout:hover{ opacity:.92; }


  /* Nút tiếp tục mua sắm – không tràn lên như tab */
  .btn-continue{
    display:inline-block; border:1px solid #d9d9d9; color:#333; background:#fff;
    padding:10px 16px; border-radius:6px; text-decoration:none;
  }
  .btn-continue:hover{ background:#f5f5f5; }

  /* nút cập nhật */
  .btn-update{
  display:inline-block;
  width:100%;
  padding:10px 16px;
  border-radius:8px;
  border:1px solid var(--brand-gold);
  background: var(--brand-gold);
  color:#fff;
  font-weight:700;
  letter-spacing:.2px;
  transition: transform .02s ease, opacity .15s;
    }
    .btn-update:hover{ opacity:.92; }
    .btn-update:active{ transform: translateY(1px); }
    .btn-update:disabled{
    background:#e8e8e8;
    border-color:#e8e8e8;
    color:#999;
    cursor:not-allowed;
    }

    /* —— Đổi brand sang đen —— */
:root { --brand-gold:#000; }  /* dùng biến cũ để đổi màu toàn cục */

/* Header bảng (backup, đề phòng nơi khác override) */
.cart-table .table thead th{
  background:#000 !important;
  color:#fff;
}

/* Nút cập nhật giỏ hàng: đen */
.btn-update{
  display:inline-block;
  width:100%;
  padding:10px 16px;
  border-radius:8px;
  border:1px solid #000;
  background:#000;
  color:#fff;
  font-weight:700;
  letter-spacing:.2px;
  transition: transform .02s ease, opacity .15s;
}
.btn-update:hover{ opacity:.92; }
.btn-update:active{ transform: translateY(1px); }
.btn-update:disabled{
  background:#e8e8e8; border-color:#e8e8e8; color:#999; cursor:not-allowed;
}

/* Nút Thanh toán: đen */
.btn-checkout{
  background:#000 !important;
  border:none;
  padding:12px 16px;
  border-radius:6px;
  font-weight:700;
  width:100%;
  color:#fff;
}
.btn-checkout:hover{ opacity:.92; }

/* Khoảng cách giữa bảng và nút cập nhật */
/* === Kích thước nút Cập nhật = nút Thanh toán === */
.cart-actions{
  width:100%;      /* = max-width của .cart-summary bên phải */
  margin-top:16px;
}

.cart-actions .btn-update{
  display:block;          /* giống a.btn-checkout */
  width:100%;             /* chiếm toàn bộ .cart-actions (520px) */
  padding:12px 16px;      /* khớp padding với nút checkout */
  border-radius:6px;      /* khớp bo góc */
}


</style>


<main>
  {{-- breadcrumb --}}
  {{-- <div class="breadcrumb-area">
    <div class="container">

    </div>
  </div> --}}

  {{-- cart main --}}
  <div class="cart-main-wrapper section-padding py-4">
    <div class="container cart-page">
      <div class="section-bg-color">
        <div class="row">
          <div class="col-lg-12">

            {{-- flash message --}}
            @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
            @if(session('error'))   <div class="alert alert-danger">{{ session('error') }}</div> @endif

            {{-- Cart Table --}}
            <div class="cart-table cart-box table-responsive">
              <table class="table align-middle mb-0">
                <thead>
                  <tr>
                    <th class="pro-thumbnail" style="width:140px">Ảnh Sản Phẩm</th>
                    <th class="pro-title">Tên Sản Phẩm</th>
                    <th class="pro-price" style="width:140px">Giá Tiền</th>
                    <th class="pro-quantity" style="width:180px">Số Lượng</th>
                    <th class="pro-subtotal" style="width:160px">Tổng Tiền</th>
                    <th class="pro-remove" style="width:90px">Thao Tác</th>
                  </tr>
                </thead>
                <tbody>
                @php
                  $tongGioHang = 0;
                  $coSanPham = !empty($cart) && count($cart) > 0;
                @endphp

                @forelse(($cart ?? []) as $row)
                  @php
                    $lineTotal   = (float)($row['price'] ?? 0) * (int)($row['quantity'] ?? 0);
                    $tongGioHang += $lineTotal;

                    // Giá trị raw từ DB
                    $raw = (string) ($row['image'] ?? '');
                    $raw = trim($raw, '/');

                    // Fallback nội bộ (tránh dùng placeholder ngoài mạng)
                    $imgUrl = asset('images/placeholder.png');

                    if ($raw !== '') {
                        // 1) Nếu là URL tuyệt đối thì dùng luôn
                        if (preg_match('#^https?://#i', $raw)) {
                            $imgUrl = $raw;
                        } else {
                            // 2) Chuẩn hoá relative path
                            //    - Bóc 'storage/' nếu có để làm việc với disk('public')
                            $rel = Str::startsWith($raw, 'storage/') ? Str::after($raw, 'storage/') : $raw;

                            //    - Lấy tên file để gắn vào thư mục chuẩn
                            $file = basename($rel);

                            // 3) Danh sách đường dẫn thử theo đúng cấu trúc dự án của bạn
                            $tries = array_values(array_unique(array_filter([
                                ltrim($rel, '/'),                      // giữ nguyên trước
                                'products/'.$file,                     // storage/app/public/products
                                'product_images/'.$file,               // storage/app/public/product_images
                            ])));

                            // 4) Tìm trên storage/app/public → /storage/...
                            foreach ($tries as $relPath) {
                                $relPath = ltrim($relPath, '/');
                                if (Storage::disk('public')->exists($relPath)) {
                                    $imgUrl = asset('storage/'.$relPath);
                                    break;
                                }
                            }

                            // 5) Nếu ai đó để ảnh thẳng trong public/...
                            if ($imgUrl === asset('images/placeholder.png')) {
                                foreach ($tries as $relPath) {
                                    if (is_file(public_path($relPath))) {
                                        $imgUrl = asset($relPath);
                                        break;
                                    }
                                }
                            }
                        }
                    }
                  @endphp
                  <tr>
                <td class="pro-thumbnail">
                @php

                // Giá trị thô từ session (có thể là URL, có thể chỉ là tên file)
                $raw = (string) ($row['image'] ?? '');
                $raw = trim($raw);

                // Fallback nội bộ (không phụ thuộc internet)
                $imgUrl = asset('images/placeholder.png');

                if ($raw !== '') {
                    // 1) Nếu là URL tuyệt đối -> dùng luôn
                    if (preg_match('#^https?://#i', $raw)) {
                        $imgUrl = $raw;
                    } else {
                        // 2) Lấy ra tên file + đuôi (nếu $raw là 'products/xxx.jpg' thì vẫn OK)
                        $basename = basename($raw);             // ví dụ: 'U6txA9zWHOA...jpg' (phải còn đuôi)
                        // Nếu DB lại lưu thiếu đuôi -> bạn phải sửa dữ liệu; code không đoán được .jpg/.png

                        // 3) Các ứng viên URL mà webserver có thể phục vụ
                        $candidates = [
                            'storage/'.ltrim($raw, '/'),                 // giữ nguyên nếu $raw đã là 'products/...'
                            'storage/products/'.$basename,               // storage/app/public/products/<file>
                            'storage/product_images/'.$basename,         // storage/app/public/product_images/<file>
                        ];

                        // 4) Chọn URL đầu tiên mà FILE THẬT sự tồn tại dưới public/
                        foreach ($candidates as $rel) {
                            $abs = public_path($rel);                    // -> public/<rel>
                            if (is_file($abs)) {                         // kiểm tra có thật không
                                $imgUrl = asset($rel);                   // -> /storage/...
                                break;
                            }
                        }
                    }
                }
            @endphp

            <img
            src="{{ $imgUrl }}"
            alt="{{ $row['name'] ?? 'Product' }}"
            class="img-fluid rounded"
            style="width: 90px; height: 90px; object-fit: cover;"
            onerror="this.onerror=null;this.src='{{ asset('images/placeholder.png') }}';"
            />

            {{-- DEBUG (tạm thời, test xong xoá): hiển thị URL thực tế --}}
            {{-- <small style="color:#888">{{ $imgUrl }}</small> --}}

                </td>
                    <td class="pro-title">
                      <div class="name">{{ $row['name'] ?? 'Sản phẩm' }}</div>
                      <div class="meta small mt-1">
                        @if(!empty($row['color'])) <span class="me-3">Màu: <strong>{{ $row['color'] }}</strong></span>@endif
                        @if(!empty($row['size']))  <span>Size: <strong>{{ $row['size'] }}</strong></span>@endif
                      </div>
                    </td>

                    <td class="pro-price">
                      <span>{{ number_format($row['price'] ?? 0) }}đ</span>
                    </td>

                    <td class="pro-quantity">
                      <form id="qty-form-{{ $row['variant_id'] }}"
                            action="{{ route('cart.update', $row['variant_id']) }}"
                            method="POST" data-variant="{{ $row['variant_id'] }}">
                        @csrf

                        <input type="hidden" name="variant_id" value="{{ $row['variant_id'] }}">
                        <div class="qty-wrap">
                          <button type="button"
                                  onclick="const i=this.nextElementSibling;i.stepDown();i.dispatchEvent(new Event('change'));">−</button>
                          <input type="number" min="1" name="quantity"
                                    value="{{ (int)($row['quantity'] ?? 1) }}"
                                    onchange="this.closest('form').dataset.dirty='1'">
                          <button type="button"
                                  onclick="const i=this.previousElementSibling;i.stepUp();i.dispatchEvent(new Event('change'));">+</button>
                        </div>
                      </form>
                    </td>

                    <td class="pro-subtotal">
                      <span class="fw-semibold">{{ number_format($lineTotal) }}đ</span>
                    </td>

                    <td class="pro-remove text-center">
                      <form action="{{ route('cart.remove', $row['variant_id']) }}" method="POST"
                            onsubmit="return confirm('Bạn có chắc muốn xoá sản phẩm này?')">
                        @csrf @method('DELETE')
                        <button class="btn-remove" title="Xóa">
                          <i class="fa fa-trash-o"></i>
                        </button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="text-center">Giỏ hàng trống</td>
                  </tr>
                @endforelse
                </tbody>
              </table>
            </div>

            @if($coSanPham)
            <div class="cart-actions">
            <button id="btnUpdateCart" class="btn-update">Cập nhật giỏ hàng</button>
            </div>
            @endif

          </div>
        </div>

{{-- Hàng dưới: bên trái là nút cập nhật, bên phải là bảng Tổng đơn hàng --}}
<div class="row align-items-start totals-row g-4">
  {{-- Cột phải: Bảng Tổng đơn hàng + nút Thanh toán --}}
  <div class="col-lg-6">
    <div class="cart-summary">
      <table class="table table-borderless mb-0">
        <thead>
          <tr><th colspan="2">Tổng đơn hàng</th></tr>
        </thead>
        <tbody>
          <tr>
            <td>Tổng tiền sản phẩm</td>
            <td class="text-end">{{ number_format($tongGioHang) }}đ</td>
          </tr>
          @if($coSanPham)
            @php $phiVanChuyen = 30000; @endphp
            <tr>
              <td>Vận chuyển</td>
              <td class="text-end">{{ number_format($phiVanChuyen) }}đ</td>
            </tr>
            <tr class="total">
              <td>Tổng thanh toán</td>
              <td class="text-end">{{ number_format($tongGioHang + $phiVanChuyen) }}đ</td>
            </tr>
          @else
            <tr class="total">
              <td>Tổng thanh toán</td>
              <td class="text-end">0đ</td>
            </tr>
          @endif
        </tbody>
      </table>
    </div>

    {{-- nút này đã có .btn-checkout { margin-top:16px } nên KHÔNG dính bảng --}}
    <a href=""
       class="btn-checkout d-block"
       onclick="return checkCartBeforeCheckout({{ $coSanPham ? 'true':'false' }})">
       Tiến hành thanh toán
    </a>
  </div>
</div>


          </div>
        </div>

      </div>
    </div>
  </div>
</main>

<script>
  function checkCartBeforeCheckout(hasItem){
    if(!hasItem){
      alert('Hiện không có sản phẩm trong giỏ hàng, vui lòng thêm sản phẩm');
      window.location.href = "{{ route('products.index') }}";
      return false;
    }
    return true;
  }

  document.querySelectorAll('form[id^="qty-form-"] input[name="quantity"]').forEach(inp => {
    inp.addEventListener('input', function(){
      this.closest('form').dataset.dirty = '1';
    });
  });

   document.getElementById('btnUpdateCart')?.addEventListener('click', async function (e) {
  e.preventDefault();
  const btn = this;
  btn.disabled = true;
  btn.textContent = 'Đang cập nhật...';

  const forms = Array.from(document.querySelectorAll('form[id^="qty-form-"][data-dirty="1"]'));

  if (forms.length === 0) {
    window.location.replace(window.location.pathname + '?t=' + Date.now());
    return;
  }

  try {
    for (const form of forms) {
      const fd = new FormData(form); // _token, quantity, variant_id
      const res = await fetch(form.action, {
        method: 'POST', // KHỚP route POST /cart/update/{id}
        headers: {
          'X-CSRF-TOKEN': fd.get('_token'),
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json'
        },
        body: fd,
        credentials: 'same-origin'
      });

      if (!res.ok) {
        const text = await res.text();
        console.error('Update failed for variant', form.dataset.variant, res.status, text);
      }
    }
  } catch (err) {
    console.error('Update error:', err);
  } finally {
    window.location.replace(window.location.pathname + '?t=' + Date.now());
  }
});
</script>

@endsection

    <body
	class="wp-singular page-template page-template-templates page-template-fullwidth page-template-templatesfullwidth-php page page-id-9 wp-embed-responsive wp-theme-mixtas ltr theme-mixtas woocommerce-cart woocommerce-page woocommerce-no-js woo-variation-swatches wvs-behavior-blur wvs-theme-mixtas wvs-show-label wvs-tooltip elementor-default elementor-kit-6 blog-sidebar-active blog-sidebar-right single-blog-sidebar-active ">
	<div class="site-wrapper">

		<div class="kitify-site-wrapper elementor-459kitify">
			<div data-elementor-type="header" data-elementor-id="459"
				class="elementor elementor-459 elementor-location-header">
				<div class="elementor-element elementor-element-022ffb4 elementor-hidden-mobile e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-root-container elementor-top-section e-con e-parent"
					data-id="022ffb4" data-element_type="container">
					<div class="e-con-inner">
						<div class="elementor-element elementor-element-dffb992 e-con-full elementor-hidden-mobile e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
							data-id="dffb992" data-element_type="container">
							<div class="elementor-element elementor-element-dc6b9df elementor-widget elementor-widget-heading"
								data-id="dc6b9df" data-element_type="widget" data-widget_type="heading.default">
								<div class="elementor-widget-container">
									<span class="elementor-heading-title elementor-size-default">Free shipping on US
										orders $100+ & Free exchanges</span>
								</div>
							</div>
						</div>
						<div class="elementor-element elementor-element-1a37318 e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
							data-id="1a37318" data-element_type="container">
							<div class="elementor-element elementor-element-10d3432 elementor-widget kitify elementor-kitify-nav-menu"
								data-id="10d3432" data-element_type="widget" data-widget_type="kitify-nav-menu.default">
								<div class="elementor-widget-container">
									<div class="kitify-nav-wrap">
										<div class="menu-language-container">
											<div class="kitify-nav kitify-nav--horizontal">
												<div
													class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children kitify-nav__item-1114 kitify-nav__item">
													<a href="#"
														class="menu-item-link menu-item-link-depth-0 menu-item-link-top"><span
															class="kitify-nav-link-text">English</span><i
															class="kitify-nav-arrow novaicon-down-arrow"></i></a>
													<div class="kitify-nav__sub kitify-nav-depth-0">
														<div
															class="menu-item menu-item-type-custom menu-item-object-custom kitify-nav__item-1115 kitify-nav__item kitify-nav-item-sub">
															<a href="#"
																class="menu-item-link menu-item-link-depth-1 menu-item-link-sub"><span
																	class="kitify-nav-link-text">French</span></a></div>
														<div
															class="menu-item menu-item-type-custom menu-item-object-custom kitify-nav__item-1116 kitify-nav__item kitify-nav-item-sub">
															<a href="#"
																class="menu-item-link menu-item-link-depth-1 menu-item-link-sub"><span
																	class="kitify-nav-link-text">German</span></a></div>
														<div
															class="menu-item menu-item-type-custom menu-item-object-custom kitify-nav__item-1117 kitify-nav__item kitify-nav-item-sub">
															<a href="#"
																class="menu-item-link menu-item-link-depth-1 menu-item-link-sub"><span
																	class="kitify-nav-link-text">Spanish</span></a>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="elementor-element elementor-element-f7ca775 elementor-widget kitify elementor-kitify-nav-menu"
								data-id="f7ca775" data-element_type="widget" data-widget_type="kitify-nav-menu.default">
								<div class="elementor-widget-container">
									<div class="kitify-nav-wrap">
										<div class="menu-currencies-container">
											<div class="kitify-nav kitify-nav--horizontal">
												<div
													class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children kitify-nav__item-1118 kitify-nav__item">
													<a href="#"
														class="menu-item-link menu-item-link-depth-0 menu-item-link-top"><span
															class="kitify-nav-link-text">USD</span><i
															class="kitify-nav-arrow novaicon-down-arrow"></i></a>
													<div class="kitify-nav__sub kitify-nav-depth-0">
														<div
															class="menu-item menu-item-type-custom menu-item-object-custom kitify-nav__item-1119 kitify-nav__item kitify-nav-item-sub">
															<a href="#"
																class="menu-item-link menu-item-link-depth-1 menu-item-link-sub"><span
																	class="kitify-nav-link-text">EURO</span></a></div>
														<div
															class="menu-item menu-item-type-custom menu-item-object-custom kitify-nav__item-1120 kitify-nav__item kitify-nav-item-sub">
															<a href="#"
																class="menu-item-link menu-item-link-depth-1 menu-item-link-sub"><span
																	class="kitify-nav-link-text">AUD</span></a></div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="elementor-element elementor-element-4c7c65b7 e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-root-container elementor-top-section e-con e-parent"
					data-id="4c7c65b7" data-element_type="container"
					data-settings="{&quot;background_background&quot;:&quot;classic&quot;,&quot;sticky&quot;:&quot;top&quot;,&quot;sticky_on&quot;:[&quot;desktop&quot;,&quot;tablet_extra&quot;,&quot;laptop&quot;],&quot;sticky_effects_offset&quot;:50,&quot;sticky_offset&quot;:0}">
					<div class="e-con-inner">
						<div class="elementor-element elementor-element-1915fa38 e-con-full kitify-col-width-auto-mobile kitify-col-align-left e-flex ignore-docs-style-no kitify-disable-relative-no e-con e-child"
							data-id="1915fa38" data-element_type="container">
							<div class="elementor-element elementor-element-2e9ed2a7 kitify-widget-align-none elementor-widget kitify elementor-kitify-logo"
								data-id="2e9ed2a7" data-element_type="widget" data-widget_type="kitify-logo.default">
								<div class="elementor-widget-container">
									<div class="kitify-logo kitify-logo-type-image kitify-logo-display-block">
										<a href="../index.html" class="kitify-logo__link"><img
												src="https://mixtas.b-cdn.net/wp-content/themes/mixtas/assets/images/logo.svg"
												class="kitify-logo__img kitify-logo-default" alt="Mixtas"
												width="130"><img
												src="https://mixtas.b-cdn.net/wp-content/themes/mixtas/assets/images/logo_light.svg"
												class="kitify-logo__img kitify-logo-light" alt="Mixtas" width="130"></a>
									</div>
								</div>
							</div>
						</div>
						<div class="elementor-element elementor-element-3f8ec217 e-con-full kitify-disable-relative-yes e-flex kitify-col-width-auto-no ignore-docs-style-no e-con e-child"
							data-id="3f8ec217" data-element_type="container">
							<div class="elementor-element elementor-element-3726810d elementor-widget kitify elementor-kitify-nova-menu"
								data-id="3726810d" data-element_type="widget"
								data-widget_type="kitify-nova-menu.default">
								<div class="elementor-widget-container">
									<div class="kitify-nova-menu kitify-nova-mobile-menu kitify-nova-menu--style-default"
										data-mobile-breakpoint="1024">
										<div class="kitify-nova-menu__mobile-trigger">
											<a data-toggle="MenuOffCanvas_3726810d">
												<span
													class="kitify-nova-menu__mobile-trigger-icon kitify-blocks-icon"><i
														aria-hidden="true"
														class="novaicon novaicon-menu-8-1"></i></span> </a>
										</div>
										<nav class="main-navigation header-primary-nav">
											<ul id="menu-main-menu" class="menu nav-menu">
												<li id="menu-item-766"
													class="menu-item menu-item-type-custom menu-item-object-custom menu-item-home menu-item-has-children">
													<a href="../index.html"><span>Home</span><i
															class="kitify-nav-arrow novaicon-down-arrow"></i></a>
													<ul class="sub-menu">
														<li id="menu-item-1645"
															class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home">
															<a href="../index.html"><span>Home v1 —
																	ChicCanvas</span></a></li>
														<li id="menu-item-941"
															class="menu-item menu-item-type-post_type menu-item-object-page">
															<a href="../home-v2/index.html"><span>Home v2 —
																	VogueVibes</span></a></li>
														<li id="menu-item-1112"
															class="menu-item menu-item-type-post_type menu-item-object-page">
															<a href="../home-v3/index.html"><span>Home v3 —
																	ModaMatrix</span></a></li>
														<li id="menu-item-1176"
															class="menu-item menu-item-type-post_type menu-item-object-page">
															<a href="../home-v4/index.html"><span>Home v4 —
																	StyleSymphony</span></a></li>
														<li id="menu-item-1316"
															class="menu-item menu-item-type-post_type menu-item-object-page">
															<a href="../home-v5/index.html"><span>Home v5 —
																	TrendTapestry</span></a></li>
														<li id="menu-item-1368"
															class="menu-item menu-item-type-post_type menu-item-object-page">
															<a href="../home-v6/index.html"><span>Home v6 —
																	HauteHarmony</span></a></li>
														<li id="menu-item-1551"
															class="menu-item menu-item-type-post_type menu-item-object-page">
															<a href="../home-v7/index.html"><span>Home v7 —
																	EleganceEnclave</span></a></li>
														<li id="menu-item-1604"
															class="menu-item menu-item-type-post_type menu-item-object-page">
															<a href="../home-v8/index.html"><span>Home v8 —
																	CoutureCanvas</span></a></li>
														<li id="menu-item-1641"
															class="menu-item menu-item-type-post_type menu-item-object-page">
															<a href="../home-v9/index.html"><span>Home v9 —
																	UrbanUtopia</span></a></li>
														<li id="menu-item-1644"
															class="menu-item menu-item-type-post_type menu-item-object-page">
															<a href="../home-v10/index.html"><span>Home v10 —
																	SilkSculpt</span></a></li>
													</ul>
												</li>
												<li
													class="menu-item menu-item-type-post_type menu-item-object-page current-menu-ancestor current_page_ancestor menu-item-has-children menu-item-79 menu-item-mega">
													<a href="../shop/index.html"><span>Shop</span><i
															class="kitify-nav-arrow novaicon-down-arrow"></i></a>
													<ul class="sub-menu mega-menu">

														<li class="mega-menu-container container-custom"
															style="width: 1440px">

															<ul class='mega-menu-main'>
																<li
																	class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-358 mega-sub-menu col-1_4">
																	<a href="#"><span>Shop Pages</span><i
																			class="kitify-nav-arrow novaicon-down-arrow"></i></a>
																	<ul class="sub-menu">
																		<li
																			class="menu-item menu-item-type-post_type menu-item-object-page menu-item-360">
																			<a href="../shop/index.html"><span>Shop —
																					Left Sidebar</span></a></li>
																		<li
																			class="menu-item menu-item-type-custom menu-item-object-custom menu-item-359">
																			<a
																				href="../shop/indexac59.html?theme_template_id=353"><span>Shop
																					— Right Sidebar</span></a></li>
																		<li
																			class="menu-item menu-item-type-custom menu-item-object-custom menu-item-368">
																			<a
																				href="../shop/indexc1c5.html?theme_template_id=363"><span>Shop
																					— Fullwidth</span></a></li>
																		<li
																			class="menu-item menu-item-type-custom menu-item-object-custom menu-item-375">
																			<a
																				href="../shop/index9a6d.html?theme_template_id=371"><span>Shop
																					— No Sidebar</span></a></li>
																		<li
																			class="menu-item menu-item-type-custom menu-item-object-custom menu-item-382">
																			<a
																				href="../shop/index2568.html?theme_template_id=376"><span>Shop
																					— 2 Columns</span></a></li>
																	</ul>
																</li>
																<li
																	class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-408 mega-sub-menu col-1_4">
																	<a href="#"><span>Product Layouts</span><i
																			class="kitify-nav-arrow novaicon-down-arrow"></i></a>
																	<ul class="sub-menu">
																		<li
																			class="menu-item menu-item-type-custom menu-item-object-custom menu-item-409">
																			<a
																				href="../product/carhartt-american-script-sweat-tobacco/index.html"><span>Product
																					— Layout v1</span></a></li>
																		<li
																			class="menu-item menu-item-type-custom menu-item-object-custom menu-item-414">
																			<a
																				href="../product/carhartt-american-script-sweat-tobacco/indexfab5.html?theme_template_id=410"><span>Product
																					— Layout v2</span></a></li>
																		<li
																			class="menu-item menu-item-type-custom menu-item-object-custom menu-item-421">
																			<a
																				href="../product/carhartt-american-script-sweat-tobacco/index01cf.html?theme_template_id=417"><span>Product
																					— Layout v3</span></a></li>
																		<li
																			class="menu-item menu-item-type-custom menu-item-object-custom menu-item-426">
																			<a
																				href="../product/carhartt-american-script-sweat-tobacco/index27db.html?theme_template_id=422"><span>Product
																					— Layout v4</span></a></li>
																		<li
																			class="menu-item menu-item-type-custom menu-item-object-custom menu-item-435">
																			<a
																				href="../product/carhartt-american-script-sweat-tobacco/index978a.html?theme_template_id=430"><span>Product
																					— Layout v5</span></a></li>
																	</ul>
																</li>
																<li
																	class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-436 mega-sub-menu col-1_4">
																	<a href="#"><span>Product Pages</span><i
																			class="kitify-nav-arrow novaicon-down-arrow"></i></a>
																	<ul class="sub-menu">
																		<li
																			class="menu-item menu-item-type-custom menu-item-object-custom menu-item-437">
																			<a
																				href="../product/carhartt-detroit-jacket-summer-zeus-rigid/index.html"><span>Product
																					— Simple</span></a></li>
																		<li
																			class="menu-item menu-item-type-custom menu-item-object-custom menu-item-438">
																			<a
																				href="../product/the-north-face-denali-jacket-summit-gold/index.html"><span>Product
																					— Variable</span></a></li>
																		<li
																			class="menu-item menu-item-type-custom menu-item-object-custom menu-item-439">
																			<a
																				href="../product/carhartt-hooded-coach-jacket-cypress/index.html"><span>Product
																					— Grouped</span></a></li>
																		<li
																			class="menu-item menu-item-type-custom menu-item-object-custom menu-item-440">
																			<a
																				href="../product/carhartt-windbreaker-pullover-winter-black/index.html"><span>Product
																					— External / Affiliate</span></a>
																		</li>
																		<li
																			class="menu-item menu-item-type-custom menu-item-object-custom menu-item-441">
																			<a
																				href="../product/polar-welcome-to-the-new-age-ls-tee-black/index.html"><span>Product
																					— Out of Stock</span></a></li>
																	</ul>
																</li>
																<li
																	class="menu-item menu-item-type-custom menu-item-object-custom current-menu-ancestor current-menu-parent menu-item-has-children menu-item-442 mega-sub-menu col-1_4">
																	<a href="#"><span>Core Pages</span><i
																			class="kitify-nav-arrow novaicon-down-arrow"></i></a>
																	<ul class="sub-menu">
																		<li
																			class="menu-item menu-item-type-post_type menu-item-object-page menu-item-445">
																			<a href="../my-account/index.html"><span>My
																					account</span></a></li>
																		<li
																			class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-9 current_page_item menu-item-447">
																			<a href="index.html"><span>Shopping
																					Cart</span></a></li>
																		<li
																			class="menu-item menu-item-type-post_type menu-item-object-page menu-item-446">
																			<a
																				href="../checkout/index.html"><span>Checkout</span></a>
																		</li>
																		<li
																			class="menu-item menu-item-type-post_type menu-item-object-page menu-item-443">
																			<a href="../order-tracking/index.html"><span>Order
																					Tracking</span></a></li>
																		<li
																			class="menu-item menu-item-type-post_type menu-item-object-page menu-item-444">
																			<a
																				href="../wishlist/index.html"><span>Wishlist</span></a>
																		</li>
																	</ul>
																</li>
															</ul>
														</li>
													</ul>
												</li>
												<li id="menu-item-80"
													class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children">
													<a href="#"><span>Pages</span><i
															class="kitify-nav-arrow novaicon-down-arrow"></i></a>
													<ul class="sub-menu">
														<li id="menu-item-83"
															class="menu-item menu-item-type-post_type menu-item-object-page">
															<a href="../about-us/index.html"><span>About Us</span></a>
														</li>
														<li id="menu-item-81"
															class="menu-item menu-item-type-post_type menu-item-object-page">
															<a href="../faqs/index.html"><span>FAQs</span></a></li>
														<li id="menu-item-82"
															class="menu-item menu-item-type-post_type menu-item-object-page">
															<a href="../order-tracking/index.html"><span>Order
																	Tracking</span></a></li>
													</ul>
												</li>
												<li id="menu-item-77"
													class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children">
													<a href="../blog/index.html"><span>Blog</span><i
															class="kitify-nav-arrow novaicon-down-arrow"></i></a>
													<ul class="sub-menu">
														<li id="menu-item-644"
															class="menu-item menu-item-type-post_type menu-item-object-page">
															<a href="../blog/index.html"><span>Blog — Style
																	01</span></a></li>
														<li id="menu-item-643"
															class="menu-item menu-item-type-custom menu-item-object-custom">
															<a href="../blog/indexc144.html?theme_template_id=637"><span>Blog
																	— Style 02</span></a></li>
														<li id="menu-item-652"
															class="menu-item menu-item-type-custom menu-item-object-custom">
															<a href="../blog/index0f67.html?theme_template_id=646"><span>Blog
																	— Style 03</span></a></li>
														<li id="menu-item-645"
															class="menu-item menu-item-type-post_type menu-item-object-post">
															<a
																href="../2023/12/gentlemans-gazette-a-guide-to-timeless-mens-fashion/index.html"><span>Blog
																	— Single</span></a></li>
													</ul>
												</li>
												<li id="menu-item-84"
													class="menu-item menu-item-type-post_type menu-item-object-page"><a
														href="../contact-us/index.html"><span>Contact Us</span></a></li>
											</ul>
										</nav>
									</div>
								</div>
							</div>
						</div>
						<div class="elementor-element elementor-element-40341a82 e-con-full kitify-col-width-auto-mobile kitify-col-align-right e-flex ignore-docs-style-no kitify-disable-relative-no e-con e-child"
							data-id="40341a82" data-element_type="container">
							<div class="elementor-element elementor-element-18b9cccf elementor-widget kitify elementor-kitify-menu-account"
								data-id="18b9cccf" data-element_type="widget"
								data-widget_type="kitify-menu-account.default">
								<div class="elementor-widget-container">
									<div class="kitify-menu-account">
										<div class="kitify-menu-account__box">
											<a data-toggle="AcccountCanvas_Popup">
												<span class="kitify-menu-account__icon kitify-blocks-icon"><svg
														xmlns="http://www.w3.org/2000/svg" width="20" height="21"
														viewBox="0 0 20 21" fill="none">
														<g clip-path="url(#clip0_188_1479)">
															<path
																d="M0.833313 19.6666C0.833313 15.0641 4.56415 11.3333 9.16665 11.3333H10.8333C15.4358 11.3333 19.1666 15.0641 19.1666 19.6666"
																stroke="currentColor" stroke-width="1.2"
																stroke-linecap="round" stroke-linejoin="round"></path>
															<path
																d="M10 11.3333C12.7614 11.3333 15 9.09468 15 6.33325C15 3.57183 12.7614 1.33325 10 1.33325C7.23858 1.33325 5 3.57183 5 6.33325C5 9.09468 7.23858 11.3333 10 11.3333Z"
																stroke="currentColor" stroke-width="1.2"
																stroke-linecap="round" stroke-linejoin="round"></path>
														</g>
														<defs>
															<clipPath id="clip0_188_1479">
																<rect width="20" height="20" fill="white"
																	transform="translate(0 0.5)"></rect>
															</clipPath>
														</defs>
													</svg></span> </a>
										</div>
									</div>
								</div>
							</div>
							<div class="elementor-element elementor-element-789c1abd elementor-widget kitify elementor-kitify-search"
								data-id="789c1abd" data-element_type="widget" data-widget_type="kitify-search.default">
								<div class="elementor-widget-container">
									<div class="kitify-search">
										<div class="kitify-search__popup-trigger">
											<div class="kitify-search__popup-trigger-container">
												<a id="js_header_search_modal" href="#headerSearchModal"><span
														class="kitify-search__popup-trigger-icon kitify-blocks-icon"><svg
															xmlns="http://www.w3.org/2000/svg" width="20" height="21"
															viewBox="0 0 20 21" fill="none">
															<path d="M18.4375 18.9376L13.2988 13.7988"
																stroke="currentColor" stroke-width="1.2"
																stroke-linecap="round" stroke-linejoin="round"></path>
															<path
																d="M8.4375 15.8125C12.2345 15.8125 15.3125 12.7345 15.3125 8.9375C15.3125 5.14054 12.2345 2.0625 8.4375 2.0625C4.64054 2.0625 1.5625 5.14054 1.5625 8.9375C1.5625 12.7345 4.64054 15.8125 8.4375 15.8125Z"
																stroke="currentColor" stroke-width="1.2"
																stroke-linecap="round" stroke-linejoin="round"></path>
														</svg></span></a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="elementor-element elementor-element-16239ba6 elementor-hidden-mobile elementor-view-default elementor-widget elementor-widget-icon"
								data-id="16239ba6" data-element_type="widget" data-widget_type="icon.default">
								<div class="elementor-widget-container">
									<div class="elementor-icon-wrapper">
										<a class="elementor-icon" href="../wishlist/index.html">
											<svg xmlns="http://www.w3.org/2000/svg" width="20" height="19"
												viewBox="0 0 20 19" fill="none">
												<g clip-path="url(#clip0_188_1484)">
													<path fill-rule="evenodd" clip-rule="evenodd"
														d="M4.10276 1.53575C1.83186 2.44932 -0.014983 4.82626 0.26654 8.33725C0.477821 10.9722 1.93049 13.1153 3.64664 14.7279C5.36367 16.3412 7.39577 17.4739 8.89721 18.0966C9.41075 18.3095 9.98779 18.3219 10.512 18.1223C12.0881 17.5221 14.1129 16.3949 15.8125 14.7748C17.5105 13.1563 18.9254 11.004 19.1783 8.35972C19.6544 4.79448 17.7508 2.42314 15.4153 1.52878C13.4653 0.782019 11.0862 1.04962 9.7063 2.64136C8.31911 1.03756 6.02213 0.763589 4.10276 1.53575ZM4.59785 2.76642C6.37434 2.05175 8.28816 2.53025 9.1221 4.13032C9.23724 4.35131 9.46656 4.48909 9.71577 4.487C9.96498 4.48493 10.192 4.34333 10.3035 4.12045C11.0791 2.56964 13.0744 2.05275 14.941 2.76758C16.7373 3.45545 18.2576 5.26658 17.8619 8.19549C17.8607 8.20434 17.8596 8.21327 17.8588 8.22211C17.6487 10.4557 16.4499 12.3346 14.8972 13.8147C13.3432 15.2959 11.4761 16.3357 10.0401 16.8826C9.8371 16.9598 9.61062 16.9563 9.40536 16.8713C8.01666 16.2954 6.13049 15.2415 4.55499 13.7611C2.9786 12.28 1.76454 10.4225 1.58883 8.23122C1.35374 5.29932 2.86493 3.46358 4.59785 2.76642Z"
														fill="currentColor"></path>
												</g>
											</svg> </a>
									</div>
								</div>
							</div>
							<div class="elementor-element elementor-element-4cfba4d5 elementor-widget kitify elementor-kitify-nova-cart"
								data-id="4cfba4d5" data-element_type="widget"
								data-widget_type="kitify-nova-cart.default">
								<div class="elementor-widget-container">
									<div
										class="kitify-nova-cart kitify-nova-cart-style-default kitify-nova-cart-label-off">
										<a href="javascript:;" data-toggle="MiniCartCanvas_4cfba4d5">
											<div class="header-cart-box">
												<span class="kitify-nova-cart__icon kitify-blocks-icon"><svg
														xmlns="http://www.w3.org/2000/svg" width="18" height="21"
														viewBox="0 0 18 21" fill="none">
														<path
															d="M3.50856 19.643H13.6343C15.4114 19.643 16.8571 18.1972 16.8571 16.4201V6.78582C16.8571 6.47153 16.6 6.21439 16.2857 6.21439H12.8571V5.35725C12.8571 2.99439 10.9343 1.07153 8.57142 1.07153C6.20856 1.07153 4.2857 2.99439 4.2857 5.35725V6.21439H0.857134C0.542848 6.21439 0.285706 6.47153 0.285706 6.78582V16.4201C0.285706 18.1972 1.73142 19.643 3.50856 19.643ZM5.42856 5.35725C5.42856 3.62296 6.83713 2.21439 8.57142 2.21439C10.3057 2.21439 11.7143 3.62296 11.7143 5.35725V6.21439H5.42856V5.35725ZM1.42856 7.35725H4.2857V8.78582C4.2857 9.1001 4.54285 9.35725 4.85713 9.35725C5.17142 9.35725 5.42856 9.1001 5.42856 8.78582V7.35725H11.7143V8.78582C11.7143 9.1001 11.9714 9.35725 12.2857 9.35725C12.6 9.35725 12.8571 9.1001 12.8571 8.78582V7.35725H15.7143V16.4201C15.7143 17.5658 14.78 18.5001 13.6343 18.5001H3.50856C2.36285 18.5001 1.42856 17.5658 1.42856 16.4201V7.35725Z"
															fill="currentColor"></path>
													</svg></span>
												<div class="cart-text">
													<div class="count-badge js_count_bag_item">6</div>
												</div>
											</div>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="site-content" class="site-content-wrapper">
				<div class="nova-container">
					<div class="grid-x">
						<div class="cell small-12">
							<div class="site-content">
								<div class="page-header-content">
									<nav class="woocommerce-breadcrumb"><a href="../index.html">Home</a><span
											class="delimiter">/</span>Cart</nav>
									<h1 class="page-title">Cart</h1>
								</div>
								<article id="post-9" class="post-9 page type-page status-publish hentry">
									<div class="entry-content">
										<div data-block-name="woocommerce/cart"
											class="wp-block-woocommerce-cart alignwide is-loading">
											<div data-block-name="woocommerce/filled-cart-block"
												class="wp-block-woocommerce-filled-cart-block">
												<div data-block-name="woocommerce/cart-items-block"
													class="wp-block-woocommerce-cart-items-block">
													<div data-block-name="woocommerce/cart-line-items-block"
														class="wp-block-woocommerce-cart-line-items-block"></div>

													<div data-block-name="woocommerce/cart-cross-sells-block"
														class="wp-block-woocommerce-cart-cross-sells-block">
														<h2 class="wp-block-heading has-large-font-size">You may be
															interested in…</h2>

														<div data-block-name="woocommerce/cart-cross-sells-products-block"
															class="wp-block-woocommerce-cart-cross-sells-products-block">
														</div>
													</div>
												</div>

												<div data-block-name="woocommerce/cart-totals-block"
													class="wp-block-woocommerce-cart-totals-block">
													<div data-block-name="woocommerce/cart-order-summary-block"
														class="wp-block-woocommerce-cart-order-summary-block">
														<div data-block-name="woocommerce/cart-order-summary-heading-block"
															class="wp-block-woocommerce-cart-order-summary-heading-block">
														</div>
														<div data-block-name="woocommerce/cart-order-summary-coupon-form-block"
															class="wp-block-woocommerce-cart-order-summary-coupon-form-block">
														</div>
														<div data-block-name="woocommerce/cart-order-summary-totals-block"
															class="wp-block-woocommerce-cart-order-summary-totals-block">
															<div data-block-name="woocommerce/cart-order-summary-subtotal-block"
																class="wp-block-woocommerce-cart-order-summary-subtotal-block">
															</div>
															<div data-block-name="woocommerce/cart-order-summary-discount-block"
																class="wp-block-woocommerce-cart-order-summary-discount-block">
															</div>
															<div data-block-name="woocommerce/cart-order-summary-fee-block"
																class="wp-block-woocommerce-cart-order-summary-fee-block">
															</div>
															<div data-block-name="woocommerce/cart-order-summary-shipping-block"
																class="wp-block-woocommerce-cart-order-summary-shipping-block">
															</div>
															<div data-block-name="woocommerce/cart-order-summary-taxes-block"
																class="wp-block-woocommerce-cart-order-summary-taxes-block">
															</div>
														</div>
													</div>

													<div data-block-name="woocommerce/cart-express-payment-block"
														class="wp-block-woocommerce-cart-express-payment-block"></div>

													<div data-block-name="woocommerce/proceed-to-checkout-block"
														class="wp-block-woocommerce-proceed-to-checkout-block"></div>

													<div data-block-name="woocommerce/cart-accepted-payment-methods-block"
														class="wp-block-woocommerce-cart-accepted-payment-methods-block">
													</div>
												</div>
											</div>

											<div data-block-name="woocommerce/empty-cart-block"
												class="wp-block-woocommerce-empty-cart-block">
												<h2
													class="wp-block-heading has-text-align-center with-empty-cart-icon wc-block-cart__empty-cart__title">
													Your cart is currently empty!</h2>

												<hr
													class="wp-block-separator has-alpha-channel-opacity is-style-dots" />

												<h2 class="wp-block-heading has-text-align-center">New in store</h2>

												<div data-block-name="woocommerce/product-new" data-columns="4"
													data-rows="1"
													class="wc-block-grid wp-block-product-new wp-block-woocommerce-product-new wc-block-product-new has-4-columns">
													<ul class="wc-block-grid__products">
														<li class="wc-block-grid__product">
															<a href="../product/carhartt-l-s-deadkebab-knock-knock-sweat/index.html"
																class="wc-block-grid__product-link">

																<div class="wc-block-grid__product-image"><img
																		fetchpriority="high" decoding="async"
																		width="700" height="700"
																		src="../../mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_08_1-700x700.jpg"
																		class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
																		alt="Carhartt L/S DeadKebab Knock Knock Sweat"
																		srcset="https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_08_1-700x700.jpg 700w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_08_1-300x300.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_08_1-150x150.jpg 150w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_08_1-768x768.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_08_1-250x250.jpg 250w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_08_1-50x50.jpg 50w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_08_1-100x100.jpg 100w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_08_1.jpg 1000w"
																		sizes="(max-width: 700px) 100vw, 700px" /></div>
																<div class="wc-block-grid__product-title">Carhartt L/S
																	DeadKebab Knock Knock Sweat</div>
															</a>
															<div class="wc-block-grid__product-price price"><span
																	class="woocommerce-Price-amount amount"><span
																		class="woocommerce-Price-currencySymbol">&#036;</span>130.00</span>
															</div>

															<div
																class="wp-block-button wc-block-grid__product-add-to-cart">
																<a href="../product/carhartt-l-s-deadkebab-knock-knock-sweat/index.html"
																	aria-label="Select options for &ldquo;Carhartt L/S DeadKebab Knock Knock Sweat&rdquo;"
																	data-quantity="1" data-product_id="1568"
																	data-product_sku="" data-price="130" rel="nofollow"
																	class="wp-block-button__link  add_to_cart_button">Select
																	options</a></div>
														</li>
														<li class="wc-block-grid__product">
															<a href="../product/parra-rug-pull-t-shirt-white/index.html"
																class="wc-block-grid__product-link">

																<div class="wc-block-grid__product-image"><img
																		decoding="async" width="700" height="700"
																		src="../../mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_07_1-700x700.jpg"
																		class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
																		alt="Parra Rug Pull t-shirt, white"
																		srcset="https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_07_1-700x700.jpg 700w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_07_1-300x300.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_07_1-150x150.jpg 150w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_07_1-768x768.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_07_1-250x250.jpg 250w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_07_1-50x50.jpg 50w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_07_1-100x100.jpg 100w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_07_1.jpg 1000w"
																		sizes="(max-width: 700px) 100vw, 700px" /></div>
																<div class="wc-block-grid__product-title">Parra Rug Pull
																	t-shirt, white</div>
															</a>
															<div class="wc-block-grid__product-price price"><span
																	class="woocommerce-Price-amount amount"><span
																		class="woocommerce-Price-currencySymbol">&#036;</span>60.00</span>
															</div>

															<div
																class="wp-block-button wc-block-grid__product-add-to-cart">
																<a href="../product/parra-rug-pull-t-shirt-white/index.html"
																	aria-label="Select options for &ldquo;Parra Rug Pull t-shirt, white&rdquo;"
																	data-quantity="1" data-product_id="1566"
																	data-product_sku="" data-price="60" rel="nofollow"
																	class="wp-block-button__link  add_to_cart_button">Select
																	options</a></div>
														</li>
														<li class="wc-block-grid__product">
															<a href="../product/butter-yard-pullover-hood-denim/index.html"
																class="wc-block-grid__product-link">

																<div class="wc-block-grid__product-image"><img
																		decoding="async" width="700" height="700"
																		src="../../mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_06_1-700x700.jpg"
																		class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
																		alt="Butter Yard Pullover Hood, denim"
																		srcset="https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_06_1-700x700.jpg 700w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_06_1-300x300.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_06_1-150x150.jpg 150w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_06_1-768x768.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_06_1-250x250.jpg 250w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_06_1-50x50.jpg 50w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_06_1-100x100.jpg 100w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_06_1.jpg 1000w"
																		sizes="(max-width: 700px) 100vw, 700px" /></div>
																<div class="wc-block-grid__product-title">Butter Yard
																	Pullover Hood, denim</div>
															</a>
															<div class="wc-block-grid__product-price price"><span
																	class="woocommerce-Price-amount amount"><span
																		class="woocommerce-Price-currencySymbol">&#036;</span>120.00</span>
															</div>

															<div
																class="wp-block-button wc-block-grid__product-add-to-cart">
																<a href="../product/butter-yard-pullover-hood-denim/index.html"
																	aria-label="Select options for &ldquo;Butter Yard Pullover Hood, denim&rdquo;"
																	data-quantity="1" data-product_id="1564"
																	data-product_sku="" data-price="120" rel="nofollow"
																	class="wp-block-button__link  add_to_cart_button">Select
																	options</a></div>
														</li>
														<li class="wc-block-grid__product">
															<a href="../product/adidas-x-pop-sl-cap-navy-white/index.html"
																class="wc-block-grid__product-link">

																<div class="wc-block-grid__product-image"><img
																		loading="lazy" decoding="async" width="700"
																		height="700"
																		src="../../mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_05_1-700x700.jpg"
																		class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
																		alt="adidas X Pop SL Cap, navy / white"
																		srcset="https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_05_1-700x700.jpg 700w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_05_1-300x300.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_05_1-150x150.jpg 150w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_05_1-768x768.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_05_1-250x250.jpg 250w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_05_1-50x50.jpg 50w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_05_1-100x100.jpg 100w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_05_1.jpg 1000w"
																		sizes="(max-width: 700px) 100vw, 700px" /></div>
																<div class="wc-block-grid__product-title">adidas X Pop
																	SL Cap, navy / white</div>
															</a>
															<div class="wc-block-grid__product-price price"><span
																	class="woocommerce-Price-amount amount"><span
																		class="woocommerce-Price-currencySymbol">&#036;</span>55.00</span>
															</div>

															<div
																class="wp-block-button wc-block-grid__product-add-to-cart">
																<a href="../product/adidas-x-pop-sl-cap-navy-white/index.html"
																	aria-label="Select options for &ldquo;adidas X Pop SL Cap, navy / white&rdquo;"
																	data-quantity="1" data-product_id="1562"
																	data-product_sku="" data-price="55" rel="nofollow"
																	class="wp-block-button__link  add_to_cart_button">Select
																	options</a></div>
														</li>
													</ul>
												</div>
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
@endsection

