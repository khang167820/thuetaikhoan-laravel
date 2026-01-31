@extends('layouts.app')

@section('title', 'Thanh toán thành công - ThueTaiKhoan')

@section('content')
<div class="success-container">
    <div class="success-card">
        <!-- Success Icon -->
        <div class="success-icon">
            <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
        </div>
        
        <!-- Success Title -->
        <h1 class="success-title">Thanh Toán Thành Công!</h1>
        <p class="success-subtitle">Cảm ơn bạn đã sử dụng dịch vụ ThueTaiKhoan</p>
        
        <!-- Order Details -->
        <div class="order-details">
            <div class="detail-row">
                <span class="detail-label">Mã đơn hàng</span>
                <span class="detail-value highlight">{{ $order->tracking_code }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Dịch vụ</span>
                <span class="detail-value">{{ $price->service ?? 'N/A' }}</span>
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
                <span class="detail-value">{{ $order->paid_at ? $order->paid_at->format('H:i d/m/Y') : 'N/A' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Trạng thái</span>
                <span class="detail-value status-paid">✓ Đã thanh toán</span>
            </div>
        </div>

        <!-- Instructions -->
        <div class="instructions">
            <h3>Hướng dẫn tiếp theo</h3>
            <ul>
                <li>Thông tin đăng nhập sẽ được gửi qua email hoặc hiển thị tại trang này</li>
                <li>Vui lòng lưu lại mã đơn hàng để tra cứu sau này</li>
                <li>Nếu cần hỗ trợ, liên hệ qua Zalo hoặc Telegram</li>
            </ul>
        </div>

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
    padding: 48px 40px;
    max-width: 500px;
    width: 100%;
    text-align: center;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
}

.success-icon {
    width: 100px;
    height: 100px;
    margin: 0 auto 24px;
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
    font-weight: 700;
    color: #059669;
    margin-bottom: 8px;
}

.success-subtitle {
    font-size: 15px;
    color: #6b7280;
    margin-bottom: 32px;
}

.order-details {
    background: #f9fafb;
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 24px;
    text-align: left;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #e5e7eb;
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
    margin-bottom: 28px;
    text-align: left;
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
    justify-content: center;
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
}

.btn-primary {
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
    color: #fff;
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

/* Dark mode */
[data-theme="dark"] .success-container {
    background: linear-gradient(135deg, #064e3b 0%, #065f46 100%);
}

[data-theme="dark"] .success-card {
    background: #1e293b;
}

[data-theme="dark"] .success-title {
    color: #34d399;
}

[data-theme="dark"] .success-subtitle {
    color: #94a3b8;
}

[data-theme="dark"] .order-details {
    background: #0f172a;
}

[data-theme="dark"] .detail-row {
    border-color: #334155;
}

[data-theme="dark"] .detail-label {
    color: #94a3b8;
}

[data-theme="dark"] .detail-value {
    color: #e2e8f0;
}

[data-theme="dark"] .instructions {
    background: #1e293b;
    border-color: #fbbf24;
}

[data-theme="dark"] .btn-secondary {
    background: #334155;
    color: #e2e8f0;
    border-color: #475569;
}

@media (max-width: 480px) {
    .success-card {
        padding: 32px 24px;
    }
    
    .success-title {
        font-size: 22px;
    }
    
    .action-buttons {
        flex-direction: column;
    }
}
</style>
@endsection
