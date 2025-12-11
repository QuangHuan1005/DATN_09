@extends('admin.master')

@section('content')
    <div class="container-xxl">

        <div class="row">
            <!-- Cột trái: Thông tin người dùng -->
            <div class="col-lg-4">
                <!-- Thông tin cơ bản -->
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="bg-primary profile-bg rounded-top p-5 position-relative mx-n3 mt-n3">
                            <img src="{{ $users->image ? asset('storage/' . $users->image) : asset('assets/images/users/avatar-2.jpg') }}"
                                alt="{{ $users->name }}"
                                class="avatar-lg border border-light border-3 rounded-circle position-absolute top-100 start-0 translate-middle ms-5">
                        </div>

                        <div class="mt-4 pt-3">
                            <h4 class="mb-1">
                                {{ $users->name }}
                                @if ($users->is_verified)
                                    <i class="bx bxs-badge-check text-success align-middle"></i>
                                @endif
                            </h4>
                            <div class="mt-2">
                                <a href="#!"
                                    class="link-primary fs-15">{{ Str::slug($users->name, '_') . '_' . $users->id }}</a>
                                <p class="fs-15 mb-1 mt-1"><span class="fw-semibold text-dark">Email:</span>
                                    {{ $users->email }}</p>
                                <p class="fs-15 mb-0 mt-1"><span class="fw-semibold text-dark">Phone:</span>
                                    {{ $users->phone ?? 'Chưa cập nhật' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-top gap-1 hstack">
                        <a href="#!" class="btn btn-primary w-100">Gửi tin nhắn</a>
                        <a href="#!" class="btn btn-light w-100">Phân tích</a>
                        <a href="{{ route('admin.users.edit', $users->id) }}"
                            class="btn btn-soft-dark d-inline-flex align-items-center justify-content-center rounded avatar-sm">
                            <i class="bx bx-edit-alt fs-18"></i>
                        </a>
                    </div>
                </div>

                <!-- Chi tiết khách hàng -->
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h4 class="card-title">Chi tiết khách hàng</h4>
                        <span
                            class="badge {{ $users->is_locked ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success' }}">
                            {{ $users->is_locked ? 'Tài khoản bị khóa' : 'Đang hoạt động' }}
                        </span>
                    </div>
                    <div class="card-body py-2">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <tbody>
                                    <tr>
                                        <td class="px-0 fw-semibold text-dark">Account ID:</td>
                                        <td class="px-0 text-dark">#USR{{ str_pad($users->id, 6, '0', STR_PAD_LEFT) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="px-0 fw-semibold text-dark">Email hóa đơn:</td>
                                        <td class="px-0 text-dark">{{ $users->email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="px-0 fw-semibold text-dark">Địa chỉ giao hàng:</td>
                                        <td class="px-0 text-dark">{{ $users->address ?? 'Chưa cập nhật' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="px-0 fw-semibold text-dark">Ngôn ngữ:</td>
                                        <td class="px-0 text-dark">Tiếng Việt</td>
                                    </tr>
                                    <tr>
                                        <td class="px-0 fw-semibold text-dark">Mã đơn gần nhất:</td>
                                        <td class="px-0 text-dark">{{ $latestOrder->code ?? 'Chưa có đơn hàng' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Hóa đơn gần nhất -->
                <div class="card">
                    <div class="card-header border-bottom border-dashed d-flex align-items-center justify-content-between">
                        <h4 class="card-title mb-0">Hóa đơn gần nhất</h4>
                        <a href="#!" class="btn btn-primary btn-sm">Xem tất cả</a>
                    </div>
                    <div class="card-body">
                        {{-- @forelse($invoices as $invoice)
                        <div class="d-flex p-2 rounded align-items-center gap-2 bg-light-subtle mb-2">
                            <div class="avatar bg-primary-subtle d-flex align-items-center justify-content-center rounded-circle">
                                <iconify-icon icon="solar:file-download-bold" class="text-primary fs-3"></iconify-icon>
                            </div>
                            <div class="d-block">
                                <a href="#!" class="text-dark fw-medium">Hóa đơn #{{ $invoice->code }}</a>
                                <p class="text-muted mb-0 fs-13">{{ $invoice->created_at->format('d M Y') }}</p>
                            </div>
                            <div class="ms-auto">
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle arrow-none card-drop p-0" data-bs-toggle="dropdown">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="#" class="dropdown-item">Tải xuống</a>
                                        <a href="#" class="dropdown-item">Chia sẻ</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Không có hóa đơn nào.</p>
                    @endforelse --}}
                    </div>
                </div>
            </div>

            <!-- Cột phải -->
            <div class="col-lg-8">
                <!-- Thống kê -->
                <div class="row">
                    <div class="col-lg-4">
                        <x-admin.stat-card title="Tổng hóa đơn" value="{{ $invoiceCount }}"
                            icon="solar:bill-list-bold-duotone" />
                    </div>
                    <div class="col-lg-4">
                        <x-admin.stat-card title="Tổng đơn hàng" value="{{ $orderCount }}"
                            icon="solar:box-bold-duotone" />
                    </div>
                    <div class="col-lg-4">
                        <x-admin.stat-card title="Tổng chi tiêu" value="{{ number_format($totalExpense, 0, ',', '.') }}₫"
                            icon="solar:chat-round-money-bold-duotone" />
                    </div>
                </div>

                <!-- Lịch sử giao dịch -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h4 class="card-title">Lịch sử giao dịch</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0 table-hover table-centered">
                                <thead class="bg-light-subtle">
                                    <tr>
                                        <th>Mã HĐ</th>
                                        <th>Trạng thái</th>
                                        <th>Tổng tiền</th>
                                        <th>Ngày thanh toán</th>
                                        <th>Phương thức</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $t)
                                        <tr>
                                            <td><a href="#" class="text-body">#{{ $t->order_code }}</a></td>
                                            <td>
                                                @php
                                                    $badgeClass = match ($t->order_status_id) {
                                                        1 => 'bg-primary-subtle text-primary',
                                                        2 => 'bg-warning-subtle text-warning',
                                                        3 => 'bg-success-subtle text-success',
                                                        4 => 'bg-success-subtle text-success',
                                                        5 => 'bg-primary-subtle text-primary',
                                                        6 => 'bg-danger-subtle text-danger',
                                                        default => 'bg-secondary-subtle text-secondary',
                                                    };
                                                @endphp
                                                <span class="badge {{ $badgeClass }} py-1 px-2 text-capitalize">
                                                    {{ $t->status->name }}
                                                </span>
                                            </td>
                                            <td>{{ number_format($t->total_amount, 0, ',', '.') }}₫</td>
                                            <td>{{ $t->created_at->format('d M, Y') }}</td>
                                            <td>{{ ucfirst($t->payment_method) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Chưa có giao dịch nào.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer border-top">
                        {{-- {{ $transactions->links('pagination::bootstrap-5') }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
