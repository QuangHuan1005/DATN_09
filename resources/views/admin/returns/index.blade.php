@extends('admin.master')

@section('content')
    <div class="container-xxl">

        {{-- Page Header --}}
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Quản Lý Hoàn Hàng</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Quản Lý Hoàn Hàng</h4>
                </div>
            </div>
        </div>

        {{-- Thông báo thành công / lỗi --}}
        @foreach (['success', 'error'] as $msg)
            @if (session($msg))
                <div class="alert alert-{{ $msg == 'success' ? 'success' : 'danger' }} alert-dismissible fade show"
                    role="alert">
                    {{ session($msg) }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        @endforeach

        {{-- Tìm kiếm + lọc trạng thái --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <form method="GET" action="{{ route('admin.returns.index') }}" class="d-flex">
                    <input type="search" name="keyword" class="form-control me-2" placeholder="Tìm mã đơn / tên KH"
                        value="{{ request('keyword') }}">
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                </form>
            </div>
            <div class="col-md-6 text-end">
                <div class="dropdown">
                    <a href="#" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                        {{ match (request('status')) {
                            'pending' => 'Chờ xác nhận',
                            'waiting_for_return' => 'Chờ người dùng gửi hàng',
                            'returned' => 'Đã nhận hàng',
                            'approved' => 'Đã chấp nhận',
                            'refunded' => 'Đã hoàn tiền',
                            'rejected' => 'Từ chối',
                            default => 'Tất cả trạng thái',
                        } }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="{{ route('admin.returns.index') }}" class="dropdown-item">Tất cả trạng thái</a>
                        <a href="{{ route('admin.returns.index', ['status' => 'pending']) }}" class="dropdown-item">Chờ xác nhận</a>
                        <a href="{{ route('admin.returns.index', ['status' => 'approved']) }}" class="dropdown-item">Đã chấp nhận</a>
                        <a href="{{ route('admin.returns.index', ['status' => 'waiting_for_return']) }}" class="dropdown-item">Chờ người dùng gửi hàng</a>
                        <a href="{{ route('admin.returns.index', ['status' => 'returned']) }}" class="dropdown-item">Đã nhận hàng</a>
                        <a href="{{ route('admin.returns.index', ['status' => 'refunded']) }}" class="dropdown-item">Đã hoàn tiền</a>
                        <a href="{{ route('admin.returns.index', ['status' => 'rejected']) }}" class="dropdown-item">Từ chối</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bảng danh sách yêu cầu hoàn hàng --}}
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-centered mb-0 align-middle">
                        <thead class="bg-light-subtle">
                            <tr>
                                <th>Mã Đơn Hàng</th>
                                <th>Ngày Yêu Cầu</th>
                                <th>Khách Hàng</th>
                                <th>Số Tiền Hoàn</th>
                                <th>Lý Do</th>
                                <th>Trạng Thái</th>
                                <th>Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($returns as $return)
                                @php
                                    $statusColors = [
                                        'pending' => 'badge border border-warning text-warning',
                                        'waiting_for_return' => 'badge border border-info text-info',
                                        'returned' => 'badge border border-primary text-primary',
                                        'approved' => 'badge border border-success text-success',
                                        'refunded' => 'badge border border-success text-success',
                                        'rejected' => 'badge border border-danger text-danger',
                                    ];
                                    $statusColor = $statusColors[$return->status] ?? 'badge bg-secondary';
                                    
                                    // Logic chặn trạng thái theo quy trình
                                    $statusOrder = ['pending', 'approved', 'waiting_for_return', 'returned', 'refunded'];
                                    $currentIndex = array_search($return->status, $statusOrder);
                                    $isRejected = $return->status === 'rejected';
                                    $isRefunded = $return->status === 'refunded';
                                @endphp
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $return->order_id) }}" class="link-primary fw-bold">
                                            #{{ $return->order->order_code }}
                                        </a>
                                    </td>
                                    <td>{{ $return->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('admin.users.show', $return->user_id ?? 0) }}" class="link-primary">
                                            {{ $return->order->name ?? ($return->user->name ?? 'Khách lẻ') }}
                                        </a>
                                    </td>
                                    <td class="text-danger fw-bold">{{ number_format($return->refund_amount, 0, ',', '.') }}đ</td>
                                    <td>
                                        <span class="text-truncate d-inline-block" style="max-width: 150px;" title="{{ $return->reason }}">
                                            {{ $return->reason }}
                                        </span>
                                    </td>

                                    <td>
                                        <form action="{{ route('admin.returns.updateStatus', $return->id) }}" method="POST" class="status-form" data-return-id="{{ $return->id }}" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="rejection_reason" class="rejection-reason-input">
                                            
                                            <select name="status" 
                                                    class="form-select form-select-sm {{ $statusColor }}"
                                                    style="min-width: 130px; height: 32px;"
                                                    onchange="confirmReturnStatusChange(this)"
                                                    {{ $isRejected || $isRefunded ? 'disabled' : '' }}>
                                                
                                                <option value="pending" data-color="badge border border-warning text-warning"
                                                    {{ $return->status === 'pending' ? 'selected' : '' }} disabled>
                                                    Chờ xác nhận
                                                </option>
                                                
                                                <option value="approved" data-color="badge border border-success text-success"
                                                    {{ $return->status === 'approved' ? 'selected' : '' }}
                                                    {{ ($currentIndex !== false && $currentIndex >= 1) || $isRejected ? 'disabled' : '' }}>
                                                    Đã chấp nhận
                                                </option>
                                                
                                                <option value="waiting_for_return" data-color="badge border border-info text-info"
                                                    {{ $return->status === 'waiting_for_return' ? 'selected' : '' }}
                                                    {{ ($currentIndex !== false && $currentIndex >= 2) || $currentIndex < 1 || $isRejected ? 'disabled' : '' }}>
                                                    Chờ khách gửi hàng
                                                </option>
                                                
                                                <option value="returned" data-color="badge border border-primary text-primary"
                                                    {{ $return->status === 'returned' ? 'selected' : '' }}
                                                    {{ ($currentIndex !== false && $currentIndex >= 3) || $currentIndex < 2 || $isRejected ? 'disabled' : '' }}>
                                                    Đã nhận hàng
                                                </option>
                                                
                                                <option value="refunded" data-color="badge border border-success text-success"
                                                    {{ $return->status === 'refunded' ? 'selected' : '' }}
                                                    {{ $currentIndex < 3 || $isRejected ? 'disabled' : '' }}>
                                                    Đã hoàn tiền
                                                </option>
                                                
                                                <option value="rejected" data-color="badge border border-danger text-danger"
                                                    {{ $return->status === 'rejected' ? 'selected' : '' }}
                                                    {{ $isRejected || $isRefunded ? 'disabled' : '' }}>
                                                    Từ chối
                                                </option>
                                            </select>
                                        </form>
                                    </td>

                                    <td>
                                        <a href="{{ route('admin.returns.show', $return->id) }}" class="btn btn-sm btn-soft-info">
                                            <i class="mdi mdi-eye"></i> Chi tiết
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">Không có yêu cầu hoàn hàng nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Phân trang --}}
        <div class="mt-3">
            {{ $returns->links() }}
        </div>

    </div>

    {{-- Modal: Nhập lý do từ chối --}}
    <div class="modal fade" id="rejectionModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title text-white">Lý do từ chối yêu cầu</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Chọn lý do <span class="text-danger">*</span></label>
                        <select class="form-select" id="rejectionReasonSelect">
                            <option value="" selected disabled>-- Chọn lý do từ chối --</option>
                            <option value="Hàng không đạt chất lượng như ban đầu">Hàng không đạt chất lượng như ban đầu</option>
                            <option value="Sản phẩm bị hư hỏng do lỗi của khách hàng">Sản phẩm bị hư hỏng do lỗi của khách hàng</option>
                            <option value="Sản phẩm đã qua sử dụng">Sản phẩm đã qua sử dụng</option>
                            <option value="Thiếu phụ kiện hoặc bộ phận đi kèm">Thiếu phụ kiện hoặc bộ phận đi kèm</option>
                            <option value="Quá thời gian quy định để hoàn hàng">Quá thời gian quy định để hoàn hàng</option>
                            <option value="other">Khác (nhập lý do cụ thể)</option>
                        </select>
                    </div>
                    <div class="mb-3 d-none" id="otherReasonContainer">
                        <label class="form-label">Nhập lý do cụ thể <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="otherReasonInput" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-danger" id="confirmRejectionBtn">Xác nhận từ chối</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal: Upload minh chứng hoàn tiền --}}
    <div class="modal fade" id="refundModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title text-white"><i class='mdi mdi-cash-multiple me-1'></i> Xác Nhận Hoàn Tiền</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="refundForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-info py-2 mb-3" style="font-size: 13px;">
                            Hệ thống yêu cầu <strong>ảnh minh chứng chuyển khoản</strong> để hoàn tất quy trình.
                        </div>
                        <input type="hidden" name="status" value="refunded">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Ảnh Bill ngân hàng <span class="text-danger">*</span></label>
                            <input type="file" name="admin_refund_proof" class="form-control" accept="image/*" required>
                            <div class="form-text">Dung lượng < 2MB (JPG, PNG).</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-success">Gửi & Hoàn tất hoàn tiền</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let currentFormToSubmit = null;
        let currentSelect = null;

        document.addEventListener('DOMContentLoaded', function() {
            // Khởi tạo màu sắc cho select ban đầu
            document.querySelectorAll('select[name="status"]').forEach(select => {
                updateSelectColor(select);
                select.dataset.current = select.value;
            });

            // Xử lý chọn lý do "Khác"
            const reasonSelect = document.getElementById('rejectionReasonSelect');
            const otherContainer = document.getElementById('otherReasonContainer');
            
            reasonSelect.addEventListener('change', function() {
                if (this.value === 'other') {
                    otherContainer.classList.remove('d-none');
                } else {
                    otherContainer.classList.add('d-none');
                }
            });

            // Xác nhận từ chối
            document.getElementById('confirmRejectionBtn').addEventListener('click', function() {
                const selectedReason = reasonSelect.value;
                let finalReason = "";

                if (!selectedReason) {
                    alert("Vui lòng chọn lý do!");
                    return;
                }

                if (selectedReason === 'other') {
                    const otherText = document.getElementById('otherReasonInput').value.trim();
                    if (!otherText) {
                        alert("Vui lòng nhập lý do cụ thể!");
                        return;
                    }
                    finalReason = otherText;
                } else {
                    finalReason = reasonSelect.options[reasonSelect.selectedIndex].text;
                }

                if (currentFormToSubmit) {
                    currentFormToSubmit.querySelector('.rejection-reason-input').value = finalReason;
                    currentFormToSubmit.submit();
                }
            });

            // Reset select khi đóng modal mà không submit
            ['rejectionModal', 'refundModal'].forEach(id => {
                document.getElementById(id).addEventListener('hidden.bs.modal', function() {
                    if (currentSelect) {
                        currentSelect.value = currentSelect.dataset.current;
                        updateSelectColor(currentSelect);
                    }
                });
            });
        });

        function updateSelectColor(select) {
            const selectedOption = select.selectedOptions[0];
            if (selectedOption && selectedOption.dataset.color) {
                // Xóa các class badge cũ
                select.className = 'form-select form-select-sm ' + selectedOption.dataset.color;
            }
        }

        function confirmReturnStatusChange(select) {
            const newStatus = select.value;
            const newStatusText = select.selectedOptions[0].text;
            const form = select.form;
            currentSelect = select;

            updateSelectColor(select);

            if (newStatus === 'rejected') {
                currentFormToSubmit = form;
                new bootstrap.Modal(document.getElementById('rejectionModal')).show();
                return;
            }

            if (newStatus === 'refunded') {
                const refundForm = document.getElementById('refundForm');
                refundForm.action = form.action;
                new bootstrap.Modal(document.getElementById('refundModal')).show();
                return;
            }

            if (confirm(`Bạn có chắc chắn muốn chuyển trạng thái sang "${newStatusText}"?`)) {
                form.submit();
            } else {
                select.value = select.dataset.current;
                updateSelectColor(select);
            }
        }
    </script>
@endsection