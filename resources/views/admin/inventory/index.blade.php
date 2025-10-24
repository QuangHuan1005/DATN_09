@extends('layouts.admin.app')
@section('content')
<div class="container py-4">
  <h1 class="h4 mb-3">Kho hàng</h1>

  @isset($error)
    <div class="alert alert-danger">{{ $error }}</div>
  @endisset

  <form class="row g-2 mb-3" method="get">
    <div class="col-md-4">
      <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Tìm theo tên / mã SP">
    </div>
    <div class="col-md-3">
      <select name="category_id" class="form-select">
        <option value="">-- Tất cả danh mục --</option>
        @foreach(\App\Models\Category::orderBy('name')->get(['id','name']) as $cat)
          <option value="{{ $cat->id }}" @selected(request('category_id')==$cat->id)>{{ $cat->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-2">
      <button class="btn btn-primary w-100">Lọc</button>
    </div>
  </form>

  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead>
        <tr>
          <th>#</th>
          <th>Mã SP</th>
          <th>Tên sản phẩm</th>
          <th>Màu</th>
          <th>Size</th>
          <th class="text-end">Tồn kho</th>
          <th class="text-end">Cập nhật</th>
        </tr>
      </thead>
      <tbody>
        @php $threshold = (int) $threshold; @endphp
        @forelse($variants as $i => $v)
          @php $low = $v->quantity < $threshold; @endphp
          <tr data-id="{{ $v->id }}">
            <td>{{ $variants->firstItem() + $i }}</td>
            <td>{{ $v->product->product_code ?? '—' }}</td>
            <td>
              {{ $v->product->name ?? '—' }}
              @if($low) <span class="badge bg-warning text-dark ms-2">Sắp hết</span> @endif
            </td>
            <td>{{ $v->color->name ?? '—' }}</td>
            <td>{{ $v->size->name ?? '—' }}</td>
            <td class="text-end">
              <input type="number" class="form-control form-control-sm qty-input text-end d-inline-block"
                     style="width:110px" min="0" step="1" value="{{ (int) $v->quantity }}">
            </td>
            <td class="text-end">
              <button class="btn btn-sm btn-primary btn-save">Lưu</button>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" class="text-center text-muted">Chưa có sản phẩm trong kho</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($variants instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
    {{ $variants->links() }}
  @endif
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
    const res = await fetch(`{{ route('admin.inventory.index') }}/${id}`, {
      method: 'PATCH',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ quantity: Number(qty) })
    });

    const data = await res.json();

    if (res.ok && data.status) {
      btn.textContent = 'Đã lưu';
      setTimeout(()=>{ btn.textContent = original; btn.disabled = false; }, 800);
      // badge sắp hết
      const nameCell = tr.cells[2];
      const badge = nameCell.querySelector('.badge');
      if (Number(qty) < {{ (int) $threshold }}) {
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
@endsection
