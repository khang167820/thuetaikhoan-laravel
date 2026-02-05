@extends('layouts.app')

@section('title', 'Lịch sử đơn hàng - ThueTaiKhoan.vn')

@section('content')
<div class="oh-page">
    <div class="oh-container">
        <!-- Header Compact -->
        <div class="oh-header">
            <div class="oh-header-left">
                <h1 class="oh-title">Lịch sử đơn hàng</h1>
                <p class="oh-subtitle">Xin chào <strong>{{ $user->name ?? $user->phone }}</strong></p>
            </div>
            <div class="oh-balance">
                <span class="oh-balance-label">Số dư</span>
                <span class="oh-balance-value">{{ number_format($user->balance ?? 0, 0, ',', '.') }}đ</span>
            </div>
        </div>
        
        <!-- Status Tabs Compact -->
        <div class="oh-tabs">
            <a href="{{ route('order.history') }}" class="oh-tab {{ $filter === 'all' ? 'active' : '' }}">
                Tất cả <span>{{ $orders->total() }}</span>
            </a>
            <a href="{{ route('order.history', ['status' => 'pending']) }}" class="oh-tab {{ $filter === 'pending' ? 'active' : '' }}">
                Chờ thanh toán <span>{{ $statusCounts['pending'] ?? 0 }}</span>
            </a>
            <a href="{{ route('order.history', ['status' => 'paid']) }}" class="oh-tab {{ $filter === 'paid' ? 'active' : '' }}">
                Đã thanh toán <span>{{ $statusCounts['paid'] ?? 0 }}</span>
            </a>
            <a href="{{ route('order.history', ['status' => 'completed']) }}" class="oh-tab {{ $filter === 'completed' ? 'active' : '' }}">
                Hoàn thành <span>{{ $statusCounts['completed'] ?? 0 }}</span>
            </a>
            <a href="{{ route('order.history', ['status' => 'cancelled']) }}" class="oh-tab {{ $filter === 'cancelled' ? 'active' : '' }}">
                Đã hủy <span>{{ $statusCounts['cancelled'] ?? 0 }}</span>
            </a>
        </div>
        
        <!-- Orders List Compact -->
        @if($orders->count() > 0)
        <div class="oh-list">
            @foreach($orders as $order)
            @php
                $serviceName = \App\Http\Controllers\OrderHistoryController::getServiceName($order);
                $statusText = \App\Http\Controllers\OrderHistoryController::getStatusText($order->status);
                $statusClass = \App\Http\Controllers\OrderHistoryController::getStatusBadgeClass($order->status);
                
                // Get logo path based on service name
                $logoPath = '/images/services/';
                $serviceNameLower = strtolower($serviceName);
                if (stripos($serviceNameLower, 'unlocktool') !== false || stripos($serviceNameLower, 'unlock') !== false) {
                    $logoPath .= 'unlocktool.png';
                } elseif (stripos($serviceNameLower, 'vietmap') !== false) {
                    $logoPath .= 'vietmap.png';
                } elseif (stripos($serviceNameLower, 'griffin') !== false) {
                    $logoPath .= 'griffin.png';
                } elseif (stripos($serviceNameLower, 'amt') !== false || stripos($serviceNameLower, 'multitool') !== false) {
                    $logoPath .= 'amt.svg';
                } elseif (stripos($serviceNameLower, 'kg') !== false || stripos($serviceNameLower, 'killer') !== false) {
                    $logoPath .= 'kg-killer.png';
                } elseif (stripos($serviceNameLower, 'samsung') !== false) {
                    $logoPath .= 'samsung-tool.png';
                } elseif (stripos($serviceNameLower, 'dft') !== false) {
                    $logoPath .= 'dft-pro.png';
                } elseif (stripos($serviceNameLower, 'tsm') !== false) {
                    $logoPath .= 'tsm.png';
                } else {
                    $logoPath .= 'unlocktool.png'; // default
                }
            @endphp
            <div class="oh-item">
                <div class="oh-item-logo">
                    <img src="{{ $logoPath }}" alt="{{ $serviceName }}" loading="lazy">
                </div>
                <div class="oh-item-info">
                    <div class="oh-item-name">{{ $serviceName }}</div>
                    <div class="oh-item-meta">{{ $order->hours }} giờ • {{ $order->tracking_code }}</div>
                </div>
                <div class="oh-item-price">
                    <div class="oh-price-value">{{ number_format($order->amount, 0, ',', '.') }}đ</div>
                    <div class="oh-price-date">{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}</div>
                </div>
                <div class="oh-item-status {{ $statusClass }}">{{ $statusText }}</div>
                
                @if(($order->status === 'paid' || $order->status === 'completed') && $order->account_username && $order->account_password)
                    @php
                        $isExpired = $order->expires_at && \Carbon\Carbon::parse($order->expires_at)->isPast();
                    @endphp
                    @if($isExpired)
                    <div class="oh-item-cred oh-cred-expired">
                        <span class="oh-cred-label">⏰ Đã hết hạn thuê</span>
                        <span class="oh-cred-expired-text">Tài khoản không còn khả dụng</span>
                    </div>
                    @else
                    <div class="oh-item-cred">
                        <span class="oh-cred-label">Tài khoản:</span>
                        <span class="oh-cred-value" onclick="copyToClipboard('{{ $order->account_username }}')">{{ $order->account_username }}</span>
                        <span class="oh-cred-sep">/</span>
                        <span class="oh-cred-value" onclick="copyToClipboard('{{ $order->account_password }}')">{{ $order->account_password }}</span>
                    </div>
                    @endif
                @endif
            </div>
            @endforeach
        </div>
        
        @if($orders->hasPages())
        <div class="oh-pagination">{{ $orders->links() }}</div>
        @endif
        
        @else
        <div class="oh-empty">
            <div class="oh-empty-icon">📭</div>
            <p>Chưa có đơn hàng{{ $filter !== 'all' ? ' với trạng thái này' : '' }}</p>
            <a href="/" class="oh-empty-btn">Thuê dịch vụ ngay</a>
        </div>
        @endif
    </div>
</div>

<style>
/* ========== COMPACT ORDER HISTORY ========== */
.oh-page {
    min-height: calc(100vh - 80px);
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    padding: 24px 16px;
}
.oh-container { max-width: 900px; margin: 0 auto; }

/* Header Compact */
.oh-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    gap: 16px;
    flex-wrap: wrap;
}
.oh-title { font-size: 22px; font-weight: 700; color: #1e293b; margin: 0; }
.oh-subtitle { font-size: 13px; color: #64748b; margin: 4px 0 0; }
.oh-subtitle strong { color: #0ea5e9; }
.oh-balance {
    background: linear-gradient(135deg, #059669, #10b981);
    padding: 10px 18px;
    border-radius: 12px;
    text-align: right;
}
.oh-balance-label { display: block; font-size: 10px; color: rgba(255,255,255,0.8); }
.oh-balance-value { font-size: 18px; font-weight: 700; color: #fff; }

/* Tabs Compact */
.oh-tabs {
    display: flex;
    gap: 6px;
    margin-bottom: 16px;
    overflow-x: auto;
    padding-bottom: 4px;
}
.oh-tab {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 14px;
    background: #fff;
    border-radius: 8px;
    text-decoration: none;
    color: #64748b;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
    transition: all 0.2s;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}
.oh-tab:hover { background: #f1f5f9; color: #334155; }
.oh-tab.active { background: #1e293b; color: #fff; }
.oh-tab span {
    background: rgba(100,116,139,0.1);
    padding: 2px 6px;
    border-radius: 10px;
    font-size: 10px;
}
.oh-tab.active span { background: rgba(255,255,255,0.2); }

/* Order List Compact */
.oh-list { display: flex; flex-direction: column; gap: 8px; }

.oh-item {
    display: grid;
    grid-template-columns: 44px 1fr auto auto;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    transition: all 0.2s;
}
.oh-item:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    transform: translateY(-1px);
}

/* Logo */
.oh-item-logo {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    overflow: hidden;
    background: #f8fafc;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.oh-item-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 4px;
}

/* Info */
.oh-item-info { min-width: 0; }
.oh-item-name { font-size: 14px; font-weight: 600; color: #1e293b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.oh-item-meta { font-size: 11px; color: #94a3b8; margin-top: 2px; }

/* Price */
.oh-item-price { text-align: right; }
.oh-price-value { font-size: 14px; font-weight: 700; color: #059669; }
.oh-price-date { font-size: 10px; color: #94a3b8; margin-top: 2px; }

/* Status Badge */
.oh-item-status {
    padding: 5px 10px;
    border-radius: 6px;
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    white-space: nowrap;
}
.oh-item-status.status-pending { background: #fef3c7; color: #d97706; }
.oh-item-status.status-paid { background: #dbeafe; color: #2563eb; }
.oh-item-status.status-completed { background: #dcfce7; color: #16a34a; }
.oh-item-status.status-failed { background: #fee2e2; color: #dc2626; }

/* Credentials Row */
.oh-item-cred {
    grid-column: 1 / -1;
    background: #ecfdf5;
    padding: 8px 12px;
    border-radius: 8px;
    margin-top: 4px;
    font-size: 12px;
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}
.oh-cred-label { color: #059669; font-weight: 600; }
.oh-cred-value {
    background: #fff;
    padding: 3px 8px;
    border-radius: 4px;
    font-family: 'Monaco', 'Consolas', monospace;
    font-size: 11px;
    cursor: pointer;
    color: #1e293b;
    transition: all 0.2s;
}
.oh-cred-value:hover { background: #059669; color: #fff; }
.oh-cred-sep { color: #a7f3d0; }

/* Expired credentials */
.oh-cred-expired {
    background: #fef2f2 !important;
    border: 1px dashed #fecaca;
}
.oh-cred-expired .oh-cred-label { color: #dc2626; }
.oh-cred-expired-text { 
    color: #991b1b; 
    font-size: 11px; 
    font-style: italic;
}

/* Empty State */
.oh-empty { text-align: center; padding: 60px 20px; background: #fff; border-radius: 16px; }
.oh-empty-icon { font-size: 48px; margin-bottom: 16px; }
.oh-empty p { color: #64748b; margin-bottom: 20px; }
.oh-empty-btn {
    display: inline-block;
    padding: 12px 24px;
    background: linear-gradient(135deg, #f97316, #ea580c);
    color: #fff;
    font-weight: 600;
    border-radius: 10px;
    text-decoration: none;
}

/* Pagination */
.oh-pagination { margin-top: 20px; display: flex; justify-content: center; }

/* Dark Mode */
[data-theme="dark"] .oh-page { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); }
[data-theme="dark"] .oh-title { color: #f1f5f9; }
[data-theme="dark"] .oh-tab, [data-theme="dark"] .oh-item, [data-theme="dark"] .oh-empty { background: #1e293b; }
[data-theme="dark"] .oh-tab.active { background: #3b82f6; }
[data-theme="dark"] .oh-item-name { color: #f1f5f9; }
[data-theme="dark"] .oh-item-logo { background: #334155; }

/* Mobile */
@media (max-width: 640px) {
    .oh-item {
        grid-template-columns: 40px 1fr;
        gap: 10px;
    }
    .oh-item-price, .oh-item-status { grid-column: 2; }
    .oh-item-price { text-align: left; }
    .oh-item-status { justify-self: start; margin-top: 4px; }
}
</style>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        const toast = document.createElement('div');
        toast.textContent = '✓ Đã sao chép!';
        toast.style.cssText = 'position:fixed;bottom:20px;left:50%;transform:translateX(-50%);background:#059669;color:#fff;padding:10px 20px;border-radius:8px;font-size:13px;font-weight:600;z-index:9999;';
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 1500);
    });
}
</script>
@endsection
