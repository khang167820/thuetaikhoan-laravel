

<?php $__env->startSection('title', 'Thuê ' . $service['name'] . ' - Giá Rẻ Từ ' . number_format($info['min']) . ' VND'); ?>

<?php $__env->startSection('service_color', $service['color']); ?>

<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="/css/service-page.css">
<style>
/* Dark Mode for Service Page */
[data-theme="dark"] h1, [data-theme="dark"] .service-section-title { color: var(--ink) !important; }
[data-theme="dark"] .fo-card { background: var(--bg-card); border-color: #475569; }
[data-theme="dark"] .fo-title { color: var(--ink); }
[data-theme="dark"] .fo-subline { color: var(--muted); }
[data-theme="dark"] .package-card { background: var(--bg-card); border-color: #475569; }
[data-theme="dark"] .package-duration { color: var(--ink); }
[data-theme="dark"] .package-price { color: var(--primary); }
[data-theme="dark"] .features-card { background: var(--bg-card); border-color: #334155; }
[data-theme="dark"] .features-title { color: var(--ink); }
[data-theme="dark"] .features-desc { color: var(--muted); }
[data-theme="dark"] .tool-ad-container { background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border-color: #334155; }
[data-theme="dark"] .faq-item { background: var(--bg-card); border-color: #334155; }
[data-theme="dark"] .faq-question { color: var(--ink); }
[data-theme="dark"] .faq-answer { color: var(--muted); }
[data-theme="dark"] .service-section { background: var(--bg); }
[data-theme="dark"] p { color: var(--muted); }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div style="max-width: 1200px; margin: 40px auto; padding: 0 20px;">
    <div style="text-align: center; margin-bottom: 30px;">
        <h1 style="font-size: 28px; font-weight: 700; color: #1e293b; margin-bottom: 10px;">Thuê nhanh <?php echo e($service['name']); ?></h1>
        <p style="color: #64748b; font-size: 16px;">Sau khi thanh toán, chỉ cần quay lại trang thanh toán — hệ thống sẽ tự chuyển bạn đến trang nhận tài khoản.</p>
    </div>
    
    <div style="display: flex; justify-content: center;">
        <article class="fo-card" style="max-width: 400px; width: 100%;">
            <div class="fo-ribbon">Flash Sale</div>
            <a class="fo-coupon-pill" href="/ma-giam-gia">Mã giảm giá</a>

            <div class="fo-logo-wrap">
                <div class="fo-logo-circle">
                    <img src="<?php echo e($service['logo']); ?>" alt="<?php echo e($service['name']); ?>">
                </div>
            </div>

            <div class="fo-title"><?php echo e($service['name']); ?></div>
            <div class="fo-subline"><?php echo e($service['description']); ?></div>

            <?php
                $hasDiscount = $info['discMax'] > 0;
            ?>

            <?php if($hasDiscount): ?>
            <div class="fo-event">
                <div class="fo-event-line1">% Đang giảm giá đến <?php echo e($info['discMax']); ?>%</div>
                <div class="fo-event-line2">Sự kiện Flash Sale: Khung giờ vàng</div>
            </div>
            <?php endif; ?>

            <ul class="fo-features">
                <?php $__currentLoopData = $service['features']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <span class="fo-dot <?php echo e($feature['dot']); ?>"></span>
                    <span class="fo-feature-text"><?php echo e($feature['text']); ?></span>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>

            <div class="fo-divider"></div>

            <div class="fo-price-row">
                <div class="fo-price-left">
                    <div class="fo-price-label">Từ</div>
                    <div class="fo-price-main">
                        <span class="fo-price-from"><?php echo e(number_format($info['min'])); ?> VND</span>
                        <?php if($hasDiscount): ?>
                        <span class="fo-price-badge">-<?php echo e($info['discMax']); ?>%</span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="fo-price-right">
                    <span class="fo-package-pill"><?php echo e($info['count']); ?> gói thuê</span>
                </div>
            </div>

            <?php if($info['available']): ?>
            <button class="fo-bottom-btn" type="button" onclick="openPackageModal()">
                <span>🛒</span>
                <span>Flash Sale</span>
            </button>
            <?php else: ?>
            <button class="fo-bottom-btn fo-bottom-btn--disabled" type="button" disabled>
                <span>Hết tài khoản</span>
            </button>
            <?php endif; ?>
        </article>
    </div>
</div>


<section class="service-section" id="packages">
    <h2 class="service-section-title">Các Gói Thuê <?php echo e(strtoupper($service['name'])); ?></h2>
    
    <div class="packages-grid">
        <?php $__currentLoopData = $info['packages']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pkg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $pkgPrice = (int)$pkg->price;
            $pkgOld = (int)($pkg->original_price ?? $pkgPrice);
            $pkgDisc = $pkg->discount_percent ?? 0;
        ?>
        <div class="package-card">
            <?php if($pkgDisc > 0): ?>
            <div class="package-badge">Giảm <?php echo e($pkgDisc); ?>%</div>
            <?php endif; ?>
            
            <div class="package-duration"><?php echo e($service['name']); ?> <?php echo e($pkg->hours_label); ?></div>
            
            <div class="package-price">
                <?php echo e(number_format($pkgPrice)); ?> VND
                <?php if($pkgOld > $pkgPrice): ?>
                <span class="package-price-old"><?php echo e(number_format($pkgOld)); ?> VND</span>
                <?php endif; ?>
            </div>
            
            <ul class="package-features">
                <li>Truy cập đầy đủ tính năng</li>
                <li>Tự động nhận tài khoản sau thanh toán</li>
                <li>Bảo hành trong thời gian thuê</li>
            </ul>
            
            <?php if($info['available']): ?>
            <button class="package-btn" onclick="selectPackage(<?php echo e($pkg->id); ?>)">Thuê ngay</button>
            <?php else: ?>
            <button class="package-btn package-btn--disabled" disabled>Hết tài khoản</button>
            <?php endif; ?>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    
    <div style="text-align: center; margin-top: 40px;">
        <a href="/ma-giam-gia" style="color: <?php echo e($service['color']); ?>; text-decoration: none; font-weight: 600;">
            🎁 Áp dụng mã giảm giá để tiết kiệm thêm
        </a>
    </div>
</section>


<?php
    $whyChoose = $service['whyChoose'] ?? [];
?>
<?php if(count($whyChoose) > 0): ?>
<section class="service-section" style="background: #f8fafc; padding: 60px 20px;">
    <div style="max-width: 1200px; margin: 0 auto;">
        <h2 class="service-section-title">Tại sao chọn <?php echo e($service['name']); ?>?</h2>
        <div class="features-grid">
            <?php $__currentLoopData = $whyChoose; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="feature-item">
                <div class="feature-icon"><?php echo e($feature['icon']); ?></div>
                <div class="feature-title"><?php echo e($feature['title']); ?></div>
                <div class="feature-desc"><?php echo e($feature['desc']); ?></div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>


<?php
    $faqList = $service['faq'] ?? [];
?>
<?php if(count($faqList) > 0): ?>
<section class="service-section">
    <h2 class="service-section-title">Câu hỏi thường gặp (FAQ)</h2>
    <div style="max-width: 800px; margin: 0 auto;">
        <?php $__currentLoopData = $faqList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <details style="background: #f8fafc; padding: 20px; margin-bottom: 16px; border-radius: 12px; cursor: pointer;">
            <summary style="font-weight: 600; font-size: 18px; color: #1e293b;"><?php echo e($faq['q']); ?></summary>
            <p style="margin-top: 12px; color: #64748b; line-height: 1.8;"><?php echo e($faq['a']); ?></p>
        </details>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</section>
<?php endif; ?>


<div class="pkg-modal-overlay" id="pkg-modal">
    <div class="pkg-modal">
        <div class="pkg-modal-header">
            <div>
                <div class="pkg-modal-title">Chọn gói thuê</div>
                <div class="pkg-modal-sub">Chọn gói thuê cho: <strong><?php echo e(strtoupper($service['name'])); ?></strong></div>
            </div>
            <button class="pkg-modal-close" onclick="closePackageModal()">&times;</button>
        </div>
        
        <div class="pkg-modal-body">
            <div class="pkg-options">
                <?php $__currentLoopData = $info['packages']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $pkg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <label class="pkg-item">
                    <input type="radio" name="package_select" value="<?php echo e($pkg->id); ?>"<?php echo e($idx === 0 ? ' checked' : ''); ?>>
                    <div style="flex:1;padding:12px;border:1px solid #e5e7eb;border-radius:10px;background:#fff;">
                        <div style="font-weight:600;color:#1e293b;"><?php echo e($service['name']); ?> <?php echo e($pkg->hours_label); ?></div>
                        <div style="margin-top:8px;font-size:18px;font-weight:800;color:<?php echo e($service['color']); ?>;">
                            <?php echo e(number_format($pkg->price)); ?> VND
                        </div>
                    </div>
                </label>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
            <div class="pkg-coupon">
                <div class="pkg-voucher-box" style="display: block;">
                    <div class="pkg-voucher-row">
                        <input type="text" class="pkg-voucher-input" id="voucher-code" placeholder="Nhập mã giảm giá">
                        <button type="button" class="pkg-voucher-btn" onclick="applyVoucher()">Áp dụng</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div style="padding: 12px 16px; border-top: 1px solid #e5e7eb; display: flex; gap: 10px;">
            <button style="flex:1;padding:12px;border:1px solid #e5e7eb;background:#fff;border-radius:10px;font-weight:600;cursor:pointer;" onclick="closePackageModal()">Hủy</button>
            <button style="flex:1;padding:12px;border:none;background:<?php echo e($service['color']); ?>;color:#fff;border-radius:10px;font-weight:600;cursor:pointer;" onclick="confirmPackage()">Xác nhận thuê</button>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
const SERVICE_TYPE = '<?php echo e($type); ?>';

function openPackageModal() {
    document.getElementById('pkg-modal').classList.add('active');
    document.body.classList.add('modal-open');
}

function closePackageModal() {
    document.getElementById('pkg-modal').classList.remove('active');
    document.body.classList.remove('modal-open');
}

function selectPackage(id) {
    document.querySelector('input[value="'+id+'"]').checked = true;
    openPackageModal();
}

function applyVoucher() {
    const code = document.getElementById('voucher-code').value.trim();
    if (!code) {
        alert('Vui lòng nhập mã giảm giá.');
        return;
    }
    alert('Mã giảm giá sẽ được áp dụng tại bước thanh toán.');
}

function confirmPackage() {
    const selected = document.querySelector('input[name="package_select"]:checked');
    if (!selected) {
        alert('Vui lòng chọn một gói thuê.');
        return;
    }
    
    const priceId = selected.value;
    const voucher = document.getElementById('voucher-code').value.trim();
    
    let url = '/thanh-toan?price_id=' + priceId + '&service=' + SERVICE_TYPE;
    if (voucher) url += '&coupon=' + encodeURIComponent(voucher);
    
    window.location.href = url;
}

document.getElementById('pkg-modal').addEventListener('click', function(e) {
    if (e.target === this) closePackageModal();
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closePackageModal();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dowload\thuetaikhoan\thuetaikhoan-laravel\resources\views/services/show.blade.php ENDPATH**/ ?>