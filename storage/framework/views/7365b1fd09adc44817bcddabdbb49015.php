

<?php $__env->startSection('title', 'Quản lý mã giảm giá'); ?>
<?php $__env->startSection('page-title', 'Quản lý mã giảm giá'); ?>

<?php $__env->startSection('content'); ?>
<!-- Actions -->
<div class="filter-bar">
    <button class="btn btn-primary" onclick="openCreateCoupon()">+ Tạo mã mới</button>
    
    <form action="<?php echo e(route('admin.coupons')); ?>" method="GET" style="display: flex; gap: 12px; margin-left: auto;">
        <select name="status" class="form-select" style="width: 140px;" onchange="this.form.submit()">
            <option value="">Tất cả</option>
            <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>>Active</option>
            <option value="inactive" <?php echo e(request('status') === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
        </select>
    </form>
</div>

<!-- Coupons Table -->
<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Mã</th>
                <th>Loại</th>
                <th>Giá trị</th>
                <th>Giới hạn</th>
                <th>Trạng thái</th>
                <th>Hết hạn</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td>#<?php echo e($coupon->id); ?></td>
                <td><strong style="color: #3b82f6;"><?php echo e($coupon->code); ?></strong></td>
                <td>
                    <?php if($coupon->discount_type === 'percent'): ?>
                        <span class="badge badge-paid">Phần trăm</span>
                    <?php else: ?>
                        <span class="badge" style="background: #ecfdf5; color: #059669;">Cố định</span>
                    <?php endif; ?>
                </td>
                <td style="font-weight: 600;">
                    <?php if($coupon->discount_type === 'percent'): ?>
                        <?php echo e($coupon->discount_value); ?>%
                    <?php else: ?>
                        <?php echo e(number_format($coupon->discount_value, 0, ',', '.')); ?>đ
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($coupon->max_discount_amount): ?>
                        Tối đa <?php echo e(number_format($coupon->max_discount_amount, 0, ',', '.')); ?>đ
                    <?php else: ?>
                        Không giới hạn
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($coupon->is_active): ?>
                        <span class="badge badge-active">Active</span>
                    <?php else: ?>
                        <span class="badge badge-inactive">Inactive</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($coupon->expires_at): ?>
                        <?php echo e($coupon->expires_at->format('d/m/Y')); ?>

                    <?php else: ?>
                        Vĩnh viễn
                    <?php endif; ?>
                </td>
                <td style="display: flex; gap: 8px;">
                    <form action="<?php echo e(route('admin.coupons.toggle', $coupon->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-sm <?php echo e($coupon->is_active ? 'btn-danger' : 'btn-success'); ?>">
                            <?php echo e($coupon->is_active ? 'Tắt' : 'Bật'); ?>

                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="8" style="text-align: center; color: #64748b; padding: 40px;">
                    Chưa có mã giảm giá nào
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Pagination -->
<?php if($coupons->hasPages()): ?>
<div class="pagination">
    <?php echo e($coupons->links()); ?>

</div>
<?php endif; ?>

<!-- Create Coupon Modal -->
<div id="createCouponModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.7); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: #1e293b; border-radius: 16px; padding: 24px; width: 450px; max-width: 90%;">
        <h3 style="margin-bottom: 20px; font-size: 16px;">🎫 Tạo mã giảm giá mới</h3>
        <form action="<?php echo e(route('admin.coupons.save')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label class="form-label">Mã code</label>
                <input type="text" name="code" class="form-input" placeholder="VD: GIAM50K" required style="text-transform: uppercase;">
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label">Loại giảm</label>
                    <select name="discount_type" class="form-select" required>
                        <option value="fixed">Cố định (VND)</option>
                        <option value="percent">Phần trăm (%)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Giá trị</label>
                    <input type="number" name="discount_value" class="form-input" placeholder="5000 hoặc 10" required>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Giảm tối đa (VND) - Để trống = không giới hạn</label>
                <input type="number" name="max_discount_amount" class="form-input" placeholder="50000">
            </div>
            <div class="form-group">
                <label class="form-label">Ngày hết hạn - Để trống = vĩnh viễn</label>
                <input type="date" name="expires_at" class="form-input">
            </div>
            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <input type="checkbox" name="is_active" value="1" checked style="width: 18px; height: 18px;">
                    <span class="form-label" style="margin: 0;">Kích hoạt ngay</span>
                </label>
            </div>
            <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 20px;">
                <button type="button" class="btn btn-secondary" onclick="closeCreateCoupon()">Hủy</button>
                <button type="submit" class="btn btn-primary">Tạo mã</button>
            </div>
        </form>
    </div>
</div>

<script>
function openCreateCoupon() {
    document.getElementById('createCouponModal').style.display = 'flex';
}

function closeCreateCoupon() {
    document.getElementById('createCouponModal').style.display = 'none';
}

document.getElementById('createCouponModal').addEventListener('click', function(e) {
    if (e.target === this) closeCreateCoupon();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dowload\thuetaikhoan\thuetaikhoan-laravel\resources\views/admin/coupons/index.blade.php ENDPATH**/ ?>