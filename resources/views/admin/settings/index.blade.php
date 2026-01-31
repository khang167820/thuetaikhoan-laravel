@extends('admin.layouts.app')

@section('title', 'Cài đặt Hệ thống')
@section('page-title', 'Cài đặt Hệ thống')

@section('content')
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('admin.settings.save') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <!-- General Settings -->
    <div class="admin-card">
        <div class="admin-card-title">🌐 Thông tin Website</div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div class="form-group">
                <label class="form-label">Tên website</label>
                <input type="text" name="site_name" class="form-input" 
                       value="{{ $settings->get('site_name')?->value ?? 'ThueTaiKhoan.vn' }}">
            </div>
            <div class="form-group">
                <label class="form-label">Slogan</label>
                <input type="text" name="site_slogan" class="form-input" 
                       value="{{ $settings->get('site_slogan')?->value ?? 'Thuê tài khoản uy tín' }}">
            </div>
            <div class="form-group">
                <label class="form-label">Email liên hệ</label>
                <input type="email" name="contact_email" class="form-input" 
                       value="{{ $settings->get('contact_email')?->value ?? '' }}">
            </div>
            <div class="form-group">
                <label class="form-label">Số điện thoại</label>
                <input type="text" name="contact_phone" class="form-input" 
                       value="{{ $settings->get('contact_phone')?->value ?? '' }}">
            </div>
            <div class="form-group" style="grid-column: span 2;">
                <label class="form-label">Địa chỉ</label>
                <input type="text" name="contact_address" class="form-input" 
                       value="{{ $settings->get('contact_address')?->value ?? '' }}">
            </div>
        </div>
    </div>
    
    <!-- Social Links -->
    <div class="admin-card">
        <div class="admin-card-title">🔗 Liên kết Mạng xã hội</div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div class="form-group">
                <label class="form-label">Facebook</label>
                <input type="url" name="social_facebook" class="form-input" 
                       value="{{ $settings->get('social_facebook')?->value ?? '' }}"
                       placeholder="https://facebook.com/...">
            </div>
            <div class="form-group">
                <label class="form-label">Zalo</label>
                <input type="text" name="social_zalo" class="form-input" 
                       value="{{ $settings->get('social_zalo')?->value ?? '' }}"
                       placeholder="0123456789">
            </div>
            <div class="form-group">
                <label class="form-label">Telegram</label>
                <input type="text" name="social_telegram" class="form-input" 
                       value="{{ $settings->get('social_telegram')?->value ?? '' }}"
                       placeholder="@username">
            </div>
            <div class="form-group">
                <label class="form-label">YouTube</label>
                <input type="url" name="social_youtube" class="form-input" 
                       value="{{ $settings->get('social_youtube')?->value ?? '' }}"
                       placeholder="https://youtube.com/...">
            </div>
        </div>
    </div>
    
    <!-- SEO Settings -->
    <div class="admin-card">
        <div class="admin-card-title">🔍 Cài đặt SEO</div>
        
        <div class="form-group">
            <label class="form-label">Meta Title mặc định</label>
            <input type="text" name="seo_title" class="form-input" 
                   value="{{ $settings->get('seo_title')?->value ?? '' }}"
                   placeholder="ThueTaiKhoan.vn - Thuê tài khoản Unlocktool, Vietmap...">
        </div>
        <div class="form-group">
            <label class="form-label">Meta Description mặc định</label>
            <textarea name="seo_description" class="form-input" rows="3"
                      placeholder="Mô tả ngắn gọn về website...">{{ $settings->get('seo_description')?->value ?? '' }}</textarea>
        </div>
        <div class="form-group">
            <label class="form-label">Meta Keywords</label>
            <input type="text" name="seo_keywords" class="form-input" 
                   value="{{ $settings->get('seo_keywords')?->value ?? '' }}"
                   placeholder="thuê tài khoản, unlocktool, vietmap...">
        </div>
        <div class="form-group">
            <label class="form-label">Google Analytics ID</label>
            <input type="text" name="google_analytics_id" class="form-input" 
                   value="{{ $settings->get('google_analytics_id')?->value ?? '' }}"
                   placeholder="G-XXXXXXXXXX">
        </div>
    </div>
    
    <!-- Payment Settings -->
    <div class="admin-card">
        <div class="admin-card-title">💳 Cài đặt Thanh toán</div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div class="form-group">
                <label class="form-label">Số tài khoản ngân hàng</label>
                <input type="text" name="bank_account" class="form-input" 
                       value="{{ $settings->get('bank_account')?->value ?? '' }}">
            </div>
            <div class="form-group">
                <label class="form-label">Tên ngân hàng</label>
                <input type="text" name="bank_name" class="form-input" 
                       value="{{ $settings->get('bank_name')?->value ?? '' }}">
            </div>
            <div class="form-group">
                <label class="form-label">Chủ tài khoản</label>
                <input type="text" name="bank_holder" class="form-input" 
                       value="{{ $settings->get('bank_holder')?->value ?? '' }}">
            </div>
            <div class="form-group">
                <label class="form-label">MoMo</label>
                <input type="text" name="momo_phone" class="form-input" 
                       value="{{ $settings->get('momo_phone')?->value ?? '' }}"
                       placeholder="Số điện thoại MoMo">
            </div>
        </div>
    </div>
    
    <!-- Advanced Settings -->
    <div class="admin-card">
        <div class="admin-card-title">⚙️ Cài đặt Nâng cao</div>
        
        <div style="display: flex; flex-direction: column; gap: 12px;">
            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                <input type="checkbox" name="maintenance_mode" value="1"
                       {{ ($settings->get('maintenance_mode')?->value ?? 0) ? 'checked' : '' }}
                       style="width: 18px; height: 18px;">
                <span>Bật chế độ bảo trì (chỉ admin có thể truy cập)</span>
            </label>
            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                <input type="checkbox" name="registration_enabled" value="1"
                       {{ ($settings->get('registration_enabled')?->value ?? 1) ? 'checked' : '' }}
                       style="width: 18px; height: 18px;">
                <span>Cho phép đăng ký tài khoản mới</span>
            </label>
            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                <input type="checkbox" name="guest_checkout" value="1"
                       {{ ($settings->get('guest_checkout')?->value ?? 1) ? 'checked' : '' }}
                       style="width: 18px; height: 18px;">
                <span>Cho phép đặt hàng không cần đăng nhập</span>
            </label>
        </div>
    </div>
    
    <div style="display: flex; justify-content: flex-end; gap: 12px;">
        <button type="submit" class="btn btn-success" style="padding: 12px 32px;">
            💾 Lưu cài đặt
        </button>
    </div>
</form>
@endsection
