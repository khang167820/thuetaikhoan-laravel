

<?php $__env->startSection('title', 'Quản lý Blog'); ?>
<?php $__env->startSection('page-title', 'Quản lý Blog'); ?>

<?php $__env->startSection('content'); ?>
<!-- Stats -->
<div class="stats-grid" style="grid-template-columns: repeat(3, 1fr);">
    <div class="stat-card">
        <div class="stat-icon blue">📝</div>
        <div class="stat-info">
            <div class="stat-label">Tổng bài viết</div>
            <div class="stat-value"><?php echo e($stats['total']); ?></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">✅</div>
        <div class="stat-info">
            <div class="stat-label">Đã xuất bản</div>
            <div class="stat-value"><?php echo e($stats['published']); ?></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange">📋</div>
        <div class="stat-info">
            <div class="stat-label">Bản nháp</div>
            <div class="stat-value"><?php echo e($stats['draft']); ?></div>
        </div>
    </div>
</div>

<!-- Filter bar -->
<div class="filter-bar">
    <a href="<?php echo e(route('admin.blog.create')); ?>" class="btn btn-success">+ Thêm bài viết</a>
    
    <select class="form-select" onchange="window.location.href='<?php echo e(route('admin.blog')); ?>?status=' + this.value">
        <option value="">Tất cả trạng thái</option>
        <option value="published" <?php echo e(request('status') === 'published' ? 'selected' : ''); ?>>Đã xuất bản</option>
        <option value="draft" <?php echo e(request('status') === 'draft' ? 'selected' : ''); ?>>Bản nháp</option>
    </select>
</div>

<!-- Bảng bài viết -->
<div class="admin-card">
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Ảnh</th>
                    <th>Tiêu đề</th>
                    <th>Danh mục</th>
                    <th>Trạng thái</th>
                    <th>Lượt xem</th>
                    <th>Ngày tạo</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <?php if($post->image): ?>
                            <img src="<?php echo e($post->image); ?>" alt="" style="width: 60px; height: 40px; object-fit: cover; border-radius: 6px;">
                        <?php else: ?>
                            <div style="width: 60px; height: 40px; background: linear-gradient(135deg, #3b82f6, #8b5cf6); border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 16px; font-weight: bold;">B</div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div style="font-weight: 600; color: #f1f5f9; max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            <?php echo e($post->title); ?>

                        </div>
                        <div style="font-size: 11px; color: #64748b;"><?php echo e($post->slug); ?></div>
                    </td>
                    <td style="font-size: 12px;"><?php echo e($post->category ?? '—'); ?></td>
                    <td>
                        <?php if($post->status === 'published'): ?>
                            <span class="badge badge-active">Đã xuất bản</span>
                        <?php else: ?>
                            <span class="badge badge-inactive">Bản nháp</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo e(number_format($post->views ?? 0)); ?></td>
                    <td style="font-size: 12px;"><?php echo e(\Carbon\Carbon::parse($post->created_at)->format('d/m/Y H:i')); ?></td>
                    <td>
                        <div style="display: flex; gap: 6px;">
                            <a href="<?php echo e(route('admin.blog.edit', $post->id)); ?>" class="btn btn-sm btn-secondary">Sửa</a>
                            
                            <form action="<?php echo e(route('admin.blog.toggle', $post->id)); ?>" method="POST" style="margin:0;">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-sm <?php echo e($post->status === 'published' ? 'btn-danger' : 'btn-success'); ?>">
                                    <?php echo e($post->status === 'published' ? 'Ẩn' : 'Xuất bản'); ?>

                                </button>
                            </form>
                            
                            <form action="<?php echo e(route('admin.blog.delete', $post->id)); ?>" method="POST" style="margin:0;" 
                                  onsubmit="return confirm('Xác nhận xóa bài viết này?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px; color: #64748b;">
                        Chưa có bài viết nào
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <?php if($posts->hasPages()): ?>
        <div class="pagination">
            <?php echo e($posts->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dowload\thuetaikhoan\thuetaikhoan-laravel\resources\views/admin/blog/index.blade.php ENDPATH**/ ?>