

<?php $__env->startSection('title', $post ? 'Sửa bài viết' : 'Thêm bài viết'); ?>
<?php $__env->startSection('page-title', $post ? 'Sửa bài viết' : 'Thêm bài viết mới'); ?>

<?php $__env->startSection('content'); ?>
<form action="<?php echo e(route('admin.blog.save', $post->id ?? null)); ?>" method="POST">
    <?php echo csrf_field(); ?>
    
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
        <!-- Main Content -->
        <div>
            <div class="admin-card">
                <div class="form-group">
                    <label class="form-label">Tiêu đề*</label>
                    <input type="text" name="title" class="form-input" required
                           value="<?php echo e($post->title ?? old('title')); ?>"
                           placeholder="Nhập tiêu đề bài viết"
                           oninput="generateSlug(this.value)">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Slug (URL)*</label>
                    <input type="text" name="slug" id="slug" class="form-input" required
                           value="<?php echo e($post->slug ?? old('slug')); ?>"
                           placeholder="tieu-de-bai-viet">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Mô tả ngắn</label>
                    <textarea name="excerpt" class="form-input" rows="3"
                              placeholder="Mô tả ngắn hiển thị trong danh sách"><?php echo e($post->excerpt ?? old('excerpt')); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Nội dung*</label>
                    <textarea name="content" class="form-input" rows="15" required
                              placeholder="Nội dung bài viết (hỗ trợ HTML)"><?php echo e($post->content ?? old('content')); ?></textarea>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div>
            <div class="admin-card">
                <div class="admin-card-title">Xuất bản</div>
                
                <div class="form-group">
                    <label class="form-label">Trạng thái</label>
                    <select name="status" class="form-select">
                        <option value="draft" <?php echo e(($post->status ?? '') === 'draft' ? 'selected' : ''); ?>>Bản nháp</option>
                        <option value="published" <?php echo e(($post->status ?? '') === 'published' ? 'selected' : ''); ?>>Xuất bản</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" name="featured" value="1" 
                               <?php echo e(($post->featured ?? false) ? 'checked' : ''); ?>

                               style="width: 16px; height: 16px;">
                        <span class="form-label" style="margin-bottom: 0;">Bài viết nổi bật</span>
                    </label>
                </div>
                
                <div style="display: flex; gap: 8px;">
                    <button type="submit" class="btn btn-primary" style="flex: 1;">💾 Lưu</button>
                    <a href="<?php echo e(route('admin.blog')); ?>" class="btn btn-secondary">Hủy</a>
                </div>
            </div>
            
            <div class="admin-card">
                <div class="admin-card-title">Hình ảnh</div>
                
                <div class="form-group">
                    <label class="form-label">URL ảnh đại diện</label>
                    <input type="text" name="image" class="form-input" 
                           value="<?php echo e($post->image ?? old('image')); ?>"
                           placeholder="https://example.com/image.jpg">
                </div>
                
                <?php if(isset($post->image) && $post->image): ?>
                    <img src="<?php echo e($post->image); ?>" alt="" style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px; margin-top: 8px;">
                <?php endif; ?>
            </div>
            
            <div class="admin-card">
                <div class="admin-card-title">SEO</div>
                
                <div class="form-group">
                    <label class="form-label">Meta Title</label>
                    <input type="text" name="meta_title" class="form-input" 
                           value="<?php echo e($post->meta_title ?? old('meta_title')); ?>"
                           placeholder="Tiêu đề SEO">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Meta Description</label>
                    <textarea name="meta_description" class="form-input" rows="3"
                              placeholder="Mô tả SEO"><?php echo e($post->meta_description ?? old('meta_description')); ?></textarea>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
function generateSlug(text) {
    const slug = text
        .toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .replace(/đ/g, 'd')
        .replace(/Đ/g, 'D')
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim();
    document.getElementById('slug').value = slug;
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dowload\thuetaikhoan\thuetaikhoan-laravel\resources\views/admin/blog/edit.blade.php ENDPATH**/ ?>