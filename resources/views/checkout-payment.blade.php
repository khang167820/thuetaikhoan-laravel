@extends('layouts.app')

@section('title', 'Thanh toán - ' . $order->tracking_code)

@section('content')
<div class="cp-wrapper">
    {{-- Back Button --}}
    <a href="/" class="cp-back">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
        </svg>
        Quay về trang chủ
    </a>

    <div class="cp-container">
        {{-- Header Card --}}
        <div class="cp-header-card">
            <div class="cp-header-left">
                <div class="cp-service-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"/>
                    </svg>
                </div>
                <div>
                    <h1 class="cp-service-name">{{ $price->type ?? 'Dịch vụ' }}</h1>
                    <div class="cp-duration">{{ $price->hours_label }}</div>
                </div>
            </div>
            <div class="cp-header-right">
                <div class="cp-amount-label">Thanh toán</div>
                <div class="cp-amount">{{ number_format($order->amount, 0, ',', '.') }}<small>đ</small></div>
            </div>
        </div>

        {{-- Order Code Badge --}}
        <div class="cp-order-badge">
            <span class="cp-badge-label">Mã đơn hàng</span>
            <span class="cp-badge-code">{{ $order->tracking_code }}</span>
            <button type="button" class="cp-copy-btn" onclick="copyOrderCode()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                </svg>
            </button>
        </div>

        {{-- Main Content Grid --}}
        <div class="cp-grid">
            {{-- Left: QR Payment --}}
            <div class="cp-qr-card">
                <div class="cp-qr-header">
                    <div class="cp-qr-icon">📱</div>
                    <div>
                        <div class="cp-qr-title">Quét mã QR để thanh toán</div>
                        <div class="cp-qr-sub">Hỗ trợ tất cả ứng dụng ngân hàng</div>
                    </div>
                </div>

                <div class="cp-qr-wrapper">
                    <img src="{{ $qrUrl }}" alt="QR Payment" class="cp-qr-img">
                    <div class="cp-qr-brand">
                        <img src="/images/vietqr-logo.png" alt="VietQR" onerror="this.style.display='none'">
                        <span>{{ $bankInfo['bank_code'] ?? 'ACB' }}</span>
                    </div>
                </div>

                <div class="cp-bank-info">
                    <div class="cp-bank-row">
                        <span class="cp-bank-label">Ngân hàng</span>
                        <span class="cp-bank-value">{{ $bankInfo['name'] }}</span>
                    </div>
                    <div class="cp-bank-row">
                        <span class="cp-bank-label">Số tài khoản</span>
                        <span class="cp-bank-value cp-highlight">{{ $bankInfo['account'] }}</span>
                    </div>
                    <div class="cp-bank-row">
                        <span class="cp-bank-label">Chủ tài khoản</span>
                        <span class="cp-bank-value">{{ $bankInfo['owner'] }}</span>
                    </div>
                    <div class="cp-bank-row">
                        <span class="cp-bank-label">Nội dung CK</span>
                        <span class="cp-bank-value cp-code">{{ $order->tracking_code }}</span>
                    </div>
                    <div class="cp-bank-row cp-bank-amount">
                        <span class="cp-bank-label">Số tiền</span>
                        <span class="cp-bank-value cp-price">{{ number_format($order->amount, 0, ',', '.') }} đ</span>
                    </div>
                </div>

                <div class="cp-warning">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                        <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                    <span>Nội dung chuyển khoản <strong>phải giống 100%</strong>: <code>{{ $order->tracking_code }}</code></span>
                </div>
            </div>

            {{-- Right: Summary & Actions --}}
            <div class="cp-summary-card">
                {{-- Order Summary --}}
                <div class="cp-summary-section">
                    <div class="cp-summary-header">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                        </svg>
                        Thông tin đơn hàng
                    </div>
                    <div class="cp-summary-body">
                        <div class="cp-summary-row">
                            <span>Dịch vụ</span>
                            <span class="cp-summary-val">{{ $price->type }}</span>
                        </div>
                        <div class="cp-summary-row">
                            <span>Thời hạn</span>
                            <span class="cp-summary-val">{{ $price->hours_label }}</span>
                        </div>
                        <div class="cp-summary-row">
                            <span>Giá gốc</span>
                            <span class="cp-summary-val @if(($pointsDiscount ?? 0) > 0 || ($couponDiscount ?? 0) > 0) cp-old-price @endif">{{ number_format($originalPrice ?? $price->price, 0, ',', '.') }}đ</span>
                        </div>
                        @if(($pointsDiscount ?? 0) > 0)
                        <div class="cp-summary-row cp-discount-row">
                            <span>🎁 Điểm tích lũy</span>
                            <span class="cp-summary-discount">-{{ number_format($pointsDiscount, 0, ',', '.') }}đ</span>
                        </div>
                        @endif
                        @if(($couponDiscount ?? 0) > 0)
                        <div class="cp-summary-row cp-discount-row">
                            <span>🏷️ Mã {{ $couponCode ?? 'giảm giá' }}</span>
                            <span class="cp-summary-discount">-{{ number_format($couponDiscount, 0, ',', '.') }}đ</span>
                        </div>
                        @endif
                        <div class="cp-summary-row cp-summary-total">
                            <span>💰 Tổng thanh toán</span>
                            <span class="cp-summary-price">{{ number_format($order->amount, 0, ',', '.') }}đ</span>
                        </div>
                    </div>
                </div>

                {{-- Status --}}
                <div class="cp-status" id="cp-status">
                    <div class="cp-status-icon" id="cp-status-icon">
                        <div class="cp-spinner"></div>
                    </div>
                    <div class="cp-status-text">
                        <div class="cp-status-title" id="cp-status-title">Đang chờ thanh toán</div>
                        <div class="cp-status-sub" id="cp-status-sub">Hệ thống tự động xác nhận sau khi nhận được tiền</div>
                    </div>
                </div>

                {{-- Balance Payment Option --}}
                @if($isLoggedIn)
                <div class="cp-balance-section">
                    <div class="cp-balance-header">
                        <span>💰 Số dư tài khoản</span>
                        <span class="cp-balance-amount">{{ number_format($userBalance, 0, ',', '.') }}đ</span>
                    </div>
                    @if($userBalance >= $order->amount)
                    {{-- MAINTENANCE MODE - Remove this block after 17:00 --}}
                    <div class="cp-maintenance-notice">
                        <div style="font-size: 13px; color: #dc2626; margin-bottom: 8px;">
                            🔧 <strong>Đang bảo trì đến 17:00</strong>
                        </div>
                        <div style="font-size: 12px; color: #64748b;">
                            Vui lòng đợi xử lý hoặc liên hệ admin
                        </div>
                    </div>
                    {{-- END MAINTENANCE - Uncomment below after 17:00
                    <button type="button" id="pay-with-balance-btn" class="cp-btn-balance">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                        Thanh toán bằng số dư
                    </button>
                    --}}
                    @else
                    <div class="cp-balance-warn">
                        ⚠️ Thiếu {{ number_format($order->amount - $userBalance, 0, ',', '.') }}đ để thanh toán
                    </div>
                    <a href="/nap-tien" class="cp-btn-deposit">Nạp thêm tiền</a>
                    @endif
                </div>
                @else
                <div class="cp-login-section">
                    <div class="cp-login-text">
                        <a href="/login?redirect={{ urlencode(request()->fullUrl()) }}">Đăng nhập</a> 
                        để thanh toán bằng số dư tài khoản
                    </div>
                </div>
                @endif

                {{-- Help --}}
                <div class="cp-help">
                    <div class="cp-help-title">Cần hỗ trợ?</div>
                    <div class="cp-help-links">
                        <a href="https://zalo.me/0367820066" target="_blank" class="cp-zalo">
                            <svg width="18" height="18" viewBox="0 0 48 48" fill="none">
                                <circle cx="24" cy="24" r="24" fill="#0068FF"/>
                                <path d="M32.5 15H15.5C14.67 15 14 15.67 14 16.5V31.5C14 32.33 14.67 33 15.5 33H32.5C33.33 33 34 32.33 34 31.5V16.5C34 15.67 33.33 15 32.5 15ZM30 19L24 26L18 19H30ZM16 31V19.5L24 28.5L32 19.5V31H16Z" fill="white"/>
                            </svg>
                            Zalo
                        </a>
                        <a href="https://t.me/thuetaikhoan" target="_blank" class="cp-telegram">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221l-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.446 1.394c-.16.16-.295.295-.605.295l.213-3.053 5.56-5.023c.242-.213-.054-.333-.373-.121l-6.869 4.326-2.96-.924c-.643-.203-.657-.643.135-.953l11.566-4.458c.537-.194 1.006.131.833.94z"/>
                            </svg>
                            Telegram
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ============================================
   CHECKOUT PAYMENT - Premium Modern Design
   Đồng bộ với style website
   ============================================ */

.cp-wrapper {
    min-height: calc(100vh - 80px);
    background: linear-gradient(180deg, #f1f5f9 0%, #e2e8f0 100%);
    padding: 24px 16px 60px;
}

[data-theme="dark"] .cp-wrapper {
    background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
}

.cp-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--primary, #1e40af);
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 20px;
    transition: all 0.2s;
}
.cp-back:hover { opacity: 0.8; transform: translateX(-4px); }

.cp-container {
    max-width: 900px;
    margin: 0 auto;
}

/* Header Card */
.cp-header-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
    border-radius: 20px;
    padding: 28px 32px;
    color: white;
    margin-bottom: 16px;
    box-shadow: 0 8px 32px rgba(30, 64, 175, 0.25);
}
.cp-header-left { display: flex; align-items: center; gap: 16px; }
.cp-service-icon {
    width: 56px; height: 56px;
    background: rgba(255,255,255,0.15);
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
}
.cp-service-name { font-size: 22px; font-weight: 700; margin: 0; }
.cp-duration { font-size: 14px; opacity: 0.85; margin-top: 4px; }
.cp-header-right { text-align: right; }
.cp-amount-label { font-size: 12px; opacity: 0.75; text-transform: uppercase; letter-spacing: 0.5px; }
.cp-amount { font-size: 36px; font-weight: 800; margin-top: 4px; }
.cp-amount small { font-size: 20px; opacity: 0.8; }

/* Order Badge */
.cp-order-badge {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    background: white;
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    padding: 14px 20px;
    margin-bottom: 20px;
}
[data-theme="dark"] .cp-order-badge { background: #1e293b; border-color: #475569; }
.cp-badge-label { color: var(--muted, #6b7280); font-size: 13px; }
.cp-badge-code { font-size: 18px; font-weight: 700; color: var(--primary, #1e40af); letter-spacing: 1px; }
.cp-copy-btn {
    background: #f1f5f9; border: none; border-radius: 8px;
    width: 36px; height: 36px; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.2s;
}
.cp-copy-btn:hover { background: #e2e8f0; }
[data-theme="dark"] .cp-copy-btn { background: #334155; color: #fff; }

/* Main Grid */
.cp-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}
@media (max-width: 768px) {
    .cp-grid { grid-template-columns: 1fr; }
    .cp-header-card { flex-direction: column; text-align: center; gap: 16px; }
    .cp-header-left { flex-direction: column; }
    .cp-header-right { text-align: center; }
    .cp-amount { font-size: 28px; }
}

/* QR Card */
.cp-qr-card {
    background: white;
    border-radius: 20px;
    padding: 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
}
[data-theme="dark"] .cp-qr-card { background: #1e293b; }

.cp-qr-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
}
.cp-qr-icon { font-size: 28px; }
.cp-qr-title { font-weight: 700; font-size: 16px; color: var(--ink, #1f2937); }
.cp-qr-sub { font-size: 12px; color: var(--muted, #6b7280); margin-top: 2px; }

.cp-qr-wrapper {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-radius: 16px;
    padding: 20px;
    text-align: center;
    margin-bottom: 20px;
}
[data-theme="dark"] .cp-qr-wrapper { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); }
.cp-qr-img {
    max-width: 200px;
    width: 100%;
    border-radius: 12px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.1);
}
.cp-qr-brand {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: 12px;
    font-size: 12px;
    color: var(--muted, #6b7280);
}
.cp-qr-brand img { height: 20px; }

/* Bank Info */
.cp-bank-info { margin-bottom: 16px; }
.cp-bank-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid var(--line, #e5e7eb);
    font-size: 13px;
}
.cp-bank-row:last-child { border-bottom: none; }
.cp-bank-label { color: var(--muted, #6b7280); }
.cp-bank-value { font-weight: 600; color: var(--ink, #1f2937); }
.cp-bank-value.cp-highlight { color: var(--primary, #1e40af); }
.cp-bank-value.cp-code { font-family: monospace; letter-spacing: 1px; color: #7c3aed; }
.cp-bank-value.cp-price { color: #10b981; font-size: 15px; }
.cp-bank-amount { background: #f0fdf4; margin: 8px -24px -8px; padding: 12px 24px !important; border-radius: 0 0 16px 16px; }
[data-theme="dark"] .cp-bank-amount { background: #064e3b; }

/* Warning */
.cp-warning {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    background: linear-gradient(135deg, #fef3c7 0%, #fef9c3 100%);
    border: 1px solid #fcd34d;
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 12px;
    color: #92400e;
}
.cp-warning svg { flex-shrink: 0; color: #f59e0b; }
.cp-warning code { 
    background: rgba(0,0,0,0.08); 
    padding: 2px 6px; 
    border-radius: 4px; 
    font-weight: 700;
}

/* Summary Card */
.cp-summary-card {
    background: white;
    border-radius: 20px;
    padding: 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    display: flex;
    flex-direction: column;
    gap: 20px;
}
[data-theme="dark"] .cp-summary-card { background: #1e293b; }

.cp-summary-section {
    background: #f8fafc;
    border-radius: 16px;
    overflow: hidden;
}
[data-theme="dark"] .cp-summary-section { background: #0f172a; }

.cp-summary-header {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 18px;
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
    color: white;
    font-weight: 600;
    font-size: 14px;
}
.cp-summary-body { padding: 16px 18px; }
.cp-summary-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    font-size: 13px;
    color: var(--muted, #6b7280);
}
.cp-summary-val { color: var(--ink, #1f2937); font-weight: 500; }
.cp-summary-val.cp-old-price { 
    text-decoration: line-through; 
    color: var(--muted, #6b7280); 
    font-weight: 400;
}
.cp-discount-row {
    background: #f0fdf4;
    margin: 4px -18px;
    padding: 10px 18px !important;
}
[data-theme="dark"] .cp-discount-row { background: #064e3b; }
.cp-summary-discount { 
    color: #16a34a; 
    font-weight: 600; 
}
.cp-summary-total {
    margin-top: 8px;
    padding-top: 12px;
    border-top: 2px solid var(--line, #e5e7eb);
    font-weight: 600;
    background: linear-gradient(135deg, #ecfdf5 0%, #f0fdf4 100%);
    margin: 8px -18px -16px;
    padding: 16px 18px !important;
    border-radius: 0 0 12px 12px;
}
[data-theme="dark"] .cp-summary-total { background: linear-gradient(135deg, #064e3b 0%, #065f46 100%); }
.cp-summary-price {
    font-size: 20px;
    font-weight: 800;
    color: #10b981;
}

/* Status */
.cp-status {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 16px;
    background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%);
    border-radius: 14px;
    border: 1px solid #93c5fd;
}
[data-theme="dark"] .cp-status { background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%); border-color: #3b82f6; }
.cp-status.success { background: linear-gradient(135deg, #d1fae5 0%, #ecfdf5 100%); border-color: #6ee7b7; }
.cp-status-icon { flex-shrink: 0; }
.cp-spinner {
    width: 24px; height: 24px;
    border: 3px solid #93c5fd;
    border-top-color: #1e40af;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }
.cp-status-title { font-weight: 600; font-size: 14px; color: var(--ink, #1f2937); }
.cp-status-sub { font-size: 12px; color: var(--muted, #6b7280); margin-top: 2px; }

/* Balance Section */
.cp-balance-section {
    background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
    border: 1px solid #86efac;
    border-radius: 14px;
    padding: 16px;
}
[data-theme="dark"] .cp-balance-section { background: linear-gradient(135deg, #064e3b 0%, #065f46 100%); border-color: #10b981; }
.cp-balance-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
    font-size: 14px;
}
.cp-balance-amount { font-weight: 700; color: #16a34a; font-size: 16px; }
.cp-btn-balance {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 14px;
    background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
}
.cp-btn-balance:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(22, 163, 74, 0.4); }
.cp-balance-warn {
    font-size: 12px;
    color: #dc2626;
    margin-bottom: 10px;
}
.cp-btn-deposit {
    display: block;
    text-align: center;
    padding: 12px;
    background: var(--primary, #1e40af);
    color: white;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    font-size: 13px;
}

/* Login Section */
.cp-login-section {
    padding: 16px;
    background: #f8fafc;
    border-radius: 14px;
    text-align: center;
}
[data-theme="dark"] .cp-login-section { background: #0f172a; }
.cp-login-text { font-size: 13px; color: var(--muted, #6b7280); }
.cp-login-text a { color: var(--primary, #1e40af); font-weight: 600; text-decoration: none; }

/* Help */
.cp-help {
    padding-top: 16px;
    border-top: 1px solid var(--line, #e5e7eb);
}
.cp-help-title { font-size: 13px; color: var(--muted, #6b7280); margin-bottom: 10px; }
.cp-help-links { display: flex; gap: 12px; }
.cp-help-links a {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 14px;
    background: #f1f5f9;
    border-radius: 8px;
    font-size: 13px;
    color: var(--ink, #1f2937);
    text-decoration: none;
    transition: all 0.2s;
}
.cp-help-links a:hover { background: #e2e8f0; }
[data-theme="dark"] .cp-help-links a { background: #334155; color: #fff; }
</style>

<script>
(function() {
    const trackingCode = '{{ $order->tracking_code }}';
    let checkCount = 0;
    
    function checkPaymentStatus() {
        fetch('/api/check-payment?code=' + encodeURIComponent(trackingCode))
            .then(r => r.json())
            .then(data => {
                checkCount++;
                if (data.paid) {
                    // Success state
                    const statusEl = document.getElementById('cp-status');
                    const iconEl = document.getElementById('cp-status-icon');
                    const titleEl = document.getElementById('cp-status-title');
                    const subEl = document.getElementById('cp-status-sub');
                    
                    statusEl.classList.add('success');
                    iconEl.innerHTML = '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>';
                    titleEl.textContent = 'Thanh toán thành công!';
                    titleEl.style.color = '#10b981';
                    subEl.textContent = 'Đang chuyển đến trang kết quả...';
                    
                    setTimeout(() => {
                        window.location.href = '/order-success?code=' + encodeURIComponent(trackingCode);
                    }, 1500);
                } else if (checkCount < 200) {
                    setTimeout(checkPaymentStatus, 3000);
                } else {
                    document.getElementById('cp-status-title').textContent = 'Hết thời gian tự động';
                    document.getElementById('cp-status-sub').textContent = 'Vui lòng kiểm tra lại sau khi thanh toán';
                }
            })
            .catch(() => {
                if (checkCount < 200) setTimeout(checkPaymentStatus, 3000);
            });
    }
    
    setTimeout(checkPaymentStatus, 3000);
    
    // Pay with balance handler
    const payBtn = document.getElementById('pay-with-balance-btn');
    if (payBtn) {
        payBtn.addEventListener('click', function() {
            payBtn.disabled = true;
            payBtn.innerHTML = '<div class="cp-spinner" style="width:18px;height:18px;border-width:2px;"></div> Đang xử lý...';
            
            fetch('/api/pay-with-balance', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ code: trackingCode })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    const statusEl = document.getElementById('cp-status');
                    const iconEl = document.getElementById('cp-status-icon');
                    const titleEl = document.getElementById('cp-status-title');
                    const subEl = document.getElementById('cp-status-sub');
                    
                    statusEl.classList.add('success');
                    iconEl.innerHTML = '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>';
                    titleEl.textContent = 'Thanh toán thành công!';
                    titleEl.style.color = '#10b981';
                    subEl.textContent = 'Đang chuyển đến trang kết quả...';
                    
                    payBtn.innerHTML = '✅ Đã thanh toán';
                    payBtn.style.background = '#86efac';
                    payBtn.style.color = '#166534';
                    
                    setTimeout(() => {
                        window.location.href = '/order-success?code=' + encodeURIComponent(trackingCode);
                    }, 1500);
                } else {
                    alert(data.error || 'Có lỗi xảy ra');
                    payBtn.disabled = false;
                    payBtn.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg> Thanh toán bằng số dư';
                }
            })
            .catch(err => {
                alert('Có lỗi xảy ra, vui lòng thử lại');
                payBtn.disabled = false;
                payBtn.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg> Thanh toán bằng số dư';
            });
        });
    }
    
    // Copy order code
    window.copyOrderCode = function() {
        navigator.clipboard.writeText(trackingCode).then(() => {
            const btn = document.querySelector('.cp-copy-btn');
            btn.innerHTML = '✓';
            btn.style.background = '#d1fae5';
            setTimeout(() => {
                btn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>';
                btn.style.background = '';
            }, 2000);
        });
    };
})();
</script>
@endsection
