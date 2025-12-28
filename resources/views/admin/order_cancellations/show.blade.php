@extends('admin.master')

@section('content')
<div class="container-xxl">
    {{-- TIÊU ĐỀ TRANG --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="fw-bold mb-0">
            Xử Lý Yêu Cầu Hủy Đơn Hàng #{{ $order->order_code ?? 'N/A' }}
        </h3>
        <a href="{{ route('admin.order-cancellations.index') }}" class="btn btn-outline-secondary btn-sm">
            <iconify-icon icon="solar:arrow-left-broken" class="align-middle"></iconify-icon> Quay lại danh sách
        </a>
    </div>

    {{-- THÔNG BÁO --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        {{-- CỘT TRÁI --}}
        <div class="col-xl-8 col-lg-7">
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-header bg-light-subtle py-3">
                    <h5 class="mb-0 fw-bold">Thông Tin Yêu Cầu Hủy</h5>
                </div>
                <div class="card-body">
                    @php
                        $statusSlug = $request->status ?? 'pending';
                        $badgeClass = match ($statusSlug) {
                            'pending'  => 'badge bg-warning text-dark',
                            'accepted' => 'badge bg-success',
                            'rejected' => 'badge bg-danger',
                            'refunded' => 'badge bg-info', 
                            default    => 'badge bg-secondary',
                        };

                        $canceledBy = match($request->cancel_by) {
                            'user', 'customer' => 'Khách hàng',
                            'admin' => 'Quản trị viên',
                            default => 'Không xác định',
                        };
                    @endphp

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <dl class="row mb-0">
                                <dt class="col-sm-5 mb-2">Trạng thái:</dt>
                                <dd class="col-sm-7 mb-2">
                                    <span class="{{ $badgeClass }} px-2 py-1">
                                        {{ $request->cancelStatus->name ?? ucfirst($statusSlug) }}
                                    </span>
                                </dd>
                                <dt class="col-sm-5 mb-2">Người gửi:</dt>
                                <dd class="col-sm-7 mb-2 fw-semibold text-primary">{{ $canceledBy }}</dd>
                                <dt class="col-sm-5 mb-2">Ngày gửi:</dt>
                                <dd class="col-sm-7 mb-2 text-muted small">
                                    {{ $request->created_at ? $request->created_at->format('H:i d/m/Y') : 'N/A' }}
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-6 border-start">
                            <h6 class="text-danger fw-bold"><i class="bx bx-error-circle"></i> Lý do từ khách hàng:</h6>
                            <p class="italic text-dark p-2 bg-light rounded border-start border-danger border-3">
                                "{{ $request->reason_user ?: '(Không có lý do)' }}"
                            </p>
                        </div>
                    </div>

                    {{-- THÔNG TIN NGÂN HÀNG --}}
                    @if((int)$order->payment_method_id !== 1)
    <div class="card mt-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">THÔNG TIN HOÀN TIỀN KHÁCH CUNG CẤP</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <strong>Ngân hàng:</strong> {{ $request->bank_name ?? 'N/A' }}
                </div>
                <div class="col-md-4">
                    <strong>Số tài khoản:</strong> {{ $request->account_number ?? 'N/A' }}
                </div>
                <div class="col-md-4">
                    <strong>Chủ TK:</strong> {{ $request->account_holder ?? 'N/A' }}
                </div>
            </div>
        </div>
    </div>
@endif

                    <hr class="my-4">

                    {{-- FORM XỬ LÝ QUY TRÌNH --}}
                    @if($request->status == 'pending')
                        <h5 class="fw-bold mb-3 text-dark">Quyết Định Xử Lý</h5>
                        <form action="{{ route('admin.order-cancellations.process', $request->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Phản hồi của Admin (Gửi cho khách): <span class="text-danger">*</span></label>
                                <textarea name="reason_admin" class="form-control @error('reason_admin') is-invalid @enderror" rows="3" placeholder="Ví dụ: Đã xác nhận hoàn tiền cho quý khách...">{{ old('reason_admin') }}</textarea>
                                @error('reason_admin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" name="action" value="accept" class="btn btn-success flex-grow-1 py-2" onclick="return confirm('Xác nhận CHẤP NHẬN hủy đơn và HOÀN KHO?')">
                                    Chấp Nhận & Hoàn Kho
                                </button>
                                <button type="submit" name="action" value="reject" class="btn btn-danger flex-grow-1 py-2" onclick="return confirm('Xác nhận TỪ CHỐI yêu cầu hủy đơn?')">
                                    Từ Chối Yêu Cầu
                                </button>
                            </div>
                        </form>

                    @elseif($request->status == 'accepted')
                        <div class="alert alert-success border-0 p-3 shadow-sm">
                            <h6 class="fw-bold text-success"><i class="bx bxs-check-circle"></i> Đã chấp nhận yêu cầu hủy</h6>
                            
                            @if($order->payment_method_id == 1)
                                <p class="mb-0">Đơn hàng thanh toán <strong>COD</strong>. Quy trình đã hoàn tất tự động.</p>
                            @else
                                <p class="mb-3">Vui lòng thực hiện chuyển khoản cho khách hàng, sau đó tải ảnh minh chứng để xác nhận hoàn tiền.</p>
                                <form action="{{ route('admin.order-cancellations.confirm-refund', $request->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-dark">Minh chứng hoàn tiền (Ảnh chụp màn hình): <span class="text-danger">*</span></label>
                                        <input type="file" name="refund_image" class="form-control @error('refund_image') is-invalid @enderror" accept="image/*" required>
                                        @error('refund_image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    </div>
                                    <button type="submit" class="btn btn-success w-100 py-2">
                                        <i class="bx bx-upload"></i> Xác nhận & Tải ảnh minh chứng
                                    </button>
                                </form>
                            @endif
                        </div>

                    @elseif($request->status == 'refunded')
                        <div class="alert alert-info border-0 p-3 shadow-sm">
                            <h6 class="fw-bold text-info"><i class="bx bxs-badge-check"></i> Quy trình hoàn tất</h6>
                            <p class="mb-1"><strong>Ghi chú Admin:</strong> {{ $request->reason_admin }}</p>
                            <p class="mb-2 text-success fw-bold"><i class="bx bx-check"></i> 
                                {{ $order->payment_method_id == 1 ? 'Đơn hàng COD đã hủy thành công.' : 'Tiền đã được hoàn trả thành công.' }}
                            </p>
                            
                            @if($request->refund_image)
                                <div class="mt-3 p-2 bg-white rounded border">
                                    <p class="small fw-bold mb-2 text-dark">Ảnh minh chứng hoàn tiền:</p>
                                    <a href="{{ asset('storage/refunds/' . $request->refund_image) }}" target="_blank">
                                        <img src="{{ asset('storage/refunds/' . $request->refund_image) }}" class="img-fluid rounded shadow-sm" style="max-width: 250px; cursor: zoom-in;">
                                    </a>
                                </div>
                            @endif
                            <div class="mt-2">
                                <small class="text-muted">Hoàn tất lúc: {{ $request->updated_at->format('H:i d/m/Y') }}</small>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-danger border-0 p-3 shadow-sm">
                            <h6 class="fw-bold"><i class="bx bxs-x-circle"></i> Yêu cầu đã bị từ chối</h6>
                            <p class="mb-1"><strong>Lý do từ chối:</strong> {{ $request->reason_admin }}</p>
                            <small class="text-muted">Lúc: {{ $request->updated_at->format('H:i d/m/Y') }}</small>
                        </div>
                    @endif
                </div>
            </div>

            {{-- DANH SÁCH SẢN PHẨM --}}
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light-subtle py-3"><h5 class="mb-0 fw-bold">Sản Phẩm Trong Đơn</h5></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-3">Sản phẩm</th>
                                    <th>Phân loại</th>
                                    <th>Đơn giá</th>
                                    <th>Số lượng</th>
                                    <th class="text-end pe-3">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->details as $line)
                                <tr>
                                    <td class="ps-3">
                                        <div class="fw-bold">{{ $line->productVariant->product->name ?? 'N/A' }}</div>
                                    </td>
                                    <td>{{ $line->productVariant->size->name ?? '' }} / {{ $line->productVariant->color->name ?? '' }}</td>
                                    <td>{{ number_format($line->price) }}₫</td>
                                    <td>{{ $line->quantity }}</td>
                                    <td class="text-end pe-3 fw-bold">{{ number_format($line->quantity * $line->price) }}₫</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- CỘT PHẢI --}}
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light-subtle py-3"><h5 class="mb-0 fw-bold">Tóm Tắt Thanh Toán</h5></div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tạm tính:</span>
                        <span class="fw-medium text-dark">{{ number_format($calc_subtotal) }}₫</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Giảm giá:</span>
                        <span class="text-danger">-{{ number_format($calc_discount) }}₫</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Phí vận chuyển:</span>
                        <span class="fw-medium text-dark">{{ number_format($order->shipping_fee ?? 30000) }}₫</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Tổng tiền hoàn:</h5>
                        <h4 class="mb-0 fw-bold text-success">{{ number_format($calc_total + ($order->shipping_fee ?? 30000)) }}₫</h4>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light-subtle py-3"><h5 class="mb-0 fw-bold">Thông Tin Khách Hàng</h5></div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar avatar-md bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold fs-4 me-3" style="width: 50px; height: 50px;">
                            {{ mb_substr($order->name, 0, 1) }}
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">{{ $order->name }}</h6>
                            <p class="mb-0 small text-muted">{{ $order->user->email ?? 'Khách lẻ' }}</p>
                        </div>
                    </div>
                    <p class="mb-1"><strong>Điện thoại:</strong> {{ $order->phone }}</p>
                    <p class="mb-0"><strong>Địa chỉ:</strong> <span class="small">{{ $order->address }}</span></p>
                </div>
                <div class="card-footer bg-light-subtle border-0">
                    <small class="text-muted">Trạng thái đơn hàng:</small>
                    <span class="badge bg-info-subtle text-info float-end">{{ $order->status->name ?? 'N/A' }}</span>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-bold mb-2">Trạng thái tài chính:</h6>
                    @if($order->payment_status_id == 5)
                        <div class="alert alert-success d-flex align-items-center mb-0 p-2">
                            <i class="bx bxs-check-shield fs-4 me-2"></i> Đã hoàn tiền xong
                        </div>
                    @elseif($order->payment_status_id == 4)
                        <div class="alert alert-warning d-flex align-items-center mb-0 p-2">
                            <i class="bx bx-time-five fs-4 me-2"></i> Đang chờ chuyển khoản
                        </div>
                    @else
                        <div class="text-muted fw-bold">{{ $order->paymentStatus->name ?? 'N/A' }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection