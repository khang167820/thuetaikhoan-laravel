

<?php $__env->startSection('title', 'ADY Config'); ?>
<?php $__env->startSection('page-title', 'ADY Unlocker Config'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-card" style="max-width: 600px;">
    <div class="admin-card-title">Cấu hình API ADY Unlocker</div>
    
    <form action="<?php echo e(route('admin.ady.config.save')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        
        <div class="form-group">
            <label class="form-label">API URL</label>
            <input type="text" name="ady_api_url" class="form-input" 
                   value="<?php echo e($settings->get('ady_api_url')?->value ?? ''); ?>"
                   placeholder="https://api.adyunlocker.com">
        </div>
        
        <div class="form-group">
            <label class="form-label">API Key</label>
            <input type="text" name="ady_api_key" class="form-input" 
                   value="<?php echo e($settings->get('ady_api_key')?->value ?? ''); ?>"
                   placeholder="Nhập API Key">
        </div>
        
        <div class="form-group">
            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                <input type="checkbox" name="ady_enabled" value="1" 
                       <?php echo e(($settings->get('ady_enabled')?->value ?? 0) ? 'checked' : ''); ?>

                       style="width: 16px; height: 16px;">
                <span class="form-label" style="margin-bottom: 0;">Kích hoạt tích hợp ADY</span>
            </label>
        </div>
        
        <button type="submit" class="btn btn-primary">💾 Lưu cấu hình</button>
    </form>
</div>

<div class="admin-card" style="max-width: 600px;">
    <div class="admin-card-title">Hướng dẫn</div>
    <div style="color: #94a3b8; font-size: 13px; line-height: 1.6;">
        <p>ADY Unlocker là dịch vụ mở khóa điện thoại chuyên nghiệp.</p>
        <ul style="margin: 12px 0; padding-left: 20px;">
            <li>Đăng ký tài khoản tại <a href="https://adyunlocker.com" target="_blank" style="color: #3b82f6;">adyunlocker.com</a></li>
            <li>Lấy API Key từ trang quản lý tài khoản</li>
            <li>Nhập API Key vào form trên và lưu</li>
        </ul>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dowload\thuetaikhoan\thuetaikhoan-laravel\resources\views/admin/ady/config.blade.php ENDPATH**/ ?>