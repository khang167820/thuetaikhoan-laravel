

<?php $__env->startSection('title', 'Quản lý đơn hàng'); ?>
<?php $__env->startSection('page-title', 'Quản lý đơn hàng'); ?>

<?php $__env->startSection('content'); ?>
<!-- Filter Bar -->
<div class="filter-bar">
    <form action="<?php echo e(route('admin.orders')); ?>" method="GET" style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
        <input type="text" name="search" class="form-input" placeholder="Tìm mã đơn..." value="<?php echo e(request('search')); ?>" style="width: 200px;">
        
        <select name="status" class="form-select" style="width: 160px;">
            <option value="">Tất cả trạng thái</option>
            <option value="pending" <?php echo e(request('status') === 'pending' ? 'selected' : ''); ?>>Chờ thanh toán (<?php echo e($statusCounts['pending'] ?? 0); ?>)</option>
            <option value="paid" <?php echo e(request('status') === 'paid' ? 'selected' : ''); ?>>Đã thanh toán (<?php echo e($statusCounts['paid'] ?? 0); ?>)</option>
            <option value="completed" <?php echo e(request('status') === 'completed' ? 'selected' : ''); ?>>Hoàn thành (<?php echo e($statusCounts['completed'] ?? 0); ?>)</option>
            <option value="cancelled" <?php echo e(request('status') === 'cancelled' ? 'selected' : ''); ?>>Đã hủy (<?php echo e($statusCounts['cancelled'] ?? 0); ?>)</option>
        </select>
        
        <button type="submit" class="btn btn-primary">Lọc</button>
        <a href="<?php echo e(route('admin.orders')); ?>" class="btn btn-secondary">Reset</a>
    </form>
</div>

<!-- Orders Table -->
<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Mã đơn</th>
                <th>Dịch vụ</th>
                <th>Thời gian</th>
                <th>Số tiền</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td>#<?php echo e($order->id); ?></td>
                <td><strong><?php echo e($order->tracking_code); ?></strong></td>
                <td><?php echo e($order->service_type ?? 'N/A'); ?></td>
                <td><?php echo e($order->hours); ?> giờ</td>
                <td style="color: #10b981; font-weight: 600;"><?php echo e(number_format($order->amount, 0, ',', '.')); ?>đ</td>
                <td>
                    <?php if($order->status === 'pending'): ?>
                        <span class="badge badge-pending">Chờ TT</span>
                    <?php elseif($order->status === 'paid'): ?>
                        <span class="badge badge-paid">Đã TT</span>
                    <?php elseif($order->status === 'completed'): ?>
                        <span class="badge badge-completed">Hoàn thành</span>
                    <?php else: ?>
                        <span class="badge badge-cancelled"><?php echo e($order->status); ?></span>
                    <?php endif; ?>
                </td>
                <td><?php echo e($order->created_at ? $order->created_at->format('d/m/Y H:i') : 'N/A'); ?></td>
                <td>
                    <form action="<?php echo e(route('admin.orders.status', $order->id)); ?>" method="POST" style="display: inline;">
                        <?php echo csrf_field(); ?>
                        <select name="status" class="form-select" style="width: 120px; font-size: 11px; padding: 4px 8px;" onchange="this.form.submit()">
                            <option value="pending" <?php echo e($order->status === 'pending' ? 'selected' : ''); ?>>Chờ TT</option>
                            <option value="paid" <?php echo e($order->status === 'paid' ? 'selected' : ''); ?>>Đã TT</option>
                            <option value="completed" <?php echo e($order->status === 'completed' ? 'selected' : ''); ?>>Hoàn thành</option>
                            <option value="cancelled" <?php echo e($order->status === 'cancelled' ? 'selected' : ''); ?>>Đã hủy</option>
                        </select>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="8" style="text-align: center; color: #64748b; padding: 40px;">
                    Không có đơn hàng nào
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Pagination -->
<?php if($orders->hasPages()): ?>
<div class="pagination">
    <?php echo e($orders->links()); ?>

</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dowload\thuetaikhoan\thuetaikhoan-laravel\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>