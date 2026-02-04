@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng - ' . $order->tracking_code)

@section('content')
<div class="od-wrapper">
    {{-- Back Button --}}
    <a href="/order-history-ip" class="od-back">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
        </svg>
        Quay lại lịch sử đơn hàng
    </a>

    <div class="od-container">
        {{-- Header --}}
        <div class="od-header">
            <div class="od-header-left">
                <div class="od-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"/>
                    </svg>
                </div>
                <div>
                    <h1 class="od-title">{{ $order->service_type ?? $order->account_type ?? 'Dịch vụ' }}</h1>
                    <div class="od-duration">{{ $order->hours_label ?? $order->hours . ' giờ' }}</div>
                </div>
            </div>
            <div class="od-header-right">
                @php
                    $statusClass = match($order->status) {
                        'paid', 'confirmed', 'completed' => 'success',
                        'pending' => 'warning',
                        default => 'danger'
                    };
                    $statusText = match($order->status) {
                        'paid' => 'Đã thanh toán',
                        'confirmed' => 'Hoàn thành',
                        'completed' => 'Hoàn thành',
                        'pending' => 'Chờ thanh toán',
                        'cancelled' => 'Đã hủy',
                        'expired' => 'Hết hạn',
                        default => $order->status
                    };
                @endphp
                <span class="od-status od-status--{{ $statusClass }}">{{ $statusText }}</span>
            </div>
        </div>

        {{-- Order Code --}}
        <div class="od-code-badge">
            <span class="od-code-label">Mã đơn hàng</span>
            <span class="od-code">{{ $order->tracking_code }}</span>
        </div>

        {{-- Grid --}}
        <div class="od-grid">
            {{-- Order Info --}}
            <div class="od-card">
                <div class="od-card-header">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                    </svg>
                    Thông tin đơn hàng
                </div>
                <div class="od-card-body">
                    <div class="od-row">
                        <span>Dịch vụ</span>
                        <span class="od-val">{{ $order->service_type ?? $order->account_type ?? 'N/A' }}</span>
                    </div>
                    <div class="od-row">
                        <span>Thời hạn</span>
                        <span class="od-val">{{ $order->hours_label ?? $order->hours . ' giờ' }}</span>
                    </div>
                    <div class="od-row">
                        <span>Ngày tạo</span>
                        <span class="od-val">{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}</span>
                    </div>
                    @if($order->paid_at)
                    <div class="od-row">
                        <span>Ngày thanh toán</span>
                        <span class="od-val">{{ \Carbon\Carbon::parse($order->paid_at)->format('d/m/Y H:i') }}</span>
                    </div>
                    @endif
                    @if($order->expires_at)
                    <div class="od-row">
                        <span>Hết hạn lúc</span>
                        <span class="od-val od-expires">{{ \Carbon\Carbon::parse($order->expires_at)->format('d/m/Y H:i') }}</span>
                    </div>
                    @endif
                    <div class="od-row od-row-total">
                        <span>💰 Số tiền</span>
                        <span class="od-price">{{ number_format($order->amount, 0, ',', '.') }}đ</span>
                    </div>
                </div>
            </div>

            {{-- Account Info (only if paid) --}}
            <div class="od-card">
                <div class="od-card-header od-card-header--green">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                    Thông tin tài khoản
                </div>
                <div class="od-card-body">
                    @if(in_array($order->status, ['paid', 'confirmed', 'completed']))
                        @if($order->account_username)
                        <div class="od-account-row">
                            <span class="od-account-label">Tài khoản</span>
                            <div class="od-account-value">
                                <input type="text" value="{{ $order->account_username }}" readonly class="od-input">
                                <button type="button" class="od-copy" onclick="copyToClipboard('{{ $order->account_username }}', this)">📋</button>
                            </div>
                        </div>
                        @endif
                        @if($order->account_password)
                        <div class="od-account-row">
                            <span class="od-account-label">Mật khẩu</span>
                            <div class="od-account-value">
                                <input type="text" value="{{ $order->account_password }}" readonly class="od-input">
                                <button type="button" class="od-copy" onclick="copyToClipboard('{{ $order->account_password }}', this)">📋</button>
                            </div>
                        </div>
                        @endif
                        @if(!$order->account_username && !$order->account_password)
                        <div class="od-notice od-notice--info">
                            <span>ℹ️</span> Tài khoản đang được cấp phát. Vui lòng chờ hoặc liên hệ hỗ trợ.
                        </div>
                        @endif
                    @else
                        <div class="od-notice od-notice--warning">
                            <span>⏳</span> Thông tin tài khoản sẽ hiển thị sau khi thanh toán thành công.
                        </div>
                        @if($order->status == 'pending')
                        <a href="/thanh-toan?tracking_code={{ $order->tracking_code }}" class="od-btn-pay">
                            Thanh toán ngay
                        </a>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        {{-- Help --}}
        <div class="od-help">
            <span>Cần hỗ trợ?</span>
            <a href="https://zalo.me/0367820066" target="_blank">💬 Zalo</a>
            <a href="https://t.me/thuetaikhoan" target="_blank">✈️ Telegram</a>
        </div>
    </div>
</div>

<style>
.od-wrapper {
    min-height: calc(100vh - 80px);
    background: linear-gradient(180deg, #f1f5f9 0%, #e2e8f0 100%);
    padding: 24px 16px 60px;
}
[data-theme="dark"] .od-wrapper { background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%); }

.od-back {
    display: inline-flex; align-items: center; gap: 8px;
    color: var(--primary, #1e40af); text-decoration: none;
    font-size: 14px; font-weight: 500; margin-bottom: 20px;
}
.od-back:hover { opacity: 0.8; }

.od-container { max-width: 800px; margin: 0 auto; }

.od-header {
    display: flex; justify-content: space-between; align-items: center;
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
    border-radius: 20px; padding: 24px 28px; color: white;
    margin-bottom: 16px; box-shadow: 0 8px 32px rgba(30, 64, 175, 0.25);
}
.od-header-left { display: flex; align-items: center; gap: 14px; }
.od-icon { width: 52px; height: 52px; background: rgba(255,255,255,0.15); border-radius: 14px; display: flex; align-items: center; justify-content: center; }
.od-title { font-size: 20px; font-weight: 700; margin: 0; }
.od-duration { font-size: 13px; opacity: 0.85; margin-top: 2px; }

.od-status { padding: 8px 16px; border-radius: 20px; font-size: 13px; font-weight: 600; }
.od-status--success { background: #86efac; color: #166534; }
.od-status--warning { background: #fde68a; color: #92400e; }
.od-status--danger { background: #fecaca; color: #dc2626; }

.od-code-badge {
    display: flex; align-items: center; justify-content: center; gap: 12px;
    background: white; border: 2px dashed #cbd5e1; border-radius: 12px;
    padding: 14px 20px; margin-bottom: 20px;
}
[data-theme="dark"] .od-code-badge { background: #1e293b; border-color: #475569; }
.od-code-label { color: var(--muted, #6b7280); font-size: 13px; }
.od-code { font-size: 18px; font-weight: 700; color: var(--primary, #1e40af); letter-spacing: 1px; }

.od-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
@media (max-width: 768px) { 
    .od-grid { grid-template-columns: 1fr; }
    .od-header { flex-direction: column; text-align: center; gap: 16px; }
    .od-header-left { flex-direction: column; }
}

.od-card { background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.06); }
[data-theme="dark"] .od-card { background: #1e293b; }

.od-card-header {
    display: flex; align-items: center; gap: 10px;
    padding: 14px 18px; background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
    color: white; font-weight: 600; font-size: 14px;
}
.od-card-header--green { background: linear-gradient(135deg, #16a34a 0%, #22c55e 100%); }
.od-card-body { padding: 16px 18px; }

.od-row { display: flex; justify-content: space-between; padding: 10px 0; font-size: 13px; color: var(--muted, #6b7280); border-bottom: 1px solid var(--line, #e5e7eb); }
.od-row:last-child { border-bottom: none; }
.od-val { color: var(--ink, #1f2937); font-weight: 500; }
.od-expires { color: #dc2626; }
.od-row-total { background: #f0fdf4; margin: 8px -18px -16px; padding: 14px 18px !important; border-radius: 0 0 12px 12px; border-bottom: none; }
[data-theme="dark"] .od-row-total { background: #064e3b; }
.od-price { font-size: 18px; font-weight: 800; color: #10b981; }

.od-account-row { margin-bottom: 14px; }
.od-account-label { display: block; font-size: 12px; color: var(--muted, #6b7280); margin-bottom: 6px; }
.od-account-value { display: flex; gap: 8px; }
.od-input { flex: 1; padding: 10px 14px; border: 1px solid var(--line, #e5e7eb); border-radius: 10px; font-size: 14px; font-weight: 500; background: #f8fafc; color: var(--ink, #1f2937); }
[data-theme="dark"] .od-input { background: #0f172a; border-color: #475569; color: #fff; }
.od-copy { padding: 10px 14px; background: var(--primary, #1e40af); color: white; border: none; border-radius: 10px; cursor: pointer; font-size: 14px; }
.od-copy:hover { opacity: 0.9; }
.od-extra pre { font-size: 12px; background: #f8fafc; padding: 12px; border-radius: 8px; white-space: pre-wrap; word-break: break-all; }

.od-notice { display: flex; align-items: flex-start; gap: 10px; padding: 14px; border-radius: 12px; font-size: 13px; }
.od-notice--info { background: #dbeafe; color: #1e40af; }
.od-notice--warning { background: #fef3c7; color: #92400e; }

.od-btn-pay {
    display: block; text-align: center; margin-top: 16px;
    padding: 14px; background: linear-gradient(135deg, #16a34a 0%, #22c55e 100%);
    color: white; border-radius: 12px; text-decoration: none;
    font-weight: 600; font-size: 14px;
}

.od-help {
    display: flex; align-items: center; justify-content: center; gap: 16px;
    margin-top: 24px; padding: 16px; font-size: 13px; color: var(--muted, #6b7280);
}
.od-help a { color: var(--primary, #1e40af); text-decoration: none; font-weight: 500; }
</style>

<script>
function copyToClipboard(text, btn) {
    navigator.clipboard.writeText(text).then(() => {
        const originalText = btn.textContent;
        btn.textContent = '✓';
        btn.style.background = '#16a34a';
        setTimeout(() => {
            btn.textContent = originalText;
            btn.style.background = '';
        }, 1500);
    });
}
</script>
@endsection
