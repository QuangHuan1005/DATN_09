<?php $__env->startSection('content'); ?>
<?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php
 use Illuminate\Support\Str;
?>


<style>

  :root { --brand-gold:#c1995a; --card-border:#e9e9e9; }

  /* Khung trang giỏ hàng thu hẹp & căn giữa */
  .cart-page { max-width: 1280px; margin: 0 auto; }

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
    vertical-align:middle; border-color:#eee!important; padding:14px 14px; background:#fff;
  }
  .cart-table .pro-thumbnail img{
    width:120px; height:120px; object-fit:cover; border-radius:6px; border:1px solid #eee;
  }
/* Tên sp: hiển thị tối đa 2 dòng, có ellipsis nếu dài */
.pro-title .name{
  display:-webkit-box;
  -webkit-line-clamp:2;
  -webkit-box-orient:vertical;
  overflow:hidden;
  line-height:1.3;
  max-height:calc(1.3em * 2);
  white-space:normal;
}

/* Dòng meta (Màu/Size): cố gắng nằm 1 dòng, nếu dài thì ellipsis */
.pro-title .meta{
  white-space:nowrap;
  overflow:hidden;
  text-overflow:ellipsis;
}

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
/* Box tổng đơn hàng (cột phải) */
.cart-summary{
  width:100%;
  /* bỏ giới hạn để nó fit theo col-lg-4 */
  max-width:none;
  border:1px solid var(--card-border);
  border-radius:10px;
  overflow:hidden;
  box-shadow:0 2px 12px rgba(0,0,0,.04);
  background:#fff;
}

@media (min-width: 992px){
  .totals-row{ margin-top:0; }
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
  display: flex;                 /* thay vì block */
  align-items: center;           /* canh giữa theo chiều dọc */
  justify-content: center;       /* canh giữa theo chiều ngang */
  text-align: center;            /* phòng hờ */
  width: 100%;
  padding: 12px 16px;
  border-radius: 6px;
  background: #000 !important;
  color: #fff;
  font-weight: 700;
  border: none;
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

.table .js-check{ width:16px; height:16px; cursor:pointer; }

#check-all,
.js-check{
  accent-color: #000;   /* nền/tô đen khi checked, dấu tick trắng */
  width: 16px;
  height: 16px;
  border-radius: 4px;   /* bo nhẹ cho đẹp */
}
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<main>
  
  

  
  <div class="cart-main-wrapper section-padding py-4">
    <div class="container cart-page">
      <div class="section-bg-color">
        <div class="row">
          <div class="col-lg-12">

            
            <?php if(session('success')): ?> <div class="alert alert-success"><?php echo e(session('success')); ?></div> <?php endif; ?>
            <?php if(session('error')): ?>   <div class="alert alert-danger"><?php echo e(session('error')); ?></div> <?php endif; ?>

            
            <div class="row align-items-start g-4">
            
            <div class="col-12 col-lg-9">
                <div class="cart-table cart-box table-responsive">
                <table class="table align-middle mb-0">
                    
                    <thead>
                    <tr>
                        <th style="width:44px;text-align:center">
                            <input type="checkbox" id="check-all" />
                        </th>
                        <th class="pro-thumbnail" style="width:120px">Ảnh Sản Phẩm</th>
                        <th class="pro-title">Tên Sản Phẩm</th>
                        <th class="pro-price" style="width:120px">Giá Tiền</th>
                        <th class="pro-quantity" style="width:150px">Số Lượng</th>
                        <th class="pro-subtotal" style="width:140px">Tổng Tiền</th>
                        <th class="pro-remove" style="width:70px">Thao Tác</th>
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
                  <tr data-variant="<?php echo e($row['variant_id']); ?>">
                    <td style="text-align:center">
                    <input type="checkbox"
                            class="js-check"
                            data-variant="<?php echo e($row['variant_id']); ?>"
                            checked />
                    </td>

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
                            method="POST"
                            data-variant="<?php echo e($row['variant_id']); ?>"
                            data-price="<?php echo e((float)($row['price'] ?? 0)); ?>"> 
                        <?php echo csrf_field(); ?>

                        <input type="hidden" name="variant_id" value="<?php echo e($row['variant_id']); ?>">
                        <div class="qty-wrap">
                            <button type="button"
                            onclick="const i=this.nextElementSibling;i.stepDown();i.dispatchEvent(new Event('input',{bubbles:true}));">−</button>

                            <input type="number" min="1" name="quantity"
                                value="<?php echo e((int)($row['quantity'] ?? 1)); ?>"
                                class="js-qty"
                                data-variant="<?php echo e($row['variant_id']); ?>"
                                <?php if(!empty($row['max_qty'])): ?> max="<?php echo e((int)$row['max_qty']); ?>" <?php endif; ?>
                                oninput="/* để JS bắt sự kiện */">


                            <button type="button"
                            onclick="const i=this.previousElementSibling;i.stepUp();i.dispatchEvent(new Event('input',{bubbles:true}));">+</button>
                        </div>
                        </form>
                    </td>

                    <td class="pro-subtotal">
                        <span class="fw-semibold" id="line-total-<?php echo e($row['variant_id']); ?>"><?php echo e(number_format($lineTotal)); ?>đ</span>
                    </td>

                    <td class="pro-remove text-center">
                    <form action="<?php echo e(route('cart.remove', $row['variant_id'])); ?>" method="POST" class="js-remove-form">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="button"
                                class="btn-remove js-remove"
                                title="Xóa"
                                data-name="<?php echo e($row['name'] ?? 'Sản phẩm'); ?>"
                                data-price="<?php echo e(number_format($row['price'] ?? 0)); ?>đ"
                                data-image="<?php echo e($imgUrl ?? ''); ?>">
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
            </div>

            
             <div class="col-12 col-lg-3">
               <div class="cart-summary">
                    <table class="table table-borderless mb-0">
                        <thead>
                        <tr><th colspan="2">Tổng đơn hàng</th></tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Tổng tiền sản phẩm</td>
                            <td class="text-end" id="sum-products"><?php echo e(number_format($tongGioHang)); ?>đ</td>
                        </tr>
                        <tr class="total">
                            <td>Tổng thanh toán</td>
                            <td class="text-end" id="sum-grand"><?php echo e(number_format($tongGioHang)); ?>đ</td>
                        </tr>
                        </tbody>
                    </table>
                    </div>

                    </tbody>
                </table>
                </div>

                <a href="<?php echo e(route('checkout.index')); ?>"
                class="btn-checkout mt-3 w-100"
                onclick="return checkCartBeforeCheckout(<?php echo e($coSanPham ? 'true':'false'); ?>)">
                Tiến hành thanh toán
                </a>
            </div>
            </div>


          </div>
        </div>
        </div>
    </main>

    <script>
        function checkCartBeforeCheckout(hasItem) {
            if (!hasItem) {
                alert('Hiện không có sản phẩm trong giỏ hàng, vui lòng thêm sản phẩm');
                window.location.href = "<?php echo e(route('products.index')); ?>";
                return false;
            }
            return true;
        }

        document.querySelectorAll('form[id^="qty-form-"] input[name="quantity"]').forEach(inp => {
            inp.addEventListener('input', function() {
                this.closest('form').dataset.dirty = '1';
            });
        });

        document.getElementById('btnUpdateCart')?.addEventListener('click', async function(e) {
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

  // (giữ lại nếu bạn còn dùng ở nơi khác, không ảnh hưởng)
  document.querySelectorAll('form[id^="qty-form-"] input[name="quantity"]').forEach(inp => {
    inp.addEventListener('input', function(){
      this.closest('form').dataset.dirty = '1';
    });
  });

  // format tiền
  function fmt(n){
    try { return new Intl.NumberFormat('vi-VN').format(n) + 'đ'; }
    catch(e){ return (n||0).toLocaleString('vi-VN') + 'đ'; }
  }

  // debounce chống bắn request dồn dập
  const timers = new Map();
  function debounce(key, fn, wait=350){
    clearTimeout(timers.get(key));
    const t = setTimeout(fn, wait);
    timers.set(key, t);
  }

  // Cập nhật 1 dòng + tổng khi đổi số lượng (KHÔNG xử lý phí ship)
  async function updateLine(variantId, qty){
    const form = document.querySelector(`form[id="qty-form-${variantId}"]`);
    if(!form) return;

    const fd = new FormData(form);
    fd.set('quantity', qty);

    const res = await fetch(form.action, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': fd.get('_token'),
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json'
      },
      body: fd,
      credentials: 'same-origin'
    });

    let data = {};
    try { data = await res.json(); } catch(e) {}

    // fallback nếu server chưa trả JSON chuẩn
    if(!data || !('line_total' in data)){
      const price = parseFloat(form.dataset.price || 0);
      data = { ok: res.ok, line_total: price * qty };
    }

    // cập nhật tiền dòng
    const lineEl = document.getElementById(`line-total-${variantId}`);
    if(lineEl){ lineEl.textContent = fmt(Math.max(0, data.line_total||0)); }

    // cập nhật tổng (grand = cart_total, không có shipping)
    if('cart_total' in data){
      const sp = document.getElementById('sum-products');
      if(sp) sp.textContent = fmt(data.cart_total||0);

      const g = document.getElementById('sum-grand');
      if(g) g.textContent = fmt(data.cart_total||0); // grand = cart_total
    }
  }

  // Lắng nghe thay đổi số lượng
  document.querySelectorAll('.js-qty').forEach(inp => {
    inp.addEventListener('input', function(){
      let qty = parseInt(this.value, 10);
      if(!Number.isFinite(qty) || qty < 1){ qty = 1; this.value = 1; }
      const variantId = this.dataset.variant;
      debounce('v'+variantId, () => updateLine(variantId, qty));
    });
  });

  (function(){
  // Màu/nút theo tông đen của site
  const theme = {
    confirmButtonColor: '#000000',
    cancelButtonColor:  '#6b7280' // xám
  };

  // Click thùng rác -> hỏi xoá
  document.querySelectorAll('.js-remove').forEach(btn => {
    btn.addEventListener('click', function(e){
      e.preventDefault();
      const form  = this.closest('form.js-remove-form');
      const name  = this.dataset.name || 'sản phẩm';
      const image = this.dataset.image || '';

      Swal.fire({
        title: 'Xoá sản phẩm?',
        html: `
          <div style="display:flex;align-items:center;gap:12px;justify-content:center">
            ${image ? `<img src="${image}" alt="" style="width:60px;height:60px;object-fit:cover;border-radius:8px;border:1px solid #eee">` : ''}
            <div style="text-align:left">
              <div style="font-weight:700;color:#111">${name}</div>
              <div style="color:#666;font-size:13px">Sản phẩm sẽ bị xoá khỏi giỏ hàng</div>
            </div>
          </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Xoá',
        cancelButtonText: 'Huỷ',
        reverseButtons: true,
        focusCancel: true,
        ...theme
      }).then((res) => {
        if (res.isConfirmed && form) {
          form.submit(); // submit form xoá như cũ
        }
      });
    });
  });

  // Nếu Controller trả về flash success/error thì show SweetAlert “đẹp” luôn
  <?php if(session('success')): ?>
    Swal.fire({
      icon: 'success',
      title: 'Đã xoá khỏi giỏ!',
      text: <?php echo json_encode(session('success'), 15, 512) ?>,
      timer: 1400,
      showConfirmButton: false
    });
  <?php endif; ?>

  <?php if(session('error')): ?>
    Swal.fire({
      icon: 'error',
      title: 'Không thể xoá',
      text: <?php echo json_encode(session('error'), 15, 512) ?>,
      confirmButtonText: 'Đã hiểu',
      ...theme
    });
  <?php endif; ?>
})();

// == TÍNH TỔNG MỚI CHO CÁC DÒNG ĐANG ĐƯỢC TICK ==
function recomputeTotals(){
  let sum = 0;
  document.querySelectorAll('tr[data-variant]').forEach(tr => {
    const cb = tr.querySelector('.js-check');
    if(!cb || !cb.checked) return;

    const form = tr.querySelector('form[id^="qty-form-"]');
    const unit = parseFloat(form?.dataset.price || 0);
    const qty  = parseInt(form?.querySelector('input[name="quantity"]')?.value || '1', 10);
    sum += (unit * qty);
  });

  const sp = document.getElementById('sum-products');
  const g  = document.getElementById('sum-grand');
  if(sp) sp.textContent = fmt(sum);
  if(g)  g.textContent  = fmt(sum);
}

// Khi đổi số lượng 1 dòng, sau khi update server -> cập nhật tổng theo lựa chọn
const _origUpdateLine = updateLine;
updateLine = async function(variantId, qty){
  await _origUpdateLine(variantId, qty);
  recomputeTotals();
};

// Tick / bỏ tick 1 dòng
document.querySelectorAll('.js-check').forEach(cb => {
  cb.addEventListener('change', recomputeTotals);
});

// Tick tất cả
document.getElementById('check-all')?.addEventListener('change', function(){
  const checked = this.checked;
  document.querySelectorAll('.js-check').forEach(cb => { cb.checked = checked; });
  recomputeTotals();
});

// Khởi tạo tổng lần đầu
document.addEventListener('DOMContentLoaded', recomputeTotals);

// Bảo vệ nút Thanh toán: phải có ít nhất 1 dòng được chọn
document.querySelectorAll('a.btn-checkout').forEach(a => {
  a.addEventListener('click', function(e){
    const chosen = [...document.querySelectorAll('.js-check:checked')].map(x => x.dataset.variant);
    if(chosen.length === 0){
      Swal.fire({
        icon: 'warning',
        title: 'Chưa chọn sản phẩm',
        text: 'Hãy tích chọn ít nhất 1 sản phẩm trước khi thanh toán.',
        confirmButtonColor: '#000'
      });
      e.preventDefault();
      return;
    }
    // (tuỳ chọn) đính kèm danh sách chọn lên URL để xử lý ở trang checkout
    this.href = this.href.split('?')[0] + '?items=' + encodeURIComponent(chosen.join(','));
  });
});

// Lắng nghe thay đổi số lượng + chặn vượt tồn kho ngay khi gõ (dùng SweetAlert2)
document.querySelectorAll('.js-qty').forEach(function (inp) {
  inp.addEventListener('input', function () {
    let v = parseInt(this.value || '1', 10);
    if (!Number.isFinite(v) || v < 1) {
      v = 1;
    }

    const max = parseInt(this.getAttribute('max') || '0', 10);

    if (max > 0 && v > max) {
      v = max;
      this.value = max;

      // Popup đẹp giống phần xoá sản phẩm
      Swal.fire({
        icon: 'warning',
        title: 'Vượt số lượng tồn kho',
        text: 'Chỉ còn ' + max + ' sản phẩm trong kho.',
        confirmButtonText: 'Đã hiểu',
        confirmButtonColor: '#000000', // cùng tông với theme xoá sản phẩm
      });
    } else {
      this.value = v;
    }

    const variantId = this.dataset.variant;
    // debounce để không spam request lên server
    debounce('v' + variantId, () => updateLine(variantId, v));
  });
});


</script>
<div id="custom-footer-wrapper">
  <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09\resources\views/cart/index.blade.php ENDPATH**/ ?>