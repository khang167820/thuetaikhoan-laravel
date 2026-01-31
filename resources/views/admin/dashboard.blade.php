@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon green">💰</div>
        <div class="stat-info">
            <div class="stat-label">Doanh thu hôm nay</div>
            <div class="stat-value">{{ number_format($todayRevenue, 0, ',', '.') }}đ</div>
            <div class="stat-sub">Tuần: {{ number_format($weekRevenue, 0, ',', '.') }}đ • Tháng: {{ number_format($monthRevenue, 0, ',', '.') }}đ</div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon blue">📦</div>
        <div class="stat-info">
            <div class="stat-label">Tổng đơn hàng</div>
            <div class="stat-value">{{ number_format($totalOrders) }}</div>
            <div class="stat-sub">Hôm nay: {{ $todayOrders }} • Chờ TT: {{ $pendingOrders }}</div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon orange">👥</div>
        <div class="stat-info">
            <div class="stat-label">Tổng users</div>
            <div class="stat-value">{{ number_format($totalUsers) }}</div>
            <div class="stat-sub">Hôm nay: {{ $todayUsers }} • Active: {{ $activeUsers }}</div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon purple">🎫</div>
        <div class="stat-info">
            <div class="stat-label">Mã giảm giá</div>
            <div class="stat-value">{{ $activeCoupons }}</div>
            <div class="stat-sub">Active / {{ $totalCoupons }} tổng</div>
        </div>
    </div>
</div>

<!-- Order Stats Row -->
<div class="stats-grid" style="grid-template-columns: repeat(4, 1fr);">
    <div class="stat-card" style="background: linear-gradient(135deg, #fef3c7, #fde68a); border: none;">
        <div class="stat-info" style="width: 100%; text-align: center;">
            <div class="stat-label" style="color: #92400e;">Chờ thanh toán</div>
            <div class="stat-value" style="color: #d97706;">{{ $pendingOrders }}</div>
        </div>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #dbeafe, #bfdbfe); border: none;">
        <div class="stat-info" style="width: 100%; text-align: center;">
            <div class="stat-label" style="color: #1e40af;">Đã thanh toán</div>
            <div class="stat-value" style="color: #2563eb;">{{ $paidOrders }}</div>
        </div>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #dcfce7, #bbf7d0); border: none;">
        <div class="stat-info" style="width: 100%; text-align: center;">
            <div class="stat-label" style="color: #166534;">Hoàn thành</div>
            <div class="stat-value" style="color: #16a34a;">{{ $completedOrders }}</div>
        </div>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #f1f5f9, #e2e8f0); border: none;">
        <div class="stat-info" style="width: 100%; text-align: center;">
            <div class="stat-label" style="color: #475569;">Tổng cộng</div>
            <div class="stat-value" style="color: #1e293b;">{{ $totalOrders }}</div>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="admin-card">
    <div class="admin-card-title">📋 Đơn hàng gần đây</div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Mã đơn</th>
                <th>Dịch vụ</th>
                <th>Thời gian</th>
                <th>Số tiền</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentOrders as $order)
            <tr>
                <td><strong>{{ $order->tracking_code }}</strong></td>
                <td>{{ $order->service_type ?? 'N/A' }}</td>
                <td>{{ $order->hours }} giờ</td>
                <td style="color: #10b981; font-weight: 600;">{{ number_format($order->amount, 0, ',', '.') }}đ</td>
                <td>
                    @if($order->status === 'pending')
                        <span class="badge badge-pending">Chờ TT</span>
                    @elseif($order->status === 'paid')
                        <span class="badge badge-paid">Đã TT</span>
                    @elseif($order->status === 'completed')
                        <span class="badge badge-completed">Hoàn thành</span>
                    @else
                        <span class="badge badge-cancelled">{{ $order->status }}</span>
                    @endif
                </td>
                <td>{{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: #64748b;">Chưa có đơn hàng nào</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div style="text-align: center; margin-top: 16px;">
        <a href="{{ route('admin.orders') }}" class="btn btn-secondary">Xem tất cả đơn hàng →</a>
    </div>
</div>
@endsection
