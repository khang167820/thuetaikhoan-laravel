

<?php $__env->startSection('title', 'Đơn ADY'); ?>
<?php $__env->startSection('page-title', 'Đơn hàng ADY Unlocker'); ?>

<?php $__env->startSection('content'); ?>
<!-- Filter -->
<div class="filter-bar">
    <select class="form-select" onchange="window.location.href='<?php echo e(route('admin.ady.orders')); ?>?status=' + this.value">
        <option value="">Tất cả trạng thái</option>
        <option value="pending" <?php echo e(request('status') === 'pending' ? 'selected' : ''); ?>>Chờ xử lý</option>
        <option value="processing" <?php echo e(request('status') === 'processing' ? 'selected' : ''); ?>>Đang xử lý</option>
        <option value="completed" <?php echo e(request('status') === 'completed' ? 'selected' : ''); ?>>Hoàn thành</option>
        <option value="failed" <?php echo e(request('status') === 'failed' ? 'selected' : ''); ?>>Thất bại</option>
    </select>
</div>

<div class="admin-card">
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>IMEI/SN</th>
                    <th>Sản phẩm</th>
                    <th>Giá</th>
                    <th>Trạng thái</th>
                    <th>Kết quả</th>
                    <th>Ngày tạo</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($order->id); ?></td>
                    <td style="font-family: monospace; color: #3b82f6;"><?php echo e($order->imei ?? 'N/A'); ?></td>
                    <td><?php echo e($order->product_name ?? 'N/A'); ?></td>
                    <td style="color: #10b981; font-weight: 600;"><?php echo e(number_format($order->price ?? 0)); ?>đ</td>
                    <td>
                        <?php
                            $statusClass = match($order->status ?? 'pending') {
                                'completed' => 'badge-completed',
                                'processing' => 'badge-paid',
                                'failed' => 'badge-cancelled',
                                default => 'badge-pending'
                            };
                        ?>
                        <span class="badge <?php echo e($statusClass); ?>"><?php echo e(ucfirst($order->status ?? 'pending')); ?></span>
                    </td>
                    <td style="font-size: 12px; max-width: 200px; overflow: hidden; text-overflow: ellipsis;">
                        <?php echo e($order->result ?? '—'); ?>

                    </td>
                    <td style="font-size: 12px;"><?php echo e(\Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i')); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px; color: #64748b;">
                        <div style="font-size: 48px; margin-bottom: 12px;">📋</div>
                        <p>Chưa có đơn ADY nào</p>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <?php if($orders->hasPages()): ?>
        <div class="pagination">
            <?php echo e($orders->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dowload\thuetaikhoan\thuetaikhoan-laravel\resources\views/admin/ady/orders.blade.php ENDPATH**/ ?>