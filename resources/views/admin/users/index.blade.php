@extends('admin.master')

@section('content')
    <div class="container-xxl">
        {{-- Thông báo --}}

        @if (session('success'))
            <div class="alert alert-{{ session('type') ? 'success' : 'warning' }} alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        {{-- <div class="row">
            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="avatar-md bg-primary bg-opacity-10 rounded">
                                <iconify-icon icon="solar:users-group-two-rounded-bold-duotone"
                                    class="fs-32 text-primary avatar-title"></iconify-icon>
                            </div>
                            <div>
                                <h4 class="mb-0">All Customers</h4>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="text-muted fw-medium fs-22 mb-0">+22.63k</p>
                            <div>
                                <span class="badge text-success bg-success-subtle fs-12"><i
                                        class="bx bx-up-arrow-alt"></i>34.4%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="avatar-md bg-primary bg-opacity-10 rounded">
                                <iconify-icon icon="solar:box-bold-duotone"
                                    class="fs-32 text-primary avatar-title"></iconify-icon>
                            </div>
                            <div>
                                <h4 class="mb-0">Orders</h4>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="text-muted fw-medium fs-22 mb-0">+4.5k</p>
                            <div>
                                <span class="badge text-danger bg-danger-subtle fs-12"><i
                                        class="bx bx-down-arrow-alt"></i>8.1%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="avatar-md bg-primary bg-opacity-10 rounded">
                                <iconify-icon icon="solar:headphones-round-sound-bold-duotone"
                                    class="fs-32 text-primary avatar-title"></iconify-icon>
                            </div>
                            <div>
                                <h4 class="mb-0">Services Request</h4>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="text-muted fw-medium fs-22 mb-0">+1.03k</p>
                            <div>
                                <span class="badge text-success bg-success-subtle fs-12"><i
                                        class="bx bx-up-arrow-alt"></i>12.6%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="avatar-md bg-primary bg-opacity-10 rounded">
                                <iconify-icon icon="solar:bill-list-bold-duotone"
                                    class="fs-32 text-primary avatar-title"></iconify-icon>
                            </div>
                            <div>
                                <h4 class="mb-0">Invoice & Payment</h4>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="text-muted fw-medium fs-22 mb-0">$38,908.00</p>
                            <div>
                                <span class="badge text-success bg-success-subtle fs-12"><i
                                        class="bx bx-up-arrow-alt"></i>45.9%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div> --}}

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="d-flex card-header justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title">Tất Cả Người Dùng</h4>
                        </div>
                        {{-- <div class="dropdown">
                            <a href="#" class="dropdown-toggle btn btn-sm btn-outline-light rounded"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                This Month
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a href="#!" class="dropdown-item">Download</a>
                                <!-- item-->
                                <a href="#!" class="dropdown-item">Export</a>
                                <!-- item-->
                                <a href="#!" class="dropdown-item">Import</a>
                            </div>
                        </div> --}}
                    </div>
                    <div>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0 table-hover table-centered">
                                <thead class="bg-light-subtle">
                                    <tr>
                                        <th style="width: 20px;">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="customCheck1">
                                                <label class="form-check-label" for="customCheck1"></label>
                                            </div>
                                        </th>
                                        <th>Tên Người Dùng</th>
                                        <th>Email</th>
                                        <th>Số Điện Thoại</th>
                                        <th>Vai Trò</th>
                                        <th>Ngày Tạo</th>
                                        <th>Trạng Thái</th>
                                        <th>Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="customCheck2">
                                                    <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td><img src="{{ asset('storage/' . $user->image) }} "
                                                    class="avatar-sm rounded-circle me-2" alt="...">{{ $user->name }}
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td> {{ $user->phone ?? 'Chưa có SĐT' }}
                                            </td>
                                            <td>
                                                @if ($user->role_id == 1)
                                                    <span class="badge bg-success-subtle text-success py-1 px-2">
                                                        {{ $user->role->name }}</span>
                                                @else
                                                    <span class="badge bg-primary-subtle text-primary py-1 px-2">
                                                        {{ $user->role->name }}</span>
                                                @endif

                                            </td>
                                            <td> {{ $user->created_at->format('d/m/Y') }}
                                            </td>
                                            <td>
                                                @if ($user->trashed())
                                                    <span class="text-muted">Đã ẩn</span>
                                                @else
                                                    {{ $user->is_locked ? 'Đã khóa' : 'Đang hoạt động' }}
                                                @endif
                                                {{-- <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        id="flexSwitchCheckChecked" checked="">
                                                </div> --}}

                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">

                                                    @if (!$user->trashed())
                                                        <a href="{{ route('admin.users.show', $user->id) }}"
                                                            class="btn btn-soft-info btn-sm"><iconify-icon
                                                                icon="solar:eye-broken"
                                                                class="align-middle fs-18"></iconify-icon></a>
                                                        <form action="{{ route('admin.users.toggleLock', $user->id) }}"
                                                            method="post">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-soft-{{ $user->is_locked ? 'success' : 'warning' }} btn-sm">
                                                                {{-- {{ $user->is_locked ? 'Mở khóa' : 'Khóa' }} --}}
                                                                <iconify-icon
                                                                    icon="{{ $user->is_locked ? 'solar:user-check-broken' : 'solar:user-block-broken' }}"
                                                                    class="align-middle fs-18"></iconify-icon>

                                                            </button>
                                                        </form>
                                                    @else
                                                    @endif

                                                    {{-- <a href="#!" class="btn btn-soft-primary btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#staticBackdrop"><iconify-icon
                                                            icon="solar:pen-2-broken"
                                                            class="align-middle fs-18"></iconify-icon></a>
                                                    <a href="#!" class="btn btn-soft-danger btn-sm"><iconify-icon
                                                            icon="solar:trash-bin-minimalistic-2-broken"
                                                            class="align-middle fs-18"></iconify-icon></a> --}}
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <td colspan="8" class="text-center">Không có người dùng nào</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- end table-responsive -->
                    </div>
                    <div class="card-footer border-top">
                        <nav aria-label="Page navigation example">
                            {{ $users->links() }}

                            {{-- <ul class="pagination justify-content-end mb-0">
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">Previous</a></li>
                                <li class="page-item active"><a class="page-link" href="javascript:void(0);">1</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">2</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">3</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">Next</a></li>
                            </ul> --}}
                        </nav>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
