@extends('admin.master')

@section('content')
<div class="container-xxl">
    
    <h3 class="fw-bold mb-4">Xử Lý Yêu Cầu Hủy Đơn Hàng #{{ $request->order->order_code ?? 'N/A' }}</h3>

    {{-- Thông báo thành công / lỗi --}}
    @foreach (['success', 'error'] as $msg)
        @if(session($msg))
            <div class="alert alert-{{ $msg == 'success' ? 'success' : 'danger' }} alert-dismissible fade show" role="alert">
                {{ session($msg) }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    @endforeach

    <div class="row">
        {{-- Cột trái: Chi tiết Yêu cầu Hủy --}}
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-light-subtle">
                    <h5 class="mb-0">Thông Tin Yêu Cầu</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Trạng Thái Hiện Tại:</dt>
                        <dd class="col-sm-8">
                             @php
                                $badgeClass = match ($request->status->slug ?? 'pending') {
                                    'pending' => 'badge bg-warning text-dark',
                                    'accepted' => 'badge bg-success',
                                    'rejected' => 'badge bg-danger',
                                    default => 'badge bg-secondary',
                                };
                            @endphp
                            <span class="{{ $badgeClass }}">{{ $request->status->name ?? 'N/A' }}</span>
                        </dd>
                        
                        <dt class="col-sm-4">Khách Hàng:</dt>
                        <dd class="col-sm-8">{{ $request->user->name ?? $request->order->name ?? 'Khách lẻ' }}</dd>
                        
                        <dt class="col-sm-4">Ngày Gửi YC:</dt>
                        <dd class="col-sm-8">{{ $request->created_at?->format('H:i d/m/Y') }}</dd>
                        
                        <dt class="col-sm-4">Lý Do Khách Hàng:</dt>
                        <dd class="col-sm-8 text-danger fw-bold">{{ $request->reason_user }}</dd>
                        
                    </dl>
                    
                    @if($request->status_id == 1)
                        <hr>
                        {{-- Form Xử lý (Chỉ hiển thị khi trạng thái là Pending) --}}
                        <h5 class="mt-4 mb-3">Quyết Định Xử Lý</h5>
                        
                        <form action="{{ route('admin.order-cancellations.process', $request->id) }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="reason_admin" class="form-label">Phản hồi của Admin (Tùy chọn):</label>
                                <textarea name="reason_admin" id="reason_admin" class="form-control" rows="3" placeholder="Nhập lý do chấp nhận hoặc từ chối..."></textarea>
                            </div>
                            
                            {{-- Nút Chấp nhận --}}
                            <button type="submit" name="action" value="accept" 
                                    class="btn btn-success me-2" 
                                    onclick="return confirm('Xác nhận CHẤP NHẬN yêu cầu hủy? (Đơn hàng sẽ chuyển sang trạng thái Đã Hủy và tồn kho đã được hoàn lại)')">
                                <iconify-icon icon="solar:check-square-broken"></iconify-icon> Chấp nhận Hủy
                            </button>
                            
                            {{-- Nút Từ chối --}}
                            <button type="submit" name="action" value="reject" 
                                    class="btn btn-danger"
                                    onclick="return confirm('Xác nhận TỪ CHỐI yêu cầu hủy? (Đơn hàng sẽ giữ nguyên trạng thái hiện tại)')">
                                <iconify-icon icon="solar:close-square-broken"></iconify-icon> Từ chối
                            </button>
                        </form>
                    @else
                        <div class="alert alert-info mt-4">
                            Yêu cầu này đã được xử lý ({{ $request->status->name }}).
                            @if($request->reason_admin)
                                <p class="mb-0 mt-2"><strong>Phản hồi:</strong> {{ $request->reason_admin }}</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        {{-- Cột phải: Chi tiết Đơn hàng liên quan --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-light-subtle">
                    <h5 class="mb-0">Chi Tiết Đơn Hàng</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Mã Đơn Hàng:</dt>
                        <dd class="col-sm-8"><a href="{{ route('admin.orders.show', $request->order_id) }}" target="_blank" class="fw-bold">#{{ $request->order->order_code ?? 'N/A' }}</a></dd>
                        
                        <dt class="col-sm-4">Trạng Thái Đơn:</dt>
                        <dd class="col-sm-8">{{ $request->order->status->name ?? 'N/A' }}</dd>
                        
                        <dt class="col-sm-4">Tổng Tiền:</dt>
                        <dd class="col-sm-8 fw-bold text-success">{{ number_format($request->order->grand_total ?? 0, 0, ',', '.') }}₫</dd>
                    </dl>
                    
                    <h6 class="mt-3">Sản Phẩm Đã Đặt ({{ $request->order->details->count() ?? 0 }} loại)</h6>
                    <ul class="list-group list-group-flush">
                        @forelse($request->order->details ?? [] as $detail)
                            <li class="list-group-item d-flex justify-content-between align-items-start px-0">
                                <div class="me-auto">
                                    <div class="fw-bold">{{ $detail->productVariant->product->name ?? 'Sản phẩm' }}</div>
                                    <small class="text-muted">{{ $detail->productVariant->size->name ?? '' }} / {{ $detail->productVariant->color->name ?? '' }}</small>
                                </div>
                                <span class="badge bg-primary rounded-pill">{{ $detail->quantity }}</span>
                            </li>
                        @empty
                            <li class="list-group-item px-0 text-muted">Không có chi tiết sản phẩm.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection