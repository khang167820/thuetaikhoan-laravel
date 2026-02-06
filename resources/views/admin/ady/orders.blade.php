@extends('admin.layouts.app')

@section('title', 'Đơn ADY')
@section('page-title', 'Đơn hàng ADY Unlocker')

@section('content')
<!-- Filter -->
<div class="filter-bar">
    <select class="form-select" onchange="window.location.href='{{ route('admin.ady.orders') }}?status=' + this.value">
        <option value="">Tất cả trạng thái</option>
        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Chờ thanh toán</option>
        <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
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
                    <th>Mã đơn</th>
                    <th>Sản phẩm</th>
                    <th>Thông tin</th>
                    <th>Giá</th>
                    <th>Trạng thái</th>
                    <th>Kết quả</th>
                    <th>Khách hàng</th>
                    <th>Ngày tạo</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                @php
                    // Extract fields from JSON
                    $fields = json_decode($order->fields ?? '{}', true) ?: [];
                    
                    // Try to find IMEI or main identifier from fields
                    $mainField = '';
                    foreach ($fields as $key => $val) {
                        if (stripos($key, 'imei') !== false || stripos($key, 'IMEI') !== false || stripos($key, 'serial') !== false) {
                            $mainField = $val;
                            break;
                        }
                    }
                    if (!$mainField && count($fields) > 0) {
                        // Get first non-quantity field
                        foreach ($fields as $key => $val) {
                            if (stripos($key, 'quantity') === false && stripos($key, 'Quantity') === false) {
                                $mainField = $val;
                                break;
                            }
                        }
                    }
                    
                    // Status mapping
                    $statusMap = [
                        'pending' => ['Chờ TT', 'badge-pending'],
                        'paid' => ['Đã TT', 'badge-paid'],
                        'processing' => ['Đang xử lý', 'badge-paid'],
                        'completed' => ['Hoàn thành', 'badge-completed'],
                        'failed' => ['Thất bại', 'badge-cancelled'],
                    ];
                    $statusInfo = $statusMap[$order->status] ?? ['N/A', 'badge-pending'];
                    
                    // User info
                    $userName = '';
                    if ($order->user_id) {
                        $user = \DB::table('users')->where('id', $order->user_id)->first();
                        $userName = $user ? $user->name : "User #{$order->user_id}";
                    }
                @endphp
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>
                        <a href="/don-ady?code={{ $order->tracking_code }}" target="_blank" style="font-family: monospace; color: #3b82f6; text-decoration: none; font-weight: 600;">
                            {{ $order->tracking_code }}
                        </a>
                    </td>
                    <td style="max-width: 180px;">
                        <div style="font-weight: 500;">{{ Str::limit($order->product_name ?? 'N/A', 35) }}</div>
                    </td>
                    <td style="max-width: 160px;">
                        @if($mainField)
                            <code style="background: #f1f5f9; padding: 2px 6px; border-radius: 4px; font-size: 11px; color: #334155;">{{ $mainField }}</code>
                        @endif
                        @if(count($fields) > 1)
                            <button onclick="this.nextElementSibling.style.display = this.nextElementSibling.style.display === 'none' ? 'block' : 'none'" 
                                    style="background: none; border: none; color: #3b82f6; cursor: pointer; font-size: 11px; margin-top: 2px;">
                                +{{ count($fields) - 1 }} thêm
                            </button>
                            <div style="display: none; margin-top: 4px; font-size: 11px; color: #64748b;">
                                @foreach($fields as $k => $v)
                                    <div><strong>{{ $k }}:</strong> {{ Str::limit($v, 30) }}</div>
                                @endforeach
                            </div>
                        @endif
                    </td>
                    <td style="font-weight: 600; white-space: nowrap;">
                        <span style="color: #10b981;">{{ number_format($order->price_vnd ?? 0) }}đ</span>
                        @if($order->price_usd)
                            <div style="font-size: 10px; color: #94a3b8;">${{ $order->price_usd }}</div>
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $statusInfo[1] }}">{{ $statusInfo[0] }}</span>
                    </td>
                    <td style="max-width: 250px;">
                        @if($order->result)
                            <div style="font-size: 11px; max-height: 60px; overflow: hidden; position: relative; cursor: pointer;" 
                                 onclick="this.style.maxHeight = this.style.maxHeight === 'none' ? '60px' : 'none'">
                                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 6px; padding: 6px 8px; font-family: monospace; word-break: break-all;">
                                    {!! strip_tags($order->result, '<br><span><b><strong>') !!}
                                </div>
                            </div>
                        @elseif($order->error)
                            <div style="font-size: 11px; color: #ef4444; background: #fef2f2; border: 1px solid #fecaca; border-radius: 6px; padding: 6px 8px;">
                                {{ Str::limit($order->error, 80) }}
                            </div>
                        @else
                            <span style="color: #94a3b8;">—</span>
                        @endif
                    </td>
                    <td style="font-size: 11px; white-space: nowrap;">
                        @if($userName)
                            <div style="font-weight: 500;">{{ $userName }}</div>
                        @endif
                        @if($order->customer_email)
                            <div style="color: #6366f1;">{{ $order->customer_email }}</div>
                        @endif
                        <div style="color: #94a3b8; font-family: monospace; font-size: 10px;">{{ $order->ip_address ?? '' }}</div>
                    </td>
                    <td style="font-size: 11px; white-space: nowrap;">
                        <div>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}</div>
                        @if($order->paid_at)
                            <div style="color: #10b981; font-size: 10px;">TT: {{ \Carbon\Carbon::parse($order->paid_at)->format('H:i') }}</div>
                        @endif
                        @if($order->completed_at)
                            <div style="color: #3b82f6; font-size: 10px;">HT: {{ \Carbon\Carbon::parse($order->completed_at)->format('H:i') }}</div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align: center; padding: 40px; color: #64748b;">
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
