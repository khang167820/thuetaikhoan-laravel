

<?php $__env->startSection('title', 'Quản lý Users'); ?>
<?php $__env->startSection('page-title', 'Quản lý Users'); ?>

<?php $__env->startSection('content'); ?>
<!-- Filter Bar -->
<div class="filter-bar">
    <form action="<?php echo e(route('admin.users')); ?>" method="GET" style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
        <input type="text" name="search" class="form-input" placeholder="Tìm tên, email, SĐT..." value="<?php echo e(request('search')); ?>" style="width: 220px;">
        
        <select name="role" class="form-select" style="width: 140px;">
            <option value="">Tất cả role</option>
            <option value="user" <?php echo e(request('role') === 'user' ? 'selected' : ''); ?>>User</option>
            <option value="admin" <?php echo e(request('role') === 'admin' ? 'selected' : ''); ?>>Admin</option>
        </select>
        
        <button type="submit" class="btn btn-primary">Lọc</button>
        <a href="<?php echo e(route('admin.users')); ?>" class="btn btn-secondary">Reset</a>
    </form>
</div>

<!-- Users Table -->
<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên / Email</th>
                <th>Số điện thoại</th>
                <th>Số dư</th>
                <th>Role</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td>#<?php echo e($user->id); ?></td>
                <td>
                    <strong><?php echo e($user->name ?? 'N/A'); ?></strong>
                    <div style="font-size: 11px; color: #64748b;"><?php echo e($user->email ?? 'N/A'); ?></div>
                </td>
                <td><?php echo e($user->phone ?? 'N/A'); ?></td>
                <td style="color: #10b981; font-weight: 600;"><?php echo e(number_format($user->balance ?? 0, 0, ',', '.')); ?>đ</td>
                <td>
                    <?php if($user->role === 'admin'): ?>
                        <span class="badge badge-paid">Admin</span>
                    <?php else: ?>
                        <span class="badge" style="background: #f1f5f9; color: #475569;">User</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($user->is_active): ?>
                        <span class="badge badge-active">Active</span>
                    <?php else: ?>
                        <span class="badge badge-inactive">Inactive</span>
                    <?php endif; ?>
                </td>
                <td><?php echo e($user->created_at ? $user->created_at->format('d/m/Y') : 'N/A'); ?></td>
                <td>
                    <button class="btn btn-sm btn-secondary" onclick="openEditUser(<?php echo e($user->id); ?>, '<?php echo e($user->balance); ?>', '<?php echo e($user->role); ?>', <?php echo e($user->is_active ? 1 : 0); ?>)">Sửa</button>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="8" style="text-align: center; color: #64748b; padding: 40px;">
                    Không có user nào
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Pagination -->
<?php if($users->hasPages()): ?>
<div class="pagination">
    <?php echo e($users->links()); ?>

</div>
<?php endif; ?>

<!-- Edit User Modal -->
<div id="editUserModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.7); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: #1e293b; border-radius: 16px; padding: 24px; width: 400px; max-width: 90%;">
        <h3 style="margin-bottom: 20px; font-size: 16px;">Chỉnh sửa User</h3>
        <form id="editUserForm" method="POST">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label class="form-label">Số dư (VND)</label>
                <input type="number" name="balance" id="editBalance" class="form-input">
            </div>
            <div class="form-group">
                <label class="form-label">Role</label>
                <select name="role" id="editRole" class="form-select">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Trạng thái</label>
                <select name="is_active" id="editActive" class="form-select">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 20px;">
                <button type="button" class="btn btn-secondary" onclick="closeEditUser()">Hủy</button>
                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditUser(id, balance, role, isActive) {
    document.getElementById('editUserForm').action = '/admin/users/' + id;
    document.getElementById('editBalance').value = balance;
    document.getElementById('editRole').value = role;
    document.getElementById('editActive').value = isActive;
    document.getElementById('editUserModal').style.display = 'flex';
}

function closeEditUser() {
    document.getElementById('editUserModal').style.display = 'none';
}

document.getElementById('editUserModal').addEventListener('click', function(e) {
    if (e.target === this) closeEditUser();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dowload\thuetaikhoan\thuetaikhoan-laravel\resources\views/admin/users/index.blade.php ENDPATH**/ ?>