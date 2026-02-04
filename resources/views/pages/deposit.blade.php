@extends('layouts.app')

@section('title', 'Nạp tiền vào tài khoản - ThueTaiKhoan.net')
@section('meta_description', 'Nạp tiền vào tài khoản ThueTaiKhoan.net để thanh toán nhanh chóng hơn.')

@section('styles')
<style>
.deposit-wrap {
    min-height: 70vh;
    padding: 40px 20px;
    max-width: 900px;
    margin: 0 auto;
}
.deposit-header {
    text-align: center;
    margin-bottom: 32px;
}
.deposit-title {
    font-size: 28px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 8px;
}
.deposit-sub {
    color: #64748b;
    font-size: 15px;
}

/* Balance Card */
.balance-card {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    border-radius: 20px;
    padding: 30px;
    color: #fff;
    margin-bottom: 32px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.balance-info h3 {
    font-size: 14px;
    font-weight: 500;
    opacity: 0.9;
    margin: 0 0 8px;
}
.balance-amount {
    font-size: 36px;
    font-weight: 800;
}
.balance-amount span {
    font-size: 20px;
    opacity: 0.8;
}
.balance-icon {
    width: 60px;
    height: 60px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
}

/* Deposit Grid */
.deposit-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
}
.deposit-card {
    background: #fff;
    border-radius: 16px;
    padding: 28px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
}
.deposit-card-title {
    font-size: 18px;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.deposit-card-title span {
    font-size: 22px;
}

/* QR Section */
.qr-container {
    text-align: center;
}
.qr-code {
    width: 200px;
    height: 200px;
    border-radius: 12px;
    border: 2px solid #e5e7eb;
    margin-bottom: 16px;
}
.bank-info {
    text-align: left;
    background: #f8fafc;
    border-radius: 12px;
    padding: 16px;
    margin-top: 16px;
}
.bank-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid #e5e7eb;
    font-size: 14px;
}
.bank-row:last-child {
    border-bottom: none;
}
.bank-label {
    color: #64748b;
}
.bank-value {
    color: #0f172a;
    font-weight: 600;
}
.copy-btn {
    background: #6366f1;
    color: #fff;
    border: none;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 12px;
    cursor: pointer;
    margin-left: 8px;
}
.copy-btn:hover {
    background: #4f46e5;
}

/* Instructions */
.instructions {
    list-style: none;
    padding: 0;
    margin: 0;
}
.instructions li {
    display: flex;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid #f1f5f9;
}
.instructions li:last-child {
    border-bottom: none;
}
.step-num {
    width: 28px;
    height: 28px;
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 700;
    flex-shrink: 0;
}
.step-text {
    color: #374151;
    font-size: 14px;
    line-height: 1.5;
}
.step-text strong {
    color: #0f172a;
}

/* Login Prompt */
.login-prompt {
    text-align: center;
    padding: 40px;
    background: #f8fafc;
    border-radius: 16px;
    margin-bottom: 24px;
}
.login-prompt h3 {
    margin: 0 0 12px;
    color: #0f172a;
}
.login-prompt p {
    color: #64748b;
    margin: 0 0 20px;
}
.login-btn {
    display: inline-block;
    padding: 14px 32px;
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    color: #fff;
    border-radius: 12px;
    font-weight: 700;
    text-decoration: none;
}
.login-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(99,102,241,0.3);
}

/* History */
.history-section {
    margin-top: 32px;
}
.history-title {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 16px;
}
.history-table {
    width: 100%;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #e5e7eb;
}
.history-table th, .history-table td {
    padding: 14px 16px;
    text-align: left;
    font-size: 14px;
}
.history-table th {
    background: #f8fafc;
    color: #64748b;
    font-weight: 600;
}
.history-table td {
    border-top: 1px solid #f1f5f9;
}
.status-success {
    color: #10b981;
    font-weight: 600;
}
.status-pending {
    color: #f59e0b;
    font-weight: 600;
}

/* Dark Mode */
[data-theme="dark"] .deposit-title { color: var(--ink); }
[data-theme="dark"] .deposit-sub { color: var(--muted); }
[data-theme="dark"] .deposit-card { background: var(--bg-card); border-color: #334155; }
[data-theme="dark"] .deposit-card-title { color: var(--ink); }
[data-theme="dark"] .bank-info { background: #1e293b; }
[data-theme="dark"] .bank-row { border-color: #334155; }
[data-theme="dark"] .bank-label { color: #94a3b8; }
[data-theme="dark"] .bank-value { color: var(--ink); }
[data-theme="dark"] .step-text { color: #cbd5e1; }
[data-theme="dark"] .step-text strong { color: var(--ink); }
[data-theme="dark"] .instructions li { border-color: #334155; }
[data-theme="dark"] .login-prompt { background: #1e293b; }
[data-theme="dark"] .login-prompt h3 { color: var(--ink); }
[data-theme="dark"] .history-table { background: var(--bg-card); border-color: #334155; }
[data-theme="dark"] .history-table th { background: #1e293b; color: #94a3b8; }
[data-theme="dark"] .history-table td { border-color: #334155; color: var(--ink); }

@media (max-width: 768px) {
    .deposit-grid { grid-template-columns: 1fr; }
    .balance-card { flex-direction: column; text-align: center; gap: 20px; }
    .balance-amount { font-size: 28px; }
    .qr-code { width: 180px; height: 180px; }
}
</style>
@endsection

@section('content')
<div class="deposit-wrap">
    <div class="deposit-header">
        <h1 class="deposit-title">💳 Nạp tiền vào tài khoản</h1>
        <p class="deposit-sub">Nạp tiền để thanh toán nhanh hơn và nhận ưu đãi</p>
    </div>

    @if($user)
    <!-- Balance Card -->
    <div class="balance-card">
        <div class="balance-info">
            <h3>Số dư hiện tại</h3>
            <div class="balance-amount">{{ number_format($user->balance ?? 0, 0, ',', '.') }} <span>VNĐ</span></div>
        </div>
        <div class="balance-icon">💰</div>
    </div>

    <div class="deposit-grid">
        <!-- QR Code Card -->
        <div class="deposit-card">
            <h2 class="deposit-card-title"><span>📱</span> Quét mã QR để nạp</h2>
            <div class="qr-container">
                <img src="https://img.vietqr.io/image/{{ $bankInfo['bin'] }}-{{ $bankInfo['account'] }}-compact.png?addInfo={{ $depositCode }}&accountName={{ urlencode($bankInfo['owner']) }}" 
                     alt="QR Code nạp tiền" class="qr-code" id="qr-code">
                <p style="color: #64748b; font-size: 13px; margin: 0;">Quét bằng app ngân hàng hoặc ví điện tử</p>
            </div>
            
            <div class="bank-info">
                <div class="bank-row">
                    <span class="bank-label">Ngân hàng</span>
                    <span class="bank-value">{{ $bankInfo['name'] }}</span>
                </div>
                <div class="bank-row">
                    <span class="bank-label">Số tài khoản</span>
                    <span class="bank-value">
                        {{ $bankInfo['account'] }}
                        <button class="copy-btn" onclick="copyText('{{ $bankInfo['account'] }}')">Copy</button>
                    </span>
                </div>
                <div class="bank-row">
                    <span class="bank-label">Chủ tài khoản</span>
                    <span class="bank-value">{{ $bankInfo['owner'] }}</span>
                </div>
                <div class="bank-row">
                    <span class="bank-label">Nội dung CK</span>
                    <span class="bank-value" style="color: #6366f1;">
                        {{ $depositCode }}
                        <button class="copy-btn" onclick="copyText('{{ $depositCode }}')">Copy</button>
                    </span>
                </div>
            </div>
        </div>

        <!-- Instructions Card -->
        <div class="deposit-card">
            <h2 class="deposit-card-title"><span>📋</span> Hướng dẫn nạp tiền</h2>
            <ul class="instructions">
                <li>
                    <span class="step-num">1</span>
                    <span class="step-text">Mở app ngân hàng hoặc ví điện tử (MoMo, ZaloPay...)</span>
                </li>
                <li>
                    <span class="step-num">2</span>
                    <span class="step-text"><strong>Quét mã QR</strong> hoặc chuyển khoản thủ công theo thông tin bên cạnh</span>
                </li>
                <li>
                    <span class="step-num">3</span>
                    <span class="step-text">Nhập số tiền muốn nạp (tối thiểu <strong>10,000đ</strong>)</span>
                </li>
                <li>
                    <span class="step-num">4</span>
                    <span class="step-text"><strong>Quan trọng:</strong> Ghi đúng nội dung chuyển khoản: <strong style="color: #6366f1;">{{ $depositCode }}</strong></span>
                </li>
                <li>
                    <span class="step-num">5</span>
                    <span class="step-text">Tiền sẽ được cộng vào tài khoản trong <strong>1-5 phút</strong></span>
                </li>
            </ul>
            
            <div style="background: #fef3c7; border: 1px solid #fcd34d; border-radius: 10px; padding: 14px; margin-top: 20px;">
                <p style="margin: 0; font-size: 13px; color: #92400e;">
                    ⚠️ <strong>Lưu ý:</strong> Nếu ghi sai nội dung chuyển khoản, vui lòng liên hệ Zalo 
                    <a href="https://zalo.me/0777333763" style="color: #6366f1; font-weight: 600;">0777333763</a> để được hỗ trợ.
                </p>
            </div>
        </div>
    </div>

    <!-- Deposit History -->
    @if($deposits->count() > 0)
    <div class="history-section">
        <h3 class="history-title">📜 Lịch sử nạp tiền</h3>
        <table class="history-table">
            <thead>
                <tr>
                    <th>Thời gian</th>
                    <th>Số tiền</th>
                    <th>Nội dung</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                @foreach($deposits as $deposit)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($deposit->created_at)->format('d/m/Y H:i') }}</td>
                    <td style="font-weight: 600; color: #10b981;">+{{ number_format($deposit->amount, 0, ',', '.') }}đ</td>
                    <td>{{ $deposit->note ?? '-' }}</td>
                    <td class="status-{{ $deposit->status }}">{{ $deposit->status == 'success' ? 'Thành công' : 'Đang xử lý' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @else
    <!-- Login Prompt for Guest -->
    <div class="login-prompt">
        <h3>🔐 Đăng nhập để nạp tiền</h3>
        <p>Bạn cần đăng nhập để sử dụng tính năng nạp tiền vào tài khoản</p>
        <a href="/login" class="login-btn">Đăng nhập ngay</a>
    </div>
    
    <div class="deposit-card" style="max-width: 600px; margin: 0 auto;">
        <h2 class="deposit-card-title"><span>🎁</span> Lợi ích khi nạp tiền</h2>
        <ul class="instructions">
            <li>
                <span class="step-num">✓</span>
                <span class="step-text"><strong>Thanh toán nhanh hơn</strong> - Không cần chờ xác nhận chuyển khoản</span>
            </li>
            <li>
                <span class="step-num">✓</span>
                <span class="step-text"><strong>Tích điểm thưởng</strong> - Mỗi lần nạp được cộng điểm đổi voucher</span>
            </li>
            <li>
                <span class="step-num">✓</span>
                <span class="step-text"><strong>Ưu đãi đặc biệt</strong> - Nạp nhiều nhận thêm khuyến mãi</span>
            </li>
        </ul>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
function copyText(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Đã copy: ' + text);
    });
}
</script>
@endsection
