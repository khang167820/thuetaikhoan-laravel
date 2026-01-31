@extends('admin.layouts.app')

@section('title', 'Nhật ký Hoạt động')
@section('page-title', 'Nhật ký Hoạt động')

@section('content')
<!-- Filter -->
<div class="filter-bar" style="margin-bottom: 20px;">
    <form style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
        <select name="action" class="form-select" onchange="this.form.submit()">
            <option value="">Tất cả hành động</option>
            <option value="login" {{ request('action') === 'login' ? 'selected' : '' }}>Đăng nhập</option>
            <option value="order" {{ request('action') === 'order' ? 'selected' : '' }}>Đơn hàng</option>
            <option value="account" {{ request('action') === 'account' ? 'selected' : '' }}>Tài khoản</option>
            <option value="settings" {{ request('action') === 'settings' ? 'selected' : '' }}>Cài đặt</option>
        </select>
        <select name="days" class="form-select" onchange="this.form.submit()">
            <option value="7" {{ request('days', '7') === '7' ? 'selected' : '' }}>7 ngày qua</option>
            <option value="30" {{ request('days') === '30' ? 'selected' : '' }}>30 ngày qua</option>
            <option value="90" {{ request('days') === '90' ? 'selected' : '' }}>90 ngày qua</option>
        </select>
    </form>
</div>

<!-- Logs Table -->
<div class="admin-card">
    <div class="admin-card-title">📝 Lịch sử Hoạt động</div>
    
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Thời gian</th>
                    <th>Admin</th>
                    <th>Hành động</th>
                    <th>Chi tiết</th>
                    <th>IP</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td style="font-size: 12px; white-space: nowrap;">
                        {{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i:s') }}
                    </td>
                    <td>
                        <span style="font-weight: 600;">{{ $log->admin_name ?? 'System' }}</span>
                    </td>
                    <td>
                        @switch($log->action ?? '')
                            @case('login')
                                <span class="badge badge-paid">🔑 Đăng nhập</span>
                                @break
                            @case('logout')
                                <span class="badge badge-inactive">🚪 Đăng xuất</span>
                                @break
                            @case('order_update')
                                <span class="badge badge-pending">📦 Cập nhật đơn</span>
                                @break
                            @case('account_add')
                                <span class="badge badge-completed">➕ Thêm TK</span>
                                @break
                            @case('account_delete')
                                <span class="badge badge-cancelled">🗑️ Xóa TK</span>
                                @break
                            @case('settings_update')
                                <span class="badge badge-active">⚙️ Cài đặt</span>
                                @break
                            @default
                                <span class="badge badge-secondary">{{ $log->action ?? 'N/A' }}</span>
                        @endswitch
                    </td>
                    <td style="max-width: 300px; font-size: 12px; color: #94a3b8;">
                        {{ Str::limit($log->details ?? '', 80) }}
                    </td>
                    <td style="font-size: 11px; font-family: monospace; color: #64748b;">
                        {{ $log->ip_address ?? 'N/A' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 60px; color: #64748b;">
                        <div style="font-size: 48px; margin-bottom: 12px;">📋</div>
                        <p>Chưa có nhật ký hoạt động</p>
                        <p style="font-size: 12px; margin-top: 8px;">Các hoạt động admin sẽ được ghi lại tại đây</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($logs->hasPages())
        <div class="pagination" style="margin-top: 20px;">
            {{ $logs->withQueryString()->links() }}
        </div>
    @endif
</div>

<!-- Stats -->
<div class="stats-grid" style="grid-template-columns: repeat(4, 1fr);">
    <div class="stat-card">
        <div class="stat-icon blue">🔑</div>
        <div class="stat-info">
            <div class="stat-label">Đăng nhập</div>
            <div class="stat-value">{{ $stats['logins'] ?? 0 }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">📦</div>
        <div class="stat-info">
            <div class="stat-label">Cập nhật đơn</div>
            <div class="stat-value">{{ $stats['order_updates'] ?? 0 }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange">👤</div>
        <div class="stat-info">
            <div class="stat-label">Tài khoản</div>
            <div class="stat-value">{{ $stats['account_changes'] ?? 0 }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon purple">⚙️</div>
        <div class="stat-info">
            <div class="stat-label">Cài đặt</div>
            <div class="stat-value">{{ $stats['settings_changes'] ?? 0 }}</div>
        </div>
    </div>
</div>
@endsection
