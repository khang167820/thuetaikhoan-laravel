

<?php $__env->startSection('title', 'Nhật ký Hoạt động'); ?>
<?php $__env->startSection('page-title', 'Nhật ký Hoạt động'); ?>

<?php $__env->startSection('content'); ?>
<!-- Filter -->
<div class="filter-bar" style="margin-bottom: 20px;">
    <form style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
        <select name="action" class="form-select" onchange="this.form.submit()">
            <option value="">Tất cả hành động</option>
            <option value="login" <?php echo e(request('action') === 'login' ? 'selected' : ''); ?>>Đăng nhập</option>
            <option value="order" <?php echo e(request('action') === 'order' ? 'selected' : ''); ?>>Đơn hàng</option>
            <option value="account" <?php echo e(request('action') === 'account' ? 'selected' : ''); ?>>Tài khoản</option>
            <option value="settings" <?php echo e(request('action') === 'settings' ? 'selected' : ''); ?>>Cài đặt</option>
        </select>
        <select name="days" class="form-select" onchange="this.form.submit()">
            <option value="7" <?php echo e(request('days', '7') === '7' ? 'selected' : ''); ?>>7 ngày qua</option>
            <option value="30" <?php echo e(request('days') === '30' ? 'selected' : ''); ?>>30 ngày qua</option>
            <option value="90" <?php echo e(request('days') === '90' ? 'selected' : ''); ?>>90 ngày qua</option>
        </select>
    </form>
</div>

<!-- Logs Table -->
<div class="admin-card">
    <div class="admin-card-title">📝 Lịch sử Hoạt động</div>
    
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Thời gian</th>
                    <th>Admin</th>
                    <th>Hành động</th>
                    <th>Chi tiết</th>
                    <th>IP</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td style="font-size: 12px; white-space: nowrap;">
                        <?php echo e(\Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i:s')); ?>

                    </td>
                    <td>
                        <span style="font-weight: 600;"><?php echo e($log->admin_name ?? 'System'); ?></span>
                    </td>
                    <td>
                        <?php switch($log->action ?? ''):
                            case ('login'): ?>
                                <span class="badge badge-paid">🔑 Đăng nhập</span>
                                <?php break; ?>
                            <?php case ('logout'): ?>
                                <span class="badge badge-inactive">🚪 Đăng xuất</span>
                                <?php break; ?>
                            <?php case ('order_update'): ?>
                                <span class="badge badge-pending">📦 Cập nhật đơn</span>
                                <?php break; ?>
                            <?php case ('account_add'): ?>
                                <span class="badge badge-completed">➕ Thêm TK</span>
                                <?php break; ?>
                            <?php case ('account_delete'): ?>
                                <span class="badge badge-cancelled">🗑️ Xóa TK</span>
                                <?php break; ?>
                            <?php case ('settings_update'): ?>
                                <span class="badge badge-active">⚙️ Cài đặt</span>
                                <?php break; ?>
                            <?php default: ?>
                                <span class="badge badge-secondary"><?php echo e($log->action ?? 'N/A'); ?></span>
                        <?php endswitch; ?>
                    </td>
                    <td style="max-width: 300px; font-size: 12px; color: #94a3b8;">
                        <?php echo e(Str::limit($log->details ?? '', 80)); ?>

                    </td>
                    <td style="font-size: 11px; font-family: monospace; color: #64748b;">
                        <?php echo e($log->ip_address ?? 'N/A'); ?>

                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" style="text-align: center; padding: 60px; color: #64748b;">
                        <div style="font-size: 48px; margin-bottom: 12px;">📋</div>
                        <p>Chưa có nhật ký hoạt động</p>
                        <p style="font-size: 12px; margin-top: 8px;">Các hoạt động admin sẽ được ghi lại tại đây</p>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <?php if($logs->hasPages()): ?>
        <div class="pagination" style="margin-top: 20px;">
            <?php echo e($logs->withQueryString()->links()); ?>

        </div>
    <?php endif; ?>
</div>

<!-- Stats -->
<div class="stats-grid" style="grid-template-columns: repeat(4, 1fr);">
    <div class="stat-card">
        <div class="stat-icon blue">🔑</div>
        <div class="stat-info">
            <div class="stat-label">Đăng nhập</div>
            <div class="stat-value"><?php echo e($stats['logins'] ?? 0); ?></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">📦</div>
        <div class="stat-info">
            <div class="stat-label">Cập nhật đơn</div>
            <div class="stat-value"><?php echo e($stats['order_updates'] ?? 0); ?></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange">👤</div>
        <div class="stat-info">
            <div class="stat-label">Tài khoản</div>
            <div class="stat-value"><?php echo e($stats['account_changes'] ?? 0); ?></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon purple">⚙️</div>
        <div class="stat-info">
            <div class="stat-label">Cài đặt</div>
            <div class="stat-value"><?php echo e($stats['settings_changes'] ?? 0); ?></div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dowload\thuetaikhoan\thuetaikhoan-laravel\resources\views/admin/logs/index.blade.php ENDPATH**/ ?>