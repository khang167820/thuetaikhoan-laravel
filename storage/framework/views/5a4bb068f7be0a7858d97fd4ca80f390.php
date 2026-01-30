

<?php $__env->startSection('title', 'Mã giảm giá - Coupon thuê UnlockTool, Vietmap, TSM Tool'); ?>
<?php $__env->startSection('meta_description', 'Danh sách mã giảm giá, coupon khuyến mãi khi thuê tài khoản UnlockTool, Vietmap Live, TSM Tool, Griffin. Tiết kiệm đến 50%.'); ?>

<?php $__env->startSection('styles'); ?>
<style>
/* Coupon Page Styles */
.coupon-wrap {
    max-width: 960px;
    margin: 40px auto;
    padding: 0 20px;
}
.coupon-header {
    text-align: center;
    margin-bottom: 30px;
}
.coupon-title {
    font-size: 28px;
    font-weight: 800;
    margin: 0 0 10px;
    color: #0f172a;
}
.coupon-sub {
    color: #475569;
    font-size: 15px;
    margin: 0;
}
.coupon-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 16px;
    margin-top: 20px;
}
.coupon-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 6px 14px rgba(15,23,42,.05);
    display: flex;
    flex-direction: column;
    gap: 12px;
    transition: all 0.2s;
}
.coupon-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(15,23,42,.1);
}
.coupon-code {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 14px;
    border-radius: 12px;
    background: linear-gradient(135deg, #eef3ff 0%, #f0f4ff 100%);
    color: #1d4ed8;
    font-weight: 800;
    font-size: 16px;
    width: max-content;
    cursor: pointer;
    border: 2px dashed #1d4ed8;
    transition: all 0.2s;
}
.coupon-code:hover {
    background: #1d4ed8;
    color: #fff;
}
.coupon-code-text { font-family: monospace; letter-spacing: 1px; }
.coupon-code svg { flex-shrink: 0; }
.coupon-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    font-size: 13px;
    color: #475569;
}
.pill {
    padding: 6px 12px;
    border-radius: 10px;
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    font-weight: 600;
}
.pill.green { background: #ecfdf3; border-color: #bbf7d0; color: #15803d; }
.pill.orange { background: #fff7ed; border-color: #fed7aa; color: #c2410c; }
.pill.blue { background: #eef3ff; border-color: #d7e1ff; color: #1d4ed8; }
.pill.red { background: #fef2f2; border-color: #fecaca; color: #dc2626; }
.coupon-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 12px;
    color: #64748b;
    padding-top: 10px;
    border-top: 1px solid #f1f5f9;
}
.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #6b7280;
}
.empty-icon {
    font-size: 48px;
    margin-bottom: 15px;
}
.empty-title {
    font-size: 18px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
}
.empty-desc {
    color: #6b7280;
}
.coupon-tip {
    background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
    border: 1px solid #bae6fd;
    border-radius: 12px;
    padding: 16px 20px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 12px;
}
.coupon-tip-icon {
    font-size: 24px;
}
.coupon-tip-text {
    font-size: 14px;
    color: #0369a1;
}

/* Dark Mode */
[data-theme="dark"] .coupon-title { color: var(--ink); }
[data-theme="dark"] .coupon-sub { color: var(--muted); }
[data-theme="dark"] .coupon-card { background: var(--bg-card); border-color: #334155; }
[data-theme="dark"] .coupon-code { background: linear-gradient(135deg, #1e3a5f 0%, #1e293b 100%); color: #60a5fa; border-color: #60a5fa; }
[data-theme="dark"] .coupon-code:hover { background: #60a5fa; color: #0f172a; }
[data-theme="dark"] .coupon-footer { border-color: #334155; color: var(--muted); }
[data-theme="dark"] .coupon-tip { background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border-color: #334155; }
[data-theme="dark"] .coupon-tip-text { color: #60a5fa; }

@media(max-width: 640px) {
    .coupon-card { padding: 16px; }
    .coupon-title { font-size: 24px; }
}
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="coupon-wrap">
    <div class="coupon-header">
        <h1 class="coupon-title">🎁 Mã giảm giá</h1>
        <p class="coupon-sub">Danh sách coupon đang hoạt động. Nhập mã ở bước thanh toán để được giảm giá.</p>
    </div>

    <div class="coupon-tip">
        <span class="coupon-tip-icon">💡</span>
        <span class="coupon-tip-text">
            <strong>Mẹo:</strong> Click vào mã để copy. Sau đó dán mã vào ô "Mã giảm giá" khi chọn gói thuê.
        </span>
    </div>

    <?php if(count($coupons) === 0): ?>
    <div class="empty-state">
        <div class="empty-icon">🎫</div>
        <div class="empty-title">Hiện chưa có mã giảm giá nào</div>
        <div class="empty-desc">Hãy quay lại sau để nhận ưu đãi nhé!</div>
    </div>
    <?php else: ?>
    <div class="coupon-grid">
        <?php $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $isPercent = ($coupon->discount_type === 'percent');
            $valueText = $isPercent 
                ? ('Giảm ' . (int)$coupon->discount_value . '%') 
                : ('Giảm ' . number_format((int)$coupon->discount_value) . 'đ');
            $minText = ((int)$coupon->min_order_amount > 0) 
                ? 'ĐH tối thiểu ' . number_format((int)$coupon->min_order_amount) . 'đ' 
                : 'Không yêu cầu tối thiểu';
            $used = (int)$coupon->used_count;
            $max = (int)$coupon->max_uses;
            $limitText = ($max > 0) ? ($used . '/' . $max . ' lượt dùng') : 'Không giới hạn';
            $expText = $coupon->expires_at 
                ? ('HSD: ' . \Carbon\Carbon::parse($coupon->expires_at)->format('d/m/Y H:i')) 
                : 'Không giới hạn thời gian';
        ?>
        <div class="coupon-card">
            <div class="coupon-code" onclick="copyCode('<?php echo e($coupon->code); ?>')" title="Click để copy mã">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                </svg>
                <span class="coupon-code-text"><?php echo e($coupon->code); ?></span>
            </div>
            <div class="coupon-meta">
                <span class="pill green"><?php echo e($valueText); ?></span>
                <span class="pill orange"><?php echo e($minText); ?></span>
                <span class="pill blue"><?php echo e($limitText); ?></span>
            </div>
            <div class="coupon-footer">
                <span><?php echo e($expText); ?></span>
                <span>📌 Dùng ở bước thanh toán</span>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
function copyCode(code) {
    navigator.clipboard.writeText(code).then(() => {
        // Show toast notification
        const toast = document.createElement('div');
        toast.innerHTML = '✅ Đã copy mã: <strong>' + code + '</strong>';
        toast.style.cssText = 'position:fixed;bottom:20px;left:50%;transform:translateX(-50%);background:#10b981;color:#fff;padding:12px 24px;border-radius:12px;font-size:14px;font-weight:500;z-index:9999;box-shadow:0 4px 12px rgba(0,0,0,0.15);animation:slideUp 0.3s ease;';
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 2000);
    });
}
</script>
<style>
@keyframes slideUp {
    from { opacity: 0; transform: translateX(-50%) translateY(20px); }
    to { opacity: 1; transform: translateX(-50%) translateY(0); }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dowload\thuetaikhoan\thuetaikhoan-laravel\resources\views/pages/coupons.blade.php ENDPATH**/ ?>