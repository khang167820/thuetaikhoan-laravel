

<?php $__env->startSection('title', 'Quản lý Tài khoản'); ?>
<?php $__env->startSection('page-title', 'Quản lý Tài khoản'); ?>

<?php $__env->startSection('content'); ?>
<!-- Tab loại tài khoản -->
<div style="margin-bottom: 20px; display: flex; gap: 8px; flex-wrap: wrap;">
    <?php $__currentLoopData = $allowedTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('admin.accounts', ['type' => $type])); ?>" 
           class="btn <?php echo e($currentType === $type ? 'btn-primary' : 'btn-secondary'); ?>">
            <?php echo e($type); ?>

        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<!-- Stats -->
<div class="stats-grid" style="grid-template-columns: repeat(3, 1fr);">
    <div class="stat-card">
        <div class="stat-icon blue">📦</div>
        <div class="stat-info">
            <div class="stat-label">Tổng tài khoản</div>
            <div class="stat-value"><?php echo e($stats['total']); ?></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">✅</div>
        <div class="stat-info">
            <div class="stat-label">Chờ thuê</div>
            <div class="stat-value"><?php echo e($stats['available']); ?></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange">🔥</div>
        <div class="stat-info">
            <div class="stat-label">Đang thuê</div>
            <div class="stat-value"><?php echo e($stats['renting']); ?></div>
        </div>
    </div>
</div>

<!-- Form thêm tài khoản -->
<div class="admin-card">
    <div class="admin-card-title">Thêm tài khoản mới</div>
    <form action="<?php echo e(route('admin.accounts.add')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="type" value="<?php echo e($currentType); ?>">
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px; align-items: end;">
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Tên đăng nhập</label>
                <input type="text" name="username" class="form-input" required placeholder="username">
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Mật khẩu</label>
                <input type="text" name="password" class="form-input" required placeholder="password">
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Hạn sử dụng</label>
                <input type="date" name="expires_at" class="form-input">
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Ghi chú</label>
                <input type="text" name="note" class="form-input" placeholder="VD: Đã đổi pass">
            </div>
            <button type="submit" class="btn btn-success">+ Thêm</button>
        </div>
    </form>
</div>

<!-- Bảng tài khoản -->
<div class="admin-card">
    <div class="admin-card-title">Danh sách tài khoản <?php echo e($currentType); ?></div>
    
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tài khoản / Mật khẩu</th>
                    <th>Trạng thái</th>
                    <th>Ghi chú</th>
                    <th>Hạn sử dụng</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($account->id); ?></td>
                    <td>
                        <div style="font-weight: 600; color: #3b82f6;"><?php echo e($account->username); ?></div>
                        <div style="font-size: 12px; color: #64748b;">MK: <?php echo e($account->password); ?></div>
                        <div style="margin-top: 6px; display: flex; gap: 4px;">
                            <button class="btn btn-sm btn-secondary" onclick="copyToClipboard('<?php echo e($account->username); ?>')">Copy TK</button>
                            <button class="btn btn-sm btn-secondary" onclick="copyToClipboard('<?php echo e($account->password); ?>')">Copy MK</button>
                        </div>
                    </td>
                    <td>
                        <?php if($account->is_available ?? false): ?>
                            <span class="badge badge-active">Chờ thuê</span>
                        <?php else: ?>
                            <span class="badge badge-pending">Đang thuê</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($account->note ?? null): ?>
                            <span style="color: #f59e0b; font-size: 12px;"><?php echo e($account->note); ?></span>
                        <?php else: ?>
                            <span style="color: #64748b;">—</span>
                        <?php endif; ?>
                    </td>
                    <td style="font-size: 12px;">
                        <?php if(isset($account->expires_at) && $account->expires_at): ?>
                            <?php echo e(\Carbon\Carbon::parse($account->expires_at)->format('d/m/Y H:i')); ?>

                        <?php else: ?>
                            —
                        <?php endif; ?>
                    </td>
                    <td>
                        <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                            <form action="<?php echo e(route('admin.accounts.toggle', $account->id)); ?>" method="POST" style="margin:0;">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-sm <?php echo e($account->is_available ? 'btn-primary' : 'btn-success'); ?>">
                                    <?php echo e($account->is_available ? 'Chuyển TT' : 'Trả về'); ?>

                                </button>
                            </form>
                            
                            
                            <a href="<?php echo e(route('admin.accounts.edit', $account->id)); ?>" class="btn btn-sm btn-secondary">Sửa</a>
                            
                            <form action="<?php echo e(route('admin.accounts.delete', $account->id)); ?>" method="POST" style="margin:0;" 
                                  onsubmit="return confirm('Xác nhận xóa tài khoản này?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px; color: #64748b;">
                        Chưa có tài khoản nào
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <?php if($accounts->hasPages()): ?>
        <div class="pagination">
            <?php echo e($accounts->links()); ?>

        </div>
    <?php endif; ?>
</div>

<!-- Modal sửa tài khoản -->
<div id="editModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.7); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:#1e293b; padding:24px; border-radius:16px; width:400px; max-width:90%;">
        <h3 style="margin-bottom:16px; color:#f1f5f9;">Sửa tài khoản</h3>
        <form id="editForm" method="POST">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label class="form-label">Tên đăng nhập</label>
                <input type="text" name="username" id="edit_username" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Mật khẩu</label>
                <input type="text" name="password" id="edit_password" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Ghi chú</label>
                <input type="text" name="note" id="edit_note" class="form-input">
            </div>
            <div style="display:flex; gap:12px; justify-content:flex-end;">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Hủy</button>
                <button type="submit" class="btn btn-primary">Lưu</button>
            </div>
        </form>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text);
    alert('Đã copy: ' + text);
}

function editAccount(account) {
    document.getElementById('editModal').style.display = 'flex';
    document.getElementById('editForm').action = '/admin/accounts/' + account.id;
    document.getElementById('edit_username').value = account.username;
    document.getElementById('edit_password').value = account.password;
    document.getElementById('edit_note').value = account.note || '';
}

function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dowload\thuetaikhoan\thuetaikhoan-laravel\resources\views/admin/accounts/index.blade.php ENDPATH**/ ?>