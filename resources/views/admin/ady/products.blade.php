@extends('admin.layouts.app')

@section('title', 'Sản phẩm ADY')
@section('page-title', 'Sản phẩm ADY Unlocker')

@section('content')
<div class="admin-card">
    <div class="admin-card-title" style="display: flex; justify-content: space-between; align-items: center;">
        <span>Danh sách sản phẩm ADY ({{ number_format($total ?? 0) }} sản phẩm)</span>
        @if($fromCache ?? false)
            <span style="font-size: 12px; color: #10b981;">✓ Từ cache</span>
        @endif
    </div>
    
    @if($apiError ?? false)
        <div style="background: #7f1d1d; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; color: #fca5a5;">
            ⚠️ {{ $apiError }}
        </div>
    @endif
    
    <!-- Filter & Search -->
    <form method="GET" style="display: flex; gap: 12px; margin-bottom: 16px; flex-wrap: wrap;">
        <select name="category" style="padding: 8px 12px; background: #1e293b; border: 1px solid #334155; border-radius: 6px; color: #f1f5f9; min-width: 180px;">
            <option value="">-- Tất cả danh mục --</option>
            @foreach($categories ?? [] as $cat => $count)
                <option value="{{ $cat }}" {{ ($category ?? '') == $cat ? 'selected' : '' }}>
                    {{ $cat }} ({{ $count }})
                </option>
            @endforeach
        </select>
        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Tìm kiếm..." 
            style="padding: 8px 12px; background: #1e293b; border: 1px solid #334155; border-radius: 6px; color: #f1f5f9; flex: 1; min-width: 200px;">
        <button type="submit" class="btn btn-primary" style="padding: 8px 16px;">🔍 Tìm</button>
        @if(($category ?? '') || ($search ?? ''))
            <a href="{{ route('admin.ady.products') }}" class="btn btn-secondary" style="padding: 8px 16px;">Xóa lọc</a>
        @endif
    </form>
    
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Giá USD</th>
                    <th>Giá VND</th>
                    <th>Thời gian</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td style="font-weight: 600; color: #f1f5f9; max-width: 400px;">{{ $product['name'] ?? 'N/A' }}</td>
                    <td>
                        <span style="background: #1e40af; padding: 4px 8px; border-radius: 4px; font-size: 11px;">
                            {{ $product['category'] ?? 'Khác' }}
                        </span>
                    </td>
                    <td style="color: #60a5fa;">${{ number_format($product['priceUsd'] ?? 0, 2) }}</td>
                    <td style="color: #10b981; font-weight: 600;">{{ number_format($product['priceVnd'] ?? 0) }}đ</td>
                    <td style="color: #94a3b8;">{{ $product['deliveryTime'] ?? 'N/A' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 40px; color: #64748b;">
                        <div style="font-size: 48px; margin-bottom: 12px;">📦</div>
                        <p>Không tìm thấy sản phẩm ADY nào</p>
                        <p style="font-size: 12px;">Vui lòng kiểm tra cấu hình API ADY trong <a href="{{ route('admin.ady.config') }}" style="color: #60a5fa;">ADY Config</a></p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($products->hasPages())
        <div class="pagination" style="margin-top: 16px;">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection
