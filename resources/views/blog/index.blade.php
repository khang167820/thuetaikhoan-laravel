@extends('layouts.app')

@section('title', 'Blog - Tin tức & Hướng dẫn GSM')

@section('content')
<style>
.blog-hero {
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 50%, #020617 100%);
    padding: 60px 0;
    text-align: center;
    color: #fff;
}
.blog-hero h1 { font-size: 2.5rem; font-weight: 800; margin-bottom: 12px; }
.blog-hero p { font-size: 1.1rem; opacity: 0.9; max-width: 600px; margin: 0 auto 24px; }

.blog-search {
    max-width: 500px;
    margin: 0 auto;
    display: flex;
    gap: 10px;
}
.blog-search input {
    flex: 1;
    padding: 14px 20px;
    border: none;
    border-radius: 12px;
    font-size: 15px;
}
.blog-search button {
    padding: 14px 24px;
    background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
    color: #fff;
    border: none;
    border-radius: 12px;
    font-weight: 700;
    cursor: pointer;
}

.blog-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
}
.blog-layout {
    display: grid;
    grid-template-columns: 1fr 280px;
    gap: 40px;
}
@media (max-width: 900px) {
    .blog-layout { grid-template-columns: 1fr; }
}

.blog-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
}

.blog-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    transition: all 0.3s;
    text-decoration: none;
}
.blog-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.15);
}
.blog-card-img {
    height: 160px;
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 48px;
}
.blog-card-body { padding: 20px; }
.blog-card-category {
    display: inline-block;
    background: #fef3c7;
    color: #d97706;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 10px;
}
.blog-card-title {
    font-size: 16px;
    font-weight: 700;
    color: #1f2937;
    line-height: 1.4;
    margin-bottom: 10px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.blog-card-meta {
    display: flex;
    gap: 16px;
    font-size: 13px;
    color: #6b7280;
}

.blog-sidebar-box {
    background: #fff;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    margin-bottom: 24px;
}
.blog-sidebar-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 3px solid #f97316;
}
.category-list { list-style: none; padding: 0; margin: 0; }
.category-list li { padding: 10px 0; border-bottom: 1px solid #f3f4f6; }
.category-list li:last-child { border-bottom: none; }
.category-list a {
    display: flex;
    justify-content: space-between;
    text-decoration: none;
    color: #4b5563;
    font-size: 14px;
}
.category-list a:hover { color: #3b82f6; }
.category-count {
    background: #f3f4f6;
    padding: 2px 10px;
    border-radius: 10px;
    font-size: 12px;
}

.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 40px;
}
</style>

<!-- Hero -->
<section class="blog-hero">
    <div class="container">
        <h1>📚 Blog & Hướng dẫn</h1>
        <p>Tin tức, hướng dẫn sử dụng tool GSM, mẹo xóa FRP, và nhiều kiến thức hữu ích khác</p>
        
        <form action="{{ route('blog.index') }}" method="GET" class="blog-search">
            <input type="text" name="q" placeholder="Tìm kiếm bài viết..." value="{{ request('q') }}">
            <button type="submit">🔍 Tìm</button>
        </form>
    </div>
</section>

<!-- Content -->
<div class="blog-container">
    <div class="blog-layout">
        <!-- Posts Grid -->
        <div>
            @if(isset($category))
                <h2 style="margin-bottom: 24px; color: #1f2937;">
                    Danh mục: <span style="color: #3b82f6;">{{ $category }}</span>
                </h2>
            @endif
            
            @if($posts->isEmpty())
                <div style="text-align: center; padding: 60px; background: #fff; border-radius: 16px;">
                    <div style="font-size: 64px; margin-bottom: 16px;">📭</div>
                    <h3 style="color: #1f2937; margin-bottom: 8px;">Không tìm thấy bài viết</h3>
                    <p style="color: #6b7280;">Thử tìm kiếm với từ khóa khác</p>
                </div>
            @else
                <div class="blog-grid">
                    @foreach($posts as $post)
                    <a href="{{ route('blog.show', $post->slug) }}" class="blog-card">
                        <div class="blog-card-img">
                            @php
                                $icons = ['📱', '🔓', '💻', '🔧', '📦', '⚙️', '🛠️', '📡'];
                                $icon = $icons[crc32($post->slug) % count($icons)];
                            @endphp
                            {{ $icon }}
                        </div>
                        <div class="blog-card-body">
                            <span class="blog-card-category">{{ $post->category }}</span>
                            <h3 class="blog-card-title">{{ $post->title }}</h3>
                            <div class="blog-card-meta">
                                <span>👁 {{ number_format($post->views) }}</span>
                                <span>📅 {{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
                
                <div class="pagination-wrapper">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
        
        <!-- Sidebar -->
        <aside>
            <!-- Categories -->
            <div class="blog-sidebar-box">
                <h3 class="blog-sidebar-title">📁 Danh mục</h3>
                <ul class="category-list">
                    @foreach($categories as $cat)
                    <li>
                        <a href="{{ route('blog.category', $cat->category) }}">
                            {{ $cat->category }}
                            <span class="category-count">{{ $cat->count }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            
            <!-- CTA -->
            <div class="blog-sidebar-box" style="background: linear-gradient(135deg, #f97316, #ea580c); color: #fff;">
                <h3 style="font-size: 1.1rem; margin-bottom: 10px;">🔓 Thuê Tool GSM</h3>
                <p style="font-size: 14px; opacity: 0.9; margin-bottom: 16px;">Giá chỉ từ 10.000đ - Nhận tài khoản ngay!</p>
                <a href="/" style="display: block; background: #fff; color: #ea580c; padding: 12px; text-align: center; border-radius: 10px; font-weight: 700; text-decoration: none;">
                    Xem dịch vụ →
                </a>
            </div>
        </aside>
    </div>
</div>
@endsection
