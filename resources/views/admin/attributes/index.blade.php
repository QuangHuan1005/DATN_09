@extends('admin.master')
@section('content')
    <div class="container-xxl">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="d-flex card-header justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title">Danh Sách Thuộc Tính</h4>
                        </div>

                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle btn btn-sm btn-outline-light rounded"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                This Month
                            </a>
                        </div>
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
                                        <th>ID</th>
                                        <th>Biến Thể</th>
                                        <th>Giá trị</th>
                                        <th>Ngày Tạo</th>
                                        {{-- <th>Trạng Thái</th> --}}
                                        <th>Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @foreach ($attributes as $attributeType => $attributeValues)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="customCheck2">
                                                <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td>{{ strtoupper(substr($attributeType, 0, 2)) }}-{{ str_pad($loop->iteration, 4, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td>{{ ucfirst($attributeType) }}</td>
                                        <td>{{ $attributeValues->pluck('name')->join(' , ') }}</td>
                                        <td>{{ $attributeValues->first()->created_at->format('d M Y') }}</td>

                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('admin.attributes.show', $attributeType) }}"
                                                    class="btn btn-soft-info btn-sm" title="Xem chi tiết"><iconify-icon
                                                        icon="solar:eye-broken"
                                                        class="align-middle fs-18"></iconify-icon></a>
                                                {{-- <a href="{{ route('admin.attributes.edit', ucfirst($attributeType)) }}"
                                                    class="btn btn-soft-primary btn-sm"><iconify-icon
                                                        icon="solar:pen-2-broken"
                                                        class="align-middle fs-18"></iconify-icon></a>
                                                <a href="#!" class="btn btn-soft-danger btn-sm"><iconify-icon
                                                        icon="solar:trash-bin-minimalistic-2-broken"
                                                        class="align-middle fs-18"></iconify-icon></a>
                                             --}}
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach

                                    {{-- <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="customCheck2">
                                                <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td>BR-3922</td>
                                        <td>Brand</td>
                                        <td>
                                             {{ $attributes['sizes']->pluck('name')->join(' , ') }}
                                            

                                        </td>
                                        <td>Dropdown</td>
                                        <td>10 Sep 2023</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="flexSwitchCheckChecked1" checked="">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="#!" class="btn btn-light btn-sm"><iconify-icon
                                                        icon="solar:eye-broken"
                                                        class="align-middle fs-18"></iconify-icon></a>
                                                <a href="#!" class="btn btn-soft-primary btn-sm"><iconify-icon
                                                        icon="solar:pen-2-broken"
                                                        class="align-middle fs-18"></iconify-icon></a>
                                                <a href="#!" class="btn btn-soft-danger btn-sm"><iconify-icon
                                                        icon="solar:trash-bin-minimalistic-2-broken"
                                                        class="align-middle fs-18"></iconify-icon></a>
                                            </div>
                                        </td> --}}
                                    </tr>

                                    {{-- <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="customCheck2">
                                                <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td>CL-3721</td>
                                        <td>Color</td>
                                        <td>Black , Blue , Green , Yellow , White</td>
                                        <td>Dropdown</td>
                                        <td>16 May 2024</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="flexSwitchCheckChecked1" checked="">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="#!" class="btn btn-light btn-sm"><iconify-icon
                                                        icon="solar:eye-broken"
                                                        class="align-middle fs-18"></iconify-icon></a>
                                                <a href="#!" class="btn btn-soft-primary btn-sm"><iconify-icon
                                                        icon="solar:pen-2-broken"
                                                        class="align-middle fs-18"></iconify-icon></a>
                                                <a href="#!" class="btn btn-soft-danger btn-sm"><iconify-icon
                                                        icon="solar:trash-bin-minimalistic-2-broken"
                                                        class="align-middle fs-18"></iconify-icon></a>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="customCheck2">
                                                <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td>SZ-2291</td>
                                        <td>Size</td>
                                        <td>XS , S , M , XL , XXL , 3XL</td>
                                        <td>Radio</td>
                                        <td>27 Jan 2024</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="flexSwitchCheckChecked1" checked="">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="#!" class="btn btn-light btn-sm"><iconify-icon
                                                        icon="solar:eye-broken"
                                                        class="align-middle fs-18"></iconify-icon></a>
                                                <a href="#!" class="btn btn-soft-primary btn-sm"><iconify-icon
                                                        icon="solar:pen-2-broken"
                                                        class="align-middle fs-18"></iconify-icon></a>
                                                <a href="#!" class="btn btn-soft-danger btn-sm"><iconify-icon
                                                        icon="solar:trash-bin-minimalistic-2-broken"
                                                        class="align-middle fs-18"></iconify-icon></a>
                                            </div>
                                        </td>
                                    </tr> --}}
                                </tbody>
                            </table>
                        </div>
                        <!-- end table-responsive -->
                    </div>
                    {{-- <div class="card-footer border-top">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end mb-0">
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">Previous</a></li>
                                <li class="page-item active"><a class="page-link" href="javascript:void(0);">1</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">2</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">3</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">Next</a></li>
                            </ul>
                        </nav>
                    </div> --}}
                </div>
            </div>
        </div>

    </div>
@endsection
