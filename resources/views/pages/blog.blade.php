@extends('layouts.app')

@section('title', 'Blog - Tin tức, Hướng dẫn thuê Tool | ThueTaiKhoan.net')
@section('meta_description', 'Blog chia sẻ tin tức, hướng dẫn sử dụng UnlockTool, Vietmap, TSM Tool, Griffin và các tool điện thoại khác.')

@section('styles')
<style>
/* Blog Page Styles */
.blog-wrap {
    max-width: 1000px;
    margin: 40px auto;
    padding: 0 20px;
}
.blog-header {
    text-align: center;
    margin-bottom: 40px;
}
.blog-title {
    font-size: 32px;
    font-weight: 800;
    margin: 0 0 12px;
    color: #0f172a;
}
.blog-sub {
    color: #475569;
    font-size: 16px;
    margin: 0;
}

/* Filter Tags */
.blog-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: center;
    margin-bottom: 30px;
}
.blog-tag {
    padding: 8px 16px;
    border-radius: 20px;
    background: #f1f5f9;
    color: #475569;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
}
.blog-tag:hover, .blog-tag.active {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    color: #fff;
}

/* Blog Grid */
.blog-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
}
.blog-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.2s;
    display: flex;
    flex-direction: column;
}
.blog-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(15,23,42,.1);
}
.blog-card-image {
    width: 100%;
    height: 180px;
    object-fit: cover;
    background: linear-gradient(135deg, #f0f4ff 0%, #faf5ff 100%);
}
.blog-card-content {
    padding: 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.blog-card-tag {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 8px;
    background: #eef3ff;
    color: #4f46e5;
    font-size: 11px;
    font-weight: 700;
    margin-bottom: 10px;
    width: fit-content;
}
.blog-card-title {
    font-size: 17px;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 10px;
    line-height: 1.4;
}
.blog-card-excerpt {
    font-size: 14px;
    color: #64748b;
    line-height: 1.6;
    margin: 0;
    flex: 1;
}
.blog-card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px solid #f1f5f9;
    font-size: 12px;
    color: #94a3b8;
}
.blog-card-link {
    color: #4f46e5;
    font-weight: 600;
    text-decoration: none;
}
.blog-card-link:hover {
    text-decoration: underline;
}

/* Dark Mode */
[data-theme="dark"] .blog-title { color: var(--ink); }
[data-theme="dark"] .blog-sub { color: var(--muted); }
[data-theme="dark"] .blog-tag { background: #1e293b; color: #94a3b8; }
[data-theme="dark"] .blog-tag:hover, [data-theme="dark"] .blog-tag.active { background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); color: #fff; }
[data-theme="dark"] .blog-card { background: var(--bg-card); border-color: #334155; }
[data-theme="dark"] .blog-card-title { color: var(--ink); }
[data-theme="dark"] .blog-card-excerpt { color: var(--muted); }
[data-theme="dark"] .blog-card-footer { border-color: #334155; color: #64748b; }
[data-theme="dark"] .blog-card-tag { background: #1e3a5f; color: #60a5fa; }

@media(max-width: 640px) {
    .blog-title { font-size: 26px; }
    .blog-grid { grid-template-columns: 1fr; }
}
</style>
@endsection

@section('content')
<div class="blog-wrap">
    <div class="blog-header">
        <h1 class="blog-title">📚 Blog & Hướng dẫn</h1>
        <p class="blog-sub">Tin tức, thủ thuật và hướng dẫn sử dụng các tool chuyên nghiệp</p>
    </div>

    <div class="blog-tags">
        <button class="blog-tag active">Tất cả</button>
        <button class="blog-tag">Hướng dẫn</button>
        <button class="blog-tag">UnlockTool</button>
        <button class="blog-tag">Vietmap</button>
        <button class="blog-tag">TSM Tool</button>
        <button class="blog-tag">Griffin</button>
        <button class="blog-tag">Tin tức</button>
    </div>

    <div class="blog-grid">
        <!-- Blog Card 1 -->
        <article class="blog-card">
            <img src="/images/blog/huong-dan-unlocktool.png" alt="Hướng dẫn thuê UnlockTool" class="blog-card-image" onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 300 180%22><rect fill=%22%23f0f4ff%22 width=%22300%22 height=%22180%22/><text x=%22150%22 y=%2290%22 fill=%22%236366f1%22 font-size=%2240%22 text-anchor=%22middle%22>🔓</text></svg>'">
            <div class="blog-card-content">
                <span class="blog-card-tag">HƯỚNG DẪN</span>
                <h2 class="blog-card-title">Cách thuê tài khoản UnlockTool tự động 24/7</h2>
                <p class="blog-card-excerpt">Hướng dẫn chi tiết từng bước thuê tài khoản UnlockTool tại ThueTaiKhoan.net với hệ thống tự động...</p>
                <div class="blog-card-footer">
                    <span>📅 29/01/2026</span>
                    <a href="/blog/huong-dan-thue-unlocktool" class="blog-card-link">Đọc thêm →</a>
                </div>
            </div>
        </article>

        <!-- Blog Card 2 -->
        <article class="blog-card">
            <img src="/images/blog/vietmap-live.png" alt="Vietmap Live PRO" class="blog-card-image" onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 300 180%22><rect fill=%22%23ecfdf5%22 width=%22300%22 height=%22180%22/><text x=%22150%22 y=%2290%22 fill=%22%2310b981%22 font-size=%2240%22 text-anchor=%22middle%22>🗺️</text></svg>'">
            <div class="blog-card-content">
                <span class="blog-card-tag" style="background:#ecfdf5;color:#10b981;">VIETMAP</span>
                <h2 class="blog-card-title">Tính năng Vietmap Live PRO 2026</h2>
                <p class="blog-card-excerpt">Khám phá các tính năng mới nhất của Vietmap Live PRO: Cảnh báo camera, tốc độ, đường cấm...</p>
                <div class="blog-card-footer">
                    <span>📅 28/01/2026</span>
                    <a href="/blog/tinh-nang-vietmap-live" class="blog-card-link">Đọc thêm →</a>
                </div>
            </div>
        </article>

        <!-- Blog Card 3 -->
        <article class="blog-card">
            <img src="/images/blog/frp-bypass.png" alt="FRP Bypass" class="blog-card-image" onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 300 180%22><rect fill=%22%23fef3c7%22 width=%22300%22 height=%22180%22/><text x=%22150%22 y=%2290%22 fill=%22%23f59e0b%22 font-size=%2240%22 text-anchor=%22middle%22>🔐</text></svg>'">
            <div class="blog-card-content">
                <span class="blog-card-tag" style="background:#fef3c7;color:#d97706;">THỦ THUẬT</span>
                <h2 class="blog-card-title">Hướng dẫn FRP Bypass Samsung với UnlockTool</h2>
                <p class="blog-card-excerpt">Cách xóa FRP Google Account trên Samsung bằng UnlockTool nhanh chóng và hiệu quả...</p>
                <div class="blog-card-footer">
                    <span>📅 27/01/2026</span>
                    <a href="/blog/frp-bypass-samsung" class="blog-card-link">Đọc thêm →</a>
                </div>
            </div>
        </article>

        <!-- Blog Card 4 -->
        <article class="blog-card">
            <img src="/images/blog/griffin-a12.png" alt="Griffin A12+ Bypass" class="blog-card-image" onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 300 180%22><rect fill=%22%23f5f3ff%22 width=%22300%22 height=%22180%22/><text x=%22150%22 y=%2290%22 fill=%22%238b5cf6%22 font-size=%2240%22 text-anchor=%22middle%22>🛡️</text></svg>'">
            <div class="blog-card-content">
                <span class="blog-card-tag" style="background:#f5f3ff;color:#8b5cf6;">GRIFFIN</span>
                <h2 class="blog-card-title">Bypass A12+ với Griffin-Unlocker Premium</h2>
                <p class="blog-card-excerpt">Hướng dẫn sử dụng Griffin-Unlocker Premium để bypass thiết bị A12+ chạy iOS mới nhất...</p>
                <div class="blog-card-footer">
                    <span>📅 26/01/2026</span>
                    <a href="/blog/griffin-bypass-a12" class="blog-card-link">Đọc thêm →</a>
                </div>
            </div>
        </article>

        <!-- Blog Card 5 -->
        <article class="blog-card">
            <img src="/images/blog/tsm-tool.png" alt="TSM Tool Guide" class="blog-card-image" onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 300 180%22><rect fill=%22%23fff7ed%22 width=%22300%22 height=%22180%22/><text x=%22150%22 y=%2290%22 fill=%22%23ea580c%22 font-size=%2240%22 text-anchor=%22middle%22>📱</text></svg>'">
            <div class="blog-card-content">
                <span class="blog-card-tag" style="background:#fff7ed;color:#ea580c;">TSM TOOL</span>
                <h2 class="blog-card-title">TSM Tool - Công cụ đa năng cho Android</h2>
                <p class="blog-card-excerpt">Tổng hợp tất cả tính năng của TSM Tool và cách sử dụng hiệu quả cho từng hãng điện thoại...</p>
                <div class="blog-card-footer">
                    <span>📅 25/01/2026</span>
                    <a href="/blog/tsm-tool-huong-dan" class="blog-card-link">Đọc thêm →</a>
                </div>
            </div>
        </article>

        <!-- Blog Card 6 -->
        <article class="blog-card">
            <img src="/images/blog/so-sanh-tool.png" alt="So sánh Tool" class="blog-card-image" onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 300 180%22><rect fill=%22%23fef2f2%22 width=%22300%22 height=%22180%22/><text x=%22150%22 y=%2290%22 fill=%22%23dc2626%22 font-size=%2240%22 text-anchor=%22middle%22>⚖️</text></svg>'">
            <div class="blog-card-content">
                <span class="blog-card-tag" style="background:#fef2f2;color:#dc2626;">SO SÁNH</span>
                <h2 class="blog-card-title">So sánh UnlockTool vs TSM Tool vs Griffin</h2>
                <p class="blog-card-excerpt">Phân tích chi tiết điểm mạnh, điểm yếu của từng tool để chọn tool phù hợp với nhu cầu...</p>
                <div class="blog-card-footer">
                    <span>📅 24/01/2026</span>
                    <a href="/blog/so-sanh-unlocktool-tsm-griffin" class="blog-card-link">Đọc thêm →</a>
                </div>
            </div>
        </article>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Blog tag filter
document.querySelectorAll('.blog-tag').forEach(tag => {
    tag.addEventListener('click', function() {
        document.querySelectorAll('.blog-tag').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        // TODO: Implement actual filtering
    });
});
</script>
@endsection
