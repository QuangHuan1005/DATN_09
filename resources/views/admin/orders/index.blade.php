@extends('admin.master')

@section('content')
    <div class="container-xxl">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <div class="row">
            {{-- <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4 class="card-title mb-2">Hoàn Tiền Thanh Toán</h4>
                                <p class="text-muted fw-medium fs-22 mb-0">490</p>
                            </div>
                            <div>
                                <div class="avatar-md bg-primary bg-opacity-10 rounded">
                                    <iconify-icon icon="solar:chat-round-money-broken"
                                        class="fs-32 text-primary avatar-title"></iconify-icon>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4 class="card-title mb-2">Hủy đơn hàng</h4>
                                <p class="text-muted fw-medium fs-22 mb-0">241</p>
                            </div>
                            <div>
                                <div class="avatar-md bg-primary bg-opacity-10 rounded">
                                    <iconify-icon icon="solar:cart-cross-broken"
                                        class="fs-32 text-primary avatar-title"></iconify-icon>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4 class="card-title mb-2">Đơn hàng đã được gửi đi</h4>
                                <p class="text-muted fw-medium fs-22 mb-0">630</p>
                            </div>
                            <div>
                                <div class="avatar-md bg-primary bg-opacity-10 rounded">
                                    <iconify-icon icon="solar:box-broken"
                                        class="fs-32 text-primary avatar-title"></iconify-icon>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4 class="card-title mb-2">Đơn hàng đang được giao</h4>
                                <p class="text-muted fw-medium fs-22 mb-0">170</p>
                            </div>
                            <div>
                                <div class="avatar-md bg-primary bg-opacity-10 rounded">
                                    <iconify-icon icon="solar:tram-broken"
                                        class="fs-32 text-primary avatar-title"></iconify-icon>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4 class="card-title mb-2">Đang chờ đánh giá</h4>
                                <p class="text-muted fw-medium fs-22 mb-0">210</p>
                            </div>
                            <div>
                                <div class="avatar-md bg-primary bg-opacity-10 rounded">
                                    <iconify-icon icon="solar:clipboard-remove-broken"
                                        class="fs-32 text-primary avatar-title"></iconify-icon>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4 class="card-title mb-2">Đang chờ thanh toán</h4>
                                <p class="text-muted fw-medium fs-22 mb-0">608</p>
                            </div>
                            <div>
                                <div class="avatar-md bg-primary bg-opacity-10 rounded">
                                    <iconify-icon icon="solar:clock-circle-broken"
                                        class="fs-32 text-primary avatar-title"></iconify-icon>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4 class="card-title mb-2">Đã giao hàng</h4>
                                <p class="text-muted fw-medium fs-22 mb-0">200</p>
                            </div>
                            <div>
                                <div class="avatar-md bg-primary bg-opacity-10 rounded">
                                    <iconify-icon icon="solar:clipboard-check-broken"
                                        class="fs-32 text-primary avatar-title"></iconify-icon>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4 class="card-title mb-2">Đang xử lý</h4>
                                <p class="text-muted fw-medium fs-22 mb-0">656</p>
                            </div>
                            <div>
                                <div class="avatar-md bg-primary bg-opacity-10 rounded">
                                    <iconify-icon icon="solar:inbox-line-broken"
                                        class="fs-32 text-primary avatar-title"></iconify-icon>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center gap-1">
                        <h4 class="card-title flex-grow-1">Tất Cả Sản Phẩm</h4>
                        <form method="GET" action="{{ route('admin.orders.index') }}" class="search-bar me-3">
                            <span><i class="bx bx-search-alt"></i></span>
                            <input type="search" name="keyword" id="search" class="form-control"
                                placeholder="Tìm theo mã đơn hoặc tên KH ..." value="{{ request('keyword') }}">
                        </form>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle btn btn-sm btn-outline-light rounded"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                {{ match (request('status')) {
                                    '1' => 'Chờ xác nhận',
                                    '2' => 'Xác nhận',
                                    '3' => 'Đang giao hàng',
                                    '4' => 'Đã giao hàng',
                                    '5' => 'Hoàn thành',
                                    '6' => 'Hủy',
                                    '7' => 'Hoàn hàng',
                                    default => 'Tất cả trạng thái',
                                } }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="{{ route('admin.orders.index', ['status' => null]) }}" class="dropdown-item">Tất cả
                                    trạng
                                    thái</a>
                                <a href="{{ route('admin.orders.index', ['status' => 1]) }}" class="dropdown-item">Chờ xác
                                    nhận</a>
                                <a href="{{ route('admin.orders.index', ['status' => 2]) }}" class="dropdown-item">Xác
                                    nhận</a>
                                <a href="{{ route('admin.orders.index', ['status' => 3]) }}" class="dropdown-item">Đang giao
                                    hàng</a>
                                <a href="{{ route('admin.orders.index', ['status' => 4]) }}" class="dropdown-item">Đã giao
                                    hàng</a>
                                <a href="{{ route('admin.orders.index', ['status' => 5]) }}" class="dropdown-item">Hoàn
                                    thành</a>
                                <a href="{{ route('admin.orders.index', ['status' => 6]) }}" class="dropdown-item">Hủy</a>
                                <a href="{{ route('admin.orders.index', ['status' => 7]) }}" class="dropdown-item">Hoàn
                                    hàng</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0 table-hover table-centered">
                                <thead class="bg-light-subtle">
                                    <tr>
                                        <th>Mã Đơn Hàng</th>
                                        <th>Ngày Tạo</th>
                                        <th>Khách Hàng</th>
                                        <th>Tổng Tiền</th>
                                        <th>Trạng Thái Thanh Toán</th>
                                        <th>Số Sản Phẩm</th>
                                        <th>Trạng Thái Đơn Hàng</th>
                                        <th>Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($orders as $order)
                                        @php
                                            // Lấy trạng thái đơn hàng
                                            $currentStatus = collect($statuses)->firstWhere(
                                                'id',
                                                $order->order_status_id,
                                            );
                                            $colorClass = $currentStatus
                                                ? $currentStatus->color_class
                                                : 'border-secondary text-secondary';
                                            $statusName = $currentStatus ? $currentStatus->name : 'Không xác định';
                                        @endphp

                                        <tr>
                                            <td>{{ $order->order_code }}</td>

                                            <td>{{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : '-' }}
                                            </td>

                                            <td>
                                                <a href="{{ route('admin.users.show', $order->user_id ?? 0) }}"
                                                    class="link-primary fw-medium">
                                                    {{ $order->name ?? 'Khách lẻ' }}
                                                </a>
                                            </td>

                                            <td>{{ number_format($order->total_amount, 0, ',', '.') }}₫</td>


                                            <td>
                                                @php
                                                    // Định nghĩa màu nhãn cho từng trạng thái
                                                    $paymentColors = [
                                                        1 => 'badge border border-primary text-primary', // Chưa thanh toán
                                                        2 => 'badge border border-warning text-warning', // Đang xử lý
                                                        3 => 'badge border border-success text-success', // Đã thanh toán
                                                        4 => 'badge border border-danger text-danger', // Thanh toán thất bại
                                                        5 => 'badge border border-secondary text-secondary', // Hoàn tiền
                                                    ];

                                                    $paymentName = $order->paymentStatus->name ?? 'Không xác định';
                                                    $color =
                                                        $paymentColors[$order->payment_status_id] ??
                                                        'bg-light text-dark';
                                                @endphp

                                                <span class="badge {{ $color }} px-2 py-1 fs-13">
                                                    {{ $paymentName }}
                                                </span>
                                            </td>
                                            <td>
                                                {{ $order->details_sum_quantity ?? 0 }} sản phẩm
                                            </td>

                                            <td>
                                                <form action="{{ route('admin.orders.status', $order->id) }}"
                                                    method="POST" class="status-form">
                                                    @csrf
                                                    <select name="order_status_id"
                                                        class="form-select form-select-sm w-auto {{ $colorClass }}"
                                                        onchange="changeStatusColor(this); this.form.submit()">
                                                        @foreach ($statuses as $status)
                                                            <option value="{{ $status->id }}"
                                                                data-color="{{ $status->color_class }}"
                                                                {{ $order->order_status_id == $status->id ? 'selected' : '' }}
                                                                {{ in_array($status->id, [5, 6, 7]) ? 'disabled' : '' }}>
                                                                {{ $status->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </form>

                                            </td>

                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                                        class="btn btn-soft-info btn-sm" title="Xem chi tiết">
                                                        <iconify-icon icon="solar:eye-broken"
                                                            class="align-middle fs-18"></iconify-icon>
                                                    </a>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center text-muted py-4">
                                                Không có đơn hàng nào.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- end table-responsive -->
                    </div>
                    <div class="card-footer border-top">
                        <nav aria-label="Page navigation example">
                            {{ $orders->links() }}
                            {{-- <ul class="pagination justify-content-end mb-0">
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">Previous</a></li>
                                <li class="page-item active"><a class="page-link" href="javascript:void(0);">1</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">2</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">3</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">Next</a></li>
                            </ul> --}}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tự ẩn alert sau 3s
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.classList.remove('show');
                    alert.classList.add('hide');
                }, 3000);
            });

            // Set màu ban đầu cho tất cả select
            document.querySelectorAll('select[name="order_status_id"]').forEach(select => {
                const selectedOption = select.selectedOptions[0];
                if (selectedOption && selectedOption.dataset.color) {
                    select.className = 'form-select form-select-sm w-auto ' + selectedOption.dataset.color;
                }
            });
        });

        // Hàm thay đổi màu khi đổi select
        function changeStatusColor(select) {
            const colorClass = select.selectedOptions[0].dataset.color || '';
            select.className = 'form-select form-select-sm w-auto ' + colorClass;
        }
    </script>

@endsection
