@extends('layouts.app')

@section('title', 'Tài khoản - ThueTaiKhoan.net')
@section('meta_description', 'Quản lý tài khoản, xem số dư và lịch sử giao dịch tại ThueTaiKhoan.net')

@section('styles')
<style>
/* Account Page - Legacy Style */
.acc-header {
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    padding: 24px 0;
}
.acc-header-inner {
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.acc-brand {
    color: #fff;
    font-size: 18px;
    font-weight: 700;
}
.acc-nav {
    display: flex;
    gap: 24px;
}
.acc-nav a {
    color: #94a3b8;
    text-decoration: none;
    font-size: 14px;
    transition: color 0.2s;
}
.acc-nav a:hover, .acc-nav a.active {
    color: #fff;
}
.acc-logout-btn {
    background: #ef4444;
    color: #fff;
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
}

/* Main Content */
.acc-wrap {
    max-width: 1000px;
    margin: 0 auto;
    padding: 32px 20px;
}

/* Balance Card */
.balance-card {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    border-radius: 16px;
    padding: 28px 32px;
    color: #fff;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 32px;
}
.balance-left h4 {
    font-size: 13px;
    font-weight: 500;
    opacity: 0.85;
    margin: 0 0 8px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.balance-amount {
    font-size: 36px;
    font-weight: 800;
    margin: 0 0 12px;
}
.balance-amount span {
    font-size: 20px;
    font-weight: 600;
    opacity: 0.8;
}
.balance-stats {
    display: flex;
    gap: 24px;
}
.balance-stat {
    text-align: center;
}
.balance-stat-value {
    font-size: 16px;
    font-weight: 700;
}
.balance-stat-label {
    font-size: 12px;
    opacity: 0.75;
}
.balance-right .deposit-btn {
    background: #fff;
    color: #6366f1;
    padding: 14px 28px;
    border-radius: 10px;
    font-size: 15px;
    font-weight: 700;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s;
}
.balance-right .deposit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

/* Quick Actions */
.quick-actions {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 32px;
}
.quick-action {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 24px;
    text-align: center;
    text-decoration: none;
    color: #374151;
    transition: all 0.2s;
}
.quick-action:hover {
    border-color: #6366f1;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
}
.quick-action-icon {
    width: 48px;
    height: 48px;
    background: #f1f5f9;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 12px;
    font-size: 22px;
}
.quick-action.active .quick-action-icon {
    background: #ede9fe;
}
.quick-action-label {
    font-size: 14px;
    font-weight: 600;
}

/* Info Grid */
.info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
}
.info-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 24px;
}
.info-card-title {
    font-size: 16px;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 20px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.info-card-title span {
    font-size: 18px;
}

/* User Info Table */
.info-table {
    width: 100%;
}
.info-table tr {
    border-bottom: 1px solid #f1f5f9;
}
.info-table tr:last-child {
    border-bottom: none;
}
.info-table td {
    padding: 12px 0;
    font-size: 14px;
}
.info-table td:first-child {
    color: #64748b;
}
.info-table td:last-child {
    color: #0f172a;
    font-weight: 600;
    text-align: right;
}
.info-table .email {
    color: #6366f1;
}
.info-table .badge {
    background: #ede9fe;
    color: #7c3aed;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 12px;
}

/* Transactions */
.transaction-item {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 14px 0;
    border-bottom: 1px solid #f1f5f9;
}
.transaction-item:last-child {
    border-bottom: none;
}
.transaction-info h5 {
    font-size: 14px;
    font-weight: 600;
    color: #0f172a;
    margin: 0 0 4px;
}
.transaction-info p {
    font-size: 12px;
    color: #94a3b8;
    margin: 0;
}
.transaction-amount {
    font-size: 14px;
    font-weight: 700;
}
.transaction-amount.positive {
    color: #10b981;
}
.transaction-amount.negative {
    color: #ef4444;
}

/* Dark Mode */
[data-theme="dark"] .balance-card { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); }
[data-theme="dark"] .quick-action { background: var(--bg-card); border-color: #334155; color: var(--ink); }
[data-theme="dark"] .quick-action-icon { background: #1e293b; }
[data-theme="dark"] .info-card { background: var(--bg-card); border-color: #334155; }
[data-theme="dark"] .info-card-title { color: var(--ink); }
[data-theme="dark"] .info-table tr { border-color: #334155; }
[data-theme="dark"] .info-table td:first-child { color: #94a3b8; }
[data-theme="dark"] .info-table td:last-child { color: var(--ink); }
[data-theme="dark"] .transaction-item { border-color: #334155; }
[data-theme="dark"] .transaction-info h5 { color: var(--ink); }

@media (max-width: 768px) {
    .balance-card { flex-direction: column; text-align: center; gap: 20px; }
    .balance-stats { justify-content: center; }
    .quick-actions { grid-template-columns: repeat(3, 1fr); gap: 12px; }
    .quick-action { padding: 16px 12px; }
    .info-grid { grid-template-columns: 1fr; }
}
</style>
@endsection

@section('content')
<div class="acc-wrap">
    <!-- Balance Card -->
    <div class="balance-card">
        <div class="balance-left">
            <h4>🔒 Số dư tài khoản</h4>
            <div class="balance-amount">{{ number_format($user->balance ?? 0, 0, ',', '.') }} <span>VND</span></div>
            <div class="balance-stats">
                <div class="balance-stat">
                    <div class="balance-stat-value">{{ number_format($totalDeposited, 0, ',', '.') }}đ</div>
                    <div class="balance-stat-label">Đã nạp</div>
                </div>
                <div class="balance-stat">
                    <div class="balance-stat-value">{{ number_format($totalSpent, 0, ',', '.') }}đ</div>
                    <div class="balance-stat-label">Đã chi tiêu</div>
                </div>
            </div>
        </div>
        <div class="balance-right">
            <a href="/deposit" class="deposit-btn">
                <span>+</span> Nạp tiền
            </a>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <a href="/deposit" class="quick-action">
            <div class="quick-action-icon">💳</div>
            <div class="quick-action-label">Nạp tiền</div>
        </a>
        <a href="/ord-services" class="quick-action active">
            <div class="quick-action-icon">🔓</div>
            <div class="quick-action-label">Dịch vụ</div>
        </a>
        <a href="/order-history-ip" class="quick-action">
            <div class="quick-action-icon">📜</div>
            <div class="quick-action-label">Lịch sử</div>
        </a>
    </div>

    <!-- Info Grid -->
    <div class="info-grid">
        <!-- User Info -->
        <div class="info-card">
            <h3 class="info-card-title"><span>👤</span> Thông tin tài khoản</h3>
            <table class="info-table">
                <tr>
                    <td>Email</td>
                    <td class="email">{{ $user->email }}</td>
                </tr>
                <tr>
                    <td>Họ tên</td>
                    <td>{{ $user->name ?? $user->fullname ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Số điện thoại</td>
                    <td>{{ $user->phone ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Hạng tài khoản</td>
                    <td><span class="badge">{{ ucfirst($user->role ?? 'User') }}</span></td>
                </tr>
                <tr>
                    <td>Ngày tham gia</td>
                    <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}</td>
                </tr>
            </table>
        </div>

        <!-- Recent Transactions -->
        <div class="info-card">
            <h3 class="info-card-title"><span>📈</span> Giao dịch gần đây</h3>
            @if($transactions->count() > 0)
                @foreach($transactions as $tx)
                <div class="transaction-item">
                    <div class="transaction-info">
                        <h5>{{ $tx->type == 'deposit' ? 'Nạp tiền qua chuyển khoản' : ($tx->service_name ?? 'Thuê dịch vụ') }}</h5>
                        <p>{{ \Carbon\Carbon::parse($tx->created_at)->format('H:i d/m/Y') }}</p>
                    </div>
                    <div class="transaction-amount {{ $tx->type == 'deposit' ? 'positive' : 'negative' }}">
                        {{ $tx->type == 'deposit' ? '+' : '-' }}{{ number_format($tx->price, 0, ',', '.') }}đ
                    </div>
                </div>
                @endforeach
            @else
                <p style="color: #94a3b8; text-align: center; padding: 40px 0;">Chưa có giao dịch nào</p>
            @endif
        </div>
    </div>
</div>
@endsection
