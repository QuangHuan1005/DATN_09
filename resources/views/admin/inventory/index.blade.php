@extends('admin.master')

@section('content')
<div class="container-xxl">
    {{-- Alerts --}}
    @if (session('success'))
        <div class="alert alert-{{ session('type') ? 'success' : 'warning' }} alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @isset($error)
        <div class="alert alert-danger">{{ $error }}</div>
    @endisset

    <div class="row">
        <div class="col-xl-12">
            <div class="card">

                {{-- Card header --}}
                <div class="d-flex card-header justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mb-0">Kho hàng</h4>
                    </div>
                    {{-- <div class="dropdown">
                        <a href="#" class="dropdown-toggle btn btn-sm btn-outline-light rounded"
                           data-bs-toggle="dropdown" aria-expanded="false">
                           Tùy chọn
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="#!" class="dropdown-item">Download</a>
                            <a href="#!" class="dropdown-item">Export</a>
                            <a href="#!" class="dropdown-item">Import</a>
                        </div>
                    </div> --}}
                </div>

                {{-- Bộ lọc --}}
                <div class="card-body border-top">
                    <form class="row g-2" method="get">
                        <div class="col-md-5 col-lg-4">
                            <input type="text" name="q" value="{{ request('q') }}"
                                   class="form-control" placeholder="Tìm theo tên / mã SP">
                        </div>
                        <div class="col-md-4 col-lg-3">
                            <select name="category_id" class="form-select">
                                <option value="">-- Tất cả danh mục --</option>
                                @foreach(\App\Models\Category::orderBy('name')->get(['id','name']) as $cat)
                                    <option value="{{ $cat->id }}" @selected(request('category_id')==$cat->id)>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 col-lg-2">
                            <button class="btn btn-primary w-100">Lọc</button>
                        </div>
                    </form>
                </div>

                {{-- Bảng dữ liệu --}}
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
                            @php $threshold = (int) $threshold; @endphp
                            @forelse($variants as $i => $v)
                                @php $low = $v->quantity < $threshold; @endphp
                                <tr data-id="{{ $v->id }}">
                                    <td>{{ $variants->firstItem() + $i }}</td>
                                    <td>{{ $v->product->product_code ?? '—' }}</td>
                                    <td>
                                        {{ $v->product->name ?? '—' }}
                                        @if($low)
                                            <span class="badge bg-warning text-dark ms-2">Sắp hết</span>
                                        @endif
                                    </td>
                                    <td>{{ $v->color->name ?? '—' }}</td>
                                    <td>{{ $v->size->name ?? '—' }}</td>
                                    <td class="text-end">
                                        <input type="number"
                                               class="form-control form-control-sm qty-input text-end d-inline-block"
                                               style="width:110px" min="0" step="1"
                                               value="{{ (int) $v->quantity }}">
                                    </td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-primary btn-save">Lưu</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Chưa có sản phẩm trong kho</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="card-footer border-top">
                    @if($variants instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
                        {{ $variants->links() }}
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>

{{-- JS giữ nguyên logic cập nhật tồn kho --}}
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

      // cập nhật badge "Sắp hết"
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
{{-- Tô sáng dòng theo tham số ?highlight=ID --}}
{{-- <script>
(function () {
  const params = new URLSearchParams(window.location.search);
  const hl = params.get('highlight');
  if (!hl) return;

  // tìm đúng <tr> đang render: <tr data-id="{{ $v->id }}">
  const row = document.querySelector(`tbody tr[data-id="${hl}"]`);
  if (!row) return;

  // thêm style nhẹ để nhìn rõ
  row.style.transition = 'background-color .6s ease';
  row.classList.add('bg-warning-subtle');     // Bootstrap 5.3
  row.classList.add('position-relative');

  // viền trái nhỏ để nổi bật hơn (tùy chọn)
  const css = document.createElement('style');
  css.textContent = `
    .pulse-highlight::before{
      content:'';
      position:absolute; left:0; top:0; height:100%; width:4px; background:#f59f00;
    }`;
  document.head.appendChild(css);
  row.classList.add('pulse-highlight');

  // cuộn vào giữa màn hình
  row.scrollIntoView({ behavior: 'smooth', block: 'center' });

  // nháy nhẹ 2-3 lần cho dễ thấy (tùy chọn)
  let i = 0;
  const blink = setInterval(() => {
    row.classList.toggle('table-active');
    if (++i > 5) { clearInterval(blink); row.classList.remove('table-active'); }
  }, 250);

  // tự bỏ highlight sau 4s
  setTimeout(() => {
    row.classList.remove('bg-warning-subtle', 'pulse-highlight');
  }, 4000);
})();
</script> --}}

@endsection
