@extends('admin.layouts.app')

@section('title', 'Quản lý Blog')
@section('page-title', 'Quản lý Blog')

@section('content')
<!-- Stats -->
<div class="stats-grid" style="grid-template-columns: repeat(3, 1fr);">
    <div class="stat-card">
        <div class="stat-icon blue">📝</div>
        <div class="stat-info">
            <div class="stat-label">Tổng bài viết</div>
            <div class="stat-value">{{ $stats['total'] }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">✅</div>
        <div class="stat-info">
            <div class="stat-label">Đã xuất bản</div>
            <div class="stat-value">{{ $stats['published'] }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange">📋</div>
        <div class="stat-info">
            <div class="stat-label">Bản nháp</div>
            <div class="stat-value">{{ $stats['draft'] }}</div>
        </div>
    </div>
</div>

<!-- Filter bar -->
<div class="filter-bar">
    <a href="{{ route('admin.blog.create') }}" class="btn btn-success">+ Thêm bài viết</a>
    
    <select class="form-select" onchange="window.location.href='{{ route('admin.blog') }}?status=' + this.value">
        <option value="">Tất cả trạng thái</option>
        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Đã xuất bản</option>
        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Bản nháp</option>
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
                @forelse($posts as $post)
                <tr>
                    <td>
                        @if($post->image)
                            <img src="{{ $post->image }}" alt="" style="width: 60px; height: 40px; object-fit: cover; border-radius: 6px;">
                        @else
                            <div style="width: 60px; height: 40px; background: linear-gradient(135deg, #3b82f6, #8b5cf6); border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 16px; font-weight: bold;">B</div>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight: 600; color: #f1f5f9; max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $post->title }}
                        </div>
                        <div style="font-size: 11px; color: #64748b;">{{ $post->slug }}</div>
                    </td>
                    <td style="font-size: 12px;">{{ $post->category ?? '—' }}</td>
                    <td>
                        @if($post->status === 'published')
                            <span class="badge badge-active">Đã xuất bản</span>
                        @else
                            <span class="badge badge-inactive">Bản nháp</span>
                        @endif
                    </td>
                    <td>{{ number_format($post->views ?? 0) }}</td>
                    <td style="font-size: 12px;">{{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y H:i') }}</td>
                    <td>
                        <div style="display: flex; gap: 6px;">
                            <a href="{{ route('admin.blog.edit', $post->id) }}" class="btn btn-sm btn-secondary">Sửa</a>
                            
                            <form action="{{ route('admin.blog.toggle', $post->id) }}" method="POST" style="margin:0;">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $post->status === 'published' ? 'btn-danger' : 'btn-success' }}">
                                    {{ $post->status === 'published' ? 'Ẩn' : 'Xuất bản' }}
                                </button>
                            </form>
                            
                            <form action="{{ route('admin.blog.delete', $post->id) }}" method="POST" style="margin:0;" 
                                  onsubmit="return confirm('Xác nhận xóa bài viết này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px; color: #64748b;">
                        Chưa có bài viết nào
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($posts->hasPages())
        <div class="pagination">
            {{ $posts->links() }}
        </div>
    @endif
</div>
@endsection
