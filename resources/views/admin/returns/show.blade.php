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
                                    // Map các bước hiển thị trên UI
                                    $steps = [
                                        ['status' => 'pending', 'label' => 'Chờ xác nhận'],
                                        ['status' => 'approved', 'label' => 'Đã chấp nhận'],
                                        ['status' => 'waiting_for_return', 'label' => 'Chờ gửi hàng'],
                                        ['status' => 'returned', 'label' => 'Đã nhận hàng'],
                                        ['status' => 'refunded', 'label' => 'Đã hoàn tiền'],
                                    ];

                                    $currentStatus = $return->status;
                                    $isRejected = $currentStatus === 'rejected';
                                    
                                    // Map status sang index để tính progress
                                    $statusIndex = [
                                        'pending' => 1,
                                        'approved' => 2,
                                        'waiting_for_return' => 3,
                                        'returned' => 4,
                                        'refunded' => 5,
                                        'rejected' => 1,
                                    ];
                                    
                                    $currentStep = $statusIndex[$currentStatus] ?? 1;

                                    // Hàm tính style cho từng bước
                                    $calc = function ($stepIndex) use ($currentStep, $isRejected) {
                                        if ($isRejected) {
                                            return [
                                                'width' => $stepIndex === 1 ? 100 : 0,
                                                'bar' => 'bg-danger',
                                                'state' => $stepIndex === 1 ? 'rejected' : 'todo',
                                                'striped' => true,
                                                'animated' => false,
                                            ];
                                        }
                                        
                                        if ($stepIndex < $currentStep) {
                                            return [
                                                'width' => 100,
                                                'bar' => 'bg-success',
                                                'state' => 'done',
                                                'striped' => true,
                                                'animated' => true,
                                            ];
                                        }
                                        
                                        if ($stepIndex === $currentStep) {
                                            $isComplete = in_array($stepIndex, [4, 5]);
                                            return [
                                                'width' => $isComplete ? 100 : 60,
                                                'bar' => $isComplete ? 'bg-success' : 'bg-warning',
                                                'state' => $isComplete ? 'done' : 'active',
                                                'striped' => true,
                                                'animated' => true,
                                            ];
                                        }
                                        
                                        return [
                                            'width' => 0,
                                            'bar' => 'bg-primary',
                                            'state' => 'todo',
                                            'striped' => true,
                                            'animated' => false,
                                        ];
                                    };
                                @endphp

                                <div class="row row-cols-xxl-6 row-cols-md-2 row-cols-1 g-3">
                                    @foreach ($steps as $index => $step)
                                        @php
                                            $s = $calc($index + 1);
                                        @endphp
                                        <div class="col">
                                            <div class="progress mt-3" style="height: 10px;">
                                                <div class="progress-bar progress-bar-striped {{ $s['animated'] ? 'progress-bar-animated' : '' }} {{ $s['bar'] }}"
                                                    role="progressbar" style="width: {{ $s['width'] }}%"
                                                    aria-valuenow="{{ $s['width'] }}" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                </div>
                                            </div>

                                            @if ($s['state'] === 'active')
                                                <div class="d-flex align-items-center gap-2 mt-2">
                                                    <p class="mb-0">{{ $step['label'] }}</p>
                                                    <div class="spinner-border spinner-border-sm text-warning"
                                                        role="status">
                                                        <span class="visually-hidden">Loading...</span>
                                                    </div>
                                                </div>
                                            @elseif($s['state'] === 'done')
                                                <div class="d-flex align-items-center gap-2 mt-2">
                                                    <p class="mb-0">{{ $step['label'] }}</p>
                                                    <i class="bx bx-check-circle text-success"></i>
                                                </div>
                                            @elseif($s['state'] === 'rejected')
                                                <div class="d-flex align-items-center gap-2 mt-2">
                                                    <p class="mb-0 text-danger fw-semibold">Từ chối</p>
                                                    <i class="bx bx-x-circle text-danger"></i>
                                                </div>
                                            @else
                                                <p class="mb-0 mt-2 text-muted">{{ $step['label'] }}</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                            <div class="card-footer d-flex flex-wrap align-items-center justify-content-between bg-light-subtle gap-2">
                                <p class="border rounded mb-0 px-2 py-1 bg-body">
                                    <i class='bx bx-calendar align-middle fs-16'></i> Ngày yêu cầu:
                                    <span class="text-dark fw-medium">{{ $return->created_at ? $return->created_at->format('d/m/Y H:i') : '-' }}</span>
                                </p>
                                <div>
                                    <a href="{{ route('admin.returns.index') }}" class="btn btn-primary">Quay lại</a>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Sản Phẩm Hoàn Trả</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table align-middle mb-0 table-hover table-centered">
                                        <thead class="bg-light-subtle border-bottom">
                                            <tr>
                                                <th>Tên Sản Phẩm & Variant</th>
                                                <th>Giá</th>
                                                <th>Số Lượng</th>
                                                <th>Thành Tiền</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $productDetails = $return->product_details ? json_decode($return->product_details, true) : [];
                                            @endphp
                                            
                                            @if(!empty($productDetails))
                                                @foreach($productDetails as $productDetail)
                                                    @php
                                                        $detail = $return->order->details->firstWhere('id', $productDetail['order_detail_id']);
                                                        if (!$detail) continue;
                                                        
                                                        $variant = $detail->productVariant;
                                                        $product = $variant ? $variant->product : $detail->product;
                                                        $variantText = [];
                                                        if ($variant?->color?->name) $variantText[] = "Màu: {$variant->color->name}";
                                                        if ($variant?->size?->name) $variantText[] = "Size: {$variant->size->name}";
                                                        $variantDisplay = $variantText ? implode(' · ', $variantText) : '-';
                                                        
                                                        $imageUrl = null;
                                                        if ($variant && $variant->image) {
                                                            $imageUrl = asset('storage/' . $variant->image);
                                                        } elseif ($product->thumbnail) {
                                                            $imageUrl = asset('storage/' . $product->thumbnail);
                                                        }
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center gap-2">
                                                                <div class="rounded bg-light avatar-md d-flex align-items-center justify-content-center">
                                                                    @if ($imageUrl)
                                                                        <img src="{{ $imageUrl }}" alt="image" style="width:60px;">
                                                                    @else
                                                                        <span>📦</span>
                                                                    @endif
                                                                </div>
                                                                <div>
                                                                    <a href="#!" class="text-dark fw-medium fs-15">{{ $product->name }}</a>
                                                                    <p class="text-muted mb-0 mt-1 fs-13">
                                                                        <span>{{ $variantDisplay }}</span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>{{ number_format($productDetail['price'], 0, ',', '.') }}₫</td>
                                                        <td>{{ $productDetail['quantity'] }}</td>
                                                        <td>{{ number_format($productDetail['total'], 0, ',', '.') }}₫</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                @foreach($return->order->details as $detail)
                                                    @php
                                                        $variant = $detail->productVariant;
                                                        $product = $variant ? $variant->product : $detail->product;
                                                        $variantText = [];
                                                        if ($variant?->color?->name) $variantText[] = "Màu: {$variant->color->name}";
                                                        if ($variant?->size?->name) $variantText[] = "Size: {$variant->size->name}";
                                                        $variantDisplay = $variantText ? implode(' · ', $variantText) : '-';
                                                        
                                                        $imageUrl = null;
                                                        if ($variant && $variant->image) {
                                                            $imageUrl = asset('storage/' . $variant->image);
                                                        } elseif ($product->thumbnail) {
                                                            $imageUrl = asset('storage/' . $product->thumbnail);
                                                        }
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center gap-2">
                                                                <div class="rounded bg-light avatar-md d-flex align-items-center justify-content-center">
                                                                    @if ($imageUrl)
                                                                        <img src="{{ $imageUrl }}" alt="image" style="width:60px;">
                                                                    @else
                                                                        <span>📦</span>
                                                                    @endif
                                                                </div>
                                                                <div>
                                                                    <a href="#!" class="text-dark fw-medium fs-15">{{ $product->name }}</a>
                                                                    <p class="text-muted mb-0 mt-1 fs-13">
                                                                        <span>{{ $variantDisplay }}</span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>{{ number_format($detail->price, 0, ',', '.') }}₫</td>
                                                        <td>{{ $detail->quantity }}</td>
                                                        <td>{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}₫</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        @if($return->images)
                            @php
                                $images = is_string($return->images) ? json_decode($return->images, true) : $return->images;
                            @endphp
                            @if(!empty($images))
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Hình Ảnh Minh Họa</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            @foreach($images as $image)
                                                <div class="col-md-3">
                                                    <img src="{{ asset($image) }}" alt="Return image" class="img-fluid rounded" style="max-height: 200px; object-fit: cover;">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tổng Tiền Hoàn</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <tbody>
                                    <tr>
                                        <td class="px-0">
                                            <p class="d-flex mb-0 align-items-center gap-1">
                                                <iconify-icon icon="solar:wallet-money-broken"></iconify-icon> Số tiền hoàn:
                                            </p>
                                        </td>
                                        <td class="text-end text-dark fw-medium px-0">
                                            {{ number_format($return->refund_amount, 0, ',', '.') }}₫
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between bg-light-subtle">
                        <div>
                            <p class="fw-medium text-dark mb-0">Tổng Hoàn Trả</p>
                        </div>
                        <div>
                            <p class="fw-medium text-dark mb-0">{{ number_format($return->refund_amount, 0, ',', '.') }}₫</p>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Thông Tin Hoàn Hàng</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h5 class="fs-14 mb-1">Lý do hoàn hàng</h5>
                            <p class="text-muted mb-0">{{ $return->reason }}</p>
                        </div>

                        @if($return->notes)
                            <div class="mb-3">
                                <h5 class="fs-14 mb-1">Ghi chú</h5>
                                <p class="text-muted mb-0">{{ $return->notes }}</p>
                            </div>
                        @endif

                        @if($return->status === 'rejected' && $return->rejection_reason)
                            <div class="mb-3">
                                <h5 class="fs-14 mb-1 text-danger">Lý do từ chối</h5>
                                <p class="text-muted mb-0">{{ $return->rejection_reason }}</p>
                            </div>
                        @endif

                        @if($return->refundAccount)
                            <div class="mb-3">
                                <h5 class="fs-14 mb-1">Tài khoản nhận hoàn tiền</h5>
                                <p class="text-muted mb-1">{{ $return->refundAccount->bank_name }}</p>
                                <p class="text-muted mb-0">{{ $return->refundAccount->masked_account_number }}</p>
                                <p class="text-muted mb-0">{{ $return->refundAccount->account_holder }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Thông Tin Khách Hàng</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <img src="{{ asset('admin/assets/images/users/avatar-1.jpg') }}" alt="" class="avatar rounded-3 border border-light border-3">
                            <div>
                                <p class="mb-1 fw-medium">{{ $return->order->name ?? 'N/A' }}</p>
                                <a href="#!" class="link-primary fw-medium">{{ $return->order->user?->email ?? 'N/A' }}</a>
                            </div>
                        </div>

                        <div class="mb-2">
                            <h5 class="fs-14 mb-1">Số Điện Thoại</h5>
                            <p class="mb-0">{{ $return->order->phone }}</p>
                        </div>

                        <div>
                            <h5 class="fs-14 mb-1">Địa Chỉ</h5>
                            <p class="mb-0">{{ $return->order->address }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection