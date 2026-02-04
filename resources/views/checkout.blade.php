@extends('layouts.app')

@section('title', 'Xác nhận đơn hàng - ' . ($price->type ?? 'Dịch vụ'))

@push('head')
{{-- reCAPTCHA v3 --}}
<script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key', '6LegMlIsAAAAALh9UGh23nn8c_J5Gq_MbiVNrtTY') }}"></script>
<style>.grecaptcha-badge { visibility: hidden !important; }</style>
@endpush

@section('content')
<div class="co-wrapper">
    <div class="co-container">
        {{-- Header --}}
        <div class="co-header">
            <a href="javascript:history.back()" class="co-back">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Quay lại
            </a>
            <h1 class="co-title">Xác Nhận Đơn Hàng</h1>
        </div>

        <div class="co-grid">
            {{-- Left Column: Main Content --}}
            <div class="co-main">
                {{-- Order Confirmation Card --}}
                <div class="co-card">
                    <div class="co-card-header">
                        <div class="co-card-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="1" y="4" width="22" height="16" rx="2"/><path d="M1 10h22"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="co-card-title">Xác nhận tạo đơn hàng</h2>
                            <p class="co-card-subtitle">Mã đơn sẽ được tạo sau khi xác nhận</p>
                        </div>
                    </div>

                    <div class="co-alert co-alert-info">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/>
                        </svg>
                        <span>Kiểm tra thông tin và nhấn nút bên dưới để tiếp tục</span>
                    </div>

                    {{-- Order Details --}}
                    <div class="co-details">
                        <div class="co-detail-row">
                            <span class="co-detail-label">Dịch vụ</span>
                            <span class="co-detail-value co-highlight">{{ $price->type }} {{ $price->hours_label }}</span>
                        </div>
                        <div class="co-detail-row">
                            <span class="co-detail-label">Thời hạn</span>
                            <span class="co-detail-value">{{ $price->hours_label }}</span>
                        </div>
                        @if($price->has_discount && $price->original_price)
                        <div class="co-detail-row">
                            <span class="co-detail-label">Giá gốc</span>
                            <span class="co-detail-value co-old-price">{{ number_format($price->original_price, 0, ',', '.') }}đ</span>
                        </div>
                        @endif
                        <div class="co-detail-row co-detail-total">
                            <span class="co-detail-label">Tổng thanh toán</span>
                            <span class="co-detail-value co-price">{{ number_format($price->price, 0, ',', '.') }}<small>đ</small></span>
                        </div>
                    </div>

                    {{-- Email Form --}}
                    <form method="POST" action="{{ route('checkout.create') }}" id="checkout-form">
                        @csrf
                        <input type="hidden" name="price_id" value="{{ $price->id }}">
                        <input type="hidden" name="g-recaptcha-response" id="recaptcha-response">

                        @if($errors->any())
                        <div class="co-alert co-alert-error">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/><path d="M15 9l-6 6M9 9l6 6"/>
                            </svg>
                            @foreach($errors->all() as $error)
                                <span>{{ $error }}</span>
                            @endforeach
                        </div>
                        @endif

                        <div class="co-form-group">
                            <label class="co-label">
                                Gửi tài khoản qua Gmail
                                <span class="co-optional">(tùy chọn)</span>
                            </label>
                            <input type="email" name="customer_email" class="co-input" 
                                   placeholder="example@gmail.com" value="{{ old('customer_email') }}">
                            <p class="co-hint">Nhập Gmail để nhận thông tin tài khoản sau khi thanh toán thành công</p>
                        </div>

                        <button type="submit" class="co-submit" id="submit-btn">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="1" y="4" width="22" height="16" rx="2"/><path d="M1 10h22"/>
                            </svg>
                            Xác nhận và Tạo đơn hàng
                        </button>
                    </form>

                    <a href="{{ url('/') }}" class="co-home-link">← Quay về trang chủ</a>

                    <div class="co-recaptcha-notice">
                        <p>Trang này được bảo vệ bởi reCAPTCHA</p>
                        <p>Chính sách: <a href="https://policies.google.com/privacy" target="_blank">Bảo mật</a> · <a href="https://policies.google.com/terms" target="_blank">Điều khoản</a> Google</p>
                    </div>
                </div>
            </div>

            {{-- Right Column: Trust & Summary --}}
            <div class="co-sidebar">
                {{-- Trust Badges --}}
                <div class="co-trust-card">
                    <div class="co-trust-icon co-trust-green">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                            <path d="M9 12l2 2 4-4"/>
                        </svg>
                    </div>
                    <div class="co-trust-content">
                        <h4>Bảo mật 100%</h4>
                        <p>Thông tin của bạn được mã hóa và bảo vệ bằng SSL</p>
                    </div>
                </div>

                <div class="co-trust-card">
                    <div class="co-trust-icon co-trust-blue">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12,6 12,12 16,14"/>
                        </svg>
                    </div>
                    <div class="co-trust-content">
                        <h4>Kích hoạt tự động</h4>
                        <p>Tài khoản được kích hoạt ngay sau thanh toán</p>
                    </div>
                </div>

                <div class="co-trust-card">
                    <div class="co-trust-icon co-trust-orange">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                    </div>
                    <div class="co-trust-content">
                        <h4>Hỗ trợ 24/7</h4>
                        <p>Liên hệ qua Zalo/Telegram bất cứ lúc nào</p>
                    </div>
                </div>

                {{-- Discount Badge --}}
                @if($price->has_discount && $price->original_price)
                <div class="co-discount-card">
                    <span class="co-discount-percent">-{{ $price->discount_percent }}%</span>
                    <span class="co-discount-text">Tiết kiệm {{ number_format($price->original_price - $price->price, 0, ',', '.') }}đ</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
/* ============================================
   CHECKOUT PAGE - PROFESSIONAL UI
   ============================================ */

/* Wrapper */
.co-wrapper {
    min-height: calc(100vh - 120px);
    background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
    padding: 32px 16px;
}

[data-theme="dark"] .co-wrapper {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
}

.co-container {
    max-width: 1000px;
    margin: 0 auto;
}

/* Header */
.co-header {
    margin-bottom: 24px;
}

.co-back {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #3b82f6;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    padding: 10px 16px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    transition: all 0.2s;
    margin-bottom: 12px;
}

.co-back:hover {
    background: #3b82f6;
    color: white;
}

[data-theme="dark"] .co-back {
    background: #1e293b;
    color: #60a5fa;
}

.co-title {
    font-size: 26px;
    font-weight: 800;
    color: #0f172a;
    margin: 0;
}

[data-theme="dark"] .co-title {
    color: #f8fafc;
}

/* Grid */
.co-grid {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 24px;
    align-items: start;
}

@media (max-width: 800px) {
    .co-grid {
        grid-template-columns: 1fr;
    }
    .co-sidebar {
        order: 2;
    }
}

/* Main Card */
.co-card {
    background: white;
    border: 3px solid #94a3b8;
    border-radius: 16px;
    padding: 28px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1), 0 1px 2px rgba(0,0,0,0.06);
}

[data-theme="dark"] .co-card {
    background: #1e293b;
}

/* Card Header */
.co-card-header {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 1px solid #e2e8f0;
}

[data-theme="dark"] .co-card-header {
    border-color: #334155;
}

.co-card-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    flex-shrink: 0;
}

.co-card-title {
    font-size: 18px;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 4px;
}

[data-theme="dark"] .co-card-title {
    color: #f8fafc;
}

.co-card-subtitle {
    font-size: 13px;
    color: #64748b;
    margin: 0;
}

/* Alerts */
.co-alert {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 16px;
    border-radius: 10px;
    font-size: 13px;
    margin-bottom: 20px;
}

.co-alert-info {
    background: #fef3c7;
    color: #92400e;
    border: 1px solid #fcd34d;
}

[data-theme="dark"] .co-alert-info {
    background: #422006;
    color: #fbbf24;
    border-color: #854d0e;
}

.co-alert-error {
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
}

[data-theme="dark"] .co-alert-error {
    background: #450a0a;
    border-color: #7f1d1d;
}

/* Details */
.co-details {
    background: #f8fafc;
    border-radius: 12px;
    padding: 4px 0;
    margin-bottom: 24px;
}

[data-theme="dark"] .co-details {
    background: #0f172a;
}

.co-detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 20px;
    border-bottom: 1px dashed #e2e8f0;
}

[data-theme="dark"] .co-detail-row {
    border-color: #334155;
}

.co-detail-row:last-child {
    border-bottom: none;
}

.co-detail-label {
    font-size: 14px;
    font-weight: 600;
    color: #334155;
}

[data-theme="dark"] .co-detail-label {
    color: #94a3b8;
}

.co-detail-value {
    font-size: 14px;
    font-weight: 700;
    color: #0f172a;
}

[data-theme="dark"] .co-detail-value {
    color: #f8fafc;
}

.co-highlight {
    color: #2563eb !important;
    font-weight: 700;
}

.co-old-price {
    text-decoration: line-through;
    color: #94a3b8 !important;
}

.co-detail-total {
    background: white;
    margin: 8px -20px -4px;
    padding: 16px 20px;
    border-radius: 0 0 12px 12px;
    border-top: 2px solid #e2e8f0;
    border-bottom: none !important;
}

[data-theme="dark"] .co-detail-total {
    background: #1e293b;
    border-color: #334155;
}

.co-price {
    font-size: 22px;
    font-weight: 800;
    color: #10b981 !important;
}

.co-price small {
    font-size: 13px;
    color: #64748b;
    font-weight: 500;
}

/* Form */
.co-form-group {
    margin-bottom: 20px;
}

.co-label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: #0f172a;
    margin-bottom: 8px;
}

[data-theme="dark"] .co-label {
    color: #f8fafc;
}

.co-optional {
    font-weight: 400;
    color: #94a3b8;
    font-size: 12px;
}

.co-input {
    width: 100%;
    padding: 14px 16px;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    font-size: 14px;
    background: #f8fafc;
    color: #0f172a;
    transition: all 0.2s;
}

[data-theme="dark"] .co-input {
    background: #0f172a;
    border-color: #334155;
    color: #f8fafc;
}

.co-input:focus {
    outline: none;
    border-color: #3b82f6;
    background: white;
    box-shadow: 0 0 0 3px rgba(59,130,246,0.15);
}

[data-theme="dark"] .co-input:focus {
    background: #1e293b;
}

.co-hint {
    font-size: 12px;
    color: #94a3b8;
    margin-top: 8px;
}

/* Submit Button */
.co-submit {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 16px;
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.25s;
    box-shadow: 0 4px 14px rgba(16,185,129,0.35);
}

.co-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(16,185,129,0.45);
}

.co-submit:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
}

.co-home-link {
    display: block;
    text-align: center;
    color: #64748b;
    text-decoration: none;
    font-size: 13px;
    padding: 14px;
    margin-top: 8px;
    transition: color 0.2s;
}

.co-home-link:hover {
    color: #3b82f6;
}

.co-recaptcha-notice {
    text-align: center;
    margin-top: 16px;
    padding-top: 16px;
    border-top: 1px solid #e2e8f0;
}

[data-theme="dark"] .co-recaptcha-notice {
    border-color: #334155;
}

.co-recaptcha-notice p {
    font-size: 11px;
    color: #94a3b8;
    margin: 2px 0;
}

.co-recaptcha-notice a {
    color: #3b82f6;
    text-decoration: none;
}

/* Sidebar */
.co-sidebar {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

/* Trust Cards */
.co-trust-card {
    background: white;
    border-radius: 12px;
    padding: 16px;
    display: flex;
    align-items: flex-start;
    gap: 14px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.12);
    border: 3px solid #94a3b8;
}

[data-theme="dark"] .co-trust-card {
    background: #1e293b;
}

.co-trust-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.co-trust-green {
    background: linear-gradient(135deg, #22c55e, #16a34a);
    color: white;
}

.co-trust-blue {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
}

.co-trust-orange {
    background: linear-gradient(135deg, #f97316, #ea580c);
    color: white;
}

[data-theme="dark"] .co-trust-green {
    background: linear-gradient(135deg, #14532d, #166534);
}

[data-theme="dark"] .co-trust-blue {
    background: linear-gradient(135deg, #1e3a5f, #1e40af);
}

[data-theme="dark"] .co-trust-orange {
    background: linear-gradient(135deg, #431407, #7c2d12);
}

.co-trust-content h4 {
    font-size: 14px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px;
}

[data-theme="dark"] .co-trust-content h4 {
    color: #f8fafc;
}

.co-trust-content p {
    font-size: 12px;
    color: #475569;
    margin: 0;
    line-height: 1.5;
    font-weight: 500;
}

[data-theme="dark"] .co-trust-content p {
    color: #94a3b8;
}

/* Discount Card */
.co-discount-card {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    color: white;
}

.co-discount-percent {
    display: block;
    font-size: 28px;
    font-weight: 800;
    margin-bottom: 4px;
}

.co-discount-text {
    font-size: 13px;
    opacity: 0.9;
}

/* Animations */
@keyframes spin {
    to { transform: rotate(360deg); }
}

.animate-spin {
    animation: spin 1s linear infinite;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('checkout-form');
    const submitBtn = document.getElementById('submit-btn');
    const recaptchaInput = document.getElementById('recaptcha-response');
    const siteKey = '{{ config('services.recaptcha.site_key', '6LegMlIsAAAAALh9UGh23nn8c_J5Gq_MbiVNrtTY') }}';

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg class="animate-spin" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10" stroke-dasharray="32" stroke-dashoffset="12"/>
            </svg>
            Đang xử lý...
        `;
        
        if (typeof grecaptcha !== 'undefined') {
            grecaptcha.ready(function() {
                grecaptcha.execute(siteKey, {action: 'create_order'}).then(function(token) {
                    recaptchaInput.value = token;
                    form.submit();
                }).catch(function() {
                    form.submit();
                });
            });
        } else {
            form.submit();
        }
    });
});
</script>
@endsection
