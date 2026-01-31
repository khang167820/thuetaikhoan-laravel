

<?php $__env->startSection('title', 'Thanh toán - ' . ($price->type ?? 'Dịch vụ')); ?>

<?php $__env->startSection('content'); ?>
<div class="checkout-wrapper">
    <div class="checkout-container">
        <a href="javascript:history.back()" class="back-link">← Quay lại</a>
        
        <div class="checkout-card">
            
            <div class="product-summary">
                <h1><?php echo e($price->type ?? 'Dịch vụ'); ?> - <?php echo e($price->hours_label); ?></h1>
                <div class="price-row">
                    <div>
                        <div class="price-label">Giá dịch vụ</div>
                    </div>
                    <div class="price-value"><?php echo e(number_format($price->price, 0, ',', '.')); ?><small>đ</small></div>
                </div>
                <?php if($price->has_discount): ?>
                <div class="original-price">
                    Giá gốc: <del><?php echo e(number_format($price->original_price, 0, ',', '.')); ?>đ</del>
                    <span class="discount-badge">-<?php echo e($price->discount_percent); ?>%</span>
                </div>
                <?php endif; ?>
            </div>

            
            <form method="POST" action="<?php echo e(route('checkout.create')); ?>" class="checkout-form">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="price_id" value="<?php echo e($price->id); ?>">
                
                <?php if($errors->any()): ?>
                <div class="error-box">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo e($error); ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

                <div class="form-group">
                    <label class="form-label">Email nhận tài khoản <span class="optional">(tùy chọn)</span></label>
                    <input type="email" name="customer_email" class="form-input" 
                           placeholder="email@example.com" value="<?php echo e(old('customer_email')); ?>">
                    <small class="form-hint">Nhập email để nhận thông tin tài khoản sau khi thanh toán</small>
                </div>

                <button type="submit" class="btn-submit">
                    💳 Tạo đơn & Thanh toán <?php echo e(number_format($price->price, 0, ',', '.')); ?>đ
                </button>
            </form>
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
    max-width: 500px;
    margin: 0 auto;
}
.back-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 24px;
    color: #6366f1;
    text-decoration: none;
    padding: 10px 20px;
    background: white;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 500;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    transition: all 0.2s;
}
.back-link:hover {
    background: #6366f1;
    color: white;
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
    color: #10b981;
}
.price-value small {
    font-size: 18px;
    opacity: 0.8;
    color: white;
}
.original-price {
    margin-top: 12px;
    font-size: 14px;
    opacity: 0.7;
}
.original-price del {
    margin-right: 8px;
}
.discount-badge {
    background: #ef4444;
    color: white;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
}
.checkout-form {
    padding: 32px;
}
.form-group {
    margin-bottom: 24px;
}
.form-label {
    display: block;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 10px;
    font-size: 14px;
}
.form-label .optional {
    font-weight: 400;
    color: #94a3b8;
}
.form-input {
    width: 100%;
    padding: 14px 18px;
    border: 2px solid #e2e8f0;
    border-radius: 14px;
    font-size: 15px;
    transition: all 0.2s;
    background: #f8fafc;
}
.form-input:focus {
    outline: none;
    border-color: #6366f1;
    background: white;
    box-shadow: 0 0 0 4px rgba(99,102,241,0.1);
}
.form-hint {
    display: block;
    margin-top: 8px;
    color: #94a3b8;
    font-size: 12px;
}
.error-box {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #dc2626;
    padding: 16px;
    border-radius: 14px;
    margin-bottom: 24px;
    font-size: 14px;
}
.btn-submit {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 18px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    border: none;
    border-radius: 14px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    box-shadow: 0 4px 14px rgba(16,185,129,0.3);
}
.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(16,185,129,0.4);
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dowload\thuetaikhoan\thuetaikhoan-laravel\resources\views/checkout.blade.php ENDPATH**/ ?>