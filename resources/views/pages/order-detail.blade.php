@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng - ' . $order->tracking_code)

@section('content')
<div class="od-wrapper">
    <div class="od-container">
        <div class="od-card">
            {{-- Header --}}
            <div class="od-header">
                <h1 class="od-title">Đơn hàng {{ $order->tracking_code }}</h1>
                @php
                    $statusClass = match($order->status) {
                        'paid', 'confirmed', 'completed' => 'success',
                        'pending' => 'warning',
                        'cancelled', 'expired' => 'danger',
                        default => 'secondary'
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
                <div class="od-status-wrapper">
                    <span class="od-label-status">Trạng thái:</span>
                    <span class="od-badge od-badge--{{ $statusClass }}">{{ $statusText }}</span>
                </div>
            </div>

            {{-- Main Info List --}}
            <div class="od-info-list">
                <div class="od-item">
                    <span class="od-label">Mã tra cứu</span>
                    <span class="od-value od-code">{{ $order->tracking_code }}</span>
                </div>
                <div class="od-item">
                    <span class="od-label">Gói thuê</span>
                    <span class="od-value">{{ $order->hours }} giờ</span>
                </div>
                <div class="od-item">
                    <span class="od-label">Loại dịch vụ</span>
                    <span class="od-value">{{ $order->service_type ?? $order->account_type }}</span>
                </div>
                <div class="od-item">
                    <span class="od-label">Số tiền</span>
                    <span class="od-value od-price">{{ number_format($order->amount, 0, ',', '.') }} đ</span>
                </div>
                <div class="od-item">
                    <span class="od-label">Tạo lúc</span>
                    <span class="od-value">{{ \Carbon\Carbon::parse($order->created_at)->format('Y-m-d H:i:s') }}</span>
                </div>
                @if($order->paid_at)
                <div class="od-item">
                    <span class="od-label">Thanh toán lúc</span>
                    <span class="od-value">{{ \Carbon\Carbon::parse($order->paid_at)->format('Y-m-d H:i:s') }}</span>
                </div>
                @endif
                @if($order->expires_at)
                <div class="od-item">
                    <span class="od-label">Hết hạn</span>
                    <span class="od-value">{{ \Carbon\Carbon::parse($order->expires_at)->format('Y-m-d H:i:s') }}</span>
                </div>
                @endif
            </div>

            {{-- Account Info Box --}}
            @if(in_array($order->status, ['paid', 'confirmed', 'completed']) && ($order->account_username || $order->account_password))
            <div class="od-account-box">
                <div class="od-account-title">Tài khoản đã cấp</div>
                
                <div class="od-account-list">
                    <div class="od-acc-item">
                        <span class="od-acc-label">Loại dịch vụ</span>
                        <span class="od-acc-value">{{ $order->service_type ?? $order->account_type }}</span>
                    </div>
                    @if($order->account_username)
                    <div class="od-acc-item">
                        <span class="od-acc-label">Username</span>
                        <span class="od-acc-value od-copy-target" onclick="copyText('{{ $order->account_username }}')">{{ $order->account_username }}</span>
                    </div>
                    @endif
                    @if($order->account_password)
                    <div class="od-acc-item">
                        <span class="od-acc-label">Mật khẩu</span>
                        <span class="od-acc-value od-copy-target" onclick="copyText('{{ $order->account_password }}')">{{ $order->account_password }}</span>
                    </div>
                    @endif

                </div>
            </div>
            @endif

            {{-- Actions --}}
            <div class="od-actions">
                <a href="/" class="od-btn od-btn-outline">Về trang chủ</a>
                @if($order->status == 'pending')
                    <a href="/thanh-toan?tracking_code={{ $order->tracking_code }}" class="od-btn od-btn-primary">Thanh toán ngay</a>
                @else
                    <a href="/order-success?code={{ $order->tracking_code }}" class="od-btn od-btn-primary">Xem trang hoàn tất</a>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
/* Reset & Base */
.od-wrapper {
    background-color: #f8f9fa;
    min-height: calc(100vh - 80px);
    padding: 40px 16px;
    font-family: 'Be Vietnam Pro', sans-serif;
}

[data-theme="dark"] .od-wrapper { background-color: #0f172a; }

.od-container {
    max-width: 800px;
    margin: 0 auto;
}

.od-card {
    background: #fff;
    border-radius: 8px;
    padding: 32px 40px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

[data-theme="dark"] .od-card { background: #1e293b; border: 1px solid #334155; }

/* Header */
.od-header { margin-bottom: 24px; }
.od-title {
    font-size: 24px;
    font-weight: 700;
    color: #1f2937;
    margin: 0 0 12px 0;
}
[data-theme="dark"] .od-title { color: #f1f5f9; }

.od-status-wrapper {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
}

.od-label-status { color: #6b7280; }

.od-badge {
    padding: 4px 12px;
    border-radius: 100px;
    font-size: 13px;
    font-weight: 500;
}
.od-badge--success { background: #dbeafe; color: #1e40af; } /* Blue style from image */
.od-badge--warning { background: #fef3c7; color: #92400e; }
.od-badge--danger { background: #fee2e2; color: #991b1b; }
.od-badge--secondary { background: #e5e7eb; color: #374151; }

[data-theme="dark"] .od-badge--success { background: #1e3a8a; color: #bfdbfe; }

/* Info List */
.od-info-list { margin-bottom: 30px; }
.od-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px dashed #e5e7eb;
    font-size: 14px;
}
.od-item:last-child { border-bottom: none; }
[data-theme="dark"] .od-item { border-bottom-color: #334155; }

.od-label { color: #6b7280; min-width: 120px; }
.od-value { font-weight: 600; color: #111827; text-align: right; }
[data-theme="dark"] .od-value { color: #f1f5f9; }

.od-code { color: #111827; font-weight: 700; }
.od-price { color: #111827; font-weight: 700; }

/* Account Box */
.od-account-box {
    background: #f8fafc;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 30px;
}
[data-theme="dark"] .od-account-box { background: #0f172a; }

.od-account-title {
    font-size: 15px;
    font-weight: 600;
    color: #6b7280;
    margin-bottom: 16px;
}

.od-acc-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    font-size: 14px;
}
.od-acc-item:last-child { margin-bottom: 0; }

.od-acc-label { color: #9ca3af; min-width: 120px; }
.od-acc-value { 
    font-weight: 600; 
    color: #1f2937; 
    text-align: right;
    word-break: break-all;
}
[data-theme="dark"] .od-acc-value { color: #e2e8f0; }

.od-copy-target { cursor: pointer; transition: color 0.2s; }
.od-copy-target:hover { color: #2563eb; }
.od-copy-target:active { opacity: 0.7; }

/* Actions */
.od-actions {
    display: flex;
    gap: 16px;
    margin-top: 20px;
}

.od-btn {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    padding: 10px 24px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
    cursor: pointer;
}

.od-btn-outline {
    border: 1px solid #e5e7eb;
    color: #374151;
    background: white;
}
.od-btn-outline:hover { background: #f9fafb; border-color: #d1d5db; }
[data-theme="dark"] .od-btn-outline { background: transparent; border-color: #475569; color: #94a3b8; }

.od-btn-primary {
    background: #1e40af;
    color: white;
    border: 1px solid #1e40af;
}
.od-btn-primary:hover { background: #1e3a8a; }

@media (max-width: 640px) {
    .od-card { padding: 24px; }
    .od-actions { flex-direction: column; }
    .od-btn { width: 100%; }
}

/* Bold UI Enhancements */
.od-title { font-weight: 800; color: #111827; letter-spacing: -0.025em; }
.od-label { color: #374151; font-weight: 700; }
.od-value { color: #000000; font-weight: 700; }
.od-account-title { color: #111827; font-weight: 700; }
.od-acc-label { color: #374151; font-weight: 700; }
.od-acc-value { color: #000000; font-weight: 700; }
.od-btn { font-weight: 700; border-width: 2px; }

/* High Contrast Borders */
.od-card { 
    border: 2px solid #e5e7eb; 
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); 
}
.od-item { border-bottom: 2px dashed #cbd5e1; }
.od-account-box { border: 2px solid #e2e8f0; }
.od-btn-outline { border: 2px solid #d1d5db; color: #111827; }
.od-btn-outline:hover { border-color: #9ca3af; background: #f3f4f6; }


</style>

<script>
function copyText(text) {
    navigator.clipboard.writeText(text).then(() => {
        // Simple toast could be added here, currently just subtle interaction
    });
}
</script>
@endsection
