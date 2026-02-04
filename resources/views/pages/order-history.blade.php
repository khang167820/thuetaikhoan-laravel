@extends('layouts.app')

@section('title', 'Lịch sử thuê 30 ngày - ThueTaiKhoan.net')
@section('meta_description', 'Xem lại các đơn hàng thuê tài khoản của bạn trong 30 ngày qua')

@php
use App\Http\Controllers\OrderHistoryController;
@endphp

@section('styles')
<style>
/* Order History Page Styles */
.history-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
}
.page-header {
    margin-bottom: 32px;
}
.page-title {
    font-size: 32px;
    font-weight: 800;
    color: #1f2937;
    margin-bottom: 8px;
}
.page-subtitle {
    color: #6b7280;
    font-size: 16px;
}
.card {
    background: #fff;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    margin-bottom: 24px;
    border: 1px solid #e5e7eb;
}
.table-responsive {
    overflow-x: auto;
}
table {
    width: 100%;
    border-collapse: collapse;
}
thead {
    background: #f9fafb;
}
th {
    padding: 12px;
    text-align: left;
    font-size: 13px;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    border-bottom: 2px solid #e5e7eb;
}
td {
    padding: 16px 12px;
    border-bottom: 1px solid #f3f4f6;
    font-size: 14px;
    color: #1f2937;
}
tbody tr:hover {
    background: #f9fafb;
}
tbody tr:last-child td {
    border-bottom: none;
}
.status-badge {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}
.status-pending {
    background: #fef3c7;
    color: #92400e;
}
.status-paid {
    background: #dbeafe;
    color: #1e40af;
}
.status-completed {
    background: #d1fae5;
    color: #065f46;
}
.status-failed {
    background: #fee2e2;
    color: #991b1b;
}
.order-link {
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
    font-family: monospace;
    font-size: 13px;
}
.order-link:hover {
    text-decoration: underline;
}
.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #9ca3af;
}
.empty-state-icon {
    font-size: 48px;
    margin-bottom: 16px;
    opacity: 0.5;
}
.empty-state-text {
    font-size: 16px;
    margin-bottom: 8px;
    font-weight: 600;
    color: #374151;
}
.empty-state-subtext {
    font-size: 14px;
    color: #9ca3af;
}
.error-box {
    background: #fee2e2;
    border: 1px solid #fecaca;
    border-radius: 12px;
    padding: 20px;
    color: #991b1b;
    margin-bottom: 24px;
}
.ip-info {
    background: linear-gradient(135deg, #f0f4ff 0%, #faf5ff 100%);
    border: 1px solid #e0e7ff;
    border-radius: 12px;
    padding: 16px 20px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 12px;
}
.ip-info-icon {
    font-size: 24px;
}
.ip-info-text {
    font-size: 14px;
    color: #4f46e5;
}
.ip-value {
    font-family: monospace;
    background: #fff;
    padding: 2px 8px;
    border-radius: 6px;
    border: 1px solid #c7d2fe;
}

/* Dark Mode */
[data-theme="dark"] .page-title { color: var(--ink); }
[data-theme="dark"] .page-subtitle { color: var(--muted); }
[data-theme="dark"] .card { background: var(--bg-card); border-color: #334155; }
[data-theme="dark"] thead { background: #1e293b; }
[data-theme="dark"] th { color: #94a3b8; border-color: #334155; }
[data-theme="dark"] td { color: var(--ink); border-color: #334155; }
[data-theme="dark"] tbody tr:hover { background: #1e293b; }
[data-theme="dark"] .ip-info { background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border-color: #334155; }
[data-theme="dark"] .ip-info-text { color: #60a5fa; }
[data-theme="dark"] .ip-value { background: #0f172a; border-color: #475569; color: #f1f5f9; }
[data-theme="dark"] .order-link { color: #60a5fa; }
[data-theme="dark"] .empty-state-text { color: #cbd5e1; }

@media (max-width: 768px) {
    .history-container {
        padding: 20px 16px;
    }
    .page-title {
        font-size: 22px;
    }
    .ip-info {
        flex-direction: column;
        text-align: center;
        gap: 8px;
    }
    /* Hide table on mobile, show as cards */
    table thead {
        display: none;
    }
    table, table tbody, table tr, table td {
        display: block;
        width: 100%;
    }
    table tr {
        background: #fff;
        margin-bottom: 12px;
        border-radius: 12px;
        padding: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        border: 1px solid #f1f5f9;
    }
    table td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px dashed #f1f5f9;
        font-size: 13px;
    }
    table td:last-child {
        border-bottom: none;
    }
    table td::before {
        content: attr(data-label);
        font-weight: 600;
        color: #64748b;
        font-size: 12px;
    }
    .order-link {
        font-size: 12px;
    }
    .status-badge {
        padding: 4px 10px;
        font-size: 11px;
    }
}
</style>
@endsection

@section('content')
<div class="history-container">
    <div class="page-header">
        <h1 class="page-title">📋 Lịch sử thuê 30 ngày</h1>
        <p class="page-subtitle">Xem lại các đơn hàng bạn đã đặt trong 30 ngày qua</p>
    </div>

    <div class="ip-info">
        <span class="ip-info-icon">🌐</span>
        <span class="ip-info-text">
            Đang hiển thị lịch sử đơn hàng từ IP: <span class="ip-value">{{ $customerIp }}</span>
        </span>
    </div>

    @if($error)
    <div class="error-box">
        <strong>Lỗi:</strong> {{ $error }}
    </div>
    @else
    <div class="card">
        @if($orders->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">📦</div>
            <div class="empty-state-text">Chưa có đơn hàng nào</div>
            <div class="empty-state-subtext">Bạn chưa đặt đơn hàng nào trong 30 ngày qua. Hãy thử đặt một đơn hàng mới!</div>
            <a href="/" style="display:inline-block;margin-top:20px;padding:12px 24px;background:linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);color:#fff;border-radius:10px;font-weight:600;text-decoration:none;">🛒 Thuê ngay</a>
        </div>
        @else
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Dịch vụ</th>
                        <th>Gói</th>
                        <th>Số tiền</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th>Hết hạn</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    @php
                        $serviceName = OrderHistoryController::getServiceName($order);
                        $hours = (int)($order->hours ?? 0);
                        $hoursLabel = $hours < 24 ? $hours . ' giờ' : ($hours / 24) . ' ngày';
                        $statusText = OrderHistoryController::getStatusText($order->status);
                        $statusClass = OrderHistoryController::getStatusBadgeClass($order->status);
                    @endphp
                    <tr>
                        <td data-label="Mã đơn">
                            <a href="/order-detail?code={{ urlencode($order->tracking_code) }}" class="order-link">
                                {{ $order->tracking_code }}
                            </a>
                        </td>
                        <td data-label="Dịch vụ">{{ $serviceName }}</td>
                        <td data-label="Gói">{{ $hoursLabel }}</td>
                        <td data-label="Số tiền"><strong>{{ number_format($order->amount) }}₫</strong></td>
                        <td data-label="Trạng thái">
                            <span class="status-badge {{ $statusClass }}">
                                {{ $statusText }}
                            </span>
                        </td>
                        <td data-label="Ngày tạo">{{ $order->created_at ? \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') : '-' }}</td>
                        <td data-label="Hết hạn">
                            @if($order->expires_at)
                                @php
                                    $expires = \Carbon\Carbon::parse($order->expires_at);
                                    $isExpired = $expires->isPast();
                                @endphp
                                <span style="color: {{ $isExpired ? '#ef4444' : '#10b981' }};">
                                    {{ $expires->format('d/m/Y H:i') }}
                                </span>
                            @else
                                -
                            @endif
                        </td>
                        <td data-label="">
                            <a href="/order-detail?code={{ urlencode($order->tracking_code) }}" class="order-link">
                                Xem chi tiết
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
    @endif
</div>
@endsection
