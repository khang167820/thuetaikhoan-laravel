@extends('layouts.app')

@section('title', 'Đặt hàng - ' . $product['name'])
@section('meta_description', 'Đặt hàng dịch vụ ' . $product['name'] . ' - Thuetaikhoan.net')

@section('content')
<style>
.ord-checkout-section {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    min-height: 80vh;
    padding: 20px 0 60px;
}
.checkout-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 0 16px;
}
.checkout-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: #64748b;
    margin-bottom: 16px;
    flex-wrap: wrap;
}
.checkout-breadcrumb a { color: #f97316; text-decoration: none; }
.checkout-breadcrumb a:hover { text-decoration: underline; }

.checkout-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.08);
    overflow: hidden;
}
.checkout-header {
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    color: white;
    padding: 20px;
    text-align: center;
}
.checkout-header h1 {
    font-size: 18px;
    font-weight: 700;
    margin: 0 0 4px;
}
.checkout-header p {
    font-size: 13px;
    opacity: 0.8;
    margin: 0;
}

.product-summary {
    padding: 20px;
    background: #f8fafc;
}
.product-name-box {
    background: white;
    padding: 16px;
    border-radius: 12px;
    margin-bottom: 12px;
    border-left: 4px solid #f97316;
}
.product-name-box h3 {
    font-size: 15px;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 8px;
    line-height: 1.4;
}
.product-meta {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
}
.product-meta span {
    font-size: 12px;
    color: #64748b;
}
.product-meta span strong {
    color: #1e293b;
}
.product-price-box {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    padding: 16px;
    border-radius: 12px;
    text-align: center;
    color: white;
}
.product-price-box .label {
    font-size: 12px;
    opacity: 0.9;
    margin-bottom: 4px;
}
.product-price-box .price {
    font-size: 26px;
    font-weight: 800;
}

.order-form {
    padding: 20px;
}
.order-form h3 {
    font-size: 15px;
    font-weight: 600;
    color: #1e293b;
    margin: 0 0 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.form-group {
    margin-bottom: 16px;
}
.form-group label {
    display: block;
    font-size: 13px;
    font-weight: 500;
    color: #475569;
    margin-bottom: 6px;
}
.form-group label .required {
    color: #ef4444;
}
.form-group input,
.form-group textarea {
    width: 100%;
    padding: 12px 14px;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    font-size: 14px;
    transition: all 0.2s;
    box-sizing: border-box;
}
.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #f97316;
    box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
}
.form-group textarea {
    resize: vertical;
    min-height: 80px;
}
.form-group .hint {
    font-size: 11px;
    color: #94a3b8;
    margin-top: 4px;
}

.payment-info {
    background: #fffbeb;
    border: 1px solid #fcd34d;
    border-radius: 12px;
    padding: 16px;
    margin: 0 20px 20px;
}
.payment-info h4 {
    font-size: 14px;
    font-weight: 600;
    color: #92400e;
    margin: 0 0 12px;
}
.bank-details {
    background: white;
    border-radius: 8px;
    padding: 12px;
    font-size: 13px;
}
.bank-row {
    display: flex;
    justify-content: space-between;
    padding: 6px 0;
    border-bottom: 1px dashed #f1f5f9;
}
.bank-row:last-child { border-bottom: none; }
.bank-row .label { color: #64748b; }
.bank-row .value { 
    font-weight: 600; 
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 6px;
}
.copy-btn {
    background: #f1f5f9;
    border: none;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 11px;
    cursor: pointer;
    color: #64748b;
}
.copy-btn:hover { background: #e2e8f0; }

.submit-section {
    padding: 0 20px 20px;
}
.btn-submit {
    width: 100%;
    padding: 16px;
    background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}
.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(249, 115, 22, 0.35);
}
.btn-submit:disabled {
    background: #94a3b8;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.zalo-contact {
    text-align: center;
    padding: 16px 20px;
    border-top: 1px solid #f1f5f9;
}
.zalo-contact p {
    font-size: 13px;
    color: #64748b;
    margin: 0 0 10px;
}
.btn-zalo {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 10px 20px;
    background: #0068ff;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
}
.btn-zalo:hover {
    background: #0052cc;
}

.back-link {
    text-align: center;
    padding: 16px;
}
.back-link a {
    color: #64748b;
    text-decoration: none;
    font-size: 13px;
}
.back-link a:hover { color: #f97316; }

/* Responsive */
@media (max-width: 500px) {
    .checkout-header { padding: 16px; }
    .checkout-header h1 { font-size: 16px; }
    .product-summary, .order-form { padding: 16px; }
    .product-price-box .price { font-size: 22px; }
    .payment-info { margin: 0 16px 16px; }
    .submit-section { padding: 0 16px 16px; }
}
</style>

<section class="ord-checkout-section">
    <div class="checkout-container">
        <div class="checkout-breadcrumb">
            <a href="/">Trang chủ</a>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
            <a href="/ord-services">Dịch vụ GSM</a>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
            <span>Đặt hàng</span>
        </div>

        <div class="checkout-card">
            <div class="checkout-header">
                <h1>🛒 Đặt hàng dịch vụ</h1>
                <p>Điền thông tin để hoàn tất đơn hàng</p>
            </div>

            <div class="product-summary">
                <div class="product-name-box">
                    <h3>{{ $product['name'] }}</h3>
                    <div class="product-meta">
                        <span>📁 <strong>{{ $product['category'] }}</strong></span>
                        <span>⏱️ <strong>{{ $product['deliveryTime'] }}</strong></span>
                    </div>
                </div>
                <div class="product-price-box">
                    <div class="label">Thành tiền</div>
                    <div class="price">{{ number_format($product['priceVnd']) }}đ</div>
                </div>
            </div>

            <form action="{{ route('ord-checkout.submit') }}" method="POST" class="order-form">
                @csrf
                <input type="hidden" name="uuid" value="{{ $product['uuid'] }}">
                
                <h3>📝 Thông tin đơn hàng</h3>
                
                <div class="form-group">
                    <label>IMEI / Serial Number</label>
                    <input type="text" name="imei" placeholder="Nhập IMEI hoặc Serial của thiết bị">
                    <div class="hint">Tùy dịch vụ có thể yêu cầu IMEI hoặc Serial</div>
                </div>

                <div class="form-group">
                    <label>Email <span class="required">*</span></label>
                    <input type="email" name="email" placeholder="email@example.com" required>
                    <div class="hint">Kết quả sẽ được gửi qua email này</div>
                </div>

                <div class="form-group">
                    <label>Ghi chú</label>
                    <textarea name="notes" placeholder="Thêm ghi chú cho đơn hàng (nếu có)"></textarea>
                </div>
            </form>

            <div class="payment-info">
                <h4>💳 Thông tin thanh toán</h4>
                <div class="bank-details">
                    <div class="bank-row">
                        <span class="label">Ngân hàng</span>
                        <span class="value">MB Bank</span>
                    </div>
                    <div class="bank-row">
                        <span class="label">Số tài khoản</span>
                        <span class="value">
                            0777333763
                            <button type="button" class="copy-btn" onclick="copyText('0777333763')">Copy</button>
                        </span>
                    </div>
                    <div class="bank-row">
                        <span class="label">Chủ tài khoản</span>
                        <span class="value">MAI THI QUYEN</span>
                    </div>
                    <div class="bank-row">
                        <span class="label">Nội dung CK</span>
                        <span class="value" style="color: #f97316;">
                            Tên DV + Email
                        </span>
                    </div>
                </div>
            </div>

            <div class="submit-section">
                <button type="submit" class="btn-submit" form="order-form" disabled>
                    🚀 Đặt hàng ngay
                </button>
                <p style="text-align: center; font-size: 12px; color: #94a3b8; margin-top: 10px;">
                    * Thanh toán trước, chuyển khoản theo thông tin trên
                </p>
            </div>

            <div class="zalo-contact">
                <p>Hoặc liên hệ trực tiếp để được hỗ trợ nhanh hơn:</p>
                <a href="https://zalo.me/0777333763" target="_blank" class="btn-zalo">
                    💬 Chat Zalo Mai Quyên
                </a>
            </div>

            <div class="back-link">
                <a href="/ord-services">← Quay lại danh sách dịch vụ</a>
            </div>
        </div>
    </div>
</section>

<script>
function copyText(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert('Đã copy: ' + text);
    });
}
</script>
@endsection
