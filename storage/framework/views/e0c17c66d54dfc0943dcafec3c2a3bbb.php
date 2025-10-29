<?php $__env->startSection('content'); ?>
<?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php
 use Illuminate\Support\Str;
?>


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
  #custom-footer-wrapper {
  position: relative;
  z-index: 1000; /* cao hơn các overlay */
  background: #222;
  color: #fff;
  padding: 20px;
}


</style>


<main>
  
  

  
  <div class="cart-main-wrapper section-padding py-4">
    <div class="container cart-page">
      <div class="section-bg-color">
        <div class="row">
          <div class="col-lg-12">

            
            <?php if(session('success')): ?> <div class="alert alert-success"><?php echo e(session('success')); ?></div> <?php endif; ?>
            <?php if(session('error')): ?>   <div class="alert alert-danger"><?php echo e(session('error')); ?></div> <?php endif; ?>

            
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
                <?php
                  $tongGioHang = 0;
                  $coSanPham = !empty($cart) && count($cart) > 0;
                ?>

                <?php $__empty_1 = true; $__currentLoopData = ($cart ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                  <?php
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
                  ?>
                  <tr>
                <td class="pro-thumbnail">
                <?php

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
            ?>

            <img
            src="<?php echo e($imgUrl); ?>"
            alt="<?php echo e($row['name'] ?? 'Product'); ?>"
            class="img-fluid rounded"
            style="width: 90px; height: 90px; object-fit: cover;"
            onerror="this.onerror=null;this.src='<?php echo e(asset('images/placeholder.png')); ?>';"
            />

            
            

                </td>
                    <td class="pro-title">
                      <div class="name"><?php echo e($row['name'] ?? 'Sản phẩm'); ?></div>
                      <div class="meta small mt-1">
                        <?php if(!empty($row['color'])): ?> <span class="me-3">Màu: <strong><?php echo e($row['color']); ?></strong></span><?php endif; ?>
                        <?php if(!empty($row['size'])): ?>  <span>Size: <strong><?php echo e($row['size']); ?></strong></span><?php endif; ?>
                      </div>
                    </td>

                    <td class="pro-price">
                      <span><?php echo e(number_format($row['price'] ?? 0)); ?>đ</span>
                    </td>

                    <td class="pro-quantity">
                      <form id="qty-form-<?php echo e($row['variant_id']); ?>"
                            action="<?php echo e(route('cart.update', $row['variant_id'])); ?>"
                            method="POST" data-variant="<?php echo e($row['variant_id']); ?>">
                        <?php echo csrf_field(); ?>

                        <input type="hidden" name="variant_id" value="<?php echo e($row['variant_id']); ?>">
                        <div class="qty-wrap">
                          <button type="button"
                                  onclick="const i=this.nextElementSibling;i.stepDown();i.dispatchEvent(new Event('change'));">−</button>
                          <input type="number" min="1" name="quantity"
                                    value="<?php echo e((int)($row['quantity'] ?? 1)); ?>"
                                    onchange="this.closest('form').dataset.dirty='1'">
                          <button type="button"
                                  onclick="const i=this.previousElementSibling;i.stepUp();i.dispatchEvent(new Event('change'));">+</button>
                        </div>
                      </form>
                    </td>

                    <td class="pro-subtotal">
                      <span class="fw-semibold"><?php echo e(number_format($lineTotal)); ?>đ</span>
                    </td>

                    <td class="pro-remove text-center">
                      <form action="<?php echo e(route('cart.remove', $row['variant_id'])); ?>" method="POST"
                            onsubmit="return confirm('Bạn có chắc muốn xoá sản phẩm này?')">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button class="btn-remove" title="Xóa">
                          <i class="fa fa-trash-o"></i>
                        </button>
                      </form>
                    </td>
                  </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                  <tr>
                    <td colspan="6" class="text-center">Giỏ hàng trống</td>
                  </tr>
                <?php endif; ?>
                </tbody>
              </table>
            </div>

            <?php if($coSanPham): ?>
            <div class="cart-actions">
            <button id="btnUpdateCart" class="btn-update">Cập nhật giỏ hàng</button>
            </div>
            <?php endif; ?>

          </div>
        </div>


<div class="row align-items-start totals-row g-4">
  
  <div class="col-lg-6">
    <div class="cart-summary">
      <table class="table table-borderless mb-0">
        <thead>
          <tr><th colspan="2">Tổng đơn hàng</th></tr>
        </thead>
        <tbody>
          <tr>
            <td>Tổng tiền sản phẩm</td>
            <td class="text-end"><?php echo e(number_format($tongGioHang)); ?>đ</td>
          </tr>
          <?php if($coSanPham): ?>
            <?php $phiVanChuyen = 30000; ?>
            <tr>
              <td>Vận chuyển</td>
              <td class="text-end"><?php echo e(number_format($phiVanChuyen)); ?>đ</td>
            </tr>
            <tr class="total">
              <td>Tổng thanh toán</td>
              <td class="text-end"><?php echo e(number_format($tongGioHang + $phiVanChuyen)); ?>đ</td>
            </tr>
          <?php else: ?>
            <tr class="total">
              <td>Tổng thanh toán</td>
              <td class="text-end">0đ</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    
    <a href="<?php echo e(route('checkout.index')); ?>"
       class="btn-checkout d-block"
       onclick="return checkCartBeforeCheckout(<?php echo e($coSanPham ? 'true':'false'); ?>)">
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
      window.location.href = "<?php echo e(route('products.index')); ?>";
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
<div id="custom-footer-wrapper">
  <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09\resources\views/cart/index.blade.php ENDPATH**/ ?>