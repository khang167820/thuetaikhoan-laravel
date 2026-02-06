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
.checkout-container { max-width: 900px; margin: 0 auto; padding: 0 16px; }
.checkout-breadcrumb { display: flex; gap: 8px; font-size: 13px; color: #64748b; margin-bottom: 16px; flex-wrap: wrap; align-items: center; }
.checkout-breadcrumb a { color: #f97316; text-decoration: none; }

.checkout-card { background: white; border-radius: 20px; box-shadow: 0 4px 24px rgba(0,0,0,0.08); overflow: hidden; border: 1px solid #e2e8f0; }
.product-summary { background: linear-gradient(135deg, #1e293b 0%, #334155 100%); padding: 28px; color: white; }
.product-summary h1 { font-size: 17px; font-weight: 600; margin-bottom: 20px; line-height: 1.5; }
.price-row { display: flex; justify-content: space-between; align-items: center; }
.price-label { opacity: 0.7; font-size: 12px; text-transform: uppercase; }
.price-value { font-size: 32px; font-weight: 700; color: #10b981; }
.price-value small { font-size: 16px; opacity: 0.8; color: white; }
.delivery-badge { display: inline-flex; gap: 6px; margin-top: 14px; padding: 8px 14px; background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.3); border-radius: 20px; font-size: 13px; color: #34d399; }

/* Form */
.checkout-form { padding: 28px; }
.form-group { margin-bottom: 20px; }
.form-group label { display: block; font-weight: 600; color: #1e293b; margin-bottom: 8px; font-size: 14px; }
.form-group label .required { color: #ef4444; }
.form-group input, .form-group textarea { width: 100%; padding: 14px 16px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 15px; transition: all 0.2s; background: #f8fafc; }
.form-group input:focus, .form-group textarea:focus { outline: none; border-color: #6366f1; background: white; box-shadow: 0 0 0 4px rgba(99,102,241,0.1); }
.form-group small { display: block; margin-top: 6px; color: #94a3b8; font-size: 12px; }

.btn-submit { display: flex; align-items: center; justify-content: center; gap: 10px; width: 100%; padding: 16px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none; border-radius: 12px; font-size: 16px; font-weight: 600; cursor: pointer; box-shadow: 0 4px 14px rgba(16,185,129,0.3); }
.btn-submit:hover:not(:disabled) { transform: translateY(-2px); }
.btn-submit:disabled { background: #94a3b8; cursor: not-allowed; }

.error-box { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; padding: 14px; border-radius: 12px; margin-bottom: 20px; font-size: 14px; }

/* Payment Section - 2 columns */
.payment-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; padding: 24px; }
.payment-left, .payment-right { display: flex; flex-direction: column; }
.qr-section { background: #f8fafc; border-radius: 14px; padding: 20px; border: 1px solid #e2e8f0; text-align: center; }
.qr-label { font-weight: 600; color: #374151; margin-bottom: 12px; font-size: 14px; }
.qr-img { max-width: 200px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
.bank-info { font-size: 13px; margin-top: 16px; text-align: left; }
.bank-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #e5e7eb; }
.bank-row:last-child { border-bottom: none; }
.bank-row span:first-child { color: #6b7280; }
.bank-row strong { color: #1f2937; }
.payment-warning { margin-top: 12px; padding: 10px; background: #fef3c7; border-radius: 8px; font-size: 12px; color: #92400e; text-align: center; }

.order-summary-box { background: #fff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 20px; }
.summary-header { font-weight: 700; color: #1e293b; margin-bottom: 14px; font-size: 15px; }
.summary-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f1f5f9; font-size: 13px; }
.summary-total { display: flex; justify-content: space-between; padding: 14px 0; margin-top: 8px; border-top: 2px solid #e2e8f0; }
.total-amount { font-size: 22px; font-weight: 700; color: #10b981; }
.badge-pending { background: #fef3c7; color: #d97706; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 600; }

.balance-section { background: #f0fdf4; border: 1px solid #86efac; border-radius: 10px; padding: 14px; margin-bottom: 12px; }
.balance-row { display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 10px; }
.balance-amt { font-weight: 700; color: #16a34a; }
.btn-balance { width: 100%; padding: 12px; background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: #fff; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; }
.balance-warning { font-size: 12px; color: #dc2626; margin-bottom: 8px; }
.btn-deposit { display: block; width: 100%; padding: 12px; background: #2563eb; color: #fff; border-radius: 8px; text-align: center; text-decoration: none; font-size: 14px; font-weight: 600; }

.direct-pay { background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 10px; padding: 14px; margin-bottom: 12px; text-align: center; }
.direct-main { font-weight: 700; color: #059669; font-size: 14px; }
.direct-sub { font-size: 12px; color: #065f46; margin-top: 4px; }

.login-hint { font-size: 12px; color: #64748b; text-align: center; margin-bottom: 12px; }
.login-hint a { color: #2563eb; font-weight: 600; text-decoration: none; }

.btn-check { display: block; width: 100%; padding: 14px; background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); color: #fff; border-radius: 10px; text-align: center; text-decoration: none; font-size: 14px; font-weight: 600; margin-bottom: 12px; }

.status-box { background: #dbeafe; border-radius: 8px; padding: 12px; font-size: 13px; text-align: center; }
.status-box.success { background: #d1fae5; color: #065f46; }

@media (max-width: 768px) { .payment-grid { grid-template-columns: 1fr; } }
</style>

<section class="ord-checkout-section">
    <div class="checkout-container">
        <div class="checkout-breadcrumb">
            <a href="/">Trang chủ</a> › <a href="/ord-services">Dịch vụ GSM</a> › <span>Đặt hàng</span>
        </div>

        <div class="checkout-card">
            <div class="product-summary">
                <h1>{{ $product['name'] }}</h1>
                <div class="price-row">
                    <div><div class="price-label">Giá dịch vụ</div></div>
                    <div class="price-value" id="unit-price" data-price="{{ $product['priceVnd'] }}">{{ number_format($product['priceVnd']) }}<small>đ</small></div>
                </div>
                <div class="delivery-badge">⏱️ Thời gian: {{ $product['deliveryTime'] }}</div>
            </div>
            
            <!-- Form Section (hidden after order created) -->
            <div id="formSection">
                <form id="checkoutForm" class="checkout-form">
                    @csrf
                    <input type="hidden" name="uuid" value="{{ $product['uuid'] }}">
                    
                    <div id="errorBox" class="error-box" style="display: none;"></div>
                    
                    {{-- Email field is always required for result delivery --}}
                    <div class="form-group">
                        <label>Email nhận kết quả <span class="required">*</span></label>
                        <input type="email" name="Email" id="Email" placeholder="email@example.com" required 
                               value="{{ Auth::check() ? Auth::user()->email : '' }}">
                        <small>Kết quả dịch vụ sẽ được gửi đến email này</small>
                    </div>
                    
                    {{-- Quantity field (Default 1) --}}
                    <div class="form-group">
                        <label>Số lượng (Quantity) <span class="required">*</span></label>
                        <div class="quantity-input-group">
                            <button type="button" class="btn-qty" onclick="updateQty(-1)">-</button>
                            <input type="number" name="Quantity" id="Quantity" value="1" min="1" required class="form-control text-center" style="width: 80px;" oninput="calculateTotal()">
                            <button type="button" class="btn-qty" onclick="updateQty(1)">+</button>
                        </div>
                    </div>

                    {{-- Dynamic fields from ADY product --}}
                    @if(!empty($product['fields']))
                        @foreach($product['fields'] as $index => $fieldConfig)
                            @php
                                // ADY API returns fields as indexed array, get name from config
                                $fieldName = $fieldConfig['name'] ?? $fieldConfig['label'] ?? "Field_$index";
                                
                                // Skip Email field since we already have it above
                                if (strtolower($fieldName) === 'email') continue;
                                // Skip Quantity field if present in dynamic fields (we handle it separately)
                                if (strtolower($fieldName) === 'quantity') continue;
                                
                                $isRequired = ($fieldConfig['required'] ?? false) || ($fieldConfig['validation'] ?? false);
                                $fieldType = $fieldConfig['type'] ?? 'text';
                                $placeholder = $fieldConfig['placeholder'] ?? "Nhập $fieldName";
                                $hint = $fieldConfig['hint'] ?? $fieldConfig['description'] ?? '';
                                
                                // Map ADY field types to HTML input types
                                if ($fieldType === 'number') {
                                    $fieldType = 'tel'; // Use tel for better mobile experience
                                }
                                
                                // Determine better placeholder and hint based on field name
                                $fieldLower = strtolower($fieldName);
                                if (str_contains($fieldLower, 'imei')) {
                                    $placeholder = $placeholder ?: 'Nhập IMEI (15 số)';
                                    $hint = $hint ?: 'Mở Settings > General > About > IMEI. IMEI gồm 15 chữ số.';
                                } elseif (str_contains($fieldLower, 'serial')) {
                                    $placeholder = $placeholder ?: 'Nhập Serial Number';
                                    $hint = $hint ?: 'Mở Settings > General > About > Serial Number';
                                } elseif (str_contains($fieldLower, 'phone') || str_contains($fieldLower, 'số điện thoại')) {
                                    $fieldType = 'tel';
                                    $placeholder = $placeholder ?: 'Nhập số điện thoại';
                                } elseif (str_contains($fieldLower, 'model')) {
                                    $placeholder = $placeholder ?: 'Nhập Model (VD: iPhone 12 Pro Max)';
                                } elseif (str_contains($fieldLower, 'carrier') || str_contains($fieldLower, 'network')) {
                                    $placeholder = $placeholder ?: 'Nhập Carrier/Nhà mạng';
                                }
                            @endphp
                            <div class="form-group">
                                <label>{{ $fieldName }} @if($isRequired)<span class="required">*</span>@endif</label>
                                <input type="{{ $fieldType }}" name="{{ $fieldName }}" id="{{ $fieldName }}" 
                                       placeholder="{{ $placeholder }}" {{ $isRequired ? 'required' : '' }}>
                                @if($hint)
                                <small>{{ $hint }}</small>
                                @endif
                            </div>
                        @endforeach
                    @else
                        {{-- Fallback: Show IMEI field if no fields specified --}}
                        <div class="form-group">
                            <label>IMEI <span class="required">*</span></label>
                            <input type="text" name="IMEI" id="IMEI" placeholder="Nhập IMEI (15 số)" required>
                            <small>Mở Settings > General > About > IMEI. IMEI gồm 15 chữ số.</small>
                        </div>
                    @endif
                    
                    <div class="form-group">
                        <label>Ghi chú</label>
                        <textarea name="Notes" id="Notes" rows="2" placeholder="Ghi chú thêm (nếu có)"></textarea>
                    </div>
                    
                    <button type="submit" class="btn-submit" id="submitBtn">
                        💳 Tạo đơn & Thanh toán <span id="btnTotalText">{{ number_format($product['priceVnd']) }}đ</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    {{-- Payment Section --}}
    <div class="container" id="paymentSection" style="display: none;">
        <div class="payment-box">
            <h2>Thanh toán đơn hàng</h2>
            <div class="qr-container">
                <img id="qrImage" src="" alt="QR Code" class="qr-code">
                <p class="qr-note">Quét mã để thanh toán</p>
            </div>
            <div class="payment-info">
                <div class="info-row">
                    <span>Mã đơn hàng:</span>
                    <strong id="displayCode" class="highlight">---</strong>
                </div>
                <div class="info-row">
                    <span>Số tiền:</span>
                    <strong id="displayAmount">0đ</strong>
                </div>
                <div class="info-row">
                    <span>Nội dung CK:</span>
                    <strong id="displayCodeCheck">---</strong>
                </div>
            </div>
            <div class="payment-actions">
                <a href="#" id="checkResultBtn" class="btn-check">Kiểm tra kết quả</a>
                <button onclick="window.location.reload()" class="btn-secondary">Tạo đơn khác</button>
            </div>
        </div>
    </div>
</section>

<style>
.quantity-input-group {
    display: flex;
    align-items: center;
    gap: 5px;
}
.btn-qty {
    width: 30px;
    height: 30px;
    border: 1px solid #ddd;
    background: #f8f9fa;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
}
.btn-qty:hover {
    background: #e9ecef;
}
</style>

<script>
let currentOrderId = null;
let currentTrackingCode = null;
let checkCount = 0;
let checkInterval = null;
const unitPrice = {{ $product['priceVnd'] }};

function updateQty(change) {
    const qtyInput = document.getElementById('Quantity');
    let newQty = parseInt(qtyInput.value) + change;
    if (newQty < 1) newQty = 1;
    qtyInput.value = newQty;
    calculateTotal();
}

function calculateTotal() {
    const qtyInput = document.getElementById('Quantity');
    let qty = parseInt(qtyInput.value);
    if (!qty || qty < 1) qty = 1;
    
    const total = unitPrice * qty;
    document.getElementById('btnTotalText').textContent = new Intl.NumberFormat('vi-VN').format(total) + 'đ';
}

document.getElementById('checkoutForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const btn = document.getElementById('submitBtn');
    const errorBox = document.getElementById('errorBox');
    
    btn.disabled = true;
    const originalBtnText = btn.innerHTML;
    btn.textContent = '⏳ Đang tạo đơn...';
    errorBox.style.display = 'none';
    
    try {
        const formData = new FormData(this);
        
        // Build dynamic fields object from all form inputs
        const payload = { uuid: formData.get('uuid'), fields: {} };
        for (const [key, value] of formData.entries()) {
            if (key !== 'uuid' && key !== '_token' && value) {
                payload.fields[key] = value;
            }
        }
        
        const response = await fetch('{{ route("ord-checkout.submit") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
        });
        
        const data = await response.json();
        
        if (data.success) {
            currentOrderId = data.order_id;
            currentTrackingCode = data.tracking_code;
            
            // Update payment section
            document.getElementById('qrImage').src = data.qr_url;
            document.getElementById('displayCode').textContent = data.tracking_code;
            document.getElementById('displayCodeCheck').textContent = data.tracking_code;
            document.getElementById('displayAmount').textContent = Number(data.amount).toLocaleString('vi-VN') + ' đ';
            // document.getElementById('totalAmount').textContent = Number(data.amount).toLocaleString('vi-VN') + 'đ'; // Removed as ID not found
            document.getElementById('checkResultBtn').href = '/don-ady?code=' + data.tracking_code;
            
            // Show payment section
            document.getElementById('formSection').style.display = 'none';
            document.getElementById('paymentSection').style.display = 'block';
            
            // Start checking status
            checkInterval = setInterval(checkOrderStatus, 5000); // Check every 5s
        } else {
            errorBox.textContent = data.error || 'Có lỗi xảy ra, vui lòng thử lại';
            errorBox.style.display = 'block';
            btn.disabled = false;
            btn.innerHTML = originalBtnText;
        }
    } catch (error) {
        console.error('Error:', error);
        errorBox.textContent = 'Lỗi kết nối server, vui lòng thử lại';
        errorBox.style.display = 'block';
        btn.disabled = false;
        btn.innerHTML = originalBtnText;
    }
});
            
            <!-- Payment Section (shown after order created) -->
            <div id="paymentSection" style="display: none;">
                <div class="payment-grid">
                    <!-- Left: QR Code -->
                    <div class="payment-left">
                        <div class="qr-section">
                            <p class="qr-label">Quét QR để thanh toán:</p>
                            <img id="qrImage" src="" alt="QR Payment" class="qr-img">
                            <div class="bank-info">
                                <div class="bank-row"><span>Ngân hàng:</span><strong>{{ $bankInfo['name'] }}</strong></div>
                                <div class="bank-row"><span>Số tài khoản:</span><strong>{{ $bankInfo['account'] }}</strong></div>
                                <div class="bank-row"><span>Chủ TK:</span><strong>{{ $bankInfo['owner'] }}</strong></div>
                                <div class="bank-row"><span>Nội dung:</span><strong style="color:#6366f1;" id="displayCode"></strong></div>
                                <div class="bank-row"><span>Số tiền:</span><strong style="color:#10b981;" id="displayAmount"></strong></div>
                            </div>
                            <div class="payment-warning">⚠️ Nội dung CK phải giống 100% mã đơn hàng</div>
                        </div>
                    </div>
                    
                    <!-- Right: Order Summary -->
                    <div class="payment-right">
                        <div class="order-summary-box">
                            <div class="summary-header">📋 Tóm tắt đơn hàng</div>
                            <div class="summary-row"><span>Dịch vụ</span><span style="max-width: 200px; text-align: right;">{{ $product['name'] }}</span></div>
                            <div class="summary-total"><span>Tổng thanh toán</span><span class="total-amount" id="totalAmount"></span></div>
                            <div style="font-size: 13px; color: #64748b; margin-bottom: 14px;">Trạng thái: <span class="badge-pending">PENDING</span></div>
                            
                            @if(Auth::check())
                            <div class="balance-section">
                                <div class="balance-row"><span>💰 Số dư</span><span class="balance-amt">{{ number_format($userBalance) }} VND</span></div>
                                @if($userBalance >= $product['priceVnd'])
                                <button id="payBalanceBtn" class="btn-balance" onclick="payWithBalance()">Thanh toán bằng số dư</button>
                                @else
                                <div class="balance-warning">⚠️ Thiếu {{ number_format($product['priceVnd'] - $userBalance) }} VND</div>
                                <a href="/nap-tien" class="btn-deposit">Nạp tiền</a>
                                @endif
                            </div>
                            @else
                            <div class="direct-pay">
                                <div class="direct-main">✅ Thanh toán qua QR</div>
                                <div class="direct-sub">Quét mã → Chuyển khoản → Tự động xác nhận</div>
                            </div>
                            <div class="login-hint">
                                Hoặc <a href="/login?redirect={{ urlencode(request()->fullUrl()) }}">Đăng nhập</a> để dùng số dư
                            </div>
                            @endif
                            
                            <a href="#" id="checkResultBtn" class="btn-check">🔍 Kiểm tra kết quả</a>
                            
                            <div id="statusBox" class="status-box">
                                <span id="statusIcon">🔄</span> <span id="statusText">Đang chờ thanh toán...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
let currentOrderId = null;
let currentTrackingCode = null;
let checkCount = 0;
let checkInterval = null;

document.getElementById('checkoutForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const btn = document.getElementById('submitBtn');
    const errorBox = document.getElementById('errorBox');
    
    btn.disabled = true;
    btn.textContent = '⏳ Đang tạo đơn...';
    errorBox.style.display = 'none';
    
    try {
        const formData = new FormData(this);
        
        // Build dynamic fields object from all form inputs
        const payload = { uuid: formData.get('uuid'), fields: {} };
        for (const [key, value] of formData.entries()) {
            if (key !== 'uuid' && key !== '_token' && value) {
                payload.fields[key] = value;
            }
        }
        
        const response = await fetch('{{ route("ord-checkout.submit") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
        });
        
        const data = await response.json();
        
        if (data.success) {
            currentOrderId = data.order_id;
            currentTrackingCode = data.tracking_code;
            
            // Update payment section
            document.getElementById('qrImage').src = data.qr_url;
            document.getElementById('displayCode').textContent = data.tracking_code;
            document.getElementById('displayAmount').textContent = Number(data.amount).toLocaleString('vi-VN') + ' đ';
            document.getElementById('totalAmount').textContent = Number(data.amount).toLocaleString('vi-VN') + 'đ';
            document.getElementById('checkResultBtn').href = '/don-ady?code=' + data.tracking_code;
            
            // Show payment section
            document.getElementById('formSection').style.display = 'none';
            document.getElementById('paymentSection').style.display = 'block';
            
            // Start polling
            startPaymentCheck();
        } else {
            errorBox.textContent = data.error;
            errorBox.style.display = 'block';
            btn.disabled = false;
            btn.innerHTML = '💳 Tạo đơn & Thanh toán {{ number_format($product["priceVnd"]) }}đ';
        }
    } catch (error) {
        console.error('Error:', error);
        errorBox.textContent = 'Lỗi kết nối. Vui lòng thử lại.';
        errorBox.style.display = 'block';
        btn.disabled = false;
        btn.innerHTML = '💳 Tạo đơn & Thanh toán {{ number_format($product["priceVnd"]) }}đ';
    }
});

function startPaymentCheck() {
    checkInterval = setInterval(function() {
        checkCount++;
        if (checkCount > 200) {
            clearInterval(checkInterval);
            document.getElementById('statusIcon').textContent = '⏰';
            document.getElementById('statusText').textContent = 'Hết thời gian tự động. Nhấn "Kiểm tra kết quả" sau khi thanh toán.';
            return;
        }
        
        fetch('/api/check-payment?code=' + encodeURIComponent(currentTrackingCode))
            .then(r => r.json())
            .then(data => {
                if (data.paid) {
                    clearInterval(checkInterval);
                    document.getElementById('statusIcon').textContent = '✅';
                    document.getElementById('statusText').textContent = 'Thanh toán thành công! Đang chuyển trang...';
                    document.getElementById('statusBox').classList.add('success');
                    setTimeout(() => {
                        window.location.href = '/don-ady?code=' + currentTrackingCode;
                    }, 1500);
                }
            })
            .catch(() => {});
    }, 3000);
}

@if(Auth::check() && $userBalance >= $product['priceVnd'])
async function payWithBalance() {
    if (!currentOrderId) {
        alert('Vui lòng tạo đơn hàng trước');
        return;
    }
    
    if (!confirm('Bạn có chắc muốn thanh toán đơn này bằng số dư tài khoản?')) return;
    
    const btn = document.getElementById('payBalanceBtn');
    btn.disabled = true;
    btn.textContent = '⏳ Đang xử lý...';
    
    try {
        const response = await fetch('/api/pay-with-balance', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ order_id: currentOrderId })
        });
        
        const data = await response.json();
        
        if (data.success) {
            clearInterval(checkInterval);
            document.getElementById('statusIcon').textContent = '✅';
            document.getElementById('statusText').textContent = data.message;
            document.getElementById('statusBox').classList.add('success');
            setTimeout(() => {
                window.location.href = data.redirect;
            }, 1500);
        } else {
            alert(data.error);
            btn.disabled = false;
            btn.textContent = 'Thanh toán bằng số dư';
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Lỗi kết nối. Vui lòng thử lại.');
        btn.disabled = false;
        btn.textContent = 'Thanh toán bằng số dư';
    }
}
@endif
</script>
@endsection
