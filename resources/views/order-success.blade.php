@extends('layouts.app')

@section('title', 'Thanh toán thành công - ThueTaiKhoan')

@section('content')
<div class="success-container">
    <div class="success-card">
        <!-- Success Header -->
        <div class="success-header">
            <div class="success-icon">
                <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </div>
            <h1 class="success-title">Thanh Toán Thành Công!</h1>
            <p class="success-subtitle">Cảm ơn bạn đã sử dụng dịch vụ ThueTaiKhoan</p>
        </div>
        
        <div class="success-grid">
            <!-- Left Column: Order Info -->
            <div class="success-col">
                <div class="order-details">
                    <div class="detail-row">
                        <span class="detail-label">Mã đơn hàng</span>
                        <span class="detail-value highlight">{{ $order->tracking_code }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Dịch vụ</span>
                        <span class="detail-value">{{ $price->type ?? 'N/A' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Thời gian</span>
                        <span class="detail-value">{{ $order->hours ?? 1 }} giờ</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Số tiền</span>
                        <span class="detail-value price">{{ number_format($order->amount, 0, ',', '.') }}đ</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Thời gian thanh toán</span>
                        <span class="detail-value">{{ $order->paid_at ? \Carbon\Carbon::parse($order->paid_at)->format('H:i d/m/Y') : 'N/A' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Trạng thái</span>
                        <span class="detail-value status-paid">✓ Đã thanh toán</span>
                    </div>
                </div>

                <div class="instructions">
                    <h3>Hướng dẫn tiếp theo</h3>
                    <ul>
                        <li>Thông tin đăng nhập hiển thị bên phải (hoặc bên dưới)</li>
                        <li>Vui lòng lưu lại mã đơn hàng để tra cứu</li>
                        <li>Nếu cần hỗ trợ, liên hệ qua Zalo/Telegram</li>
                    </ul>
                </div>
            </div>

            <!-- Right Column: Account & Actions -->
            <div class="success-col">
                <!-- Account Info -->
                @if($order->account)
                @php
                    // Check if order has expired
                    $isExpired = false;
                    $gracePeriodMinutes = 30;
                    
                    if ($order->expires_at) {
                        $expiresAt = \Carbon\Carbon::parse($order->expires_at);
                        $now = \Carbon\Carbon::now();
                        $isExpired = $now->greaterThan($expiresAt->addMinutes($gracePeriodMinutes));
                    }
                    
                    // Check if admin changed password
                    $passwordChanged = false;
                    if (!empty($order->assigned_password) && !empty($order->account->password)) {
                        $passwordChanged = ($order->assigned_password !== $order->account->password);
                    }
                    
                    // Get display password
                    $displayPassword = $order->assigned_password ?? $order->account->password ?? null;
                @endphp
                
                @if($isExpired)
                    {{-- Order has expired --}}
                    <div class="account-info account-expired">
                        <div class="expired-notice">
                            <span class="expired-icon">🔒</span>
                            <h3>Đơn hàng đã hết hạn</h3>
                            <p>Thông tin tài khoản không còn khả dụng.</p>
                        </div>
                    </div>
                @elseif($passwordChanged)
                    {{-- Password was changed by admin --}}
                    <div class="account-info account-changed">
                        <div class="changed-notice">
                            <span class="changed-icon">🔐</span>
                            <h3>Mật khẩu đã thay đổi</h3>
                            <p>Vui lòng liên hệ admin để được cấp lại mật khẩu mới.</p>
                        </div>
                        <div class="detail-row account-row">
                            <span class="detail-label">Tài khoản</span>
                            <div class="account-input-group">
                                <input type="text" value="{{ $order->account->username }}" readonly onclick="this.select()">
                                <button type="button" onclick="copyToClipboard('{{ $order->account->username }}', this)">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                                </button>
                            </div>
                        </div>
                        <a href="https://zalo.me/0832282999" target="_blank" class="btn-zalo">
                            📞 Liên hệ Zalo Admin
                        </a>
                    </div>
                @else
                    {{-- Normal display --}}
                    <div class="account-info">
                        <h3>Tài khoản đã cấp</h3>
                        <div class="detail-row account-row">
                            <span class="detail-label">Tài khoản</span>
                            <div class="account-input-group">
                                <input type="text" value="{{ $order->account->username }}" readonly onclick="this.select()">
                                <button type="button" onclick="copyToClipboard('{{ $order->account->username }}', this)">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                                </button>
                            </div>
                        </div>
                        @if($displayPassword)
                        <div class="detail-row account-row">
                            <span class="detail-label">Mật khẩu</span>
                            <div class="account-input-group">
                                <input type="text" value="{{ $displayPassword }}" readonly onclick="this.select()">
                                <button type="button" onclick="copyToClipboard('{{ $displayPassword }}', this)">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                                </button>
                            </div>
                        </div>
                        @endif
                    </div>
                @endif
                @endif

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="/" class="btn-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        </svg>
                        Về trang chủ
                    </a>
                    <a href="/order-history" class="btn-secondary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                        Xem lịch sử
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.success-container {
    min-height: 70vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
    background: linear-gradient(135deg, #ecfdf5 0%, #f0fdf4 100%);
}

.success-card {
    background: #fff;
    border-radius: 24px;
    padding: 40px 48px;
    max-width: 960px;
    width: 100%;
    text-align: center;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
}

.success-header {
    margin-bottom: 40px;
    border-bottom: 1px solid #e5e7eb;
    padding-bottom: 32px;
}

.success-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border-radius: 50%;
    color: #fff;
    animation: successPulse 2s ease-in-out infinite;
}

@keyframes successPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.success-title {
    font-size: 28px;
    font-weight: 800;
    color: #059669;
    margin-bottom: 8px;
}

.success-subtitle {
    font-size: 16px;
    color: #6b7280;
}

.success-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    text-align: left;
}

.success-col {
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.order-details, .account-info {
    background: #f8fafc;
    border-radius: 16px;
    padding: 24px;
    border: 1px solid #e5e7eb;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px dashed #e5e7eb;
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-label {
    font-size: 14px;
    color: #6b7280;
}

.detail-value {
    font-size: 14px;
    font-weight: 600;
    color: #1f2937;
}

.detail-value.highlight {
    font-family: 'Monaco', monospace;
    background: #dbeafe;
    padding: 4px 10px;
    border-radius: 6px;
    color: #1e40af;
}

.detail-value.price {
    color: #059669;
    font-size: 16px;
}

.detail-value.status-paid {
    color: #059669;
    background: #ecfdf5;
    padding: 4px 10px;
    border-radius: 6px;
}

.instructions {
    background: #fffbeb;
    border: 1px solid #fcd34d;
    border-radius: 12px;
    padding: 20px;
}

.instructions h3 {
    font-size: 14px;
    font-weight: 600;
    color: #d97706;
    margin-bottom: 12px;
}

.instructions ul {
    margin: 0;
    padding-left: 20px;
}

.instructions li {
    font-size: 13px;
    color: #92400e;
    margin-bottom: 6px;
}

.action-buttons {
    display: flex;
    gap: 12px;
    justify-content: center; /* Centered buttons usually look better */
    margin-top: 10px;
}

.btn-primary, .btn-secondary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    font-size: 14px;
    font-weight: 600;
    border-radius: 12px;
    text-decoration: none;
    transition: all 0.2s;
    justify-content: center;
}

.btn-primary {
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
    color: #fff;
    border: none;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
}

.btn-secondary {
    background: #f3f4f6;
    color: #374151;
    border: 1px solid #e5e7eb;
}

.btn-secondary:hover {
    background: #e5e7eb;
}

/* Account Info Styles */
.account-info {
    border: 2px dashed #cbd5e1;
    border-top: 3px solid #3b82f6; /* Highlight top */
}
.account-info h3 {
    font-size: 15px;
    font-weight: 700;
    color: #334155;
    margin-bottom: 16px;
    margin-top: 0;
}
.account-input-group {
    display: flex;
    flex: 1;
    gap: 8px;
}
.account-input-group input {
    flex: 1;
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    color: #0f172a;
    background: #fff;
    outline: none;
}
.account-input-group button {
    padding: 8px 12px;
    background: #eff6ff;
    border: 1px solid #dbeafe;
    border-radius: 8px;
    color: #2563eb;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
}
.account-input-group button:hover {
    background: #dbeafe;
}

@media (max-width: 768px) {
    .success-grid {
        grid-template-columns: 1fr;
        gap: 24px;
    }
    .success-card {
        padding: 32px 24px;
    }
    .action-buttons {
        flex-direction: column;
    }
}

/* Dark mode */
[data-theme="dark"] .success-container { background: linear-gradient(135deg, #064e3b 0%, #065f46 100%); }
[data-theme="dark"] .success-card { background: #1e293b; }
[data-theme="dark"] .success-title { color: #34d399; }
[data-theme="dark"] .success-subtitle { color: #94a3b8; }
[data-theme="dark"] .order-details { background: #0f172a; border-color: #334155; }
[data-theme="dark"] .detail-row { border-color: #334155; }
[data-theme="dark"] .detail-label { color: #94a3b8; }
[data-theme="dark"] .detail-value { color: #e2e8f0; }
[data-theme="dark"] .instructions { background: #1e293b; border-color: #fbbf24; }
[data-theme="dark"] .btn-secondary { background: #334155; color: #e2e8f0; border-color: #475569; }
[data-theme="dark"] .account-info { background: #1e293b; border-color: #475569; }
[data-theme="dark"] .account-info h3 { color: #e2e8f0; }
[data-theme="dark"] .account-input-group input { background: #0f172a; border-color: #334155; color: #f1f5f9; }

/* Expired Order Styles */
.account-expired {
    background: linear-gradient(135deg, #fef2f2 0%, #fecaca 100%) !important;
    border-color: #fca5a5 !important;
    border-top-color: #dc2626 !important;
}
.account-expired .expired-notice {
    text-align: center;
    padding: 20px 0;
}
.account-expired .expired-icon {
    font-size: 36px;
    display: block;
    margin-bottom: 12px;
}
.account-expired h3 {
    color: #dc2626 !important;
    margin: 0 0 8px 0;
}
.account-expired p {
    color: #991b1b;
    margin: 0;
    font-size: 14px;
}
[data-theme="dark"] .account-expired {
    background: linear-gradient(135deg, #450a0a 0%, #7f1d1d 100%) !important;
    border-color: #dc2626 !important;
}
[data-theme="dark"] .account-expired h3 { color: #fca5a5 !important; }
[data-theme="dark"] .account-expired p { color: #f87171; }

/* Password Changed Styles */
.account-changed {
    background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%) !important;
    border-color: #f59e0b !important;
    border-top-color: #d97706 !important;
}
.account-changed .changed-notice {
    text-align: center;
    padding: 16px 0;
    margin-bottom: 16px;
    border-bottom: 1px dashed #fbbf24;
}
.account-changed .changed-icon {
    font-size: 36px;
    display: block;
    margin-bottom: 12px;
}
.account-changed h3 {
    color: #d97706 !important;
    margin: 0 0 8px 0;
}
.account-changed p {
    color: #92400e;
    margin: 0;
    font-size: 14px;
}
.btn-zalo {
    display: block;
    text-align: center;
    padding: 12px 20px;
    background: #0068ff;
    color: #fff !important;
    font-weight: 600;
    border-radius: 10px;
    text-decoration: none;
    margin-top: 16px;
    transition: all 0.2s;
}
.btn-zalo:hover {
    background: #0055cc;
    transform: translateY(-2px);
}
[data-theme="dark"] .account-changed {
    background: linear-gradient(135deg, #451a03 0%, #78350f 100%) !important;
    border-color: #f59e0b !important;
}
[data-theme="dark"] .account-changed h3 { color: #fcd34d !important; }
[data-theme="dark"] .account-changed p { color: #fbbf24; }
</style>

<script>
function copyToClipboard(text, btn) {
    if (!text) return;
    navigator.clipboard.writeText(text).then(() => {
        const originalHtml = btn.innerHTML;
        btn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>';
        btn.style.color = '#10b981';
        btn.style.borderColor = '#a7f3d0';
        btn.style.backgroundColor = '#ecfdf5';
        
        setTimeout(() => {
            btn.innerHTML = originalHtml;
            btn.style.color = '';
            btn.style.borderColor = '';
            btn.style.backgroundColor = '';
        }, 2000);
    });
}
</script>
@endsection
