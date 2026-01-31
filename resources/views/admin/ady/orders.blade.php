@extends('admin.layouts.app')

@section('title', 'Đơn ADY')
@section('page-title', 'Đơn hàng ADY Unlocker')

@section('content')
<!-- Filter -->
<div class="filter-bar">
    <select class="form-select" onchange="window.location.href='{{ route('admin.ady.orders') }}?status=' + this.value">
        <option value="">Tất cả trạng thái</option>
        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
        <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Đang xử lý</option>
        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Hoàn thành</option>
        <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Thất bại</option>
    </select>
</div>

<div class="admin-card">
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>IMEI/SN</th>
                    <th>Sản phẩm</th>
                    <th>Giá</th>
                    <th>Trạng thái</th>
                    <th>Kết quả</th>
                    <th>Ngày tạo</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td style="font-family: monospace; color: #3b82f6;">{{ $order->imei ?? 'N/A' }}</td>
                    <td>{{ $order->product_name ?? 'N/A' }}</td>
                    <td style="color: #10b981; font-weight: 600;">{{ number_format($order->price ?? 0) }}đ</td>
                    <td>
                        @php
                            $statusClass = match($order->status ?? 'pending') {
                                'completed' => 'badge-completed',
                                'processing' => 'badge-paid',
                                'failed' => 'badge-cancelled',
                                default => 'badge-pending'
                            };
                        @endphp
                        <span class="badge {{ $statusClass }}">{{ ucfirst($order->status ?? 'pending') }}</span>
                    </td>
                    <td style="font-size: 12px; max-width: 200px; overflow: hidden; text-overflow: ellipsis;">
                        {{ $order->result ?? '—' }}
                    </td>
                    <td style="font-size: 12px;">{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px; color: #64748b;">
                        <div style="font-size: 48px; margin-bottom: 12px;">📋</div>
                        <p>Chưa có đơn ADY nào</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($orders->hasPages())
        <div class="pagination">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
