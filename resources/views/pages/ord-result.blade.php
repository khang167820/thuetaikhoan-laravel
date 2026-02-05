@extends('layouts.app')

@section('title', 'Đơn hàng ADY - ' . $order->tracking_code)

@section('content')
<div class="container" style="max-width: 600px; margin: 40px auto; padding: 0 16px;">
    <div class="order-card" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border-radius: 16px; padding: 32px; border: 1px solid #334155;">
        <!-- Header -->
        <div style="text-align: center; margin-bottom: 24px;">
            @if($order->status === 'completed')
                <div style="width: 64px; height: 64px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                </div>
                <h1 style="color: #10b981; font-size: 24px; margin: 0;">Hoàn thành!</h1>
            @elseif($order->status === 'processing' || $order->status === 'pending')
                <div style="width: 64px; height: 64px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                </div>
                <h1 style="color: #f59e0b; font-size: 24px; margin: 0;">Đang xử lý...</h1>
            @else
                <div style="width: 64px; height: 64px; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                </div>
                <h1 style="color: #ef4444; font-size: 24px; margin: 0;">Thất bại</h1>
            @endif
        </div>

        <!-- Order Info -->
        <div style="background: #0f172a; border-radius: 12px; padding: 20px; margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                <span style="color: #94a3b8;">Mã đơn:</span>
                <span style="color: #f1f5f9; font-weight: 600;">{{ $order->tracking_code }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                <span style="color: #94a3b8;">Sản phẩm:</span>
                <span style="color: #f1f5f9; text-align: right; max-width: 60%;">{{ $order->product_name }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                <span style="color: #94a3b8;">Giá:</span>
                <span style="color: #10b981; font-weight: 600;">{{ number_format($order->price_vnd ?? $order->price) }}đ</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                <span style="color: #94a3b8;">Thời gian:</span>
                <span style="color: #f1f5f9;">{{ $order->created_at }}</span>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <span style="color: #94a3b8;">Trạng thái:</span>
                <span style="
                    padding: 4px 12px; 
                    border-radius: 20px; 
                    font-size: 13px;
                    @if($order->status === 'completed') background: rgba(16, 185, 129, 0.2); color: #10b981;
                    @elseif($order->status === 'processing' || $order->status === 'pending') background: rgba(245, 158, 11, 0.2); color: #f59e0b;
                    @else background: rgba(239, 68, 68, 0.2); color: #ef4444;
                    @endif
                ">
                    @if($order->status === 'completed') ✓ Hoàn thành
                    @elseif($order->status === 'processing') ⏳ Đang xử lý
                    @elseif($order->status === 'pending') ⏳ Chờ xử lý
                    @else ✗ {{ ucfirst($order->status) }}
                    @endif
                </span>
            </div>
        </div>

        <!-- Result -->
        @if($order->result)
        <div style="background: #0f172a; border-radius: 12px; padding: 20px; margin-bottom: 20px;">
            <div style="color: #94a3b8; margin-bottom: 8px; font-size: 13px;">Kết quả:</div>
            <div style="background: #1e293b; padding: 16px; border-radius: 8px; font-family: monospace; color: #10b981; white-space: pre-wrap; word-break: break-all; font-size: 13px;">{{ $order->result }}</div>
        </div>
        @endif

        <!-- Error -->
        @if($order->error)
        <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 12px; padding: 16px; margin-bottom: 20px;">
            <div style="color: #ef4444; font-size: 13px;">⚠️ {{ $order->error }}</div>
        </div>
        @endif

        <!-- Actions -->
        <div style="display: flex; gap: 12px;">
            <a href="/ord-services" style="flex: 1; display: block; text-align: center; padding: 14px 20px; background: #3b82f6; color: white; border-radius: 8px; text-decoration: none; font-weight: 600;">
                ← Đặt thêm dịch vụ
            </a>
        </div>
        
        @if($order->status === 'processing' || $order->status === 'pending')
        <p style="text-align: center; color: #64748b; font-size: 13px; margin-top: 20px;">
            Trang này sẽ tự động cập nhật khi có kết quả. Hoặc bạn có thể quay lại sau.
        </p>
        <script>
            // Auto refresh every 30 seconds for pending orders
            setTimeout(function() { location.reload(); }, 30000);
        </script>
        @endif
    </div>
</div>
@endsection
