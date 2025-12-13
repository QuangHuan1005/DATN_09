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
                                    $statusLabels = [
                                        'pending' => 'Chờ xác nhận',
                                        'waiting_for_return' => 'Chờ người dùng gửi hàng',
                                        'returned' => 'Đã nhận hàng',
                                        'approved' => 'Đã chấp nhận',
                                        'refunded' => 'Đã hoàn tiền',
                                        'rejected' => 'Từ chối',
                                    ];
                                    $statusColor = $statusColors[$return->status] ?? 'badge bg-secondary';
                                    $statusLabel = $statusLabels[$return->status] ?? 'Không xác định';
                                @endphp
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $return->order_id) }}" class="link-primary">
                                            {{ $return->order->order_code }}
                                        </a>
                                    </td>
                                    <td>{{ $return->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('admin.users.show', $return->user_id ?? 0) }}"
                                            class="link-primary">
                                            {{ $return->order->name ?? ($return->user->name ?? 'Khách lẻ') }}
                                        </a>
                                    </td>
                                    <td>{{ number_format($return->refund_amount, 0, ',', '.') }}đ</td>
                                    <td>
                                        <span class="text-truncate d-inline-block" style="max-width: 200px;" title="{{ $return->reason }}">
                                            {{ $return->reason }}
                                        </span>
                                    </td>

                                    {{-- Cập nhật trạng thái --}}
                                    <td>
                                        <form action="{{ route('admin.returns.updateStatus', $return->id) }}" method="POST" class="status-form" data-return-id="{{ $return->id }}">
                                            @csrf
                                            <input type="hidden" name="rejection_reason" class="rejection-reason-input">
                                            @php
                                                // Logic: chỉ cho phép chọn bước tiếp theo hoặc từ chối
                                                // Thứ tự: pending -> approved -> waiting_for_return -> returned -> refunded
                                                $statusOrder = ['pending', 'approved', 'waiting_for_return', 'returned', 'refunded'];
                                                $currentIndex = array_search($return->status, $statusOrder);
                                                
                                                // Nếu đã từ chối thì không thay đổi được nữa
                                                $isRejected = $return->status === 'rejected';
                                                // Nếu đã hoàn tiền thì không thay đổi được nữa
                                                $isRefunded = $return->status === 'refunded';
                                            @endphp
                                            <select name="status" 
                                                    class="form-select form-select-sm {{ $statusColor }}"
                                                    style="min-width: 100px; height: 30px;"
                                                    onchange="confirmReturnStatusChange(this)"
                                                    {{ $isRejected || $isRefunded ? 'disabled' : '' }}>
                                                <option value="pending" 
                                                        data-color="badge border border-warning text-warning"
                                                        {{ $return->status === 'pending' ? 'selected' : '' }}
                                                        disabled>
                                                    Chờ xác nhận
                                                </option>
                                                <option value="approved" 
                                                        data-color="badge border border-success text-success"
                                                        {{ $return->status === 'approved' ? 'selected' : '' }}
                                                        {{ ($currentIndex !== false && $currentIndex >= 1) || $isRejected ? 'disabled' : '' }}>
                                                    Đã chấp nhận
                                                </option>
                                                <option value="waiting_for_return" 
                                                        data-color="badge border border-info text-info"
                                                        {{ $return->status === 'waiting_for_return' ? 'selected' : '' }}
                                                        {{ ($currentIndex !== false && $currentIndex >= 2) || $currentIndex < 1 || $isRejected ? 'disabled' : '' }}>
                                                    Chờ người dùng gửi hàng
                                                </option>
                                                <option value="returned" 
                                                        data-color="badge border border-primary text-primary"
                                                        {{ $return->status === 'returned' ? 'selected' : '' }}
                                                        {{ ($currentIndex !== false && $currentIndex >= 3) || $currentIndex < 2 || $isRejected ? 'disabled' : '' }}>
                                                    Đã nhận hàng
                                                </option>
                                                <option value="refunded" 
                                                        data-color="badge border border-success text-success"
                                                        {{ $return->status === 'refunded' ? 'selected' : '' }}
                                                        {{ $currentIndex < 3 || $isRejected ? 'disabled' : '' }}>
                                                    Đã hoàn tiền
                                                </option>
                                                <option value="rejected" 
                                                        data-color="badge border border-danger text-danger"
                                                        {{ $return->status === 'rejected' ? 'selected' : '' }}
                                                        {{ $isRejected || $isRefunded ? 'disabled' : '' }}>
                                                    Từ chối
                                                </option>
                                            </select>
                                        </form>
                                    </td>

                                    {{-- Thao tác --}}
                                    <td>
                                        <a href="{{ route('admin.returns.show', $return->id) }}" class="btn btn-sm btn-info">
                                            <i class="mdi mdi-eye"></i> Chi tiết
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">Không có yêu cầu hoàn hàng nào.</td>
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
    <div class="modal fade" id="rejectionModal" tabindex="-1" aria-labelledby="rejectionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectionModalLabel">Lý do từ chối yêu cầu hoàn hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rejectionReasonSelect" class="form-label">Chọn lý do từ chối <span class="text-danger">*</span></label>
                        <select class="form-select" id="rejectionReasonSelect">
                            <option value="" selected disabled>-- Chọn lý do từ chối --</option>
                            <option value="Hàng không đạt chất lượng như ban đầu">Hàng không đạt chất lượng như ban đầu</option>
                            <option value="Sản phẩm bị hư hỏng do lỗi của khách hàng">Sản phẩm bị hư hỏng do lỗi của khách hàng</option>
                            <option value="Sản phẩm đã qua sử dụng">Sản phẩm đã qua sử dụng</option>
                            <option value="Thiếu phụ kiện hoặc bộ phận đi kèm">Thiếu phụ kiện hoặc bộ phận đi kèm</option>
                            <option value="Không có hóa đơn hoặc chứng từ hợp lệ">Không có hóa đơn hoặc chứng từ hợp lệ</option>
                            <option value="Quá thời gian quy định để hoàn hàng">Quá thời gian quy định để hoàn hàng</option>
                            <option value="Sản phẩm không thuộc chính sách hoàn trả">Sản phẩm không thuộc chính sách hoàn trả</option>
                            <option value="Hình ảnh minh chứng không rõ ràng">Hình ảnh minh chứng không rõ ràng</option>
                            <option value="Thông tin khách hàng không chính xác">Thông tin khách hàng không chính xác</option>
                            <option value="other">Khác (nhập lý do cụ thể)</option>
                        </select>
                        <div class="invalid-feedback d-none" id="rejectionSelectError">
                            Vui lòng chọn lý do từ chối!
                        </div>
                    </div>
                    
                    {{-- Input text chỉ hiện khi chọn "Khác" --}}
                    <div class="mb-3 d-none" id="otherReasonContainer">
                        <label for="otherReasonInput" class="form-label">Nhập lý do cụ thể <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="otherReasonInput" rows="3" placeholder="Vui lòng nhập lý do cụ thể..."></textarea>
                        <div class="invalid-feedback d-none" id="otherReasonError">
                            Vui lòng nhập lý do cụ thể!
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-danger" id="confirmRejectionBtn">Xác nhận từ chối</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Script --}}
    <script>
        let currentFormToSubmit = null;
        let currentSelect = null;

        document.addEventListener('DOMContentLoaded', function() {
            // Ẩn alert sau 3s
            document.querySelectorAll('.alert').forEach(alert => {
                setTimeout(() => alert.classList.add('d-none'), 3000);
            });

            // Set màu select trạng thái khi load và lưu giá trị hiện tại
            document.querySelectorAll('select[name="status"]').forEach(select => {
                const selectedOption = select.selectedOptions[0];
                if (selectedOption && selectedOption.dataset.color) {
                    select.className = 'form-select form-select-sm ' + selectedOption.dataset.color;
                }
                select.dataset.current = select.value;
            });

            // Xử lý khi chọn lý do từ dropdown
            const reasonSelect = document.getElementById('rejectionReasonSelect');
            const otherReasonContainer = document.getElementById('otherReasonContainer');
            const otherReasonInput = document.getElementById('otherReasonInput');

            reasonSelect.addEventListener('change', function() {
                // Ẩn lỗi khi chọn
                reasonSelect.classList.remove('is-invalid');
                document.getElementById('rejectionSelectError').classList.add('d-none');

                // Nếu chọn "Khác", hiện input text
                if (this.value === 'other') {
                    otherReasonContainer.classList.remove('d-none');
                    otherReasonInput.focus();
                } else {
                    otherReasonContainer.classList.add('d-none');
                    otherReasonInput.value = '';
                    otherReasonInput.classList.remove('is-invalid');
                    document.getElementById('otherReasonError').classList.add('d-none');
                }
            });

            // Ẩn lỗi khi người dùng bắt đầu nhập vào textarea "Khác"
            otherReasonInput.addEventListener('input', function() {
                if (this.value.trim() !== '') {
                    this.classList.remove('is-invalid');
                    document.getElementById('otherReasonError').classList.add('d-none');
                }
            });

            // Xử lý nút xác nhận từ chối trong modal
            document.getElementById('confirmRejectionBtn').addEventListener('click', function() {
                const selectedReason = reasonSelect.value;
                let finalReason = '';
                let hasError = false;

                // Validate: phải chọn lý do
                if (!selectedReason || selectedReason === '') {
                    reasonSelect.classList.add('is-invalid');
                    document.getElementById('rejectionSelectError').classList.remove('d-none');
                    hasError = true;
                } else {
                    reasonSelect.classList.remove('is-invalid');
                    document.getElementById('rejectionSelectError').classList.add('d-none');
                }

                // Nếu chọn "Khác", phải nhập lý do cụ thể
                if (selectedReason === 'other') {
                    const otherReason = otherReasonInput.value.trim();
                    if (otherReason === '') {
                        otherReasonInput.classList.add('is-invalid');
                        document.getElementById('otherReasonError').classList.remove('d-none');
                        hasError = true;
                    } else if (otherReason.length < 10) {
                        otherReasonInput.classList.add('is-invalid');
                        document.getElementById('otherReasonError').textContent = 'Lý do phải có ít nhất 10 ký tự!';
                        document.getElementById('otherReasonError').classList.remove('d-none');
                        hasError = true;
                    } else {
                        otherReasonInput.classList.remove('is-invalid');
                        document.getElementById('otherReasonError').classList.add('d-none');
                        finalReason = otherReason;
                    }
                } else {
                    // Lấy text của option đã chọn
                    finalReason = reasonSelect.selectedOptions[0].text;
                }

                // Nếu có lỗi, dừng lại
                if (hasError) {
                    return;
                }

                // Thêm lý do vào form và submit
                if (currentFormToSubmit) {
                    const hiddenInput = currentFormToSubmit.querySelector('.rejection-reason-input');
                    if (hiddenInput) {
                        hiddenInput.value = finalReason;
                    }
                    
                    // Đổi màu select
                    if (currentSelect) {
                        const color = currentSelect.selectedOptions[0].dataset.color || '';
                        currentSelect.className = 'form-select form-select-sm ' + color;
                        currentSelect.dataset.current = currentSelect.value;
                    }

                    // Đóng modal và submit form
                    const modal = bootstrap.Modal.getInstance(document.getElementById('rejectionModal'));
                    modal.hide();
                    currentFormToSubmit.submit();
                }
            });

            // Reset validation khi đóng modal
            document.getElementById('rejectionModal').addEventListener('hidden.bs.modal', function() {
                // Reset dropdown
                reasonSelect.value = '';
                reasonSelect.classList.remove('is-invalid');
                document.getElementById('rejectionSelectError').classList.add('d-none');
                
                // Ẩn và reset textarea "Khác"
                otherReasonContainer.classList.add('d-none');
                otherReasonInput.value = '';
                otherReasonInput.classList.remove('is-invalid');
                document.getElementById('otherReasonError').classList.add('d-none');
                document.getElementById('otherReasonError').textContent = 'Vui lòng nhập lý do cụ thể!';
                
                // Reset về trạng thái cũ nếu không submit
                if (currentSelect && currentFormToSubmit && !currentFormToSubmit.querySelector('.rejection-reason-input').value) {
                    currentSelect.value = currentSelect.dataset.current;
                }
            });
        });

        function confirmReturnStatusChange(select) {
            const newStatus = select.value;
            const newStatusText = select.selectedOptions[0].text;
            const form = select.form;

            // Nếu chọn "Từ chối", hiện modal để nhập lý do
            if (newStatus === 'rejected') {
                currentFormToSubmit = form;
                currentSelect = select;
                
                // Hiện modal
                const modal = new bootstrap.Modal(document.getElementById('rejectionModal'));
                modal.show();
                return;
            }

            // Các trạng thái khác, xác nhận bình thường
            if (confirm(`Bạn có chắc chắn muốn đổi trạng thái sang "${newStatusText}" không?`)) {
                // Nếu đồng ý, đổi màu và submit
                const color = select.selectedOptions[0].dataset.color || '';
                select.className = 'form-select form-select-sm ' + color;
                select.dataset.current = select.value;
                form.submit();
            } else {
                // Nếu cancel, trả về trạng thái cũ
                select.value = select.dataset.current;
            }
        }
    </script>
@endsection

