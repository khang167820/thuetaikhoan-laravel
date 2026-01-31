

<?php $__env->startSection('title', 'Đơn thiếu tiền'); ?>
<?php $__env->startSection('page-title', 'Đơn hàng thiếu tiền'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-card">
    <div class="admin-card-title">Danh sách đơn hàng có vấn đề</div>
    <p style="color: #64748b; font-size: 13px; margin-bottom: 16px;">
        Các đơn hàng chưa thanh toán đủ hoặc cần xử lý đặc biệt
    </p>
    
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Mã đơn</th>
                    <th>User</th>
                    <th>Gói thuê</th>
                    <th>Số tiền</th>
                    <th>Ghi chú</th>
                    <th>Ngày tạo</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <span style="font-family: monospace; color: #3b82f6;"><?php echo e($order->tracking_code ?? 'N/A'); ?></span>
                    </td>
                    <td><?php echo e($order->user_id ?? 'Khách'); ?></td>
                    <td><?php echo e($order->price_id ?? 'N/A'); ?></td>
                    <td style="color: #f59e0b; font-weight: 600;"><?php echo e(number_format($order->amount ?? 0)); ?>đ</td>
                    <td style="font-size: 12px; max-width: 200px; color: #94a3b8;">
                        <?php echo e($order->notes ?? '—'); ?>

                    </td>
                    <td style="font-size: 12px;"><?php echo e(\Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i')); ?></td>
                    <td>
                        <a href="<?php echo e(route('admin.orders')); ?>?search=<?php echo e($order->tracking_code); ?>" class="btn btn-sm btn-secondary">
                            Xem chi tiết
                        </a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px; color: #64748b;">
                        <div style="font-size: 48px; margin-bottom: 12px;">✅</div>
                        <p>Không có đơn thiếu tiền</p>
                        <p style="font-size: 12px;">Tất cả đơn hàng đều ổn!</p>
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

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dowload\thuetaikhoan\thuetaikhoan-laravel\resources\views/admin/underpaid/index.blade.php ENDPATH**/ ?>