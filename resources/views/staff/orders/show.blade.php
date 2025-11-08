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
                                            #{{ $order->order_code }}
                                            {{-- <span class="badge bg-success-subtle text-success  px-2 py-1 fs-13">Paid</span> --}}
                                            @php
                                                // Định nghĩa màu nhãn cho từng trạng thái
                                                $paymentColors = [
                                                    1 => 'badge border border-primary text-primary', // Chưa thanh toán
                                                    2 => 'badge border border-warning text-warning', // Đang xử lý
                                                    3 => 'badge border border-success text-success', // Đã thanh toán
                                                    4 => 'badge border border-danger text-danger', // Thanh toán thất bại
                                                    5 => 'badge border border-secondary text-secondary', // Hoàn tiền
                                                ];

                                                $paymentName = $order->paymentStatus->name ?? 'Không xác định';
                                                $color =
                                                    $paymentColors[$order->payment_status_id] ?? 'bg-light text-dark';
                                            @endphp
                                            <span class="{{ $color }} fs-13 px-2 py-1 rounded">
                                                {{ $paymentName }}</span>
                                        </h4>
                                        <p class="mb-0">Order / Order Details / #{{ $order->order_code }} -
                                            {{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : '-' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <h4 class="fw-medium text-dark">Tiến độ</h4>
                                </div>

                                @php
                                    // Map các bước hiển thị trên UI
                                    $steps = [
                                        ['id' => 1, 'label' => 'Chờ xác nhận'],
                                        ['id' => 2, 'label' => 'Xác nhận'],
                                        ['id' => 3, 'label' => 'Đang giao hàng'],
                                        ['id' => 4, 'label' => 'Đã giao hàng'],
                                        ['id' => 5, 'label' => 'Hoàn thành'],
                                    ];

                                    $status = (int) ($order->order_status_id ?? 1);
                                    $isTerminal = in_array($status, [6, 7], true);
                                    $terminalLabel = $status === 6 ? 'Đã hủy' : ($status === 7 ? 'Hoàn hàng' : null);

                                    /**
                                     * Xác định "bước hiện tại" để đổ progress:
                                     * - Trạng thái thường (1..5): current = chính status
                                     * - Trạng thái kết thúc:
                                     *   + Hủy (6): dừng ở bước 2 (đã xác nhận xong rồi bị hủy) — có thể chỉnh theo nghiệp vụ
                                     *   + Hoàn hàng (7): dừng ở bước 4 (đã giao rồi bị hoàn) — có thể chỉnh theo nghiệp vụ
                                     */
                                    $current = $isTerminal ? ($status === 6 ? 2 : 5) : min(max($status, 1), 5);

                                    // Hàm phụ để tính style cho từng bước
                                    $calc = function (int $stepId) use ($current, $isTerminal) {
                                        if ($stepId < $current) {
                                            return [
                                                'width' => 100,
                                                'bar' => 'bg-success',
                                                'state' => 'done',
                                                'striped' => true,
                                                'animated' => true,
                                            ];
                                        }
                                        if ($stepId === $current && !$isTerminal) {
                                            $with = in_array($stepId, [4, 5]) ? 100 : 60;
                                            $bar = in_array($stepId, [4, 5]) ? 'bg-success' : 'bg-warning';
                                            $striped = in_array($stepId, [4, 5]) ? 'done' : 'active';

                                            return [
                                                'width' => $with,
                                                'bar' => $bar,
                                                'state' => $striped,
                                                'striped' => true,
                                                'animated' => true,
                                            ];
                                        }
                                        // Chưa tới bước
                                        return [
                                            'width' => 0,
                                            'bar' => 'bg-primary',
                                            'state' => 'todo',
                                            'striped' => true,
                                            'animated' => true,
                                        ];
                                    };
                                @endphp
                                <div class="row row-cols-xxl-6 row-cols-md-2 row-cols-1 g-3">
                                    @foreach ($steps as $step)
                                        @php
                                            $s = $calc($step['id']);
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
                                                    <p class="mb-0 mb-0">{{ $step['label'] }}</p>
                                                    <i class="bx bx-check-circle text-success"></i>
                                                </div>
                                            @else
                                                <p class="mb-0 mt-2 text-muted">{{ $step['label'] }}</p>
                                            @endif
                                        </div>
                                    @endforeach

                                    {{-- Cột trạng thái kết thúc (nếu có) --}}
                                    @if ($isTerminal)
                                        <div class="col">
                                            <div class="progress mt-3" style="height: 10px;">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated {{ $status === 6 ? 'bg-danger' : 'bg-secondary' }}"
                                                    role="progressbar" style="width: 100%" aria-valuenow="100"
                                                    aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center gap-2 mt-2">
                                                <p
                                                    class="mb-0 fw-semibold {{ $status === 6 ? 'text-danger' : 'text-secondary' }}">
                                                    {{ $terminalLabel }}</p>
                                                <i
                                                    class="bx {{ $status === 6 ? 'bx-x-circle text-danger' : 'bx-transfer text-secondary' }}"></i>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                            </div>
                            <div
                                class="card-footer d-flex flex-wrap align-items-center justify-content-between bg-light-subtle gap-2">
                                <p class="border rounded mb-0 px-2 py-1 bg-body"><i
                                        class='bx bx-arrow-from-left align-middle fs-16'></i> Ngày dự kiến giao hàng:
                                    <span
                                        class="text-dark fw-medium">{{ $order->created_at ? $order->created_at->addDays(2)->format('d/m/Y') : '-' }}
                                    </span>
                                </p>
                                <div>
                                    <a href="{{ route('staff.orders.index') }}" class="btn btn-primary">Quay lại</a>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Sản Phẩm</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table align-middle mb-0 table-hover table-centered">
                                        <thead class="bg-light-subtle border-bottom">
                                            <tr>
                                                <th>Tên Sản Phẩm & Size</th>
                                                {{-- <th>Status</th> --}}
                                                <th>Giá</th>
                                                <th>Số Lượng</th>
                                                {{-- <th>Text</th> --}}
                                                <th>Thành Tiền</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($lines as $line)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div
                                                                class="rounded bg-light avatar-md d-flex align-items-center justify-content-center">
                                                                @if ($line->image)
                                                                    <img src="{{ asset('storage/' . $line->image) }}"
                                                                        alt="image" style="width:60px;">
                                                                @else
                                                                    <span>Không có</span>
                                                                @endif
                                                            </div>
                                                            <div>
                                                                <a href="#!"
                                                                    class="text-dark fw-medium fs-15">{{ $line->product_name }}</a>
                                                                <p class="text-muted mb-0 mt-1 fs-13">
                                                                    <span>{{ $line->variant_text ?? '-' }}</span>
                                                                </p>
                                                            </div>
                                                        </div>

                                                    </td>

                                                    {{-- <td>
                                                        <span
                                                            class="badge bg-success-subtle text-success  px-2 py-1 fs-13">Ready</span>
                                                    </td> --}}
                                                    <td>{{ number_format($line->unit_price, 0, ',', '.') }}₫</td>
                                                    <td> {{ $line->qty }}</td>
                                                    <td>{{ number_format($line->line_total, 0, ',', '.') }}₫</td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Dòng thời gian đơn hàng</h4>
                            </div>
                            <div class="card-body">
                                <div class="position-relative ms-2">
                                    <span class="position-absolute start-0  top-0 border border-dashed h-100"></span>
                                    <div class="position-relative ps-4">
                                        <div class="mb-4">
                                            <span
                                                class="position-absolute start-0 avatar-sm translate-middle-x bg-light d-inline-flex align-items-center justify-content-center rounded-circle">
                                                <div class="spinner-border spinner-border-sm text-warning" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </span>
                                            <div
                                                class="ms-2 d-flex flex-wrap gap-2 align-items-center justify-content-between">
                                                <div>
                                                    <h5 class="mb-1 text-dark fw-medium fs-15">The packing has been started
                                                    </h5>
                                                    <p class="mb-0">Confirmed by Gaston Lapierre</p>
                                                </div>
                                                <p class="mb-0">April 23, 2024, 09:40 am</p>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="position-relative ps-4">
                                        <div class="mb-4">
                                            <span
                                                class="position-absolute start-0 avatar-sm translate-middle-x bg-light d-inline-flex align-items-center justify-content-center rounded-circle text-success fs-20">
                                                <i class='bx bx-check-circle'></i>
                                            </span>
                                            <div
                                                class="ms-2 d-flex flex-wrap gap-2  align-items-center justify-content-between">
                                                <div>
                                                    <h5 class="mb-1 text-dark fw-medium fs-15">The Invoice has been sent to
                                                        the customer</h5>
                                                    <p class="mb-2">Invoice email was sent to <a href="#!"
                                                            class="link-primary">hello@dundermuffilin.com</a></p>
                                                    <a href="#!" class="btn btn-light">Resend Invoice</a>
                                                </div>
                                                <p class="mb-0">April 23, 2024, 09:40 am</p>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="position-relative ps-4">
                                        <div class="mb-4">
                                            <span
                                                class="position-absolute start-0 avatar-sm translate-middle-x bg-light d-inline-flex align-items-center justify-content-center rounded-circle text-success fs-20">
                                                <i class='bx bx-check-circle'></i>
                                            </span>
                                            <div
                                                class="ms-2 d-flex flex-wrap gap-2 align-items-center justify-content-between">
                                                <div>
                                                    <h5 class="mb-1 text-dark fw-medium fs-15">The Invoice has been created
                                                    </h5>
                                                    <p class="mb-2">Invoice created by Gaston Lapierre</p>
                                                    <a href="#!" class="btn btn-primary">Download Invoice</a>
                                                </div>
                                                <p class="mb-0">April 23, 2024, 09:40 am</p>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="position-relative ps-4">
                                        <div class="mb-4">
                                            <span
                                                class="position-absolute start-0 avatar-sm translate-middle-x bg-light d-inline-flex align-items-center justify-content-center rounded-circle text-success fs-20">
                                                <i class='bx bx-check-circle'></i>
                                            </span>
                                            <div
                                                class="ms-2 d-flex flex-wrap gap-2 align-items-center justify-content-between">
                                                <div>
                                                    <h5 class="mb-1 text-dark fw-medium fs-15">Order Payment</h5>
                                                    <p class="mb-2">Using Master Card</p>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <p class="mb-1 text-dark fw-medium">Status :</p>
                                                        <span
                                                            class="badge bg-success-subtle text-success  px-2 py-1 fs-13">Paid</span>
                                                    </div>
                                                </div>
                                                <p class="mb-0">April 23, 2024, 09:40 am</p>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="position-relative ps-4">
                                        <div class="mb-2">
                                            <span
                                                class="position-absolute start-0 avatar-sm translate-middle-x bg-light d-inline-flex align-items-center justify-content-center rounded-circle text-success fs-20">
                                                <i class='bx bx-check-circle'></i>
                                            </span>
                                            <div
                                                class="ms-2 d-flex flex-wrap gap-2  align-items-center justify-content-between">
                                                <div>
                                                    <h5 class="mb-2 text-dark fw-medium fs-15">4 Order conform by Gaston
                                                        Lapierre</h5>
                                                    <a href="#!"
                                                        class="badge bg-light text-dark fw-normal  px-2 py-1 fs-13">Order
                                                        1</a>
                                                    <a href="#!"
                                                        class="badge bg-light text-dark fw-normal  px-2 py-1 fs-13">Order
                                                        2</a>
                                                    <a href="#!"
                                                        class="badge bg-light text-dark fw-normal  px-2 py-1 fs-13">Order
                                                        3</a>
                                                    <a href="#!"
                                                        class="badge bg-light text-dark fw-normal  px-2 py-1 fs-13">Order
                                                        4</a>
                                                </div>
                                                <p class="mb-0">April 23, 2024, 09:40 am</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tóm Tắt Đơn Hàng</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <tbody>
                                    <tr>
                                        <td class="px-0">
                                            <p class="d-flex mb-0 align-items-center gap-1"><iconify-icon
                                                    icon="solar:clipboard-text-broken"></iconify-icon> Tạm Tính : </p>
                                        </td>
                                        <td class="text-end text-dark fw-medium px-0">
                                            {{ number_format($calc_subtotal, 0, ',', '.') }}₫</td>
                                    </tr>
                                    <tr>
                                        <td class="px-0">
                                            <p class="d-flex mb-0 align-items-center gap-1"><iconify-icon
                                                    icon="solar:ticket-broken" class="align-middle"></iconify-icon>
                                                Giảm Giá : </p>
                                        </td>
                                        <td class="text-end text-dark fw-medium px-0">
                                            -{{ number_format($calc_discount, 0, ',', '.') }}₫</td>
                                    </tr>
                                    <tr>
                                        <td class="px-0">
                                            <p class="d-flex mb-0 align-items-center gap-1"><iconify-icon
                                                    icon="solar:kick-scooter-broken" class="align-middle"></iconify-icon>
                                                Phí giao hàng. : </p>
                                        </td>
                                        <td class="text-end text-dark fw-medium px-0">30.000₫</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between bg-light-subtle">
                        <div>
                            <p class="fw-medium text-dark mb-0">Tổng Số Tiền</p>
                        </div>
                        <div>
                            <p class="fw-medium text-dark mb-0">{{ number_format($calc_total + 30000, 0, ',', '.') }}₫
                            </p>
                        </div>

                    </div>
                </div>
                {{-- <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Thông Tin Thanh Toán</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="rounded-3 bg-light avatar d-flex align-items-center justify-content-center">
                                <img src="assets/images/card/mastercard.svg" alt="" class="avatar-sm">
                            </div>
                            <div>
                                <p class="mb-1 text-dark fw-medium">Master Card</p>
                                <p class="mb-0 text-dark">xxxx xxxx xxxx 7812</p>
                            </div>
                            <div class="ms-auto">
                                <iconify-icon icon="solar:check-circle-broken" class="fs-22 text-success"></iconify-icon>
                            </div>
                        </div>
                        <p class="text-dark mb-1 fw-medium">Transaction ID : <span class="text-muted fw-normal fs-13">
                                #IDN768139059</span></p>
                        <p class="text-dark mb-0 fw-medium">Card Holder Name : <span class="text-muted fw-normal fs-13">
                                Gaston Lapierre</span></p>

                    </div>
                </div> --}}
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Chi tiết khách hàng</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2">
                            <img src="assets/images/users/avatar-1.jpg" alt=""
                                class="avatar rounded-3 border border-light border-3">
                            <div>
                                <p class="mb-1">{{ $order->name ?? 'N/A' }}</p>
                                <a href="#!" class="link-primary fw-medium">{{ $order->user?->email ?? 'N/A' }}</a>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <h5 class="">Số Điện Thoại</h5>
                            <div>
                                {{-- <a href="#!"><i class='bx bx-edit-alt fs-18'></i></a> --}}
                            </div>
                        </div>
                        <p class="mb-1">{{ $order->phone }}</p>

                        <div class="d-flex justify-content-between mt-3">
                            <h5 class="">Địa Chỉ Giao Hàng</h5>
                            <div>
                                {{-- <a href="#!"><i class='bx bx-edit-alt fs-18'></i></a> --}}
                            </div>
                        </div>

                        <div>
                            <p class="mb-1">{{ $order->address }}</p>
                            {{-- <p class="mb-1">1344 Hershell Hollow Road ,</p>
                            <p class="mb-1">Tukwila, WA 98168 ,</p>
                            <p class="mb-1">United States</p> --}}
                            <p class="">{{ $order->phone }}</p>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <h5 class="">Địa Chỉ Thanh Toán</h5>
                            <div>
                                {{-- <a href="#!"><i class='bx bx-edit-alt fs-18'></i></a> --}}
                            </div>
                        </div>

                        <p class="mb-1">Giống với địa chỉ giao hàng</p>
                    </div>
                </div>
                {{-- <div class="card">
                    <div class="card-body">
                        <div class="mapouter">
                            <div class="gmap_canvas"><iframe class="gmap_iframe rounded" width="100%"
                                    style="height: 418px;" frameborder="0" scrolling="no" marginheight="0"
                                    marginwidth="0"
                                    src="https://maps.google.com/maps?width=1980&amp;height=400&amp;hl=en&amp;q=University%20of%20Oxford&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
@endsection
