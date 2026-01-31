

<?php $__env->startSection('title', 'Thanh toán - ' . $order->tracking_code); ?>

<?php $__env->startSection('content'); ?>
<div class="checkout-wrapper">
    <div class="checkout-container">
        <div class="checkout-card">
            
            <div class="product-summary">
                <h1><?php echo e($price->type ?? 'Dịch vụ'); ?> - <?php echo e($price->hours_label); ?></h1>
                <div class="price-row">
                    <div>
                        <div class="price-label">TỔNG THANH TOÁN</div>
                    </div>
                    <div class="price-value"><?php echo e(number_format($order->amount, 0, ',', '.')); ?><small>đ</small></div>
                </div>
                <div class="tracking-badge">
                    Mã đơn: <strong><?php echo e($order->tracking_code); ?></strong>
                </div>
            </div>

            
            <div class="payment-grid">
                
                <div class="payment-left">
                    <div class="qr-section">
                        <p class="qr-label">Quét QR để thanh toán:</p>
                        <div class="qr-wrapper">
                            <img src="<?php echo e($qrUrl); ?>" alt="QR Payment" class="qr-img">
                        </div>
                        <div class="bank-info">
                            <div class="bank-row">
                                <span>Ngân hàng:</span>
                                <strong><?php echo e($bankInfo['name']); ?></strong>
                            </div>
                            <div class="bank-row">
                                <span>Số tài khoản:</span>
                                <strong><?php echo e($bankInfo['account']); ?></strong>
                            </div>
                            <div class="bank-row">
                                <span>Chủ TK:</span>
                                <strong><?php echo e($bankInfo['owner']); ?></strong>
                            </div>
                            <div class="bank-row">
                                <span>Nội dung:</span>
                                <strong class="tracking-code"><?php echo e($order->tracking_code); ?></strong>
                            </div>
                            <div class="bank-row">
                                <span>Số tiền:</span>
                                <strong class="amount"><?php echo e(number_format($order->amount, 0, ',', '.')); ?> đ</strong>
                            </div>
                        </div>
                        <div class="payment-warning">
                            ⚠️ Nội dung CK phải giống 100% "<strong><?php echo e($order->tracking_code); ?></strong>"
                        </div>
                    </div>
                </div>

                
                <div class="payment-right">
                    <div class="order-summary-box">
                        <div class="summary-header">📋 Tóm tắt đơn hàng</div>
                        
                        <div class="summary-row">
                            <span>Dịch vụ</span>
                            <span class="summary-value"><?php echo e($price->type); ?></span>
                        </div>
                        <div class="summary-row">
                            <span>Thời hạn</span>
                            <span class="summary-value"><?php echo e($price->hours_label); ?></span>
                        </div>
                        
                        <div class="summary-total">
                            <span>Tổng thanh toán</span>
                            <span class="total-amount"><?php echo e(number_format($order->amount, 0, ',', '.')); ?> đ</span>
                        </div>
                        
                        <div class="summary-status">
                            Trạng thái: <span class="badge-pending">PENDING</span>
                        </div>

                        <?php if($isLoggedIn): ?>
                        <div class="balance-section">
                            <div class="balance-row">
                                <span>💰 Số dư tài khoản</span>
                                <span class="balance-amt"><?php echo e(number_format($userBalance, 0, ',', '.')); ?> đ</span>
                            </div>
                            <?php if($userBalance >= $order->amount): ?>
                            <button type="button" id="pay-with-balance-btn" class="btn-balance">
                                Thanh toán bằng số dư
                            </button>
                            <?php else: ?>
                            <div class="balance-warning">⚠️ Thiếu <?php echo e(number_format($order->amount - $userBalance, 0, ',', '.')); ?> đ</div>
                            <a href="/deposit" class="btn-deposit">Nạp tiền</a>
                            <?php endif; ?>
                        </div>
                        <?php else: ?>
                        <div class="direct-pay">
                            <div class="direct-main">✅ Thanh toán qua QR</div>
                            <div class="direct-sub">Quét mã → Chuyển khoản → Tự động xác nhận</div>
                        </div>
                        <div class="login-hint">
                            <span>Hoặc</span>
                            <a href="/login?redirect=<?php echo e(urlencode(request()->fullUrl())); ?>">Đăng nhập</a>
                            <span>để dùng số dư</span>
                        </div>
                        <?php endif; ?>

                        <div id="status-checking" class="status-box">
                            <span id="status-icon">🔄</span>
                            <span id="status-text">Đang chờ thanh toán...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.checkout-wrapper {
    background: linear-gradient(180deg, #f8fafc 0%, #fff 100%);
    padding: 40px 20px;
    min-height: calc(100vh - 200px);
}
.checkout-container {
    max-width: 900px;
    margin: 0 auto;
}
.checkout-card {
    background: white;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 4px 24px rgba(0,0,0,0.08);
    border: 1px solid #e2e8f0;
}
.product-summary {
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    padding: 32px;
    color: white;
}
.product-summary h1 {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 20px;
    line-height: 1.5;
}
.price-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.price-label {
    opacity: 0.7;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.price-value {
    font-size: 32px;
    font-weight: 700;
    color: #fbbf24;
}
.price-value small {
    font-size: 18px;
    opacity: 0.8;
    color: white;
}
.tracking-badge {
    margin-top: 16px;
    padding: 8px 16px;
    background: rgba(255,255,255,0.1);
    border-radius: 8px;
    font-size: 14px;
}
.payment-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
    padding: 24px;
}
@media (max-width: 768px) {
    .payment-grid {
        grid-template-columns: 1fr;
    }
}
.qr-section {
    background: #f8fafc;
    border-radius: 16px;
    padding: 20px;
    border: 1px solid #e2e8f0;
}
.qr-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 12px;
    text-align: center;
    font-size: 14px;
}
.qr-wrapper {
    text-align: center;
    margin-bottom: 16px;
}
.qr-img {
    max-width: 200px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.bank-info {
    font-size: 13px;
}
.bank-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid #e5e7eb;
}
.bank-row:last-child {
    border-bottom: none;
}
.bank-row span:first-child {
    color: #6b7280;
}
.bank-row strong {
    color: #1f2937;
}
.bank-row .tracking-code {
    color: #6366f1;
}
.bank-row .amount {
    color: #10b981;
}
.payment-warning {
    margin-top: 12px;
    padding: 10px;
    background: #fef3c7;
    border-radius: 8px;
    font-size: 12px;
    color: #92400e;
    text-align: center;
}
.order-summary-box {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 20px;
}
.summary-header {
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 16px;
    font-size: 15px;
}
.summary-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #f1f5f9;
    font-size: 13px;
}
.summary-value {
    font-weight: 600;
    color: #1e293b;
}
.summary-total {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 0;
    margin-top: 8px;
    border-top: 2px solid #e2e8f0;
}
.total-amount {
    font-size: 20px;
    font-weight: 700;
    color: #10b981;
}
.summary-status {
    font-size: 13px;
    color: #64748b;
    margin-bottom: 16px;
}
.badge-pending {
    background: #fef3c7;
    color: #d97706;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 600;
}
.balance-section {
    background: #f0fdf4;
    border: 1px solid #86efac;
    border-radius: 10px;
    padding: 12px;
    margin-bottom: 12px;
}
.balance-row {
    display: flex;
    justify-content: space-between;
    font-size: 13px;
    margin-bottom: 10px;
}
.balance-amt {
    font-weight: 700;
    color: #16a34a;
}
.btn-balance {
    width: 100%;
    padding: 10px;
    background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
}
.balance-warning {
    font-size: 12px;
    color: #dc2626;
    margin-bottom: 8px;
}
.btn-deposit {
    display: block;
    width: 100%;
    padding: 10px;
    background: #2563eb;
    color: #fff;
    border-radius: 8px;
    text-align: center;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
}
.direct-pay {
    background: #ecfdf5;
    border: 1px solid #a7f3d0;
    border-radius: 10px;
    padding: 12px;
    margin-bottom: 12px;
    text-align: center;
}
.direct-main {
    font-weight: 700;
    color: #059669;
    font-size: 13px;
}
.direct-sub {
    font-size: 11px;
    color: #065f46;
    margin-top: 4px;
}
.login-hint {
    font-size: 12px;
    color: #64748b;
    text-align: center;
    margin-bottom: 12px;
}
.login-hint a {
    color: #2563eb;
    font-weight: 600;
    text-decoration: none;
}
.status-box {
    background: #dbeafe;
    border-radius: 8px;
    padding: 10px;
    font-size: 13px;
    text-align: center;
}
</style>

<script>
(function() {
    const trackingCode = '<?php echo e($order->tracking_code); ?>';
    let checkCount = 0;
    
    function checkPaymentStatus() {
        fetch('/api/check-payment?code=' + encodeURIComponent(trackingCode))
            .then(r => r.json())
            .then(data => {
                checkCount++;
                if (data.paid) {
                    document.getElementById('status-icon').textContent = '✅';
                    document.getElementById('status-text').textContent = 'Thanh toán thành công! Đang chuyển trang...';
                    document.getElementById('status-box').style.background = '#d1fae5';
                    setTimeout(() => {
                        window.location.href = '/order-success?code=' + encodeURIComponent(trackingCode);
                    }, 1500);
                } else if (checkCount < 200) {
                    setTimeout(checkPaymentStatus, 3000);
                } else {
                    document.getElementById('status-icon').textContent = '⏰';
                    document.getElementById('status-text').textContent = 'Hết thời gian tự động. Vui lòng kiểm tra lại sau khi thanh toán.';
                }
            })
            .catch(() => {
                if (checkCount < 200) setTimeout(checkPaymentStatus, 3000);
            });
    }
    
    setTimeout(checkPaymentStatus, 3000);
})();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dowload\thuetaikhoan\thuetaikhoan-laravel\resources\views/checkout-payment.blade.php ENDPATH**/ ?>