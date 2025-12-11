<!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Vendor css (Require in all Page) -->
    <link href="{{ asset('assets/css/vendor.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Icons css (Require in all Page) -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- App css (Require in all Page) -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Theme Config js (Require in all Page) -->
<script src="{{ asset('assets/js/config.js') }}"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/github-dark.min.css">
<style>
    /* Wrapper chứa các thumbnail */
.thumbs-wrapper {
    justify-content: flex-start;
    gap: 8px;
    overflow-x: auto;
    padding: 6px 0;
    white-space: nowrap;
}

/* Ẩn bớt scrollbar cho gọn (tuỳ chọn) */
.thumbs-wrapper::-webkit-scrollbar {
    height: 6px;
}

.thumbs-wrapper::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.thumbs-wrapper::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}

/* Nút thumbnail */
.thumb-indicator {
    border: none;
    padding: 0;
    background: #f5f5f5;
    width: 70px;
    height: 70px;
    flex: 0 0 auto;
    border-radius: 8px;
    overflow: hidden;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: 0.2s ease;
}

.thumb-indicator:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
}

/* Ảnh bên trong thumbnail */
.thumb-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

/* Active state: bo viền nổi bật */
.carousel-indicators .thumb-indicator.active {
    border: 2px solid var(--brand-gold, #c1995a);
    background: #fff;
}

</style>
