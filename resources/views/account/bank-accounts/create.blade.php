@extends('master')
@section('content')

    <div class="wp-singular page-template page-template-templates page-template-fullwidth page-template-templatesfullwidth-php page page-id-11 logged-in wp-embed-responsive wp-theme-mixtas ltr theme-mixtas woocommerce-account woocommerce-page woocommerce-edit-account woocommerce-js woo-variation-swatches wvs-behavior-blur wvs-theme-mixtas wvs-show-label wvs-tooltip elementor-default elementor-kit-6 blog-sidebar-active blog-sidebar-right single-blog-sidebar-active kitify--js-ready body-loaded e--ua-blink e--ua-chrome e--ua-webkit"
        data-elementor-device-mode="laptop">
        <div class="site-wrapper">

            <div class="kitify-site-wrapper elementor-459kitify">
                @include('layouts.header')
                <div id="site-content" class="site-content-wrapper">
                    <div class="container">
                        <div class="grid-x">
                            <div class="cell small-12">
                                <div class="site-content">
                                    <div class="page-header-content">
                                        <nav class="woocommerce-breadcrumb"><a
                                                href="/">Home</a><span
                                                class="delimiter">/</span><a
                                                href="{{ route('account.dashboard') }}">Tài khoản của tôi</a><span
                                                class="delimiter">/</span><a
                                                href="{{ route('account.bank-accounts.index') }}">Thanh toán</a><span
                                                class="delimiter">/</span>Thêm tài khoản</nav>
                                        <h1 class="page-title">Tài khoản của tôi</h1>
                                    </div>
                                    <article class="post-11 page type-page status-publish hentry">
                                        <div class="entry-content">
                                            <div class="woocommerce">
                                                @include('account.partials.navigation')
                                                <div class="woocommerce-MyAccount-content">
                                                    <div class="woocommerce-notices-wrapper"></div>

                                                    <div class="d-flex align-items-center mb-4">
                                                        <a href="{{ route('account.bank-accounts.index') }}" class="btn btn-secondary mr-4">
                                                            <i class="fa fa-arrow-left"></i>
                                                        </a>&nbsp;&nbsp;&nbsp;
                                                        <h2 class="woocommerce-order-details__title mb-0 ml-3">Thêm tài khoản ngân hàng</h2>
                                                    </div>

                        <form method="POST" action="{{ route('account.bank-accounts.store') }}">
                            @csrf

                            <div class="form-group">
                                <label for="bank_name">Tên ngân hàng <span class="text-danger">*</span></label>
                                <div class="bank-selector-container">
                                    <input type="text" class="form-control bank-search @error('bank_name') is-invalid @enderror"
                                           id="bank_name" name="bank_name" value="{{ old('bank_name') }}"
                                           placeholder="Tìm kiếm ngân hàng..." autocomplete="off" required>
                                    <div class="bank-dropdown" id="bankDropdown">
                                        <div class="bank-list" id="bankList">
                                            <!-- Bank options will be populated by JavaScript -->
                                        </div>
                                    </div>
                                </div>
                                @error('bank_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="account_number">Số tài khoản <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('account_number') is-invalid @enderror"
                                       id="account_number" name="account_number" value="{{ old('account_number') }}" required>
                                @error('account_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="account_holder">Tên chủ tài khoản <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('account_holder') is-invalid @enderror"
                                       id="account_holder" name="account_holder"
                                       value="{{ old('account_holder', $defaultAccountHolder ?? '') }}"
                                       {{ $defaultAccountHolder ? 'readonly' : '' }} required>
                                @error('account_holder')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($defaultAccountHolder)
                                    <small class="form-text text-muted">
                                        Tên chủ tài khoản được thiết lập tự động từ tài khoản ngân hàng đầu tiên của bạn và không thể thay đổi.
                                    </small>
                                @else
                                    <small class="form-text text-muted">
                                        Đây là tài khoản ngân hàng đầu tiên của bạn. Vui lòng nhập tên chủ tài khoản chính xác.
                                    </small>
                                @endif
                            </div>

                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_default" name="is_default" value="1"
                                           {{ old('is_default') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_default">
                                        Đặt làm tài khoản mặc định
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Lưu tài khoản
                                </button>
                                <a href="{{ route('account.bank-accounts.index') }}" class="btn btn-secondary ml-2">
                                    Hủy
                                </a>
                            </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom styles for bank account buttons */
        .woocommerce-MyAccount-content .btn {
            background-color: #000 !important;
            border-color: #000 !important;
            color: #fff !important;
            text-align: center !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            transition: all 0.3s ease !important;
        }

        .woocommerce-MyAccount-content .btn:hover {
            background-color: #333 !important;
            border-color: #333 !important;
            color: #fff !important;
        }

        .woocommerce-MyAccount-content .btn-primary {
            background-color: #000 !important;
            border-color: #000 !important;
            color: #fff !important;
        }

        .woocommerce-MyAccount-content .btn-primary:hover {
            background-color: #333 !important;
            border-color: #333 !important;
            color: #fff !important;
        }

        .woocommerce-MyAccount-content .btn-secondary {
            background-color: #666 !important;
            border-color: #666 !important;
            color: #fff !important;
        }

        .woocommerce-MyAccount-content .btn-secondary:hover {
            background-color: #999 !important;
            border-color: #999 !important;
            color: #fff !important;
        }

        /* Center text in buttons */
        .woocommerce-MyAccount-content .btn i {
            margin-right: 5px;
        }

        /* Bank selector styles */
        .bank-selector-container {
            position: relative;
        }

        .bank-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            max-height: 300px;
            overflow: hidden;
            z-index: 1000;
            display: none;
        }


        .bank-list {
            max-height: 280px;
            overflow-y: auto;
        }

        .bank-item {
            padding: 10px 15px;
            cursor: pointer;
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.2s;
        }

        .bank-item:hover,
        .bank-item.active {
            background-color: #f8f9fa;
        }

        .bank-item:last-child {
            border-bottom: none;
        }

        .bank-search {
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15'/%3e%3cpolyline points='12,9 6,15'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 16px;
            padding-right: 35px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Bank list data
            const banks = [
                'Vietcombank', 'VPBank', 'Techcombank', 'BIDV', 'MBBANK',
                'VietinBank', 'Agribank', 'ACB', 'SHB', 'HDBank',
                'LVBank', 'VIB', 'SeABank', 'TPBank', 'MSB',
                'VBSP', 'OCB', 'Sacombank', 'Eximbank', 'SCB',
                'VDB', 'Nam A Bank', 'Woori', 'NCB', 'ABBANK',
                'UOB', 'Bac A Bank', 'PVcomBank', 'HSBC', 'Vietbank',
                'PBVN', 'SCBVL', 'SHBVN', 'BVBank', 'VietABank',
                'ANZVL', 'PGBank', 'CIMB', 'Kienlongbank', 'SAIGONBANK',
                'IVB', 'BAOVIET Bank', 'VRB', 'Co-opBank', 'HLBVN',
                'Vikki Bank', 'MBV', 'GPBank', 'VCBNeo'
            ];

            const bankSearch = document.getElementById('bank_name');
            const bankDropdown = document.getElementById('bankDropdown');
            const bankList = document.getElementById('bankList');

            let filteredBanks = [...banks];
            let selectedIndex = -1;

            // Populate bank list
            function populateBankList(banksToShow) {
                bankList.innerHTML = '';
                banksToShow.forEach((bank, index) => {
                    const bankItem = document.createElement('div');
                    bankItem.className = 'bank-item';
                    bankItem.textContent = bank;
                    bankItem.dataset.index = index;
                    bankList.appendChild(bankItem);
                });
            }

            // Show dropdown
            function showDropdown() {
                bankDropdown.style.display = 'block';
                populateBankList(filteredBanks);
            }

            // Hide dropdown
            function hideDropdown() {
                bankDropdown.style.display = 'none';
                selectedIndex = -1;
            }

            // Filter banks
            function filterBanks(searchTerm) {
                filteredBanks = banks.filter(bank =>
                    bank.toLowerCase().includes(searchTerm.toLowerCase())
                );
                populateBankList(filteredBanks);
            }

            // Select bank
            function selectBank(bankName) {
                bankSearch.value = bankName;
                hideDropdown();
                bankSearch.blur();
            }

            // Event listeners
            bankSearch.addEventListener('focus', showDropdown);
            bankSearch.addEventListener('input', function() {
                filterBanks(this.value);
                showDropdown();
            });


            // Click outside to close
            document.addEventListener('click', function(e) {
                if (!bankSearch.contains(e.target) && !bankDropdown.contains(e.target)) {
                    hideDropdown();
                }
            });

            // Bank item click
            bankList.addEventListener('click', function(e) {
                if (e.target.classList.contains('bank-item')) {
                    selectBank(e.target.textContent);
                }
            });

            // Keyboard navigation
            bankSearch.addEventListener('keydown', function(e) {
                const items = bankList.querySelectorAll('.bank-item');

                switch(e.key) {
                    case 'ArrowDown':
                        e.preventDefault();
                        selectedIndex = Math.min(selectedIndex + 1, items.length - 1);
                        updateSelection(items);
                        break;
                    case 'ArrowUp':
                        e.preventDefault();
                        selectedIndex = Math.max(selectedIndex - 1, -1);
                        updateSelection(items);
                        break;
                    case 'Enter':
                        e.preventDefault();
                        if (selectedIndex >= 0 && items[selectedIndex]) {
                            selectBank(items[selectedIndex].textContent);
                        }
                        break;
                    case 'Escape':
                        hideDropdown();
                        break;
                }
            });

            function updateSelection(items) {
                items.forEach((item, index) => {
                    item.classList.toggle('active', index === selectedIndex);
                });

                if (selectedIndex >= 0) {
                    items[selectedIndex].scrollIntoView({ block: 'nearest' });
                }
            }

            // Initialize
            populateBankList(banks);
        });
    </script>
@endsection
