@extends('layouts.app')

@section('title', 'Nạp tiền - ThueTaiKhoan.net')
@section('meta_description', 'Nạp tiền vào tài khoản ThueTaiKhoan.net để thanh toán nhanh chóng.')

@push('head')
<script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key', '6LegMlIsAAAAALh9UGh23nn8c_J5Gq_MbiVNrtTY') }}"></script>
<style>.grecaptcha-badge { visibility: hidden !important; }</style>
@endpush

@section('styles')
<style>
/* Deposit Page - Legacy Style */
.dep-header {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    padding: 20px 0;
    text-align: center;
}
.dep-header-inner {
    max-width: 600px;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.dep-title {
    color: #fff;
    font-size: 18px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 8px;
}
.dep-back {
    color: rgba(255,255,255,0.85);
    text-decoration: none;
    font-size: 14px;
}
.dep-back:hover {
    color: #fff;
}

.dep-wrap {
    max-width: 600px;
    margin: 0 auto;
    padding: 32px 20px;
}

/* Balance Display */
.dep-balance {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 20px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}
.dep-balance-info p {
    font-size: 13px;
    color: #64748b;
    margin: 0 0 4px;
}
.dep-balance-info h2 {
    font-size: 28px;
    font-weight: 800;
    color: #10b981;
    margin: 0;
}
.dep-balance-icon {
    width: 48px;
    height: 48px;
    background: #f0fdf4;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

/* Create Order Card */
.dep-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 24px;
}
.dep-card-title {
    font-size: 16px;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 20px;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* Amount Selection */
.amount-label {
    font-size: 13px;
    color: #64748b;
    margin-bottom: 12px;
}
.amount-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
    margin-bottom: 16px;
}
.amount-btn {
    padding: 14px;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    background: #fff;
    font-size: 14px;
    font-weight: 600;
    color: #374151;
    cursor: pointer;
    transition: all 0.2s;
    text-align: center;
}
.amount-btn:hover {
    border-color: #10b981;
    background: #f0fdf4;
}
.amount-btn.active {
    border-color: #10b981;
    background: #10b981;
    color: #fff;
}
.custom-amount {
    margin-top: 12px;
}
.custom-amount input {
    width: 100%;
    padding: 14px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 15px;
    outline: none;
    transition: border-color 0.2s;
}
.custom-amount input:focus {
    border-color: #10b981;
}
.custom-amount input::placeholder {
    color: #9ca3af;
}

/* Payment Methods */
.payment-label {
    font-size: 13px;
    color: #64748b;
    margin: 24px 0 12px;
}
.payment-methods {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}
.payment-method {
    padding: 16px;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    background: #fff;
    cursor: pointer;
    transition: all 0.2s;
    text-align: center;
}
.payment-method:hover {
    border-color: #10b981;
}
.payment-method.active {
    border-color: #10b981;
    background: #f0fdf4;
}
.payment-method-icon {
    font-size: 28px;
    margin-bottom: 8px;
}
.payment-method-name {
    font-size: 14px;
    font-weight: 600;
    color: #374151;
}

/* Submit Button */
.dep-submit-btn {
    width: 100%;
    padding: 16px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #fff;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    margin-top: 24px;
    transition: all 0.2s;
}
.dep-submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(16,185,129,0.3);
}
.dep-submit-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

.recaptcha-notice {
    text-align: center;
    margin-top: 16px;
    font-size: 11px;
    color: #94a3b8;
}
.recaptcha-notice a {
    color: #10b981;
}

/* QR Section (shown after creating order) */
.qr-section {
    display: none;
}
.qr-section.active {
    display: block;
    animation: fadeIn 0.3s ease;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
.success-alert {
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    border: 2px solid #4ade80;
    border-radius: 12px;
    padding: 18px 20px;
    margin-bottom: 24px;
    color: #166534;
    font-size: 15px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
}
.qr-card {
    background: #fff;
    border: 2px solid #e5e7eb;
    border-radius: 16px;
    padding: 32px;
    text-align: center;
    box-shadow: 0 8px 30px rgba(0,0,0,0.06);
}
.qr-card-title {
    font-size: 18px;
    font-weight: 700;
    margin: 0 0 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    color: #0f172a;
}
.vietqr-logo {
    background: linear-gradient(135deg, #e63946 0%, #f94449 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 800;
    font-size: 20px;
}
.qr-wrapper {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    padding: 20px;
    border-radius: 16px;
    display: inline-block;
    margin-bottom: 20px;
}
.qr-image {
    width: 220px;
    height: 220px;
    border-radius: 12px;
    border: 3px solid #fff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
.qr-hint {
    color: #64748b;
    font-size: 14px;
    margin-bottom: 28px;
}

/* Bank Info Table */
.bank-table {
    width: 100%;
    text-align: left;
    border-top: 1px solid #e5e7eb;
}
.bank-table tr {
    border-bottom: 1px solid #f1f5f9;
}
.bank-table td {
    padding: 14px 0;
    font-size: 14px;
}
.bank-table td:first-child {
    color: #64748b;
    width: 120px;
}
.bank-table td:last-child {
    color: #0f172a;
    font-weight: 600;
    text-align: right;
}
.bank-table .amount {
    color: #10b981;
    font-size: 16px;
}
.bank-table .code {
    color: #6366f1;
}
.copy-btn {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #fff;
    border: none;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    margin-left: 12px;
    transition: all 0.2s;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.copy-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(16,185,129,0.3);
}
.copy-btn.copied {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
}

/* Toast notification */
.toast {
    position: fixed;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%) translateY(100px);
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    color: #fff;
    padding: 14px 28px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 600;
    z-index: 9999;
    opacity: 0;
    transition: all 0.3s ease;
    box-shadow: 0 8px 30px rgba(0,0,0,0.2);
}
.toast.show {
    transform: translateX(-50%) translateY(0);
    opacity: 1;
}
.toast.success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

/* Warning Box */
.warning-box {
    background: #fef3c7;
    border: 1px solid #fcd34d;
    border-radius: 10px;
    padding: 16px;
    margin-top: 24px;
}
.warning-box h4 {
    color: #92400e;
    font-size: 14px;
    margin: 0 0 10px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.warning-box ul {
    margin: 0;
    padding-left: 20px;
    color: #92400e;
    font-size: 13px;
}
.warning-box li {
    margin-bottom: 6px;
}

/* Cancel Button */
.cancel-btn {
    display: block;
    width: fit-content;
    margin: 24px auto 0;
    padding: 12px 24px;
    background: #fff;
    border: 2px solid #ef4444;
    color: #ef4444;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}
.cancel-btn:hover {
    background: #fef2f2;
}

/* History */
.dep-history {
    margin-top: 32px;
}
.dep-history-title {
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.history-table {
    width: 100%;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
}
.history-table th, .history-table td {
    padding: 14px 16px;
    text-align: left;
    font-size: 13px;
}
.history-table th {
    background: #f8fafc;
    color: #64748b;
    font-weight: 600;
}
.history-table td {
    border-top: 1px solid #f1f5f9;
}
.status-success {
    color: #10b981;
    font-weight: 600;
}
.status-pending {
    color: #f59e0b;
    font-weight: 600;
}

/* Dark Mode */
[data-theme="dark"] .dep-balance, [data-theme="dark"] .dep-card, [data-theme="dark"] .qr-card { 
    background: var(--bg-card); 
    border-color: #334155; 
}
[data-theme="dark"] .dep-balance-info h2 { color: #4ade80; }
[data-theme="dark"] .dep-balance-icon { background: #1e293b; }
[data-theme="dark"] .dep-card-title { color: var(--ink); }
[data-theme="dark"] .amount-btn { background: var(--bg-card); border-color: #334155; color: var(--ink); }
[data-theme="dark"] .amount-btn:hover { border-color: #10b981; background: #1e293b; }
[data-theme="dark"] .amount-btn.active { background: #10b981; color: #fff; }
[data-theme="dark"] .custom-amount input { background: #1e293b; border-color: #334155; color: var(--ink); }
[data-theme="dark"] .payment-method { background: var(--bg-card); border-color: #334155; }
[data-theme="dark"] .payment-method-name { color: var(--ink); }
[data-theme="dark"] .bank-table { border-color: #334155; }
[data-theme="dark"] .bank-table tr { border-color: #334155; }
[data-theme="dark"] .bank-table td:last-child { color: var(--ink); }
[data-theme="dark"] .history-table { background: var(--bg-card); border-color: #334155; }
[data-theme="dark"] .history-table th { background: #1e293b; }
[data-theme="dark"] .history-table td { border-color: #334155; color: var(--ink); }

@media (max-width: 640px) {
    .amount-grid { grid-template-columns: repeat(2, 1fr); }
    .payment-methods { grid-template-columns: 1fr 1fr; }
    
    /* History Table Mobile - Card Layout */
    .history-table {
        border: none;
        background: transparent;
    }
    .history-table thead {
        display: none;
    }
    .history-table tbody {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .history-table tr {
        display: block;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 16px;
    }
    .history-table td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 6px 0;
        border-top: none;
        font-size: 13px;
    }
    .history-table td::before {
        content: attr(data-label);
        font-weight: 600;
        color: #64748b;
        font-size: 12px;
    }
    .history-table td:first-child {
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 10px;
        margin-bottom: 6px;
    }
    [data-theme="dark"] .history-table tr {
        background: var(--bg-card);
        border-color: #334155;
    }
}
</style>
@endsection

@section('content')
<!-- Green Header -->
<div class="dep-header">
    <div class="dep-header-inner">
        <div class="dep-title">💰 Nạp tiền</div>
        <a href="/account" class="dep-back">← Tài khoản</a>
    </div>
</div>

<div class="dep-wrap">
    <!-- Balance -->
    <div class="dep-balance">
        <div class="dep-balance-info">
            <p>Số dư hiện tại</p>
            <h2>{{ number_format($user->balance ?? 0, 0, ',', '.') }} VND</h2>
        </div>
        <div class="dep-balance-icon">💳</div>
    </div>

    <!-- Create Order Form -->
    <div class="dep-card" id="createOrderSection">
        <h3 class="dep-card-title">📝 Tạo lệnh nạp tiền</h3>
        
        <form id="depositForm">
            @csrf
            <p class="amount-label">Chọn số tiền nạp</p>
            <div class="amount-grid">
                <button type="button" class="amount-btn" data-amount="50000">50,000đ</button>
                <button type="button" class="amount-btn" data-amount="100000">100,000đ</button>
                <button type="button" class="amount-btn" data-amount="200000">200,000đ</button>
                <button type="button" class="amount-btn" data-amount="500000">500,000đ</button>
                <button type="button" class="amount-btn" data-amount="1000000">1,000,000đ</button>
                <button type="button" class="amount-btn" data-amount="2000000">2,000,000đ</button>
            </div>
            
            <div class="custom-amount">
                <input type="number" name="amount" id="customAmount" placeholder="Hoặc nhập số tiền khác" min="10000">
            </div>
            
            <p class="payment-label">Phương thức thanh toán</p>
            <div class="payment-methods">
                <div class="payment-method active" data-method="bank">
                    <div class="payment-method-icon">🏦</div>
                    <div class="payment-method-name">Ngân hàng</div>
                </div>
                <div class="payment-method" data-method="momo">
                    <div class="payment-method-icon">📱</div>
                    <div class="payment-method-name">MoMo</div>
                </div>
            </div>
            
            <input type="hidden" name="method" id="paymentMethod" value="bank">
            <input type="hidden" name="amount_selected" id="amountSelected" value="">
            
            <button type="submit" class="dep-submit-btn" id="submitBtn" disabled>
                Tạo lệnh nạp tiền
            </button>
            
            <div class="recaptcha-notice">
                Trang này được bảo vệ bởi reCAPTCHA.<br>
                <a href="https://policies.google.com/privacy" target="_blank">Chính sách</a> · <a href="https://policies.google.com/terms" target="_blank">Điều khoản</a> Google.
            </div>
        </form>
    </div>

    <!-- QR Code Section (Hidden by default) -->
    <div class="qr-section" id="qrSection">
        <div class="success-alert">
            ✅ Tạo lệnh nạp tiền thành công! Vui lòng chuyển khoản theo thông tin bên dưới.
        </div>
        
        <div class="qr-card">
            <h3 class="qr-card-title">🏦 Chuyển khoản ngân hàng <span class="vietqr-logo">VIETQR</span></h3>
            <div class="qr-wrapper">
                <img src="" alt="QR Code" class="qr-image" id="qrImage">
            </div>
            <p class="qr-hint">📱 Mở app ngân hàng → Quét mã QR → Xác nhận thanh toán</p>
            
            <table class="bank-table">
                <tr>
                    <td>Ngân hàng</td>
                    <td>{{ $bankInfo['name'] }}</td>
                </tr>
                <tr>
                    <td>Số tài khoản</td>
                    <td>{{ $bankInfo['account'] }} <button class="copy-btn" onclick="copyText('{{ $bankInfo['account'] }}')">Copy</button></td>
                </tr>
                <tr>
                    <td>Chủ tài khoản</td>
                    <td>{{ $bankInfo['owner'] }}</td>
                </tr>
                <tr>
                    <td>Số tiền</td>
                    <td class="amount" id="displayAmount">-</td>
                </tr>
                <tr>
                    <td>Nội dung CK</td>
                    <td class="code" id="displayCode">- <button class="copy-btn" onclick="copyText(document.getElementById('displayCode').innerText.replace(' Copy', ''))">Copy</button></td>
                </tr>
            </table>
            
            <div class="warning-box">
                <h4>⚠️ Lưu ý quan trọng:</h4>
                <ul>
                    <li>Nhập đúng nội dung chuyển khoản để được cộng tiền tự động</li>
                    <li>Hệ thống sẽ tự động cộng tiền trong vòng 1-5 phút sau khi nhận được tiền</li>
                    <li>Nếu sau 10 phút chưa nhận được tiền, vui lòng liên hệ hỗ trợ</li>
                </ul>
            </div>
            
            <button class="cancel-btn" onclick="cancelDeposit()">✕ Hủy lệnh nạp tiền</button>
        </div>
    </div>

    <!-- Deposit History -->
    @if(isset($deposits) && $deposits->count() > 0)
    <div class="dep-history">
        <h3 class="dep-history-title">📜 Lịch sử nạp tiền</h3>
        <table class="history-table">
            <thead>
                <tr>
                    <th>Thời gian</th>
                    <th>Số tiền</th>
                    <th>Phương thức</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                @foreach($deposits as $dep)
                <tr>
                    <td data-label="Thời gian">{{ \Carbon\Carbon::parse($dep->created_at)->format('d/m/Y H:i') }}</td>
                    <td data-label="Số tiền" style="font-weight: 600; color: #10b981;">{{ number_format($dep->amount, 0, ',', '.') }}đ</td>
                    <td data-label="Phương thức">🏦 Ngân hàng</td>
                    <td data-label="Trạng thái" class="status-{{ $dep->status }}">{{ $dep->status == 'success' ? '✅ Thành công' : '⏳ Đang xử lý' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const amountBtns = document.querySelectorAll('.amount-btn');
    const customAmount = document.getElementById('customAmount');
    const amountSelected = document.getElementById('amountSelected');
    const submitBtn = document.getElementById('submitBtn');
    const paymentMethods = document.querySelectorAll('.payment-method');
    const paymentMethodInput = document.getElementById('paymentMethod');
    const createOrderSection = document.getElementById('createOrderSection');
    const qrSection = document.getElementById('qrSection');
    const depositForm = document.getElementById('depositForm');
    
    const bankInfo = {
        bin: '{{ $bankInfo['bin'] }}',
        account: '{{ $bankInfo['account'] }}',
        owner: '{{ $bankInfo['owner'] }}'
    };
    
    // Amount button click
    amountBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            amountBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            amountSelected.value = this.dataset.amount;
            customAmount.value = '';
            updateSubmitBtn();
        });
    });
    
    // Custom amount input
    customAmount.addEventListener('input', function() {
        amountBtns.forEach(b => b.classList.remove('active'));
        amountSelected.value = this.value;
        updateSubmitBtn();
    });
    
    // Payment method selection
    paymentMethods.forEach(method => {
        method.addEventListener('click', function() {
            paymentMethods.forEach(m => m.classList.remove('active'));
            this.classList.add('active');
            paymentMethodInput.value = this.dataset.method;
        });
    });
    
    function updateSubmitBtn() {
        const amount = parseInt(amountSelected.value) || 0;
        submitBtn.disabled = amount < 10000;
    }
    
    // Form submit
    depositForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const amount = parseInt(amountSelected.value);
        if (amount < 10000) {
            alert('Số tiền tối thiểu là 10,000đ');
            return;
        }
        
        // Generate deposit code
        const userId = {{ $user->id ?? 0 }};
        const timestamp = Date.now();
        const depositCode = 'NAP' + timestamp + (userId > 0 ? userId : '');
        
        // Generate QR URL
        const qrUrl = 'https://img.vietqr.io/image/' + bankInfo.bin + '-' + bankInfo.account + 
            '-compact.png?amount=' + amount + '&addInfo=' + depositCode + '&accountName=' + encodeURIComponent(bankInfo.owner);
        
        // Update QR section
        document.getElementById('qrImage').src = qrUrl;
        document.getElementById('displayAmount').innerText = amount.toLocaleString('vi-VN') + ' VND';
        document.getElementById('displayCode').innerHTML = depositCode + ' <button class="copy-btn" onclick="copyText(\'' + depositCode + '\')">Copy</button>';
        
        // Show QR section
        createOrderSection.style.display = 'none';
        qrSection.classList.add('active');
        
        // Scroll to top
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
});

function copyText(text, btn) {
    navigator.clipboard.writeText(text).then(function() {
        showToast('✓ Đã copy: ' + text, 'success');
        if (btn) {
            btn.classList.add('copied');
            btn.innerText = 'Đã copy!';
            setTimeout(() => {
                btn.classList.remove('copied');
                btn.innerText = 'Copy';
            }, 2000);
        }
    });
}

function showToast(message, type = '') {
    // Remove existing toast
    const existingToast = document.querySelector('.toast');
    if (existingToast) existingToast.remove();
    
    const toast = document.createElement('div');
    toast.className = 'toast ' + type;
    toast.innerText = message;
    document.body.appendChild(toast);
    
    setTimeout(() => toast.classList.add('show'), 10);
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, 2500);
}

function cancelDeposit() {
    document.getElementById('createOrderSection').style.display = 'block';
    document.getElementById('qrSection').classList.remove('active');
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
</script>
@endsection
