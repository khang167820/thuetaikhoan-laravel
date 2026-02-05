@extends('layouts.app')

@section('title', 'Nạp tiền thành công - ThueTaiKhoan.net')

@section('styles')
<style>
.success-page {
    min-height: calc(100vh - 200px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
}
.success-card {
    background: #fff;
    border-radius: 20px;
    padding: 48px 40px;
    text-align: center;
    max-width: 480px;
    box-shadow: 0 20px 60px rgba(16, 185, 129, 0.15);
    animation: slideUp 0.5s ease;
}
@keyframes slideUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
.success-icon {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 24px;
    animation: pulse 1.5s infinite;
}
@keyframes pulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); }
    50% { box-shadow: 0 0 0 20px rgba(16, 185, 129, 0); }
}
.success-icon svg {
    width: 50px;
    height: 50px;
    stroke: #fff;
    stroke-width: 3;
}
.success-title {
    font-size: 28px;
    font-weight: 800;
    color: #059669;
    margin-bottom: 12px;
}
.success-message {
    font-size: 16px;
    color: #64748b;
    margin-bottom: 32px;
    line-height: 1.6;
}
.success-amount {
    background: #f0fdf4;
    border: 2px solid #10b981;
    border-radius: 16px;
    padding: 20px;
    margin-bottom: 32px;
}
.success-amount-label {
    font-size: 13px;
    color: #64748b;
    margin-bottom: 4px;
}
.success-amount-value {
    font-size: 36px;
    font-weight: 800;
    color: #059669;
}
.success-balance {
    background: #f8fafc;
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 32px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.success-balance-label {
    font-size: 14px;
    color: #64748b;
}
.success-balance-value {
    font-size: 20px;
    font-weight: 700;
    color: #1e293b;
}
.success-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    justify-content: center;
}
.success-btn {
    padding: 14px 28px;
    border-radius: 12px;
    font-weight: 700;
    font-size: 15px;
    text-decoration: none;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}
.success-btn-primary {
    background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
    color: #fff;
}
.success-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(249, 115, 22, 0.3);
}
.success-btn-secondary {
    background: #f1f5f9;
    color: #475569;
}
.success-btn-secondary:hover {
    background: #e2e8f0;
}
.confetti {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 1000;
}
[data-theme="dark"] .success-page { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); }
[data-theme="dark"] .success-card { background: #1e293b; }
[data-theme="dark"] .success-title { color: #4ade80; }
[data-theme="dark"] .success-message { color: #94a3b8; }
[data-theme="dark"] .success-amount { background: #0f172a; border-color: #10b981; }
[data-theme="dark"] .success-amount-value { color: #4ade80; }
[data-theme="dark"] .success-balance { background: #0f172a; }
[data-theme="dark"] .success-balance-value { color: #f1f5f9; }
</style>
@endsection

@section('content')
<div class="success-page">
    <div class="success-card">
        <div class="success-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        </div>
        
        <h1 class="success-title">Nạp tiền thành công!</h1>
        <p class="success-message">
            Số tiền đã được cộng vào tài khoản của bạn.<br>
            Cảm ơn bạn đã sử dụng dịch vụ!
        </p>
        
        @if(isset($amount))
        <div class="success-amount">
            <div class="success-amount-label">Số tiền đã nạp</div>
            <div class="success-amount-value">+{{ number_format($amount, 0, ',', '.') }}đ</div>
        </div>
        @endif
        
        <div class="success-balance">
            <span class="success-balance-label">Số dư hiện tại:</span>
            <span class="success-balance-value">{{ number_format(auth()->user()->balance ?? 0, 0, ',', '.') }}đ</span>
        </div>
        
        <div class="success-actions">
            <a href="/" class="success-btn success-btn-primary">
                🛒 Thuê dịch vụ ngay
            </a>
            <a href="/deposit" class="success-btn success-btn-secondary">
                💰 Nạp thêm
            </a>
        </div>
    </div>
</div>

<script>
// Simple confetti effect
function createConfetti() {
    const colors = ['#10b981', '#f97316', '#3b82f6', '#fbbf24', '#ec4899'];
    for (let i = 0; i < 50; i++) {
        setTimeout(() => {
            const confetti = document.createElement('div');
            confetti.style.cssText = `
                position: fixed;
                width: 10px;
                height: 10px;
                background: ${colors[Math.floor(Math.random() * colors.length)]};
                top: -10px;
                left: ${Math.random() * 100}%;
                border-radius: 50%;
                z-index: 1000;
                pointer-events: none;
                animation: fall ${2 + Math.random() * 2}s linear forwards;
            `;
            document.body.appendChild(confetti);
            setTimeout(() => confetti.remove(), 4000);
        }, i * 50);
    }
}

// Add confetti animation
const style = document.createElement('style');
style.textContent = `
    @keyframes fall {
        to {
            transform: translateY(100vh) rotate(720deg);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
createConfetti();
</script>
@endsection
