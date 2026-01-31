

<?php $__env->startSection('title', 'Sản phẩm ADY'); ?>
<?php $__env->startSection('page-title', 'Sản phẩm ADY Unlocker'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-card">
    <div class="admin-card-title">Danh sách sản phẩm ADY</div>
    
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Mã ADY</th>
                    <th>Giá gốc</th>
                    <th>Giá bán</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($product->id); ?></td>
                    <td style="font-weight: 600; color: #f1f5f9;"><?php echo e($product->name ?? 'N/A'); ?></td>
                    <td><?php echo e($product->ady_product_id ?? 'N/A'); ?></td>
                    <td><?php echo e(number_format($product->original_price ?? 0)); ?>đ</td>
                    <td style="color: #10b981; font-weight: 600;"><?php echo e(number_format($product->price ?? 0)); ?>đ</td>
                    <td>
                        <?php if($product->is_active ?? false): ?>
                            <span class="badge badge-active">Đang bán</span>
                        <?php else: ?>
                            <span class="badge badge-inactive">Tạm ẩn</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px; color: #64748b;">
                        <div style="font-size: 48px; margin-bottom: 12px;">📦</div>
                        <p>Chưa có sản phẩm ADY nào</p>
                        <p style="font-size: 12px;">Vui lòng cấu hình API ADY để đồng bộ sản phẩm</p>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <?php if($products->hasPages()): ?>
        <div class="pagination">
            <?php echo e($products->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dowload\thuetaikhoan\thuetaikhoan-laravel\resources\views/admin/ady/products.blade.php ENDPATH**/ ?>