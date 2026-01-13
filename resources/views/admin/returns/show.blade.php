@extends('admin.master')

@section('content')
    <div class="container-xxl">
        <div class="row">
            <div class="col-xl-9 col-lg-8">
                <div class="row">
                    <div class="col-lg-12">
                        {{-- Thông báo --}}
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

                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                                    <div>
                                        <h4 class="fw-medium text-dark d-flex align-items-center gap-2">
                                            Yêu cầu hoàn hàng #{{ $return->order->order_code }}
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
                                                $statusLabels = [
                                                    'pending'           => 'Chờ duyệt',
                                                    'approved'          => 'Chấp nhận',
                                                    'returning'         => 'Đang trả hàng',
                                                    'received'          => 'Đã nhận/Kiểm tra',
                                                    'refund_processing' => 'Đang xử lý hoàn tiền',
                                                    'completed'         => 'Hoàn tất',
                                                    'rejected'          => 'Bị từ chối',
                                                ];
                                                $color = $statusColors[$return->status] ?? 'badge border border-secondary text-secondary';
                                                $label = $statusLabels[$return->status] ?? $return->status;
                                            @endphp
                                            <span class="{{ $color }} fs-13 px-2 py-1 rounded">
                                                {{ $label }}
                                            </span>
                                        </h4>
                                        <p class="mb-0">Return Request / Details / #{{ $return->order->order_code }} -
                                            {{ $return->created_at ? $return->created_at->format('d/m/Y H:i') : '-' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <h4 class="fw-medium text-dark">Tiến độ hoàn hàng hệ thống</h4>
                                </div>

                                @php
                                    // Định nghĩa 6 bước tiến độ (không tính rejected vì nó là nhánh cụt)
                                    $steps = [
                                        ['status' => 'pending',           'label' => 'Chờ duyệt'],
                                        ['status' => 'approved',          'label' => 'Chấp nhận'],
                                        ['status' => 'returning',         'label' => 'Đang trả hàng'],
                                        ['status' => 'received',          'label' => 'Đã nhận hàng'],
                                        ['status' => 'refund_processing', 'label' => 'Đang hoàn tiền'],
                                        ['status' => 'completed',         'label' => 'Hoàn tất'],
                                    ];
                                    
                                    $currentStatus = $return->status;
                                    $isRejected = $currentStatus === 'rejected';
                                    
                                    $statusOrder = ['pending', 'approved', 'returning', 'received', 'refund_processing', 'completed'];
                                    $currentIndex = array_search($currentStatus, $statusOrder);
                                    
                                    // Hàm tính toán trạng thái thanh Progress Bar
                                    $calc = function ($stepIndex) use ($currentIndex, $isRejected, $currentStatus) {
                                        if ($isRejected) {
                                            return [
                                                'width' => $stepIndex === 1 ? 100 : 0,
                                                'bar' => 'bg-danger',
                                                'state' => $stepIndex === 1 ? 'rejected' : 'todo',
                                                'animated' => false,
                                            ];
                                        }
                                        
                                        $stepPos = $stepIndex - 1; 

                                        if ($stepPos < $currentIndex) {
                                            return ['width' => 100, 'bar' => 'bg-success', 'state' => 'done', 'animated' => false];
                                        }
                                        
                                        if ($stepPos === $currentIndex) {
                                            $isLast = ($currentStatus === 'completed');
                                            return [
                                                'width' => $isLast ? 100 : 60,
                                                'bar' => $isLast ? 'bg-success' : 'bg-warning',
                                                'state' => $isLast ? 'done' : 'active',
                                                'animated' => !$isLast,
                                            ];
                                        }
                                        
                                        return ['width' => 0, 'bar' => 'bg-light', 'state' => 'todo', 'animated' => false];
                                    };
                                @endphp

                                <div class="row row-cols-xxl-6 row-cols-md-3 row-cols-2 g-3">
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
                                                    <p class="mb-0 text-danger fw-semibold fs-13">Bị từ chối</p>
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
                                    <a href="{{ route('admin.returns.index') }}" class="btn btn-outline-secondary btn-sm">Quay lại danh sách</a>
                                </div>
                            </div>
                        </div>

                        {{-- DANH SÁCH SẢN PHẨM --}}
                        <div class="card">
                            <div class="card-header bg-light-subtle"><h4 class="card-title mb-0">Sản Phẩm Hoàn Trả</h4></div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table align-middle mb-0 table-hover">
                                        <thead class="bg-light-subtle border-bottom">
                                            <tr>
                                                <th class="ps-3">Sản Phẩm</th>
                                                <th>Giá Hoàn</th>
                                                <th>Số Lượng</th>
                                                <th class="text-end pe-3">Thành Tiền</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $productDetails = is_array($return->product_details) ? $return->product_details : json_decode($return->product_details, true);
                                            @endphp
                                            @if(!empty($productDetails))
                                                @foreach($productDetails as $item)
                                                    @php
                                                        // CHỈ THAY ĐỔI Ở ĐÂY: Xử lý hiển thị giá tiền chính xác
                                                        $itemPrice = $item['price'] ?? ($item['original_price'] ?? 0);
                                                        $itemQty = $item['quantity'] ?? 0;
                                                        $itemTotal = $item['total'] ?? ($itemPrice * $itemQty);

                                                        $variantId = $item['product_variant_id'] ?? null;
                                                        $detail = $return->order->details->where('product_variant_id', $variantId)->first();
                                                        $variant = $detail ? $detail->productVariant : null;
                                                        $product = $variant ? $variant->product : null;
                                                        $img = ($variant && $variant->image) ? $variant->image : ($product->thumbnail ?? null);
                                                    @endphp
                                                    <tr>
                                                        <td class="ps-3">
                                                            <div class="d-flex align-items-center gap-3">
                                                                <div class="avatar-md bg-light rounded d-flex align-items-center justify-content-center">
                                                                    @if($img)
                                                                        <img src="{{ asset('storage/' . $img) }}" class="img-fluid rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                                                    @else
                                                                        <i class="bx bx-package fs-24 text-muted"></i>
                                                                    @endif
                                                                </div>
                                                                <div>
                                                                    <h5 class="fs-14 mb-1">{{ $item['product_name'] ?? ($product->name ?? 'Sản phẩm') }}</h5>
                                                                    <p class="text-muted mb-0 fs-12">
                                                                        Màu: {{ $item['color_name'] ?? ($variant->color->name ?? 'N/A') }} · Size: {{ $item['size_name'] ?? ($variant->size->name ?? 'N/A') }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>{{ number_format($itemPrice, 0, ',', '.') }}₫</td>
                                                        <td>{{ $itemQty }}</td>
                                                        <td class="text-end fw-medium text-dark pe-3">{{ number_format($itemTotal, 0, ',', '.') }}₫</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- 📸 1. ẢNH MINH CHỨNG CỦA KHÁCH HÀNG --}}
                        <div class="card">
                            <div class="card-header d-flex align-items-center gap-2 bg-light-subtle">
                                <i class='bx bx-image text-warning fs-20'></i>
                                <h4 class="card-title mb-0">Ảnh Minh Chứng Lỗi (Khách hàng gửi)</h4>
                            </div>
                            <div class="card-body">
                                @php
                                    $images = is_array($return->images) ? $return->images : json_decode($return->images, true);
                                @endphp
                                <div class="row g-2">
                                    @if(!empty($images))
                                        @foreach($images as $image)
                                            @php $cleanPath = str_replace('\\', '/', $image); @endphp
                                            <div class="col-md-3">
                                                <a href="{{ asset('storage/' . $cleanPath) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $cleanPath) }}" class="img-fluid rounded border shadow-sm w-100" style="height: 160px; object-fit: cover;">
                                                </a>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-12 text-center py-4 bg-light rounded border border-dashed">
                                            <i class='bx bx-no-entry fs-30 text-muted'></i>
                                            <p class="text-muted mb-0 mt-1">Khách hàng không gửi ảnh minh chứng lỗi.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CỘT BÊN PHẢI --}}
            <div class="col-xl-3 col-lg-4">
                {{-- TỔNG TIỀN HOÀN --}}
                <div class="card bg-primary-subtle border-primary shadow-none mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h5 class="text-primary mb-0">Tổng hoàn tiền</h5>
                            <i class='bx bx-money fs-20 text-primary'></i>
                        </div>
                        <h3 class="text-primary fw-bold">{{ number_format($return->refund_amount, 0, ',', '.') }}₫</h3>
                    </div>
                </div>

                {{-- THÔNG TIN TÀI KHOẢN KHÁCH --}}
                <div class="card mb-3">
                    <div class="card-header bg-light"><h4 class="card-title mb-0 fs-15">Tài Khoản Nhận Tiền</h4></div>
                    <div class="card-body">
                        @if($return->refundAccount)
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class='bx bxs-bank text-primary fs-18'></i>
                                <span class="fw-bold">{{ $return->refundAccount->bank_name }}</span>
                            </div>
                            <p class="mb-1 text-dark fw-medium fs-15">{{ $return->refundAccount->account_number }}</p>
                            <p class="mb-0 text-muted text-uppercase fs-12">{{ $return->refundAccount->account_holder }}</p>
                        @else
                            <div class="text-center py-2">
                                <p class="text-danger fs-13 mb-0">Chưa cung cấp thông tin tài khoản.</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- 📸 2. BIÊN LAI HOÀN TIỀN CỦA ADMIN --}}
                <div class="card shadow-sm border mb-3">
                    <div class="card-header bg-light d-flex align-items-center gap-2">
                        <i class='bx bx-receipt text-success fs-20'></i>
                        <h4 class="card-title mb-0 fs-15">Biên Lai Của Shop</h4>
                    </div>
                    <div class="card-body text-center">
                        @if($return->admin_refund_proof)
                            <a href="{{ asset('storage/' . str_replace('\\', '/', $return->admin_refund_proof)) }}" target="_blank">
                                <img src="{{ asset('storage/' . str_replace('\\', '/', $return->admin_refund_proof)) }}" 
                                     class="img-fluid rounded border shadow-sm mb-2" style="max-height: 250px; width: 100%; object-fit: contain; background: #fff;">
                            </a>
                            <p class="text-success fw-medium mb-0 fs-12"><i class='bx bx-check-double'></i> Đã xác nhận chuyển khoản</p>
                        @else
                            <div class="py-4 bg-light rounded border border-dashed">
                                <i class='bx bx-time-five fs-30 text-muted'></i>
                                <p class="text-muted fs-12 mb-0 mt-2">Đang chờ xử lý thanh toán.</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- FORM XỬ LÝ NHANH (NẾU ĐANG Ở BƯỚC HOÀN TIỀN) --}}
                @if($return->status === 'refund_processing')
                    <div class="card border-danger shadow-sm">
                        <div class="card-header bg-danger"><h4 class="card-title text-white mb-0 fs-15">Thực Hiện Hoàn Tiền</h4></div>
                        <div class="card-body">
                            <form action="{{ route('admin.returns.updateStatus', $return->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="status" value="completed">
                                <div class="mb-3">
                                    <label class="form-label fw-bold small">Tải lên biên lai chuyển khoản *</label>
                                    <input type="file" name="admin_refund_proof" class="form-control form-control-sm" accept="image/*" required>
                                </div>
                                <button type="submit" class="btn btn-danger w-100 fw-bold btn-sm">XÁC NHẬN HOÀN TẤT</button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection