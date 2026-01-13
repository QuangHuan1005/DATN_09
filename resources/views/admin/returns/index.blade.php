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
                            'pending' => 'Chờ duyệt',
                            'approved' => 'Chấp nhận',
                            'returning' => 'Đang trả hàng',
                            'received' => 'Đã nhận/Kiểm tra',
                            'refund_processing' => 'Đang xử lý hoàn tiền',
                            'completed' => 'Hoàn tất',
                            'rejected' => 'Từ chối',
                            default => 'Tất cả trạng thái',
                        } }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="{{ route('admin.returns.index') }}" class="dropdown-item">Tất cả trạng thái</a>
                        <a href="{{ route('admin.returns.index', ['status' => 'pending']) }}" class="dropdown-item">Chờ duyệt</a>
                        <a href="{{ route('admin.returns.index', ['status' => 'approved']) }}" class="dropdown-item">Chấp nhận</a>
                        <a href="{{ route('admin.returns.index', ['status' => 'returning']) }}" class="dropdown-item">Đang trả hàng</a>
                        <a href="{{ route('admin.returns.index', ['status' => 'received']) }}" class="dropdown-item">Đã nhận/Kiểm tra</a>
                        <a href="{{ route('admin.returns.index', ['status' => 'refund_processing']) }}" class="dropdown-item">Đang xử lý hoàn tiền</a>
                        <a href="{{ route('admin.returns.index', ['status' => 'completed']) }}" class="dropdown-item text-success fw-bold">Hoàn tất</a>
                        <a href="{{ route('admin.returns.index', ['status' => 'rejected']) }}" class="dropdown-item text-danger">Từ chối</a>
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
                                <th>Trạng Thái Hệ Thống</th>
                                <th>Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($returns as $return)
                                @php
                                    $statusColors = [
                                        'pending'           => 'badge border border-warning text-warning',
                                        'approved'          => 'badge border border-info text-info',
                                        'returning'         => 'badge border border-primary text-primary',
                                        'received'          => 'badge border border-secondary text-secondary',
                                        'refund_processing' => 'badge border border-danger text-danger',
                                        'completed'         => 'badge border border-success text-success',
                                        'rejected'          => 'badge border border-dark text-dark',
                                    ];
                                    $statusColor = $statusColors[$return->status] ?? 'badge bg-secondary';
                                    
                                    $statusOrder = ['pending', 'approved', 'returning', 'received', 'refund_processing', 'completed'];
                                    $currentIndex = array_search($return->status, $statusOrder);
                                    $isFinal = in_array($return->status, ['completed', 'rejected']);

                                    $bankInfo = [
                                        'bank_name' => $return->refundAccount->bank_name ?? 'N/A',
                                        'account_name' => $return->refundAccount->account_holder ?? 'N/A',
                                        'account_number' => $return->refundAccount->account_number ?? 'N/A',
                                        'amount' => number_format($return->refund_amount, 0, ',', '.') . 'đ'
                                    ];
                                @endphp
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $return->order_id) }}" class="link-primary fw-bold">
                                            #{{ $return->order->order_code }}
                                        </a>
                                    </td>
                                    <td>{{ $return->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                                    <td>{{ $return->user->name ?? 'Khách lẻ' }}</td>
                                    <td class="text-danger fw-bold">{{ number_format($return->refund_amount, 0, ',', '.') }}đ</td>
                                    <td>
                                        <span class="text-truncate d-inline-block" style="max-width: 150px;" title="{{ $return->reason }}">
                                            {{ $return->reason }}
                                        </span>
                                    </td>

                                    <td>
                                        <form action="{{ route('admin.returns.updateStatus', $return->id) }}" method="POST" class="status-form" 
                                              data-bank-json="{{ json_encode($bankInfo) }}"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="rejection_reason" class="rejection-reason-input">
                                            
                                            <select name="status" 
                                                    class="form-select form-select-sm {{ $statusColor }}"
                                                    style="min-width: 165px; height: 32px;"
                                                    onchange="confirmReturnStatusChange(this)"
                                                    {{ $isFinal || $return->status === 'refund_processing' ? 'disabled' : '' }}>
                                                
                                                <option value="pending" data-color="badge border border-warning text-warning"
                                                    {{ $return->status === 'pending' ? 'selected' : '' }} {{ $currentIndex > 0 ? 'disabled' : '' }}>
                                                    Chờ duyệt
                                                </option>
                                                
                                                <option value="approved" data-color="badge border border-info text-info"
                                                    {{ $return->status === 'approved' ? 'selected' : '' }}
                                                    {{ $currentIndex > 1 ? 'disabled' : '' }}>
                                                    Chấp nhận
                                                </option>
                                                
                                                <option value="returning" data-color="badge border border-primary text-primary"
                                                    {{ $return->status === 'returning' ? 'selected' : '' }}
                                                    {{ ($currentIndex < 1 || $currentIndex > 2) && $return->status !== 'returning' ? 'disabled' : '' }}>
                                                    Đang trả hàng
                                                </option>
                                                
                                                <option value="received" data-color="badge border border-secondary text-secondary"
                                                    {{ $return->status === 'received' ? 'selected' : '' }}
                                                    {{ ($currentIndex < 2 || $currentIndex > 3) && $return->status !== 'received' ? 'disabled' : '' }}>
                                                    Đã nhận hàng
                                                </option>

                                                <option value="refund_processing" data-color="badge border border-danger text-danger"
                                                    {{ $return->status === 'refund_processing' ? 'selected' : '' }}
                                                    {{ ($currentIndex < 3 || $currentIndex > 4) && $return->status !== 'refund_processing' ? 'disabled' : '' }}>
                                                    Đang hoàn tiền
                                                </option>

                                                <option value="completed" data-color="badge border border-success text-success"
                                                    {{ $return->status === 'completed' ? 'selected' : '' }}
                                                    disabled> 
                                                    Hoàn tất 
                                                </option>
                                                
                                                <option value="rejected" data-color="badge border border-dark text-dark"
                                                    {{ $return->status === 'rejected' ? 'selected' : '' }}>
                                                    Từ chối
                                                </option>
                                            </select>
                                        </form>
                                    </td>

                                    <td>
                                        <a href="{{ route('admin.returns.show', $return->id) }}" class="btn btn-sm btn-soft-info">
                                            <i class="bx bx-show align-middle"></i>
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

    {{-- Modal Từ chối --}}
    <div class="modal fade" id="rejectionModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title text-white">Từ chối yêu cầu hoàn hàng</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Lý do từ chối cụ thể <span class="text-danger">*</span></label>
                        <select class="form-select mb-2" id="rejectionReasonSelect">
                            <option value="" selected disabled>-- Chọn lý do --</option>
                            <option value="Hàng không đạt chất lượng/Bị tráo đổi">Hàng không đạt chất lượng/Bị tráo đổi</option>
                            <option value="Sản phẩm bị hư hỏng do khách hàng">Sản phẩm bị hư hỏng do khách hàng</option>
                            <option value="Quá thời gian quy định">Quá thời gian quy định</option>
                            <option value="other">Khác...</option>
                        </select>
                        <textarea class="form-control d-none" id="otherReasonInput" rows="3" placeholder="Nhập lý do chi tiết"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-danger" id="confirmRejectionBtn">Xác nhận Từ chối</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Hoàn tiền --}}
    <div class="modal fade" id="refundModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title text-white"><i class='mdi mdi-bank me-1'></i> Minh chứng hoàn tiền</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="refundForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="card bg-light border-0 mb-3">
                            <div class="card-body p-3">
                                <h6 class="fw-bold text-success mb-2 small text-uppercase">Thông tin nhận tiền (Từ User)</h6>
                                <div class="row g-2">
                                    <div class="col-5 text-muted small">Ngân hàng:</div>
                                    <div class="col-7 fw-bold small" id="bank_name_display">-</div>
                                    <div class="col-5 text-muted small">Chủ tài khoản:</div>
                                    <div class="col-7 fw-bold small" id="account_name_display">-</div>
                                    <div class="col-5 text-muted small">Số tài khoản:</div>
                                    <div class="col-7 fw-bold small text-primary" id="account_number_display">-</div>
                                    <div class="col-5 text-muted small">Số tiền hoàn:</div>
                                    <div class="col-7 fw-bold text-danger fs-15" id="refund_amount_display">0đ</div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="status" value="refund_processing">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Ảnh biên lai giao dịch <span class="text-danger">*</span></label>
                            <input type="file" name="admin_refund_proof" class="form-control" accept="image/*" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-success fw-bold">Xác nhận Đã Chuyển Tiền</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let currentFormToSubmit = null;
        let currentSelect = null;

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('select[name="status"]').forEach(select => {
                updateSelectColor(select);
                select.dataset.current = select.value;
            });

            const reasonSelect = document.getElementById('rejectionReasonSelect');
            const otherInput = document.getElementById('otherReasonInput');
            reasonSelect.addEventListener('change', function() {
                if (this.value === 'other') otherInput.classList.remove('d-none');
                else otherInput.classList.add('d-none');
            });

            document.getElementById('confirmRejectionBtn').addEventListener('click', function() {
                const choice = reasonSelect.value;
                let final = choice === 'other' ? otherInput.value.trim() : reasonSelect.options[reasonSelect.selectedIndex].text;
                if (!final || final === "-- Chọn lý do --") return alert("Vui lòng nhập lý do!");
                if (currentFormToSubmit) {
                    currentFormToSubmit.querySelector('.rejection-reason-input').value = final;
                    currentFormToSubmit.submit();
                }
            });

            ['rejectionModal', 'refundModal'].forEach(id => {
                const el = document.getElementById(id);
                if(el){
                    el.addEventListener('hidden.bs.modal', function() {
                        if (currentSelect) {
                            currentSelect.value = currentSelect.dataset.current;
                            updateSelectColor(currentSelect);
                        }
                    });
                }
            });
        });

        function updateSelectColor(select) {
            const selectedOption = select.selectedOptions[0];
            if (selectedOption && selectedOption.dataset.color) {
                select.className = 'form-select form-select-sm ' + selectedOption.dataset.color;
            }
        }

        function confirmReturnStatusChange(select) {
            const newStatus = select.value;
            const form = select.closest('form');
            currentSelect = select;
            currentFormToSubmit = form;

            updateSelectColor(select);

            if (newStatus === 'rejected') {
                new bootstrap.Modal(document.getElementById('rejectionModal')).show();
                return;
            }

            if (newStatus === 'refund_processing') {
                try {
                    const bankData = JSON.parse(form.dataset.bankJson);
                    document.getElementById('bank_name_display').innerText = bankData.bank_name;
                    document.getElementById('account_name_display').innerText = bankData.account_name;
                    document.getElementById('account_number_display').innerText = bankData.account_number;
                    document.getElementById('refund_amount_display').innerText = bankData.amount;
                    document.getElementById('refundForm').action = form.action;
                    new bootstrap.Modal(document.getElementById('refundModal')).show();
                } catch (e) {
                    alert("Lỗi dữ liệu ngân hàng!");
                }
                return;
            }

            if (confirm("Chuyển trạng thái sang: " + select.selectedOptions[0].text + "?")) {
                form.submit();
            } else {
                select.value = select.dataset.current;
                updateSelectColor(select);
            }
        }
    </script>
    
    <style>
        .badge.border { padding: 4px 10px; font-weight: 600; text-transform: uppercase; font-size: 10px; }
        .btn-soft-info { background: rgba(59, 175, 218, 0.1); color: #3bafda; border: none; }
    </style>
@endsection