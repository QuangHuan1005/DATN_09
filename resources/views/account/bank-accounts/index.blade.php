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
                                                class="delimiter">/</span>Thanh toán</nav>
                                        <h1 class="page-title">Tài khoản của tôi</h1>
                                    </div>
                                    <article class="post-11 page type-page status-publish hentry">
                                        <div class="entry-content">
                                            <div class="woocommerce">
                                                @include('account.partials.navigation')
                                                <div class="woocommerce-MyAccount-content">
                                                    <div class="woocommerce-notices-wrapper"></div>

                                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                                        <div>
                                                            <h2 class="woocommerce-order-details__title">Tài khoản ngân hàng</h2>
                                                            <small class="text-muted">Bạn có thể thêm tối đa {{ $maxAccounts }} tài khoản (hiện có: {{ $bankAccounts->count() }})</small>
                                                        </div>
                                                        @if($canAddMore)
                                                            <a href="{{ route('account.bank-accounts.create') }}" class="btn btn-primary">
                                                                <i class="fa fa-plus"></i> Thêm tài khoản
                                                            </a>
                                                        @else
                                                            <span class="text-warning">
                                                                <i class="fa fa-info-circle"></i> Đã đạt giới hạn {{ $maxAccounts }} tài khoản
                                                            </span>
                                                        @endif
                                                    </div>

                                                    @if(session('success'))
                                                        <div class="alert alert-success">
                                                            {{ session('success') }}
                                                        </div>
                                                    @endif

                                                    @if(session('error'))
                                                        <div class="alert alert-danger">
                                                            {{ session('error') }}
                                                        </div>
                                                    @endif

                        @if($bankAccounts->count() > 0)
                            <div class="bank-accounts-grid">
                                @foreach($bankAccounts as $account)
                                    <div class="bank-account-card">
                                        <div class="bank-account-header">
                                            <div class="bank-info">
                                                <div class="bank-name">{{ $account->bank_name }}</div>
                                                @if($account->is_default)
                                                    <span class="default-badge">
                                                        <i class="fa fa-star"></i> Mặc định
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="bank-actions">
                                                @if(!$account->is_default)
                                                    <form method="POST" action="{{ route('account.bank-accounts.set-default', $account->id) }}" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-secondary" title="Đặt làm mặc định">
                                                            <i class="fa fa-star-o"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                @if(!$account->is_default || $bankAccounts->count() > 1)
                                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteBankAccount({{ $account->id }}, '{{ addslashes($account->bank_name) }}')" title="Xóa tài khoản">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="bank-account-body">
                                            <div class="account-detail">
                                                <label>Số tài khoản:</label>
                                                <span class="account-number">{{ $account->masked_account_number }}</span>
                                            </div>
                                            <div class="account-detail">
                                                <label>Chủ tài khoản:</label>
                                                <span>{{ $account->account_holder }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                                                    @else
                                                        <div class="text-center py-5">
                                                            <i class="fa fa-credit-card fa-3x text-muted mb-3"></i>
                                                            <h4>Bạn chưa có tài khoản ngân hàng nào</h4>
                                                            <p class="text-muted">Thêm tài khoản ngân hàng để thuận tiện cho việc thanh toán và nhận tiền hoàn lại.</p>
                                                            @if($canAddMore)
                                                                <a href="{{ route('account.bank-accounts.create') }}" class="btn btn-primary">
                                                                    <i class="fa fa-plus"></i> Thêm tài khoản ngân hàng đầu tiên
                                                                </a>
                                                            @endif
                                                        </div>
                                                    @endif
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

        .woocommerce-MyAccount-content .btn-outline-primary {
            background-color: #000 !important;
            border-color: #000 !important;
            color: #fff !important;
        }

        .woocommerce-MyAccount-content .btn-outline-primary:hover {
            background-color: #333 !important;
            border-color: #333 !important;
            color: #fff !important;
        }

        .woocommerce-MyAccount-content .btn-danger {
            background-color: #000 !important;
            border-color: #000 !important;
            color: #fff !important;
        }

        .woocommerce-MyAccount-content .btn-danger:hover {
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

        /* Bank accounts grid and cards */
        .bank-accounts-grid {
            display: grid;
            gap: 20px;
        }

        .bank-account-card {
            border: 1px solid #e1e5e9;
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
            transition: box-shadow 0.3s ease;
        }

        .bank-account-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .bank-account-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 24px;
            border-bottom: 1px solid #f0f2f5;
            background: #fafbfc;
        }

        .bank-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .bank-name {
            font-size: 18px;
            font-weight: 600;
            color: #1a202c;
        }

        .default-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 8px;
            background: #fef3c7;
            color: #92400e;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
        }

        .default-badge i {
            font-size: 10px;
        }

        .bank-actions {
            display: flex;
            gap: 8px;
            justify-content: center;
        }

        .bank-actions .btn {
            width: 36px;
            height: 36px;
            padding: 0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .bank-actions .btn i {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }

        .bank-account-body {
            padding: 20px 24px;
        }

        .account-detail {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .account-detail:last-child {
            margin-bottom: 0;
        }

        .account-detail label {
            font-weight: 500;
            color: #64748b;
            font-size: 14px;
            min-width: 120px;
        }

        .account-detail span {
            font-weight: 500;
            color: #1a202c;
            text-align: right;
        }

        .account-number {
            font-family: 'Monaco', 'Menlo', monospace;
            letter-spacing: 0.5px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .bank-account-header {
                padding: 16px 20px;
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .bank-info {
                width: 100%;
                justify-content: space-between;
            }

            .bank-actions {
                width: 100%;
                justify-content: flex-end;
            }

            .bank-account-body {
                padding: 16px 20px;
            }

            .account-detail {
                flex-direction: column;
                align-items: flex-start;
                gap: 4px;
            }

            .account-detail label {
                min-width: auto;
            }

            .account-detail span {
                text-align: left;
            }
        }

        /* Modal improvements */
        .modal-content {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            border-bottom: 1px solid #e1e5e9;
            padding: 20px 24px;
        }

        .modal-title {
            font-weight: 600;
            color: #1a202c;
        }

        .modal-body {
            padding: 24px;
            color: #64748b;
        }

        .modal-footer {
            border-top: 1px solid #e1e5e9;
            padding: 20px 24px;
        }

        .close {
            font-size: 24px;
            opacity: 0.6;
        }

        .close:hover {
            opacity: 1;
        }

        /* Custom Modal Styles */
        .custom-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .custom-modal {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            max-width: 450px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .custom-modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid #e1e5e9;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .custom-modal-title {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
            color: #1a202c;
        }

        .custom-modal-body {
            padding: 24px;
            color: #64748b;
            line-height: 1.6;
        }

        .custom-modal-body p {
            margin-bottom: 12px;
        }

        .custom-modal-body p:last-child {
            margin-bottom: 0;
        }

        .custom-modal-footer {
            padding: 20px 24px;
            border-top: 1px solid #e1e5e9;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        .custom-modal-footer .btn {
            min-width: 100px;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .custom-modal {
                margin: 20px;
                width: calc(100% - 40px);
            }

            .custom-modal-header,
            .custom-modal-body,
            .custom-modal-footer {
                padding: 16px 20px;
            }

            .custom-modal-footer {
                flex-direction: column;
            }

            .custom-modal-footer .btn {
                width: 100%;
            }
        }
    </style>

    <!-- Custom Delete Modal -->
    <div id="customDeleteModal" class="custom-modal-overlay" style="display: none;">
        <div class="custom-modal">
            <div class="custom-modal-header">
                <h5 class="custom-modal-title">Xác nhận xóa tài khoản</h5>
            </div>
            <div class="custom-modal-body">
                <p>Bạn có chắc muốn xóa tài khoản <strong id="deleteBankName"></strong> không?</p>
                <p class="text-warning"><small>Hành động này không thể hoàn tác.</small></p>
            </div>
            <div class="custom-modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">Hủy</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Xóa tài khoản</button>
            </div>
        </div>
    </div>

    <script>
        let deleteAccountId = null;

        function deleteBankAccount(accountId, bankName) {
            deleteAccountId = accountId;
            document.getElementById('deleteBankName').textContent = bankName;
            document.getElementById('customDeleteModal').style.display = 'flex';
        }

        function closeDeleteModal() {
            document.getElementById('customDeleteModal').style.display = 'none';
            deleteAccountId = null;
        }

        function confirmDelete() {
            if (deleteAccountId) {
                // Tạo form và submit
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = '/account/payment/' + deleteAccountId;

                // Add CSRF token
                var csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                // Add method spoofing
                var methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                form.appendChild(methodField);

                document.body.appendChild(form);
                form.submit();
            }
        }

        // Close modal when clicking outside
        document.getElementById('customDeleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        // Handle confirm button
        document.getElementById('confirmDeleteBtn').addEventListener('click', confirmDelete);

        // Handle ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && document.getElementById('customDeleteModal').style.display === 'flex') {
                closeDeleteModal();
            }
        });
    </script>
@endsection
