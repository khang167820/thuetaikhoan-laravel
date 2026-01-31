@extends('admin.layouts.app')

@section('title', $post ? 'Sửa bài viết' : 'Thêm bài viết')
@section('page-title', $post ? 'Sửa bài viết' : 'Thêm bài viết mới')

@section('content')
<form action="{{ route('admin.blog.save', $post->id ?? null) }}" method="POST">
    @csrf
    
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
        <!-- Main Content -->
        <div>
            <div class="admin-card">
                <div class="form-group">
                    <label class="form-label">Tiêu đề*</label>
                    <input type="text" name="title" class="form-input" required
                           value="{{ $post->title ?? old('title') }}"
                           placeholder="Nhập tiêu đề bài viết"
                           oninput="generateSlug(this.value)">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Slug (URL)*</label>
                    <input type="text" name="slug" id="slug" class="form-input" required
                           value="{{ $post->slug ?? old('slug') }}"
                           placeholder="tieu-de-bai-viet">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Mô tả ngắn</label>
                    <textarea name="excerpt" class="form-input" rows="3"
                              placeholder="Mô tả ngắn hiển thị trong danh sách">{{ $post->excerpt ?? old('excerpt') }}</textarea>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Nội dung*</label>
                    <textarea name="content" class="form-input" rows="15" required
                              placeholder="Nội dung bài viết (hỗ trợ HTML)">{{ $post->content ?? old('content') }}</textarea>
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
                        <option value="draft" {{ ($post->status ?? '') === 'draft' ? 'selected' : '' }}>Bản nháp</option>
                        <option value="published" {{ ($post->status ?? '') === 'published' ? 'selected' : '' }}>Xuất bản</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" name="featured" value="1" 
                               {{ ($post->featured ?? false) ? 'checked' : '' }}
                               style="width: 16px; height: 16px;">
                        <span class="form-label" style="margin-bottom: 0;">Bài viết nổi bật</span>
                    </label>
                </div>
                
                <div style="display: flex; gap: 8px;">
                    <button type="submit" class="btn btn-primary" style="flex: 1;">💾 Lưu</button>
                    <a href="{{ route('admin.blog') }}" class="btn btn-secondary">Hủy</a>
                </div>
            </div>
            
            <div class="admin-card">
                <div class="admin-card-title">Hình ảnh</div>
                
                <div class="form-group">
                    <label class="form-label">URL ảnh đại diện</label>
                    <input type="text" name="image" class="form-input" 
                           value="{{ $post->image ?? old('image') }}"
                           placeholder="https://example.com/image.jpg">
                </div>
                
                @if(isset($post->image) && $post->image)
                    <img src="{{ $post->image }}" alt="" style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px; margin-top: 8px;">
                @endif
            </div>
            
            <div class="admin-card">
                <div class="admin-card-title">SEO</div>
                
                <div class="form-group">
                    <label class="form-label">Meta Title</label>
                    <input type="text" name="meta_title" class="form-input" 
                           value="{{ $post->meta_title ?? old('meta_title') }}"
                           placeholder="Tiêu đề SEO">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Meta Description</label>
                    <textarea name="meta_description" class="form-input" rows="3"
                              placeholder="Mô tả SEO">{{ $post->meta_description ?? old('meta_description') }}</textarea>
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
@endsection
