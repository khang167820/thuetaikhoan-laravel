@extends('admin.layouts.app')

@section('title', 'Sản phẩm ADY')
@section('page-title', 'Sản phẩm ADY Unlocker')

@section('content')
<div class="admin-card">
    <div class="admin-card-title">Danh sách sản phẩm ADY</div>
    
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Mã ADY</th>
                    <th>Giá gốc</th>
                    <th>Giá bán</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td style="font-weight: 600; color: #f1f5f9;">{{ $product->name ?? 'N/A' }}</td>
                    <td>{{ $product->ady_product_id ?? 'N/A' }}</td>
                    <td>{{ number_format($product->original_price ?? 0) }}đ</td>
                    <td style="color: #10b981; font-weight: 600;">{{ number_format($product->price ?? 0) }}đ</td>
                    <td>
                        @if($product->is_active ?? false)
                            <span class="badge badge-active">Đang bán</span>
                        @else
                            <span class="badge badge-inactive">Tạm ẩn</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px; color: #64748b;">
                        <div style="font-size: 48px; margin-bottom: 12px;">📦</div>
                        <p>Chưa có sản phẩm ADY nào</p>
                        <p style="font-size: 12px;">Vui lòng cấu hình API ADY để đồng bộ sản phẩm</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($products->hasPages())
        <div class="pagination">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection
