@extends('admin.master')

@section('content')
    <div class="container-xxl">

        <div class="row">
            {{-- CỘT TRÁI: THÔNG TIN KHÁCH HÀNG --}}
            <div class="col-lg-4">
                {{-- Profile card --}}
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="bg-primary profile-bg rounded-top p-5 position-relative mx-n3 mt-n3">
                            <img src="{{ $users->image ? asset('storage/' . $users->image) : asset('assets/images/users/avatar-2.jpg') }}"
                                alt="avatar"
                                class="avatar-lg border border-light border-3 rounded-circle position-absolute top-100 start-0 translate-middle ms-5">
                        </div>
                        <div class="mt-4 pt-3">
                            <h4 class="mb-1">
                                {{ $users->name }}
                                <i class="bx bxs-badge-check text-success align-middle"></i>
                            </h4>
                            <div class="mt-2">
                                {{-- nếu có username thì show, không thì dùng email --}}
                                <a href="#!" class="link-primary fs-15">
                                    {{ '@' . ($users->username ?? Str::before($users->email, '@')) }}
                                </a>
                                <p class="fs-15 mb-1 mt-1">
                                    <span class="text-dark fw-semibold">Email : </span>
                                    {{ $users->email }}
                                </p>
                                <p class="fs-15 mb-0 mt-1">
                                    <span class="text-dark fw-semibold">Số Điện thoại : </span>
                                    {{ $users->phone ?? 'Chưa cập nhật' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="card-footer border-top gap-1 hstack">
                        <a href="#!" class="btn btn-primary w-100">Send Message</a>
                        <a href="#!" class="btn btn-light w-100">Analytics</a>
                        <a href="#!"
                            class="btn btn-soft-dark d-inline-flex align-items-center justify-content-center rounded avatar-sm">
                            <i class="bx bx-edit-alt fs-18"></i>
                        </a>
                    </div> --}}
                </div>

                {{-- Customer Details --}}
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="card-title">Chi Tiết Khách Hàng</h4>
                        </div>
                        <div>
                            <span class="badge bg-success-subtle text-success px-2 py-1">
                                {{ $users->is_locked ? 'Tài khoản bị khóa' : 'Đang hoạt động' }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body py-2">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <tbody>
                                    <tr>
                                        <td class="px-0 fw-semibold text-dark">ID:</td>
                                        <td class="px-0 text-dark">#USR{{ str_pad($users->id, 3, '0', STR_PAD_LEFT) }}</td>

                                    </tr>
                                    <tr>
                                        <td class="px-0 fw-semibold text-dark">Email hóa đơn:</td>
                                        <td class="px-0 text-dark">{{ $users->email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="px-0 fw-semibold text-dark">Địa chỉ giao hàng:</td>
                                        <td class="px-0 text-dark">{{ $users->address ?? 'Chưa cập nhật' }}</td>
                                    </tr>
                                    {{-- <tr>
                                        <td class="px-0 fw-semibold text-dark">Ngôn ngữ:</td>
                                        <td class="px-0 text-dark">Tiếng Việt</td>
                                    </tr>
                                    <tr>
                                        <td class="px-0 fw-semibold text-dark">Mã đơn gần nhất:</td>
                                        <td class="px-0 text-dark">{{ $latestOrder->code ?? 'Chưa có đơn hàng' }}</td>
                                    </tr> --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Latest Invoice --}}
                {{-- <div class="card">
                    <div class="card-header border-bottom border-dashed">
                        <div class="d-flex align-items-center gap-2">
                            <div class="d-block">
                                <h4 class="card-title mb-1">Hóa Đơn Mới Nhất</h4>
                                <p class="mb-0 text-muted">
                                    Tất cả {{ $totalInvoices ?? 0 }} hóa đơn
                                </p>
                            </div>
                            <div class="ms-auto">
                                <a href="{{ route('admin.invoices.index') }}" class="btn btn-primary btn-sm">View All</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @forelse($latestInvoices as $invoice)
                            <div class="d-flex p-2 rounded align-items-center gap-2 bg-light-subtle {{ !$loop->first ? 'mt-2' : '' }}">
                                <div class="avatar bg-primary-subtle d-flex align-items-center justify-content-center rounded-circle">
                                    <iconify-icon icon="solar:file-download-bold" class="text-primary fs-3"></iconify-icon>
                                </div>
                                <div class="d-block">
                                    <a href="{{ route('admin.invoices.show', $invoice->id) }}" class="text-dark fw-medium">
                                        Invoice Id {{ $invoice->invoice_code }}
                                    </a>
                                    <p class="text-muted mb-0 fs-13">
                                        {{ optional($invoice->issue_date)->format('d M Y') }}
                                    </p>
                                </div>
                                <div class="ms-auto text-end">
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle arrow-none card-drop p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="{{ route('admin.invoices.download', $invoice->id) }}" class="dropdown-item">Download</a>
                                            <a href="{{ route('admin.invoices.show', $invoice->id) }}" class="dropdown-item">View Detail</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No invoices yet.</p>
                        @endforelse
                    </div>
                </div> --}}
            </div>

            {{-- CỘT PHẢI --}}
            <div class="col-lg-8">
                <div class="row">
                    {{-- Total Invoice --}}
                    {{-- <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h4 class="card-title mb-2 d-flex align-items-center gap-2">Tổng Hóa Đơn</h4>
                                        <p class="text-muted fw-medium fs-22 mb-0">
                                            {{ $totalInvoices ?? 0 }}
                                        </p>
                                    </div>
                                    <div>
                                        <div class="avatar-md bg-primary bg-opacity-10 rounded">
                                            <iconify-icon icon="solar:bill-list-bold-duotone"
                                                class="fs-32 text-primary avatar-title"></iconify-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    {{-- Total Order --}}
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h4 class="card-title mb-2 d-flex align-items-center gap-2">Tổng Đơn Hàng</h4>
                                        <p class="text-muted fw-medium fs-22 mb-0">
                                            {{ $totalOrders ?? 0 }}
                                        </p>
                                    </div>
                                    <div>
                                        <div class="avatar-md bg-primary bg-opacity-10 rounded">
                                            <iconify-icon icon="solar:box-bold-duotone"
                                                class="fs-32 text-primary avatar-title"></iconify-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Total Expense --}}
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h4 class="card-title mb-2 d-flex align-items-center gap-2">Tổng Chi Phí</h4>
                                        <p class="text-muted fw-medium fs-22 mb-0">
                                            {{ number_format($totalExpense ?? 0, 0, ',', '.') }}₫
                                        </p>
                                    </div>
                                    <div>
                                        <div class="avatar-md bg-primary bg-opacity-10 rounded">
                                            <iconify-icon icon="solar:chat-round-money-bold-duotone"
                                                class="fs-32 text-primary avatar-title"></iconify-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TRANSACTION HISTORY --}}
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Lịch Sử Giao Dịch</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0 table-hover table-centered">
                                <thead class="bg-light-subtle">
                                    <th>Mã HĐ</th>
                                    <th>Trạng thái</th>
                                    <th>Tổng tiền</th>
                                    <th>Ngày thanh toán</th>
                                    <th>Phương thức</th>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.orders.show', $order->id) }}" class="text-body">
                                                    {{ $order->order_code }}
                                                </a>
                                            </td>
                                            <td>
                                                @php
                                                    $badgeClass = match ($order->order_status_id) {
                                                        1 => 'bg-secondary-subtle text-secondary',
                                                        2 => 'bg-primary-subtle text-primary',
                                                        3 => 'bg-warning-subtle text-warning',
                                                        4 => 'bg-info-subtle text-info',
                                                        5 => 'bg-success-subtle text-success',
                                                        6 => 'bg-danger-subtle text-danger',
                                                        default => 'bg-dark-subtle text-dark',
                                                    };
                                                @endphp
                                                <span class="badge {{ $badgeClass }} py-1 px-2 text-capitalize">
                                                    {{ $order->status->name }}
                                                </span>
                                            </td>
                                            <td>
                                                {{ number_format($order->total_amount, 0, ',', '.') }}₫
                                            </td>
                                            <td>
                                                {{ $order->created_at->translatedFormat('d M, Y') }}
                                            </td>
                                            <td>{{ $order->payment?->paymentMethod?->code ?? 'Chưa thanh toán' }}</td>


                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">
                                                Không có giao dịch nào.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Pagination orders --}}
                    <div class="card-footer border-top">
                        {{ $orders->links('pagination::bootstrap-5') }}
                    </div>
                </div>

                {{-- Phần dưới anh có thể giữ nguyên template cũ hoặc bind thêm dữ liệu nếu muốn --}}
                {{-- ... các card Points, Payment Arrived, chart ... --}}
            </div>
        </div>

    </div>
@endsection
