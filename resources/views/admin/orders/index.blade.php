@extends('admin.layouts.app')

@section('title', 'Quản lý đơn hàng')
@section('page-title', 'Quản lý đơn hàng')

@section('content')
<!-- Filter Bar -->
<div class="filter-bar">
    <form action="{{ route('admin.orders') }}" method="GET" style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
        <input type="text" name="search" class="form-input" placeholder="Tìm mã đơn..." value="{{ request('search') }}" style="width: 200px;">
        
        <select name="status" class="form-select" style="width: 160px;">
            <option value="">Tất cả trạng thái</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Chờ thanh toán ({{ $statusCounts['pending'] ?? 0 }})</option>
            <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Đã thanh toán ({{ $statusCounts['paid'] ?? 0 }})</option>
            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Hoàn thành ({{ $statusCounts['completed'] ?? 0 }})</option>
            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Đã hủy ({{ $statusCounts['cancelled'] ?? 0 }})</option>
        </select>
        
        <button type="submit" class="btn btn-primary">Lọc</button>
        <a href="{{ route('admin.orders') }}" class="btn btn-secondary">Reset</a>
    </form>
</div>

<!-- Orders Table -->
<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Mã đơn</th>
                <th>Người thuê</th>
                <th>Dịch vụ</th>
                <th>Thời gian</th>
                <th>Số tiền</th>
                <th>Trạng thái</th>
                <th>Tài khoản cấp</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td>#{{ $order->id }}</td>
                <td><strong>{{ $order->tracking_code }}</strong></td>
                <td style="font-size: 11px;">
                    @if($order->user)
                        <div style="color: var(--primary); font-weight: 500;" title="Tài khoản đăng nhập">
                            👤 {{ Str::limit($order->user->name ?? $order->user->email, 20) }}
                        </div>
                    @endif
                    @if($order->customer_email)
                        <div style="color: var(--text-primary); font-weight: 500;">
                            ✉️ {{ Str::limit($order->customer_email, 22) }}
                        </div>
                    @endif
                    @if($order->ip_address)
                        <div style="color: var(--text-dimmed); font-family: monospace; font-size: 10px;" title="{{ $order->ip_address }}">
                            🌐 {{ $order->ip_address }}
                        </div>
                    @endif
                    @if(!$order->customer_email && !$order->ip_address && !$order->user)
                        <span style="color: #64748b;">—</span>
                    @endif
                </td>
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
                <td style="font-size: 11px;">
                    @if($order->account)
                        <div style="color: #16a34a; font-weight: 600;">🔑 {{ $order->account->username ?? $order->account->email ?? 'TK #'.$order->account->id }}</div>
                        @if($order->assigned_password)
                            <div style="color: #64748b; font-family: monospace; font-size: 10px;">🔒 {{ $order->assigned_password }}</div>
                        @endif
                    @elseif($order->status === 'completed')
                        <span style="color: #f59e0b;">⚠️ Chưa gán</span>
                    @else
                        <span style="color: #cbd5e1;">—</span>
                    @endif
                </td>
                <td>{{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                <td>
                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <select name="status" class="form-select" style="width: 120px; font-size: 11px; padding: 4px 8px;" onchange="this.form.submit()">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Chờ TT</option>
                            <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Đã TT</option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" style="text-align: center; color: #64748b; padding: 40px;">
                    Không có đơn hàng nào
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if($orders->hasPages())
<div class="pagination">
    {{ $orders->links() }}
</div>
@endif
@endsection
