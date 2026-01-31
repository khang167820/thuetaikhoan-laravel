@extends('admin.layouts.app')

@section('title', 'Kết quả Tìm kiếm')
@section('page-title', 'Kết quả Tìm kiếm')

@section('content')
<div style="margin-bottom: 20px;">
    <span style="color: #94a3b8;">Kết quả tìm kiếm cho: </span>
    <span style="font-weight: 600; color: #3b82f6;">"{{ $query }}"</span>
</div>

@if($results->isEmpty())
<div class="admin-card" style="text-align: center; padding: 60px;">
    <div style="font-size: 64px; margin-bottom: 16px;">🔍</div>
    <h3 style="color: #f1f5f9; margin-bottom: 8px;">Không tìm thấy kết quả</h3>
    <p style="color: #64748b;">Thử tìm kiếm với từ khóa khác</p>
</div>
@else

<!-- Orders Results -->
@if($results['orders']->isNotEmpty())
<div class="admin-card">
    <div class="admin-card-title">📦 Đơn hàng ({{ $results['orders']->count() }})</div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Tracking Code</th>
                <th>Dịch vụ</th>
                <th>Số tiền</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results['orders'] as $order)
            <tr>
                <td><strong>{{ $order->tracking_code }}</strong></td>
                <td>{{ $order->service_type }}</td>
                <td style="color: #10b981;">{{ number_format($order->amount) }}đ</td>
                <td>
                    <span class="badge badge-{{ $order->status }}">{{ $order->status }}</span>
                </td>
                <td style="font-size: 12px;">{{ $order->created_at?->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<!-- Users Results -->
@if($results['users']->isNotEmpty())
<div class="admin-card">
    <div class="admin-card-title">👥 Users ({{ $results['users']->count() }})</div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Tên</th>
                <th>Email</th>
                <th>SĐT</th>
                <th>Số dư</th>
                <th>Ngày tạo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results['users'] as $user)
            <tr>
                <td><strong>{{ $user->name }}</strong></td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone ?? 'N/A' }}</td>
                <td style="color: #10b981;">{{ number_format($user->balance ?? 0) }}đ</td>
                <td style="font-size: 12px;">{{ $user->created_at?->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<!-- Accounts Results -->
@if($results['accounts']->isNotEmpty())
<div class="admin-card">
    <div class="admin-card-title">🔑 Tài khoản ({{ $results['accounts']->count() }})</div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Loại</th>
                <th>Username</th>
                <th>Trạng thái</th>
                <th>Ghi chú</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results['accounts'] as $account)
            <tr>
                <td><span class="badge badge-active">{{ $account->type }}</span></td>
                <td><strong>{{ $account->username }}</strong></td>
                <td>
                    @if($account->is_available)
                        <span class="badge badge-completed">Còn trống</span>
                    @else
                        <span class="badge badge-pending">Đang thuê</span>
                    @endif
                </td>
                <td style="font-size: 12px; color: #94a3b8;">{{ Str::limit($account->note, 50) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<!-- Coupons Results -->
@if($results['coupons']->isNotEmpty())
<div class="admin-card">
    <div class="admin-card-title">🎫 Mã giảm giá ({{ $results['coupons']->count() }})</div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Mã</th>
                <th>Loại</th>
                <th>Giá trị</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results['coupons'] as $coupon)
            <tr>
                <td><strong style="font-family: monospace;">{{ $coupon->code }}</strong></td>
                <td>{{ $coupon->type }}</td>
                <td>
                    @if($coupon->type === 'percent')
                        {{ $coupon->value }}%
                    @else
                        {{ number_format($coupon->value) }}đ
                    @endif
                </td>
                <td>
                    @if($coupon->is_active)
                        <span class="badge badge-completed">Active</span>
                    @else
                        <span class="badge badge-inactive">Inactive</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@endif
@endsection
