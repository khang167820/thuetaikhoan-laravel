@extends('layouts.app')

@section('title', 'Đặt hàng - ' . $product['name'])
@section('meta_description', 'Đặt hàng dịch vụ ' . $product['name'] . ' - Thuetaikhoan.net')

@section('content')
<style>
.ord-checkout-section {
    background: var(--light, #f8fafc);
    min-height: 80vh;
    padding: 30px 0 60px;
}
.checkout-container {
    max-width: 800px;
    margin: 0 auto;
}
.checkout-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    color: #64748b;
    margin-bottom: 20px;
}
.checkout-breadcrumb a { color: #f97316; text-decoration: none; }
.checkout-breadcrumb a:hover { text-decoration: underline; }

.checkout-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    overflow: hidden;
}
.checkout-header {
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    color: white;
    padding: 24px;
}
.checkout-header h1 {
    font-size: 20px;
    font-weight: 700;
    margin: 0 0 6px;
}
.checkout-header p {
    font-size: 14px;
    opacity: 0.8;
    margin: 0;
}

.product-summary {
    padding: 24px;
    border-bottom: 1px solid #f1f5f9;
}
.product-summary h3 {
    font-size: 16px;
    font-weight: 600;
    color: #1e293b;
    margin: 0 0 16px;
}
.product-info-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #f8fafc;
}
.product-info-row:last-child { border-bottom: none; }
.product-info-label {
    color: #64748b;
    font-size: 14px;
}
.product-info-value {
    font-weight: 600;
    color: #1e293b;
    font-size: 14px;
}
.product-info-value.price {
    color: #059669;
    font-size: 18px;
}

.checkout-notice {
    margin: 24px;
    padding: 20px;
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    border-radius: 12px;
    text-align: center;
}
.checkout-notice h4 {
    color: #92400e;
    margin: 0 0 10px;
    font-size: 16px;
}
.checkout-notice p {
    color: #78350f;
    font-size: 14px;
    margin: 0 0 16px;
}
.checkout-notice .btn-zalo {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: linear-gradient(135deg, #0068ff 0%, #0052cc 100%);
    color: white;
    text-decoration: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.2s;
}
.checkout-notice .btn-zalo:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 104, 255, 0.3);
}

.back-link {
    display: block;
    text-align: center;
    padding: 20px;
    color: #64748b;
    font-size: 14px;
}
.back-link a {
    color: #f97316;
    text-decoration: none;
    font-weight: 500;
}
.back-link a:hover { text-decoration: underline; }
</style>

<section class="ord-checkout-section">
    <div class="container checkout-container">
        <div class="checkout-breadcrumb">
            <a href="/">Trang chủ</a>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
            <a href="/ord-services">Dịch vụ GSM</a>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
            <span>Đặt hàng</span>
        </div>

        <div class="checkout-card">
            <div class="checkout-header">
                <h1>🛒 Xác nhận đơn hàng</h1>
                <p>Vui lòng kiểm tra thông tin dịch vụ trước khi đặt hàng</p>
            </div>

            <div class="product-summary">
                <h3>📦 Thông tin dịch vụ</h3>
                <div class="product-info-row">
                    <span class="product-info-label">Tên dịch vụ</span>
                    <span class="product-info-value">{{ $product['name'] }}</span>
                </div>
                <div class="product-info-row">
                    <span class="product-info-label">Danh mục</span>
                    <span class="product-info-value">{{ $product['category'] }}</span>
                </div>
                <div class="product-info-row">
                    <span class="product-info-label">Thời gian xử lý</span>
                    <span class="product-info-value">{{ $product['deliveryTime'] }}</span>
                </div>
                <div class="product-info-row">
                    <span class="product-info-label">Giá VNĐ</span>
                    <span class="product-info-value price">{{ number_format($product['priceVnd']) }}đ</span>
                </div>
            </div>

            <div class="checkout-notice">
                <h4>🚧 Tính năng đang phát triển</h4>
                <p>Hệ thống đặt hàng tự động đang được hoàn thiện.<br>Vui lòng liên hệ Zalo để đặt hàng trực tiếp.</p>
                <a href="https://zalo.me/0777333763" target="_blank" class="btn-zalo">
                    💬 Liên hệ Zalo Mai Quyên
                </a>
            </div>

            <div class="back-link">
                <a href="/ord-services">← Quay lại danh sách dịch vụ</a>
            </div>
        </div>
    </div>
</section>
@endsection
