@extends('layouts.app')

@section('title', 'Thanh toán - ' . ($price->type ?? 'Dịch vụ'))

@push('head')
{{-- reCAPTCHA v3 --}}
<script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key', '6LegMlIsAAAAALh9UGh23nn8c_J5Gq_MbiVNrtTY') }}"></script>
<style>
.grecaptcha-badge { visibility: hidden !important; }
</style>
@endpush

@section('content')
<div class="checkout-wrapper">
    <div class="checkout-container">
        {{-- Header --}}
        <div class="checkout-header">
            <a href="javascript:history.back()" class="back-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Quay lại
            </a>
            <h1 class="page-title">Xác Nhận Đơn Hàng</h1>
        </div>

        <div class="checkout-grid">
            {{-- Left: Order Summary --}}
            <div class="order-summary-card">
                <div class="card-header">
                    <div class="cart-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                        </svg>
                    </div>
                    <span>Xác nhận tạo đơn hàng</span>
                </div>

                <p class="info-text">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/>
                    </svg>
                    Kiểm tra thông tin và nhấn nút bên dưới để tiếp tục
                </p>

                <div class="order-details">
                    <div class="detail-row">
                        <span class="label">Dịch vụ</span>
                        <span class="value highlight">{{ $price->type }} {{ $price->hours_label }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="label">Thời hạn</span>
                        <span class="value">{{ $price->hours_label }}</span>
                    </div>
                    @if($price->has_discount)
                    <div class="detail-row">
                        <span class="label">Giá gốc</span>
                        <span class="value old-price">{{ number_format($price->original_price, 0, ',', '.') }}đ</span>
                    </div>
                    @endif
                    <div class="detail-row total">
                        <span class="label">Tổng thanh toán</span>
                        <span class="value price">{{ number_format($price->price, 0, ',', '.') }}<small>đ</small></span>
                    </div>
                </div>

                {{-- Email Input --}}
                <form method="POST" action="{{ route('checkout.create') }}" class="checkout-form" id="checkout-form">
                    @csrf
                    <input type="hidden" name="price_id" value="{{ $price->id }}">
                    <input type="hidden" name="g-recaptcha-response" id="recaptcha-response">

                    @if($errors->any())
                    <div class="error-alert">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/><path d="M15 9l-6 6M9 9l6 6"/>
                        </svg>
                        @foreach($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                    @endif

                    <div class="form-group">
                        <label class="form-label">
                            Gửi tài khoản qua Gmail
                            <span class="optional">(tùy chọn)</span>
                        </label>
                        <input type="email" name="customer_email" class="form-input" 
                               placeholder="example@gmail.com" value="{{ old('customer_email') }}">
                        <p class="form-hint">
                            Nhập Gmail để nhận thông tin tài khoản sau khi thanh toán thành công
                        </p>
                    </div>

                    <button type="submit" class="submit-btn" id="submit-btn">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="1" y="4" width="22" height="16" rx="2"/><path d="M1 10h22"/>
                        </svg>
                        Xác nhận và Tạo đơn hàng
                    </button>
                </form>

                <a href="{{ url('/') }}" class="home-link">← Quay về trang chủ</a>

                <div class="recaptcha-notice">
                    <p>Trang này được bảo vệ bởi reCAPTCHA</p>
                    <p>Chính sách: <a href="https://policies.google.com/privacy" target="_blank">Bảo mật</a> · <a href="https://policies.google.com/terms" target="_blank">Điều khoản</a> Google</p>
                </div>
            </div>

            {{-- Right: Trust Badges --}}
            <div class="trust-section">
                <div class="trust-card">
                    <div class="trust-icon green">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                            <path d="M9 12l2 2 4-4"/>
                        </svg>
                    </div>
                    <div class="trust-content">
                        <h4>Bảo mật 100%</h4>
                        <p>Thông tin của bạn được mã hóa và bảo vệ bằng SSL</p>
                    </div>
                </div>

                <div class="trust-card">
                    <div class="trust-icon blue">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12,6 12,12 16,14"/>
                        </svg>
                    </div>
                    <div class="trust-content">
                        <h4>Kích hoạt tự động</h4>
                        <p>Tài khoản được kích hoạt ngay sau thanh toán</p>
                    </div>
                </div>

                <div class="trust-card">
                    <div class="trust-icon orange">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                    </div>
                    <div class="trust-content">
                        <h4>Hỗ trợ 24/7</h4>
                        <p>Liên hệ qua Zalo/Telegram bất cứ lúc nào</p>
                    </div>
                </div>

                @if($price->has_discount)
                <div class="discount-badge">
                    <span class="discount-percent">-{{ $price->discount_percent }}%</span>
                    <span class="discount-text">Tiết kiệm {{ number_format($price->original_price - $price->price, 0, ',', '.') }}đ</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
/* Checkout Wrapper */
.checkout-wrapper {
    min-height: calc(100vh - 120px);
    background: linear-gradient(135deg, #f0f4f8 0%, #e2e8f0 100%);
    padding: 40px 20px;
}

[data-theme="dark"] .checkout-wrapper {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
}

.checkout-container {
    max-width: 900px;
    margin: 0 auto;
}

/* Header */
.checkout-header {
    margin-bottom: 32px;
}

.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #3b82f6;
    text-decoration: none;
    font-weight: 500;
    font-size: 14px;
    margin-bottom: 16px;
    padding: 8px 16px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    transition: all 0.2s;
}

.back-btn:hover {
    background: #3b82f6;
    color: white;
    transform: translateX(-4px);
}

[data-theme="dark"] .back-btn {
    background: #1e293b;
    color: #60a5fa;
}

[data-theme="dark"] .back-btn:hover {
    background: #3b82f6;
    color: white;
}

.page-title {
    font-size: 28px;
    font-weight: 800;
    color: #1e293b;
    margin: 0;
}

[data-theme="dark"] .page-title {
    color: #f1f5f9;
}

/* Grid Layout */
.checkout-grid {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 24px;
}

@media (max-width: 768px) {
    .checkout-grid {
        grid-template-columns: 1fr;
    }
    .trust-section {
        order: 2;
    }
}

/* Order Summary Card */
.order-summary-card {
    background: white;
    border-radius: 24px;
    padding: 32px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.08);
    border: 1px solid #e2e8f0;
}

[data-theme="dark"] .order-summary-card {
    background: #1e293b;
    border-color: #334155;
}

.card-header {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 18px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 16px;
}

[data-theme="dark"] .card-header {
    color: #f1f5f9;
}

.cart-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.info-text {
    display: flex;
    align-items: center;
    gap: 8px;
    background: #fef3c7;
    color: #92400e;
    padding: 12px 16px;
    border-radius: 12px;
    font-size: 13px;
    margin-bottom: 24px;
}

[data-theme="dark"] .info-text {
    background: #422006;
    color: #fbbf24;
}

/* Order Details */
.order-details {
    background: #f8fafc;
    border-radius: 16px;
    padding: 20px;
    margin-bottom: 24px;
}

[data-theme="dark"] .order-details {
    background: #0f172a;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px dashed #e2e8f0;
}

[data-theme="dark"] .detail-row {
    border-color: #334155;
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-row .label {
    color: #64748b;
    font-size: 14px;
}

[data-theme="dark"] .detail-row .label {
    color: #94a3b8;
}

.detail-row .value {
    font-weight: 600;
    color: #1e293b;
}

[data-theme="dark"] .detail-row .value {
    color: #f1f5f9;
}

.detail-row .value.highlight {
    color: #3b82f6;
}

.detail-row .value.old-price {
    text-decoration: line-through;
    color: #94a3b8;
}

.detail-row.total {
    margin-top: 8px;
    padding-top: 16px;
    border-top: 2px solid #e2e8f0;
    border-bottom: none;
}

[data-theme="dark"] .detail-row.total {
    border-color: #334155;
}

.detail-row .value.price {
    font-size: 24px;
    font-weight: 800;
    color: #10b981;
}

.detail-row .value.price small {
    font-size: 14px;
    color: #64748b;
}

/* Form Styles */
.checkout-form {
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-label {
    display: block;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 8px;
    font-size: 14px;
}

[data-theme="dark"] .form-label {
    color: #f1f5f9;
}

.form-label .optional {
    font-weight: 400;
    color: #94a3b8;
    font-size: 12px;
}

.form-input {
    width: 100%;
    padding: 14px 18px;
    border: 2px solid #e2e8f0;
    border-radius: 14px;
    font-size: 15px;
    background: #f8fafc;
    transition: all 0.2s;
    color: #1e293b;
}

[data-theme="dark"] .form-input {
    background: #0f172a;
    border-color: #334155;
    color: #f1f5f9;
}

.form-input:focus {
    outline: none;
    border-color: #3b82f6;
    background: white;
    box-shadow: 0 0 0 4px rgba(59,130,246,0.15);
}

[data-theme="dark"] .form-input:focus {
    background: #1e293b;
}

.form-hint {
    margin-top: 8px;
    font-size: 12px;
    color: #94a3b8;
}

.error-alert {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #dc2626;
    padding: 14px 18px;
    border-radius: 14px;
    margin-bottom: 20px;
    font-size: 14px;
}

[data-theme="dark"] .error-alert {
    background: #450a0a;
    border-color: #7f1d1d;
}

/* Submit Button */
.submit-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 18px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    border: none;
    border-radius: 14px;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 4px 16px rgba(16,185,129,0.3);
}

.submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(16,185,129,0.4);
}

.submit-btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
}

.home-link {
    display: block;
    text-align: center;
    color: #64748b;
    text-decoration: none;
    font-size: 14px;
    padding: 12px;
    transition: color 0.2s;
}

.home-link:hover {
    color: #3b82f6;
}

.recaptcha-notice {
    text-align: center;
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #e2e8f0;
}

[data-theme="dark"] .recaptcha-notice {
    border-color: #334155;
}

.recaptcha-notice p {
    font-size: 11px;
    color: #94a3b8;
    margin: 4px 0;
}

.recaptcha-notice a {
    color: #3b82f6;
    text-decoration: none;
}

/* Trust Section */
.trust-section {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.trust-card {
    background: white;
    border-radius: 16px;
    padding: 20px;
    display: flex;
    align-items: flex-start;
    gap: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    border: 1px solid #e2e8f0;
}

[data-theme="dark"] .trust-card {
    background: #1e293b;
    border-color: #334155;
}

.trust-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.trust-icon.green {
    background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
    color: #16a34a;
}

.trust-icon.blue {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    color: #2563eb;
}

.trust-icon.orange {
    background: linear-gradient(135deg, #ffedd5 0%, #fed7aa 100%);
    color: #ea580c;
}

[data-theme="dark"] .trust-icon.green {
    background: linear-gradient(135deg, #14532d 0%, #166534 100%);
}

[data-theme="dark"] .trust-icon.blue {
    background: linear-gradient(135deg, #1e3a5f 0%, #1e40af 100%);
}

[data-theme="dark"] .trust-icon.orange {
    background: linear-gradient(135deg, #431407 0%, #7c2d12 100%);
}

.trust-content h4 {
    font-size: 14px;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 4px;
}

[data-theme="dark"] .trust-content h4 {
    color: #f1f5f9;
}

.trust-content p {
    font-size: 12px;
    color: #64748b;
    margin: 0;
    line-height: 1.5;
}

[data-theme="dark"] .trust-content p {
    color: #94a3b8;
}

/* Discount Badge */
.discount-badge {
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    border-radius: 16px;
    padding: 20px;
    text-align: center;
    color: white;
}

.discount-percent {
    display: block;
    font-size: 32px;
    font-weight: 800;
    margin-bottom: 4px;
}

.discount-text {
    font-size: 14px;
    opacity: 0.9;
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
        
        // Disable button and show loading
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg class="animate-spin" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10" stroke-dasharray="32" stroke-dashoffset="12"/>
            </svg>
            Đang xử lý...
        `;
        
        // Execute reCAPTCHA
        if (typeof grecaptcha !== 'undefined') {
            grecaptcha.ready(function() {
                grecaptcha.execute(siteKey, {action: 'create_order'}).then(function(token) {
                    recaptchaInput.value = token;
                    form.submit();
                }).catch(function() {
                    // If reCAPTCHA fails, still submit
                    form.submit();
                });
            });
        } else {
            // No reCAPTCHA, submit directly
            form.submit();
        }
    });
});
</script>
@endsection
