@extends('layouts.app')

@section('title', 'Đặt hàng - ' . $product['name'])
@section('meta_description', 'Đặt hàng dịch vụ ' . $product['name'] . ' - Thuetaikhoan.net')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
/* ===== BASE ===== */
.ck-page * { box-sizing: border-box; font-family: 'Inter', -apple-system, sans-serif; }
.ck-page { min-height: 100vh; background: #f8fafc; padding: 0 16px 60px; }

/* ===== BREADCRUMB ===== */
.ck-bread { max-width: 1000px; margin: 0 auto; padding: 16px 0; display: flex; gap: 8px; font-size: 13px; color: #64748b; align-items: center; flex-wrap: wrap; }
.ck-bread a { color: #f97316; text-decoration: none; font-weight: 500; }
.ck-bread a:hover { color: #ea580c; }
.ck-bread svg { width: 14px; height: 14px; opacity: 0.4; }

/* ===== GRID ===== */
.ck-grid { max-width: 1000px; margin: 0 auto; display: grid; grid-template-columns: 1fr 360px; gap: 24px; align-items: start; }

/* ===== HERO ===== */
.ck-hero {
    grid-column: 1 / -1;
    background: #fff;
    border: 1px solid #cbd5e1;
    border-radius: 14px;
    padding: 28px 32px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}
.ck-hero-top { display: flex; justify-content: space-between; align-items: flex-start; gap: 20px; flex-wrap: wrap; }
.ck-hero h1 { font-size: 17px; font-weight: 700; color: #1e293b; line-height: 1.6; max-width: 580px; }
.ck-price-block { text-align: right; flex-shrink: 0; }
.ck-price-label { font-size: 11px; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 2px; }
.ck-price-main { font-size: 34px; font-weight: 800; color: #10b981; }
.ck-price-main small { font-size: 16px; color: #64748b; }
.ck-price-total { font-size: 13px; color: #64748b; margin-top: 2px; }
.ck-price-total strong { color: #059669; font-size: 14px; }
.ck-badges { display: flex; gap: 8px; margin-top: 14px; flex-wrap: wrap; }
.ck-badge { display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
.ck-badge--time { background: #ecfdf5; border: 1px solid #a7f3d0; color: #059669; }
.ck-badge--stock { background: #eff6ff; border: 1px solid #bfdbfe; color: #2563eb; }

/* ===== FORM CARD ===== */
.ck-form-card { background: #fff; border: 1px solid #cbd5e1; border-radius: 14px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
.ck-form-header {
    padding: 18px 24px; border-bottom: 1px solid #e2e8f0;
    display: flex; align-items: center; gap: 10px;
    font-weight: 700; color: #1e293b; font-size: 15px;
    background: #fafbfc;
}
.ck-form-header .icon { font-size: 18px; }
.ck-form-body { padding: 24px; }

/* Form Groups */
.ck-fg { margin-bottom: 20px; }
.ck-fg:last-child { margin-bottom: 0; }
.ck-fg label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px; }
.ck-fg label .req { color: #ef4444; margin-left: 2px; }
.ck-fg input, .ck-fg textarea, .ck-fg select {
    width: 100%; padding: 12px 16px;
    background: #f8fafc; border: 1.5px solid #cbd5e1;
    border-radius: 12px; color: #1e293b; font-size: 14px;
    transition: all 0.25s ease;
}
.ck-fg input:focus, .ck-fg textarea:focus, .ck-fg select:focus {
    outline: none; border-color: #f97316;
    box-shadow: 0 0 0 3px rgba(249,115,22,0.1);
    background: #fff;
}
.ck-fg input::placeholder, .ck-fg textarea::placeholder { color: #94a3b8; }
.ck-fg .hint { font-size: 11px; color: #94a3b8; margin-top: 6px; display: block; }

/* Quantity */
.ck-qty {
    display: inline-flex; align-items: center;
    background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 12px;
    overflow: hidden;
}
.ck-qty button {
    width: 40px; height: 42px; border: none;
    background: transparent; color: #64748b; font-size: 18px; font-weight: 700;
    cursor: pointer; transition: all 0.2s;
}
.ck-qty button:hover { background: #e2e8f0; color: #1e293b; }
.ck-qty input {
    width: 56px; text-align: center; border: none; border-radius: 0;
    border-left: 1px solid #cbd5e1; border-right: 1px solid #cbd5e1;
    background: #fff; padding: 12px 0; font-weight: 700; font-size: 15px; color: #1e293b;
}
.ck-qty input:focus { box-shadow: none; outline: none; }

/* Submit */
.ck-submit {
    display: flex; align-items: center; justify-content: center; gap: 10px;
    width: 100%; padding: 16px 24px; margin-top: 24px;
    background: linear-gradient(135deg, #10b981, #059669);
    color: #fff; font-size: 15px; font-weight: 700;
    border: none; border-radius: 14px; cursor: pointer;
    box-shadow: 0 4px 14px rgba(16,185,129,0.25);
    transition: all 0.3s ease;
}
.ck-submit:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(16,185,129,0.35); }
.ck-submit:disabled { background: #cbd5e1; box-shadow: none; cursor: not-allowed; }
.ck-submit .price-tag { background: rgba(255,255,255,0.25); padding: 4px 12px; border-radius: 8px; font-size: 14px; }

/* Error */
.ck-error {
    background: #fef2f2; border: 1px solid #fecaca;
    color: #dc2626; padding: 14px 16px; border-radius: 12px;
    margin-bottom: 20px; font-size: 13px; display: none;
}

/* ===== SIDEBAR ===== */
.ck-sidebar { background: #fff; border: 1px solid #cbd5e1; border-radius: 14px; overflow: hidden; position: sticky; top: 100px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
.ck-sidebar-header { padding: 18px 24px; border-bottom: 1px solid #e2e8f0; font-weight: 700; color: #1e293b; font-size: 15px; background: #fafbfc; }
.ck-sidebar-body { padding: 20px 24px; }
.ck-sum-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 10px 0; font-size: 13px; color: #64748b;
    border-bottom: 1px solid #f1f5f9;
}
.ck-sum-row:last-child { border-bottom: none; }
.ck-sum-row .val { color: #1e293b; font-weight: 600; text-align: right; max-width: 180px; word-break: break-word; }
.ck-sum-total {
    display: flex; justify-content: space-between; align-items: center;
    padding: 16px 0; margin-top: 8px; border-top: 2px solid #e2e8f0;
}
.ck-sum-total .lbl { font-size: 14px; font-weight: 600; color: #374151; }
.ck-sum-total .amt { font-size: 24px; font-weight: 800; color: #10b981; }

/* Guarantees */
.ck-guarantees { display: flex; flex-direction: column; gap: 8px; margin-top: 16px; }
.ck-guarantee {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 14px; background: #f8fafc;
    border-radius: 10px; font-size: 12px; color: #64748b;
    border: 1px solid #f1f5f9;
}
.ck-guarantee .gi { font-size: 16px; flex-shrink: 0; }

/* ===== PAYMENT ===== */
.ck-payment { display: none; grid-column: 1 / -1; }
.ck-pay-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
.ck-pay-card { background: #fff; border: 1px solid #cbd5e1; border-radius: 14px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
.ck-pay-header {
    padding: 16px 24px; border-bottom: 1px solid #e2e8f0;
    font-weight: 700; color: #1e293b; font-size: 14px;
    display: flex; align-items: center; gap: 8px; background: #fafbfc;
}
.ck-pay-body { padding: 24px; }

.ck-qr-wrap { text-align: center; }
.ck-qr-img {
    width: 220px; height: 220px; border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    border: 2px solid #e2e8f0; margin: 0 auto 16px;
}
.ck-qr-note { font-size: 12px; color: #94a3b8; }

.ck-bank-rows { margin-top: 20px; }
.ck-bank-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 10px 0; border-bottom: 1px solid #f1f5f9; font-size: 13px;
}
.ck-bank-row:last-child { border-bottom: none; }
.ck-bank-row .k { color: #94a3b8; }
.ck-bank-row .v { color: #1e293b; font-weight: 600; }
.ck-bank-row .v.mono { font-family: 'JetBrains Mono', monospace; color: #6366f1; letter-spacing: 0.5px; }
.ck-bank-row .v.green { color: #10b981; }

.ck-pay-warn {
    margin-top: 16px; padding: 12px; border-radius: 10px;
    background: #fffbeb; border: 1px solid #fde68a;
    font-size: 12px; color: #92400e; text-align: center;
}

.ck-pay-status {
    padding: 16px; border-radius: 12px; text-align: center;
    font-size: 14px; font-weight: 600;
    background: #eff6ff; border: 1px solid #bfdbfe; color: #2563eb;
    margin-bottom: 16px; transition: all 0.3s;
}
.ck-pay-status.success { background: #ecfdf5; border-color: #a7f3d0; color: #059669; }

.ck-balance-box {
    background: #ecfdf5; border: 1px solid #a7f3d0;
    border-radius: 12px; padding: 16px; margin-bottom: 12px;
}
.ck-balance-row { display: flex; justify-content: space-between; font-size: 13px; color: #64748b; margin-bottom: 10px; }
.ck-balance-val { color: #059669; font-weight: 700; }
.ck-btn-balance {
    width: 100%; padding: 12px;
    background: linear-gradient(135deg, #16a34a, #15803d);
    color: #fff; border: none; border-radius: 10px;
    font-size: 14px; font-weight: 600; cursor: pointer;
}
.ck-balance-warn { font-size: 12px; color: #dc2626; margin-bottom: 8px; }
.ck-btn-deposit {
    display: block; width: 100%; padding: 12px;
    background: #2563eb; color: #fff; border-radius: 10px;
    text-align: center; text-decoration: none; font-size: 14px; font-weight: 600;
}

.ck-btn-check {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    width: 100%; padding: 14px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: #fff; border-radius: 12px; text-decoration: none;
    font-size: 14px; font-weight: 600; margin-bottom: 12px; transition: all 0.2s;
}
.ck-btn-check:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(99,102,241,0.3); }

.ck-btn-new {
    display: block; width: 100%; padding: 12px;
    background: transparent; border: 1.5px solid #e2e8f0;
    color: #64748b; border-radius: 10px; font-size: 13px; font-weight: 600;
    cursor: pointer; text-align: center;
}
.ck-btn-new:hover { border-color: #cbd5e1; color: #374151; }

.ck-login-hint { font-size: 12px; color: #94a3b8; text-align: center; margin: 12px 0; }
.ck-login-hint a { color: #6366f1; text-decoration: none; font-weight: 600; }

@media (max-width: 768px) {
    .ck-grid { grid-template-columns: 1fr; }
    .ck-pay-grid { grid-template-columns: 1fr; }
    .ck-hero h1 { font-size: 15px; }
    .ck-price-main { font-size: 28px; }
    .ck-sidebar { position: static; }
}
</style>

<div class="ck-page">
    <div class="ck-bread">
        <a href="/">Trang chủ</a>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
        <a href="/ord-services">Dịch vụ GSM</a>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
        <span>Đặt hàng</span>
    </div>

    <div class="ck-grid">
        {{-- HERO --}}
        <div class="ck-hero">
            <div class="ck-hero-top">
                <h1>{{ $product['name'] }}</h1>
                <div class="ck-price-block">
                    <div class="ck-price-label">Đơn giá</div>
                    <div class="ck-price-main" data-unit="{{ $product['priceVnd'] }}">{{ number_format($product['priceVnd']) }}<small>đ</small></div>
                    <div class="ck-price-total" id="totalDisplay">Tổng: <strong>{{ number_format($product['priceVnd']) }}đ</strong></div>
                </div>
            </div>
            <div class="ck-badges">
                <span class="ck-badge ck-badge--time">⏱️ 30s - 5 phút</span>
                <span class="ck-badge ck-badge--stock">✅ Còn hàng</span>
            </div>
        </div>

        {{-- FORM --}}
        <div class="ck-form-card" id="formSection">
            <div class="ck-form-header"><span class="icon">📝</span> Thông tin đặt hàng</div>
            <div class="ck-form-body">
                <form id="checkoutForm">
                    @csrf
                    <input type="hidden" name="uuid" value="{{ $product['uuid'] }}">
                    <div class="ck-error" id="errorBox"></div>

                    <div class="ck-fg">
                        <label>Email nhận kết quả <span class="req">*</span></label>
                        <input type="email" name="Email" id="Email" placeholder="email@example.com" required 
                               value="{{ Auth::check() ? Auth::user()->email : '' }}">
                        <span class="hint">Kết quả dịch vụ sẽ được gửi đến email này</span>
                    </div>

                    <div class="ck-fg">
                        <label>Số lượng <span class="req">*</span></label>
                        <div class="ck-qty">
                            <button type="button" onclick="updateQty(-1)">−</button>
                            <input type="number" name="Quantity" id="Quantity" value="1" min="1" oninput="calculateTotal()">
                            <button type="button" onclick="updateQty(1)">+</button>
                        </div>
                    </div>

                    @if(!empty($product['fields']))
                        @foreach($product['fields'] as $index => $fieldConfig)
                            @php
                                $fieldName = $fieldConfig['name'] ?? $fieldConfig['label'] ?? "Field_$index";
                                if (strtolower($fieldName) === 'email' || strtolower($fieldName) === 'quantity') continue;
                                $isRequired = ($fieldConfig['required'] ?? false) || ($fieldConfig['validation'] ?? false);
                                $fieldType = $fieldConfig['type'] ?? 'text';
                                $placeholder = $fieldConfig['placeholder'] ?? "Nhập $fieldName";
                                $hint = $fieldConfig['hint'] ?? $fieldConfig['description'] ?? '';
                                if ($fieldType === 'number') $fieldType = 'tel';
                                $fl = strtolower($fieldName);
                                $isIMEI = str_contains($fl, 'imei');
                                if ($isIMEI) { 
                                    $placeholder = $placeholder ?: 'Nhập IMEI (15 số)'; 
                                    $hint = $hint ?: 'Mở Settings > General > About > IMEI'; 
                                    $fieldType = 'tel';
                                }
                                elseif (str_contains($fl, 'serial')) { $placeholder = $placeholder ?: 'Nhập Serial Number'; $hint = $hint ?: 'Mở Settings > General > About > Serial Number'; }
                                elseif (str_contains($fl, 'model')) { $placeholder = $placeholder ?: 'VD: iPhone 12 Pro Max'; }
                            @endphp
                            <div class="ck-fg">
                                <label>{{ $fieldName }} @if($isRequired)<span class="req">*</span>@endif</label>
                                <input type="{{ $fieldType }}" name="{{ $fieldName }}" id="{{ $fieldName }}" 
                                       placeholder="{{ $placeholder }}" {{ $isRequired ? 'required' : '' }}
                                       @if($isIMEI) pattern="[0-9]{15}" maxlength="15" minlength="15" inputmode="numeric" class="imei-field" @endif>
                                @if($hint)<span class="hint">{{ $hint }}@if($isIMEI) <span class="imei-counter" data-for="{{ $fieldName }}"></span>@endif</span>@endif
                            </div>
                        @endforeach
                    @else
                        <div class="ck-fg">
                            <label>IMEI <span class="req">*</span></label>
                            <input type="tel" name="IMEI" id="IMEI" placeholder="Nhập IMEI (15 số)" required 
                                   pattern="[0-9]{15}" maxlength="15" minlength="15" inputmode="numeric" class="imei-field">
                            <span class="hint">Mở Settings > General > About > IMEI <span class="imei-counter" data-for="IMEI"></span></span>
                        </div>
                    @endif

                    <div class="ck-fg">
                        <label>Ghi chú</label>
                        <textarea name="Notes" id="Notes" rows="2" placeholder="Ghi chú thêm (nếu có)"></textarea>
                    </div>

                    <button type="submit" class="ck-submit" id="submitBtn">
                        💳 Tạo đơn & Thanh toán <span class="price-tag" id="btnTotalText">{{ number_format($product['priceVnd']) }}đ</span>
                    </button>
                </form>
            </div>
        </div>

        {{-- SIDEBAR --}}
        <div class="ck-sidebar" id="sidebarSection">
            <div class="ck-sidebar-header">📋 Tóm tắt đơn hàng</div>
            <div class="ck-sidebar-body">
                <div class="ck-sum-row"><span>Dịch vụ</span><span class="val">{{ Str::limit($product['name'], 35) }}</span></div>
                <div class="ck-sum-row"><span>Đơn giá</span><span class="val">{{ number_format($product['priceVnd']) }}đ</span></div>
                <div class="ck-sum-row"><span>Số lượng</span><span class="val" id="summaryQty">1</span></div>
                <div class="ck-sum-row"><span>Thời gian xử lý</span><span class="val">30s - 5 phút</span></div>
                <div class="ck-sum-total">
                    <span class="lbl">Tổng cộng</span>
                    <span class="amt" id="summaryTotal">{{ number_format($product['priceVnd']) }}đ</span>
                </div>
                <div class="ck-guarantees">
                    <div class="ck-guarantee"><span class="gi">🔒</span> Thanh toán bảo mật 100%</div>
                    <div class="ck-guarantee"><span class="gi">⚡</span> Xử lý tự động sau thanh toán</div>
                    <div class="ck-guarantee"><span class="gi">📧</span> Kết quả gửi qua Email</div>
                    <div class="ck-guarantee"><span class="gi">💬</span> Hỗ trợ 24/7 qua Zalo</div>
                </div>
            </div>
        </div>

        {{-- PAYMENT --}}
        <div class="ck-payment" id="paymentSection">
            <div class="ck-pay-grid">
                <div class="ck-pay-card">
                    <div class="ck-pay-header">🏦 Thanh toán chuyển khoản</div>
                    <div class="ck-pay-body">
                        <div class="ck-qr-wrap">
                            <img id="qrImage" src="" alt="QR" class="ck-qr-img">
                            <p class="ck-qr-note">Mở app ngân hàng → Quét mã QR</p>
                        </div>
                        <div class="ck-bank-rows">
                            <div class="ck-bank-row"><span class="k">Ngân hàng</span><span class="v">{{ $bankInfo['name'] }}</span></div>
                            <div class="ck-bank-row"><span class="k">Số tài khoản</span><span class="v mono">{{ $bankInfo['account'] }}</span></div>
                            <div class="ck-bank-row"><span class="k">Chủ TK</span><span class="v">{{ $bankInfo['owner'] }}</span></div>
                            <div class="ck-bank-row"><span class="k">Nội dung CK</span><span class="v mono" id="displayCode">---</span></div>
                            <div class="ck-bank-row"><span class="k">Số tiền</span><span class="v green" id="displayAmount">0đ</span></div>
                        </div>
                        <div class="ck-pay-warn">⚠️ Nội dung CK phải <b>chính xác 100%</b> mã đơn hàng</div>
                    </div>
                </div>
                <div class="ck-pay-card">
                    <div class="ck-pay-header">📋 Trạng thái đơn hàng</div>
                    <div class="ck-pay-body">
                        <div class="ck-pay-status" id="statusBox">
                            <span id="statusIcon">🔄</span> <span id="statusText">Đang chờ thanh toán...</span>
                        </div>
                        <div class="ck-sum-row"><span>Mã đơn</span><span class="val" style="color:#6366f1;font-family:monospace;" id="displayCode2">---</span></div>
                        <div class="ck-sum-row"><span>Dịch vụ</span><span class="val">{{ Str::limit($product['name'], 30) }}</span></div>
                        <div class="ck-sum-total">
                            <span class="lbl">Tổng</span>
                            <span class="amt" id="totalAmount">0đ</span>
                        </div>

                        @if(Auth::check())
                        <div class="ck-balance-box">
                            <div class="ck-balance-row"><span>💰 Số dư</span><span class="ck-balance-val">{{ number_format($userBalance) }}đ</span></div>
                            @if($userBalance >= $product['priceVnd'])
                            <button id="payBalanceBtn" class="ck-btn-balance" onclick="payWithBalance()">⚡ Thanh toán bằng số dư</button>
                            @else
                            <div class="ck-balance-warn">⚠️ Thiếu {{ number_format($product['priceVnd'] - $userBalance) }}đ</div>
                            <a href="/nap-tien" class="ck-btn-deposit">Nạp tiền vào tài khoản</a>
                            @endif
                        </div>
                        @else
                        <div class="ck-login-hint"><a href="/login?redirect={{ urlencode(request()->fullUrl()) }}">Đăng nhập</a> để thanh toán bằng số dư</div>
                        @endif

                        <a href="#" id="checkResultBtn" class="ck-btn-check">🔍 Kiểm tra kết quả</a>
                        <button onclick="window.location.reload()" class="ck-btn-new">Tạo đơn hàng mới</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const unitPrice = {{ $product['priceVnd'] }};
let currentOrderId = null, currentTrackingCode = null, checkCount = 0, checkInterval = null;

function updateQty(d) {
    const el = document.getElementById('Quantity');
    el.value = Math.max(1, parseInt(el.value || 1) + d);
    calculateTotal();
}
function calculateTotal() {
    const q = Math.max(1, parseInt(document.getElementById('Quantity').value) || 1);
    const t = unitPrice * q, f = new Intl.NumberFormat('vi-VN').format(t);
    document.getElementById('btnTotalText').textContent = f + 'đ';
    document.getElementById('summaryQty').textContent = q;
    document.getElementById('summaryTotal').textContent = f + 'đ';
    document.getElementById('totalDisplay').innerHTML = 'Tổng: <strong>' + f + 'đ</strong>';
}

document.getElementById('checkoutForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const btn = document.getElementById('submitBtn'), errorBox = document.getElementById('errorBox');
    
    // Validate IMEI fields
    const imeiInputs = document.querySelectorAll('.imei-field');
    for (const input of imeiInputs) {
        const val = input.value.trim();
        if (val && !/^[0-9]{15}$/.test(val)) {
            errorBox.textContent = `${input.name || 'IMEI'} phải có đúng 15 chữ số. Hiện tại: ${val.length} số.`;
            errorBox.style.display = 'block';
            input.focus();
            return;
        }
    }
    
    btn.disabled = true;
    const orig = btn.innerHTML;
    btn.innerHTML = '<span>⏳ Đang tạo đơn...</span>';
    errorBox.style.display = 'none';
    try {
        const fd = new FormData(this), payload = { uuid: fd.get('uuid'), fields: {} };
        for (const [k, v] of fd.entries()) { if (k !== 'uuid' && k !== '_token' && v) payload.fields[k] = v; }
        const res = await fetch('{{ route("ord-checkout.submit") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json', 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });
        const data = await res.json();
        if (data.success) {
            currentOrderId = data.order_id;
            currentTrackingCode = data.tracking_code;
            const af = Number(data.amount).toLocaleString('vi-VN');
            document.getElementById('qrImage').src = data.qr_url;
            document.getElementById('displayCode').textContent = data.tracking_code;
            document.getElementById('displayCode2').textContent = data.tracking_code;
            document.getElementById('displayAmount').textContent = af + 'đ';
            document.getElementById('totalAmount').textContent = af + 'đ';
            document.getElementById('checkResultBtn').href = '/don-ady?code=' + data.tracking_code;
            document.getElementById('formSection').style.display = 'none';
            document.getElementById('sidebarSection').style.display = 'none';
            document.getElementById('paymentSection').style.display = 'block';
            startPaymentCheck();
        } else {
            errorBox.textContent = data.error || 'Có lỗi xảy ra';
            errorBox.style.display = 'block';
            btn.disabled = false; btn.innerHTML = orig;
        }
    } catch (err) {
        errorBox.textContent = 'Lỗi kết nối server';
        errorBox.style.display = 'block';
        btn.disabled = false; btn.innerHTML = orig;
    }
});

function startPaymentCheck() {
    checkInterval = setInterval(function() {
        if (++checkCount > 200) {
            clearInterval(checkInterval);
            document.getElementById('statusIcon').textContent = '⏰';
            document.getElementById('statusText').textContent = 'Hết thời gian. Nhấn "Kiểm tra kết quả".';
            return;
        }
        fetch('/api/check-payment?code=' + encodeURIComponent(currentTrackingCode))
            .then(r => r.json())
            .then(d => {
                if (d.paid) {
                    clearInterval(checkInterval);
                    document.getElementById('statusIcon').textContent = '✅';
                    document.getElementById('statusText').textContent = 'Thanh toán thành công!';
                    document.getElementById('statusBox').classList.add('success');
                    setTimeout(() => { window.location.href = '/don-ady?code=' + currentTrackingCode; }, 1500);
                }
            }).catch(() => {});
    }, 3000);
}

// IMEI character counter
document.querySelectorAll('.imei-field').forEach(input => {
    const counter = document.querySelector(`.imei-counter[data-for="${input.id}"]`);
    if (!counter) return;
    
    function updateCounter() {
        const len = input.value.length;
        counter.textContent = ` (${len}/15 số)`;
        counter.style.color = len === 15 ? '#10b981' : '#f97316';
        counter.style.fontWeight = '600';
    }
    
    input.addEventListener('input', updateCounter);
    updateCounter();
});


@if(Auth::check() && $userBalance >= $product['priceVnd'])
async function payWithBalance() {
    if (!currentOrderId) { alert('Vui lòng tạo đơn trước'); return; }
    if (!confirm('Thanh toán đơn này bằng số dư?')) return;
    const btn = document.getElementById('payBalanceBtn');
    btn.disabled = true; btn.textContent = '⏳ Đang xử lý...';
    try {
        const res = await fetch('/api/ady/pay-with-balance', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ order_id: currentOrderId })
        });
        const d = await res.json();
        if (d.success) {
            clearInterval(checkInterval);
            document.getElementById('statusIcon').textContent = '✅';
            document.getElementById('statusText').textContent = d.message;
            document.getElementById('statusBox').classList.add('success');
            setTimeout(() => { window.location.href = d.redirect; }, 1500);
        } else { alert(d.error); btn.disabled = false; btn.textContent = '⚡ Thanh toán bằng số dư'; }
    } catch { alert('Lỗi kết nối'); btn.disabled = false; btn.textContent = '⚡ Thanh toán bằng số dư'; }
}
@endif
</script>
@endsection
