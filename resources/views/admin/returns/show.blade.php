@extends('admin.master')

@section('content')
    <div class="container-xxl">
        <div class="row">
            <div class="col-xl-9 col-lg-8">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                                    <div>
                                        <h4 class="fw-medium text-dark d-flex align-items-center gap-2">
                                            Yêu cầu hoàn hàng #{{ $return->order->order_code }}
                                            @php
                                                $statusColors = [
                                                    'pending' => 'badge border border-warning text-warning',
                                                    'approved' => 'badge border border-info text-info',
                                                    'waiting_for_return' => 'badge border border-primary text-primary',
                                                    'returned' => 'badge border border-success text-success',
                                                    'refunded' => 'badge border border-success text-success',
                                                    'rejected' => 'badge border border-danger text-danger',
                                                ];
                                                $color = $statusColors[$return->status] ?? 'badge border border-secondary text-secondary';
                                            @endphp
                                            <span class="{{ $color }} fs-13 px-2 py-1 rounded">
                                                {{ $return->status_label }}
                                            </span>
                                        </h4>
                                        <p class="mb-0">Return Request / Details / #{{ $return->order->order_code }} -
                                            {{ $return->created_at ? $return->created_at->format('d/m/Y H:i') : '-' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <h4 class="fw-medium text-dark">Tiến độ hoàn hàng</h4>
                                </div>

                                @php
                                    $steps = [
                                        ['status' => 'pending', 'label' => 'Chờ xác nhận'],
                                        ['status' => 'approved', 'label' => 'Đã chấp nhận'],
                                        ['status' => 'waiting_for_return', 'label' => 'Chờ gửi hàng'],
                                        ['status' => 'returned', 'label' => 'Đã nhận hàng'],
                                        ['status' => 'refunded', 'label' => 'Đã hoàn tiền'],
                                    ];
                                    $currentStatus = $return->status;
                                    $isRejected = $currentStatus === 'rejected';
                                    $statusIndexMap = [
                                        'pending' => 1, 'approved' => 2, 'waiting_for_return' => 3,
                                        'returned' => 4, 'refunded' => 5, 'rejected' => 1,
                                    ];
                                    $currentStep = $statusIndexMap[$currentStatus] ?? 1;

                                    $calc = function ($stepIndex) use ($currentStep, $isRejected) {
                                        if ($isRejected) {
                                            return [
                                                'width' => $stepIndex === 1 ? 100 : 0,
                                                'bar' => 'bg-danger',
                                                'state' => $stepIndex === 1 ? 'rejected' : 'todo',
                                                'animated' => false,
                                            ];
                                        }
                                        if ($stepIndex < $currentStep) {
                                            return ['width' => 100, 'bar' => 'bg-success', 'state' => 'done', 'animated' => true];
                                        }
                                        if ($stepIndex === $currentStep) {
                                            $isComplete = in_array($stepIndex, [4, 5]);
                                            return [
                                                'width' => $isComplete ? 100 : 60,
                                                'bar' => $isComplete ? 'bg-success' : 'bg-warning',
                                                'state' => $isComplete ? 'done' : 'active',
                                                'animated' => true,
                                            ];
                                        }
                                        return ['width' => 0, 'bar' => 'bg-light', 'state' => 'todo', 'animated' => false];
                                    };
                                @endphp

                                <div class="row row-cols-xxl-5 row-cols-md-2 row-cols-1 g-3">
                                    @foreach ($steps as $index => $step)
                                        @php $s = $calc($index + 1); @endphp
                                        <div class="col">
                                            <div class="progress mt-3" style="height: 8px;">
                                                <div class="progress-bar progress-bar-striped {{ $s['animated'] ? 'progress-bar-animated' : '' }} {{ $s['bar'] }}"
                                                    role="progressbar" style="width: {{ $s['width'] }}%"></div>
                                            </div>
                                            <div class="d-flex align-items-center gap-2 mt-2">
                                                @if ($s['state'] === 'active')
                                                    <p class="mb-0 fs-13">{{ $step['label'] }}</p>
                                                    <div class="spinner-border spinner-border-sm text-warning" role="status"></div>
                                                @elseif($s['state'] === 'done')
                                                    <p class="mb-0 fs-13">{{ $step['label'] }}</p>
                                                    <i class="bx bx-check-circle text-success"></i>
                                                @elseif($s['state'] === 'rejected')
                                                    <p class="mb-0 text-danger fw-semibold fs-13">Từ chối</p>
                                                    <i class="bx bx-x-circle text-danger"></i>
                                                @else
                                                    <p class="mb-0 fs-13 text-muted">{{ $step['label'] }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="card-footer d-flex flex-wrap align-items-center justify-content-between bg-light-subtle gap-2">
                                <p class="border rounded mb-0 px-2 py-1 bg-body fs-13">
                                    <i class='bx bx-calendar align-middle fs-16'></i> Ngày yêu cầu:
                                    <span class="text-dark fw-medium">{{ $return->created_at ? $return->created_at->format('d/m/Y H:i') : '-' }}</span>
                                </p>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.returns.index') }}" class="btn btn-outline-secondary btn-sm">Quay lại</a>
                                    {{-- Nút cập nhật trạng thái có thể thêm ở đây --}}
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header"><h4 class="card-title">Sản Phẩm Hoàn Trả</h4></div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table align-middle mb-0 table-hover">
                                        <thead class="bg-light-subtle border-bottom">
                                            <tr>
                                                <th>Sản Phẩm</th>
                                                <th>Giá Hoàn</th>
                                                <th>Số Lượng</th>
                                                <th class="text-end">Thành Tiền</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $productDetails = is_array($return->product_details) 
                                                    ? $return->product_details 
                                                    : json_decode($return->product_details, true);
                                            @endphp
                                            
                                            @if(!empty($productDetails))
                                                @foreach($productDetails as $item)
                                                    @php
                                                        // FIX LỖI: Kiểm tra key an toàn bằng ?? null
                                                        $orderDetailId = $item['order_detail_id'] ?? null;
                                                        $variantId = $item['product_variant_id'] ?? null;

                                                        // Tìm chi tiết đơn hàng (Thử theo ID detail trước, sau đó thử theo Variant ID)
                                                        $detail = $return->order->details->where('id', $orderDetailId)->first() 
                                                                ?? $return->order->details->where('product_variant_id', $variantId)->first();

                                                        if (!$detail) continue;
                                                        
                                                        $variant = $detail->productVariant;
                                                        $product = $variant ? $variant->product : $detail->product;
                                                        
                                                        $variantText = [];
                                                        if ($variant?->color) $variantText[] = "Màu: " . $variant->color->name;
                                                        if ($variant?->size) $variantText[] = "Size: " . $variant->size->name;
                                                        $variantDisplay = !empty($variantText) ? implode(' · ', $variantText) : 'Mặc định';
                                                        
                                                        $img = ($variant && $variant->image) ? $variant->image : ($product->thumbnail ?? null);
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center gap-3">
                                                                <div class="avatar-md bg-light rounded d-flex align-items-center justify-content-center">
                                                                    @if($img)
                                                                        <img src="{{ asset('storage/' . $img) }}" class="img-fluid rounded" style="width: 50px">
                                                                    @else
                                                                        <i class="bx bx-package fs-24 text-muted"></i>
                                                                    @endif
                                                                </div>
                                                                <div>
                                                                    <h5 class="fs-14 mb-1">{{ $product->name }}</h5>
                                                                    <p class="text-muted mb-0 fs-12">{{ $variantDisplay }}</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>{{ number_format($item['price'] ?? 0, 0, ',', '.') }}₫</td>
                                                        <td>{{ $item['quantity'] ?? 0 }}</td>
                                                        <td class="text-end fw-medium text-dark">{{ number_format($item['total'] ?? 0, 0, ',', '.') }}₫</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr><td colspan="4" class="text-center">Không có dữ liệu chi tiết sản phẩm.</td></tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        @php
                            $images = is_string($return->images) ? json_decode($return->images, true) : $return->images;
                        @endphp
                        @if(!empty($images))
                        <div class="card">
                            <div class="card-header"><h4 class="card-title">Hình Ảnh Minh Chứng</h4></div>
                            <div class="card-body">
                                <div class="row g-2">
                                    @foreach($images as $image)
                                        <div class="col-md-3">
                                            <a href="{{ asset($image) }}" target="_blank">
                                                <img src="{{ asset($image) }}" class="img-fluid rounded border" style="height: 150px; width: 100%; object-fit: cover;">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-4">
                <div class="card bg-primary-subtle border-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h5 class="text-primary mb-0">Tổng hoàn trả</h5>
                            <i class='bx bx-money fs-20 text-primary'></i>
                        </div>
                        <h3 class="text-primary fw-bold">{{ number_format($return->refund_amount, 0, ',', '.') }}₫</h3>
                        <p class="text-muted fs-12 mb-0">Hệ thống sẽ hoàn lại vào tài khoản khách hàng khi admin xác nhận "Đã hoàn tiền".</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"><h4 class="card-title">Thông Tin Hoàn Trả</h4></div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Lý do hoàn hàng:</label>
                            <p class="text-dark bg-light p-2 rounded">{{ $return->reason }}</p>
                        </div>
                        @if($return->notes)
                        <div class="mb-3">
                            <label class="form-label fw-bold">Ghi chú của khách:</label>
                            <p class="text-muted">{{ $return->notes }}</p>
                        </div>
                        @endif
                        @if($return->rejection_reason)
                        <div class="mb-3">
                            <label class="form-label fw-bold text-danger">Lý do từ chối:</label>
                            <p class="text-danger bg-danger-subtle p-2 rounded">{{ $return->rejection_reason }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                @if($return->refundAccount)
                <div class="card">
                    <div class="card-header"><h4 class="card-title">Tài Khoản Nhận Tiền</h4></div>
                    <div class="card-body">
                        <p class="mb-1 fw-medium text-dark">{{ $return->refundAccount->bank_name }}</p>
                        <p class="mb-1 text-muted">{{ $return->refundAccount->masked_account_number }}</p>
                        <p class="mb-0 text-muted text-uppercase">{{ $return->refundAccount->account_holder }}</p>
                    </div>
                </div>
                @endif

                <div class="card">
                    <div class="card-header"><h4 class="card-title">Khách Hàng</h4></div>
                    <div class="card-body text-center">
                        <img src="{{ asset('admin/assets/images/users/avatar-1.jpg') }}" class="avatar-lg rounded-circle border border-3 border-light mb-3">
                        <h5 class="mb-1">{{ $return->order->name }}</h5>
                        <p class="text-muted fs-13">{{ $return->order->user?->email }}</p>
                        <hr>
                        <div class="text-start">
                            <p class="mb-1"><i class='bx bx-phone'></i> {{ $return->order->phone }}</p>
                            <p class="mb-0 fs-12"><i class='bx bx-map'></i> {{ $return->order->address }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection