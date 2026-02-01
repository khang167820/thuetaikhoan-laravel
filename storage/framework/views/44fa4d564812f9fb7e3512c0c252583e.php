

<?php $__env->startSection('title', $post->meta_title ?: $post->title); ?>
<?php $__env->startSection('meta_description', $post->meta_description ?: Str::limit(strip_tags($post->content), 160)); ?>

<?php $__env->startSection('content'); ?>
<style>
.blog-post-hero {
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #8b5cf6 100%);
    padding: 60px 0;
    color: #fff;
}
.blog-post-hero .container { max-width: 900px; }
.blog-breadcrumb { display: flex; gap: 8px; font-size: 14px; margin-bottom: 20px; opacity: 0.9; flex-wrap: wrap; }
.blog-breadcrumb a { color: #fff; text-decoration: none; }
.blog-post-category {
    display: inline-block;
    background: rgba(255,255,255,0.2);
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 16px;
}
.blog-post-title { font-size: 2rem; font-weight: 800; line-height: 1.3; margin-bottom: 20px; }
.blog-post-meta { display: flex; gap: 20px; flex-wrap: wrap; font-size: 14px; opacity: 0.9; }

.blog-post-content { background: #f8fafc; padding: 50px 0 80px; }
.blog-post-wrapper {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 40px;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}
@media (max-width: 900px) {
    .blog-post-wrapper { grid-template-columns: 1fr; }
    .blog-sidebar { order: -1; }
}

.blog-article {
    background: #fff;
    border-radius: 16px;
    padding: 40px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}
.blog-article h2 {
    font-size: 1.4rem;
    font-weight: 700;
    color: #1e40af;
    margin: 30px 0 15px;
    padding-top: 20px;
    border-top: 1px solid #e5e7eb;
}
.blog-article h2:first-of-type { margin-top: 0; padding-top: 0; border-top: none; }
.blog-article h3 { font-size: 1.15rem; font-weight: 700; color: #1f2937; margin: 20px 0 10px; }
.blog-article p { font-size: 16px; line-height: 1.8; color: #374151; margin-bottom: 16px; }
.blog-article ul, .blog-article ol { margin: 16px 0; padding-left: 24px; }
.blog-article li { font-size: 16px; line-height: 1.8; color: #374151; margin-bottom: 8px; }
.blog-article img { max-width: 100%; border-radius: 12px; margin: 20px 0; }
.blog-article a { color: #3b82f6; }
.blog-article code {
    background: #f3f4f6;
    padding: 3px 8px;
    border-radius: 4px;
    font-family: monospace;
    font-size: 14px;
}
.blog-article pre {
    background: #1f2937;
    color: #e5e7eb;
    padding: 20px;
    border-radius: 12px;
    overflow-x: auto;
    margin: 20px 0;
}
.blog-article blockquote {
    background: #eff6ff;
    border-left: 4px solid #3b82f6;
    padding: 20px;
    margin: 20px 0;
    border-radius: 0 12px 12px 0;
}
.blog-article table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
}
.blog-article th, .blog-article td {
    padding: 12px;
    border: 1px solid #e5e7eb;
    text-align: left;
}
.blog-article th { background: #f9fafb; font-weight: 600; }

.blog-share {
    display: flex;
    gap: 12px;
    margin-top: 30px;
    padding-top: 30px;
    border-top: 1px solid #e5e7eb;
}
.blog-share-btn {
    padding: 10px 16px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
    border: none;
    cursor: pointer;
}
.blog-share-btn.facebook { background: #1877f2; color: #fff; }
.blog-share-btn.copy { background: #f3f4f6; color: #374151; }

.blog-sidebar { position: sticky; top: 20px; }
.sidebar-box {
    background: #fff;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    margin-bottom: 24px;
}
.sidebar-title {
    font-size: 1rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 2px solid #3b82f6;
}

.related-post {
    display: flex;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid #f3f4f6;
    text-decoration: none;
}
.related-post:last-child { border-bottom: none; }
.related-post-img {
    width: 60px;
    height: 45px;
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    border-radius: 8px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 18px;
}
.related-post-title {
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    line-height: 1.4;
}
.related-post:hover .related-post-title { color: #3b82f6; }

@media (max-width: 768px) {
    .blog-post-title { font-size: 1.5rem; }
    .blog-article { padding: 24px; }
}
</style>

<!-- Hero -->
<section class="blog-post-hero">
    <div class="container">
        <div class="blog-breadcrumb">
            <a href="/">Trang chủ</a> /
            <a href="<?php echo e(route('blog.index')); ?>">Blog</a> /
            <span><?php echo e($post->category); ?></span>
        </div>
        <span class="blog-post-category"><?php echo e($post->category); ?></span>
        <h1 class="blog-post-title"><?php echo e($post->title); ?></h1>
        <div class="blog-post-meta">
            <span>📅 <?php echo e(\Carbon\Carbon::parse($post->created_at)->format('d/m/Y')); ?></span>
            <span>✍️ <?php echo e($post->author); ?></span>
            <span>👁 <?php echo e(number_format($post->views)); ?> lượt xem</span>
        </div>
    </div>
</section>

<!-- Content -->
<section class="blog-post-content">
    <div class="blog-post-wrapper">
        <!-- Article -->
        <article class="blog-article">
            <?php echo $post->content; ?>

            
            <!-- Share -->
            <div class="blog-share">
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e(urlencode(url()->current())); ?>" target="_blank" class="blog-share-btn facebook">
                    📘 Chia sẻ Facebook
                </a>
                <button class="blog-share-btn copy" onclick="navigator.clipboard.writeText(window.location.href); alert('Đã copy link!');">
                    📋 Copy link
                </button>
            </div>
        </article>
        
        <!-- Sidebar -->
        <aside class="blog-sidebar">
            <!-- CTA -->
            <div class="sidebar-box" style="background: linear-gradient(135deg, #f97316, #ea580c); color: #fff;">
                <h3 style="font-size: 1.1rem; margin-bottom: 10px;">🔓 Thuê Tool GSM</h3>
                <p style="font-size: 14px; opacity: 0.9; margin-bottom: 16px;">Giá chỉ từ 10.000đ - Nhận tài khoản ngay!</p>
                <a href="/" style="display: block; background: #fff; color: #ea580c; padding: 12px; text-align: center; border-radius: 10px; font-weight: 700; text-decoration: none;">
                    Xem dịch vụ →
                </a>
            </div>
            
            <?php if($relatedPosts->isNotEmpty()): ?>
            <!-- Related -->
            <div class="sidebar-box">
                <h3 class="sidebar-title">📰 Bài viết liên quan</h3>
                <?php $__currentLoopData = $relatedPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('blog.show', $related->slug)); ?>" class="related-post">
                    <div class="related-post-img">📄</div>
                    <div class="related-post-title"><?php echo e(Str::limit($related->title, 60)); ?></div>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>
            
            <!-- Back to Blog -->
            <div class="sidebar-box" style="text-align: center;">
                <a href="<?php echo e(route('blog.index')); ?>" style="color: #3b82f6; text-decoration: none; font-weight: 600;">
                    ← Quay lại Blog
                </a>
            </div>
        </aside>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dowload\thuetaikhoan\thuetaikhoan-laravel\resources\views/blog/show.blade.php ENDPATH**/ ?>