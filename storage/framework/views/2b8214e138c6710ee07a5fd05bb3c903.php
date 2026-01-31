

<?php $__env->startSection('title', 'Backup & Restore'); ?>
<?php $__env->startSection('page-title', 'Backup & Restore'); ?>

<?php $__env->startSection('content'); ?>
<!-- Current Backups -->
<div class="admin-card">
    <div class="admin-card-title">💾 Backup Database</div>
    <p style="color: #64748b; font-size: 13px; margin-bottom: 16px;">
        Tạo backup database để phục hồi khi cần thiết
    </p>
    
    <div style="display: flex; gap: 12px; flex-wrap: wrap;">
        <form action="<?php echo e(route('admin.backup.create')); ?>" method="POST" style="margin:0;">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-primary" onclick="return confirm('Tạo backup database?')">
                ➕ Tạo Backup Mới
            </button>
        </form>
        
        <form action="<?php echo e(route('admin.backup.export-sql')); ?>" method="POST" style="margin:0;">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-secondary">
                📥 Export SQL
            </button>
        </form>
    </div>
</div>

<!-- Backup List -->
<div class="admin-card">
    <div class="admin-card-title">📁 Danh sách Backup</div>
    
    <table class="admin-table">
        <thead>
            <tr>
                <th>Tên file</th>
                <th>Kích thước</th>
                <th>Ngày tạo</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $backups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $backup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td>
                    <span style="font-family: monospace; font-size: 12px;"><?php echo e($backup['name']); ?></span>
                </td>
                <td><?php echo e($backup['size']); ?></td>
                <td style="font-size: 12px;"><?php echo e($backup['date']); ?></td>
                <td>
                    <div style="display: flex; gap: 6px;">
                        <a href="<?php echo e(route('admin.backup.download', $backup['name'])); ?>" class="btn btn-sm btn-secondary">
                            📥 Tải
                        </a>
                        <form action="<?php echo e(route('admin.backup.delete', $backup['name'])); ?>" method="POST" style="margin:0;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Xóa backup này?')">
                                🗑️
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="4" style="text-align: center; padding: 40px; color: #64748b;">
                    <div style="font-size: 48px; margin-bottom: 12px;">📂</div>
                    <p>Chưa có backup nào</p>
                    <p style="font-size: 12px;">Tạo backup để bảo vệ dữ liệu của bạn</p>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Danger Zone -->
<div class="admin-card" style="border-color: #ef4444;">
    <div class="admin-card-title" style="color: #ef4444;">⚠️ Vùng Nguy hiểm</div>
    
    <div style="display: flex; gap: 12px; flex-wrap: wrap;">
        <form action="<?php echo e(route('admin.system.optimize')); ?>" method="POST" style="margin:0;">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-secondary" onclick="return confirm('Optimize database?')">
                ⚡ Optimize Tables
            </button>
        </form>
        
        <form action="<?php echo e(route('admin.cache.clear-all')); ?>" method="POST" style="margin:0;">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-secondary" onclick="return confirm('Xóa tất cả cache?')">
                🗑️ Clear All Cache
            </button>
        </form>
    </div>
    
    <p style="color: #94a3b8; font-size: 12px; margin-top: 16px;">
        ⚠️ Các thao tác này có thể ảnh hưởng đến hiệu suất tạm thời. Chỉ sử dụng khi cần thiết.
    </p>
</div>

<?php if(session('success')): ?>
<div class="alert alert-success" style="margin-top: 16px;"><?php echo e(session('success')); ?></div>
<?php endif; ?>

<?php if(session('error')): ?>
<div class="alert alert-danger" style="margin-top: 16px;"><?php echo e(session('error')); ?></div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dowload\thuetaikhoan\thuetaikhoan-laravel\resources\views/admin/backup/index.blade.php ENDPATH**/ ?>