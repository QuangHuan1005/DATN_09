<?php $__env->startSection('content'); ?>
<div class="container-xxl">
    
    <?php if(session('success')): ?>
        <div class="alert alert-<?php echo e(session('type') ? 'success' : 'warning'); ?> alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <?php if(isset($error)): ?>
        <div class="alert alert-danger"><?php echo e($error); ?></div>
    <?php endif; ?>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">

                
                <div class="d-flex card-header justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mb-0">Kho hàng</h4>
                    </div>
                    
                </div>

                
                <div class="card-body border-top">
                    <form class="row g-2" method="get">
                        <div class="col-md-5 col-lg-4">
                            <input type="text" name="q" value="<?php echo e(request('q')); ?>"
                                   class="form-control" placeholder="Tìm theo tên / mã SP">
                        </div>
                        <div class="col-md-4 col-lg-3">
                            <select name="category_id" class="form-select">
                                <option value="">-- Tất cả danh mục --</option>
                                <?php $__currentLoopData = \App\Models\Category::orderBy('name')->get(['id','name']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($cat->id); ?>" <?php if(request('category_id')==$cat->id): echo 'selected'; endif; ?>>
                                        <?php echo e($cat->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-3 col-lg-2">
                            <button class="btn btn-primary w-100">Lọc</button>
                        </div>
                    </form>
                </div>

                
                <div class="table-responsive">
                    <table class="table align-middle mb-0 table-hover table-centered">
                        <thead class="bg-light-subtle">
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th>Mã SP</th>
                                <th>Tên sản phẩm</th>
                                <th>Màu</th>
                                <th>Size</th>
                                <th class="text-end">Tồn kho</th>
                                <th class="text-end" style="width: 120px;">Cập nhật</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $threshold = (int) $threshold; ?>
                            <?php $__empty_1 = true; $__currentLoopData = $variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php $low = $v->quantity < $threshold; ?>
                                <tr data-id="<?php echo e($v->id); ?>">
                                    <td><?php echo e($variants->firstItem() + $i); ?></td>
                                    <td><?php echo e($v->product->product_code ?? '—'); ?></td>
                                    <td>
                                        <?php echo e($v->product->name ?? '—'); ?>

                                        <?php if($low): ?>
                                            <span class="badge bg-warning text-dark ms-2">Sắp hết</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($v->color->name ?? '—'); ?></td>
                                    <td><?php echo e($v->size->name ?? '—'); ?></td>
                                    <td class="text-end">
                                        <input type="number"
                                               class="form-control form-control-sm qty-input text-end d-inline-block"
                                               style="width:110px" min="0" step="1"
                                               value="<?php echo e((int) $v->quantity); ?>">
                                    </td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-primary btn-save">Lưu</button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Chưa có sản phẩm trong kho</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                
                <div class="card-footer border-top">
                    <?php if($variants instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator): ?>
                        <?php echo e($variants->links()); ?>

                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('click', async (e) => {
  const btn = e.target.closest('.btn-save');
  if (!btn) return;

  const tr = btn.closest('tr');
  const id = tr.dataset.id;
  const input = tr.querySelector('.qty-input');
  const qty = input.value.trim();

  if (qty === '') { alert('Vui lòng nhập số lượng'); return; }
  if (!/^\d+$/.test(qty)) { alert('Số lượng không hợp lệ'); return; }

  btn.disabled = true;
  const original = btn.textContent;
  btn.textContent = 'Đang lưu...';

  try {
    const res = await fetch(`<?php echo e(route('admin.inventory.index')); ?>/${id}`, {
      method: 'PATCH',
      headers: {
        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ quantity: Number(qty) })
    });

    const data = await res.json();

    if (res.ok && data.status) {
      btn.textContent = 'Đã lưu';
      setTimeout(()=>{ btn.textContent = original; btn.disabled = false; }, 800);

      // cập nhật badge "Sắp hết"
      const nameCell = tr.cells[2];
      const badge = nameCell.querySelector('.badge');
      if (Number(qty) < <?php echo e((int) $threshold); ?>) {
        if (!badge) {
          const span = document.createElement('span');
          span.className = 'badge bg-warning text-dark ms-2';
          span.textContent = 'Sắp hết';
          nameCell.appendChild(span);
        }
      } else if (badge) {
        badge.remove();
      }
    } else {
      alert((data && data.message) ? data.message : 'Cập nhật thất bại');
      btn.textContent = original; btn.disabled = false;
    }
  } catch (err) {
    alert('Cập nhật thất bại');
    btn.textContent = original; btn.disabled = false;
  }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09\resources\views/admin/inventory/index.blade.php ENDPATH**/ ?>