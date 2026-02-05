@extends('layouts.app')

@section('title', 'Đặt hàng - ' . $product['name'])
@section('meta_description', 'Đặt hàng dịch vụ ' . $product['name'] . ' - Thuetaikhoan.net')

@section('content')
<style>
.ord-checkout-section {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
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
    color: #94a3b8;
    margin-bottom: 16px;
    flex-wrap: wrap;
}
.checkout-breadcrumb a { color: #f97316; text-decoration: none; }
.checkout-breadcrumb a:hover { text-decoration: underline; }

.checkout-card {
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.3);
    overflow: hidden;
    border: 1px solid #334155;
}
.checkout-header {
    background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
    color: white;
    padding: 24px;
    text-align: center;
}
.checkout-header h1 {
    font-size: 20px;
    font-weight: 700;
    margin: 0 0 6px;
}
.checkout-header p {
    font-size: 14px;
    opacity: 0.9;
    margin: 0;
}

.product-summary {
    padding: 24px;
    background: #0f172a;
}
.product-name-box {
    background: #1e293b;
    padding: 16px;
    border-radius: 12px;
    margin-bottom: 16px;
    border-left: 4px solid #f97316;
}
.product-name-box h3 {
    font-size: 16px;
    font-weight: 700;
    color: #f1f5f9;
    margin: 0 0 10px;
    line-height: 1.5;
}
.product-meta {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
}
.product-meta span {
    font-size: 13px;
    color: #94a3b8;
}
.product-meta span strong {
    color: #f1f5f9;
}

.price-balance-row {
    display: flex;
    gap: 12px;
}
.price-box, .balance-box {
    flex: 1;
    padding: 16px;
    border-radius: 12px;
    text-align: center;
}
.price-box {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    color: white;
}
.balance-box {
    background: #1e293b;
    border: 1px solid #334155;
}
.price-box .label, .balance-box .label {
    font-size: 12px;
    opacity: 0.9;
    margin-bottom: 4px;
}
.balance-box .label { color: #94a3b8; }
.price-box .amount {
    font-size: 24px;
    font-weight: 800;
}
.balance-box .amount {
    font-size: 24px;
    font-weight: 800;
    color: #60a5fa;
}
.balance-box.sufficient .amount { color: #10b981; }
.balance-box.insufficient .amount { color: #ef4444; }

.order-form {
    padding: 24px;
}
.order-form h3 {
    font-size: 16px;
    font-weight: 600;
    color: #f1f5f9;
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
    color: #94a3b8;
    margin-bottom: 6px;
}
.form-group label .required {
    color: #ef4444;
}
.form-group input,
.form-group textarea {
    width: 100%;
    padding: 14px 16px;
    border: 2px solid #334155;
    background: #0f172a;
    color: #f1f5f9;
    border-radius: 10px;
    font-size: 14px;
    transition: all 0.2s;
    box-sizing: border-box;
}
.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #f97316;
    box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.2);
}
.form-group input::placeholder,
.form-group textarea::placeholder {
    color: #64748b;
}
.form-group textarea {
    resize: vertical;
    min-height: 80px;
}
.form-group .hint {
    font-size: 11px;
    color: #64748b;
    margin-top: 4px;
}

.submit-section {
    padding: 0 24px 24px;
}
.btn-submit {
    width: 100%;
    padding: 18px;
    background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 17px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}
.btn-submit:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(249, 115, 22, 0.4);
}
.btn-submit:disabled {
    background: #475569;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}
.btn-submit.loading {
    background: #64748b;
}

.insufficient-notice {
    background: linear-gradient(135deg, #7f1d1d 0%, #991b1b 100%);
    border: 1px solid #f87171;
    border-radius: 12px;
    padding: 16px;
    margin: 0 24px 16px;
    text-align: center;
}
.insufficient-notice p {
    color: #fecaca;
    font-size: 14px;
    margin: 0 0 12px;
}
.btn-deposit {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: #fbbf24;
    color: #1e293b;
    text-decoration: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 700;
}
.btn-deposit:hover {
    background: #f59e0b;
    transform: translateY(-1px);
}

.login-notice {
    background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 100%);
    border: 1px solid #60a5fa;
    border-radius: 12px;
    padding: 20px;
    margin: 0 24px 16px;
    text-align: center;
}
.login-notice p {
    color: #bfdbfe;
    font-size: 14px;
    margin: 0 0 12px;
}
.btn-login {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: white;
    color: #1e40af;
    text-decoration: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 700;
}
.btn-login:hover {
    background: #f1f5f9;
}

.result-message {
    padding: 16px;
    border-radius: 10px;
    margin: 16px 24px;
    display: none;
}
.result-message.success {
    background: rgba(16, 185, 129, 0.2);
    border: 1px solid #10b981;
    color: #6ee7b7;
}
.result-message.error {
    background: rgba(239, 68, 68, 0.2);
    border: 1px solid #ef4444;
    color: #fca5a5;
}

.back-link {
    text-align: center;
    padding: 20px;
    border-top: 1px solid #334155;
}
.back-link a {
    color: #94a3b8;
    text-decoration: none;
    font-size: 14px;
}
.back-link a:hover { color: #f97316; }

@media (max-width: 500px) {
    .checkout-header { padding: 20px; }
    .checkout-header h1 { font-size: 18px; }
    .product-summary, .order-form { padding: 16px; }
    .price-balance-row { flex-direction: column; }
    .price-box .amount, .balance-box .amount { font-size: 20px; }
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
                <h1>🚀 Đặt hàng tự động</h1>
                <p>Trừ số dư tự động, xử lý ngay lập tức</p>
            </div>

            <div class="product-summary">
                <div class="product-name-box">
                    <h3>{{ $product['name'] }}</h3>
                    <div class="product-meta">
                        <span>📁 <strong>{{ $product['category'] }}</strong></span>
                        <span>⏱️ <strong>{{ $product['deliveryTime'] }}</strong></span>
                    </div>
                </div>
                <div class="price-balance-row">
                    <div class="price-box">
                        <div class="label">Thành tiền</div>
                        <div class="amount">{{ number_format($product['priceVnd']) }}đ</div>
                    </div>
                    <div class="balance-box {{ $userBalance >= $product['priceVnd'] ? 'sufficient' : 'insufficient' }}">
                        <div class="label">Số dư hiện tại</div>
                        <div class="amount">{{ Auth::check() ? number_format($userBalance) . 'đ' : '---' }}</div>
                    </div>
                </div>
            </div>

            @if(!Auth::check())
            {{-- User not logged in --}}
            <div class="login-notice">
                <p>Vui lòng đăng nhập để đặt hàng</p>
                <a href="/login?redirect={{ urlencode(request()->fullUrl()) }}" class="btn-login">
                    🔐 Đăng nhập ngay
                </a>
            </div>
            @elseif($userBalance < $product['priceVnd'])
            {{-- Insufficient balance --}}
            <div class="insufficient-notice">
                <p>⚠️ Số dư không đủ! Bạn cần nạp thêm <strong>{{ number_format($product['priceVnd'] - $userBalance) }}đ</strong></p>
                <a href="/nap-tien" class="btn-deposit">
                    💰 Nạp tiền ngay
                </a>
            </div>
            @endif

            <form id="orderForm" class="order-form">
                @csrf
                <input type="hidden" name="uuid" value="{{ $product['uuid'] }}">
                
                <h3>📝 Thông tin đơn hàng</h3>
                
                <div class="form-group">
                    <label>IMEI / Serial Number</label>
                    <input type="text" name="imei" id="imei" placeholder="Nhập IMEI hoặc Serial của thiết bị">
                    <div class="hint">Tùy dịch vụ có thể yêu cầu IMEI hoặc Serial</div>
                </div>

                <div class="form-group">
                    <label>Email <span class="required">*</span></label>
                    <input type="email" name="email" id="email" placeholder="email@example.com" required
                           value="{{ Auth::check() ? Auth::user()->email : '' }}">
                    <div class="hint">Kết quả sẽ được gửi qua email này</div>
                </div>

                <div class="form-group">
                    <label>Ghi chú</label>
                    <textarea name="notes" id="notes" placeholder="Thêm ghi chú cho đơn hàng (nếu có)"></textarea>
                </div>
            </form>

            <div id="resultMessage" class="result-message"></div>

            <div class="submit-section">
                @if(Auth::check() && $userBalance >= $product['priceVnd'])
                <button type="button" id="btnSubmit" class="btn-submit" onclick="submitOrder()">
                    ⚡ Đặt hàng & Trừ {{ number_format($product['priceVnd']) }}đ
                </button>
                @else
                <button type="button" class="btn-submit" disabled>
                    ⚡ Đặt hàng ngay
                </button>
                @endif
            </div>

            <div class="back-link">
                <a href="/ord-services">← Quay lại danh sách dịch vụ</a>
            </div>
        </div>
    </div>
</section>

<script>
async function submitOrder() {
    const btn = document.getElementById('btnSubmit');
    const resultDiv = document.getElementById('resultMessage');
    
    btn.disabled = true;
    btn.classList.add('loading');
    btn.innerHTML = '⏳ Đang xử lý...';
    resultDiv.style.display = 'none';
    
    try {
        const formData = new FormData(document.getElementById('orderForm'));
        
        const response = await fetch('{{ route("ord-checkout.submit") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                uuid: formData.get('uuid'),
                imei: formData.get('imei'),
                email: formData.get('email'),
                notes: formData.get('notes')
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            resultDiv.className = 'result-message success';
            resultDiv.innerHTML = '✅ ' + data.message + '<br>Mã đơn: <strong>' + data.tracking_code + '</strong>';
            resultDiv.style.display = 'block';
            
            // Redirect to order result page
            setTimeout(() => {
                window.location.href = data.redirect;
            }, 1500);
        } else {
            resultDiv.className = 'result-message error';
            resultDiv.innerHTML = '❌ ' + data.error;
            resultDiv.style.display = 'block';
            
            btn.disabled = false;
            btn.classList.remove('loading');
            btn.innerHTML = '⚡ Đặt hàng & Trừ {{ number_format($product["priceVnd"]) }}đ';
            
            // If redirect provided (e.g., to login)
            if (data.redirect) {
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 2000);
            }
        }
    } catch (error) {
        console.error('Error:', error);
        resultDiv.className = 'result-message error';
        resultDiv.innerHTML = '❌ Lỗi kết nối. Vui lòng thử lại.';
        resultDiv.style.display = 'block';
        
        btn.disabled = false;
        btn.classList.remove('loading');
        btn.innerHTML = '⚡ Đặt hàng & Trừ {{ number_format($product["priceVnd"]) }}đ';
    }
}
</script>
@endsection
