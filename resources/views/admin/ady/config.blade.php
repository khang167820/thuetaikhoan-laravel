@extends('admin.layouts.app')

@section('title', 'ADY Config')
@section('page-title', 'ADY Unlocker Config')

@section('content')
<div class="admin-card" style="max-width: 600px;">
    <div class="admin-card-title">Cấu hình API ADY Unlocker</div>
    
    @if(session('success'))
        <div style="background: #065f46; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; color: #6ee7b7;">
            ✓ {{ session('success') }}
        </div>
    @endif
    
    <form action="{{ route('admin.ady.config.save') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label class="form-label">API URL</label>
            <input type="text" name="ady_api_url" class="form-input" 
                   value="{{ $settings->get('ady_api_url')?->value ?? 'https://api.adyunlocker.com' }}"
                   placeholder="https://api.adyunlocker.com">
        </div>
        
        <div class="form-group">
            <label class="form-label">API Key (Access Token)</label>
            <input type="text" name="ady_api_token" class="form-input" 
                   value="{{ $settings->get('ady_api_token')?->value ?? '' }}"
                   placeholder="Nhập API Key từ ADY-Unlocker">
            <small style="color: #64748b; font-size: 11px;">Lấy từ shop.adyunlocker.com → Profile → API Settings</small>
        </div>
        
        <hr style="border-color: #334155; margin: 20px 0;">
        
        <div class="form-group">
            <label class="form-label">💰 Tỷ giá USD/VND</label>
            <input type="number" name="usd_to_vnd_rate" class="form-input" 
                   value="{{ $settings->get('usd_to_vnd_rate')?->value ?? 26800 }}"
                   placeholder="26800" step="100">
            <small style="color: #64748b; font-size: 11px;">VD: 26800 = 1 USD = 26,800 VND</small>
        </div>
        
        <div class="form-group">
            <label class="form-label">📈 Markup (%)</label>
            <input type="number" name="ady_markup_percent" class="form-input" 
                   value="{{ $settings->get('ady_markup_percent')?->value ?? 6 }}"
                   placeholder="6" step="0.5" min="0" max="100">
            <small style="color: #64748b; font-size: 11px;">Phần trăm lợi nhuận thêm vào giá gốc. VD: 6% → Giá bán = Giá gốc × 1.06</small>
        </div>
        
        <hr style="border-color: #334155; margin: 20px 0;">
        
        <div class="form-group">
            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                <input type="checkbox" name="ady_enabled" value="1" 
                       {{ ($settings->get('ady_enabled')?->value ?? 0) ? 'checked' : '' }}
                       style="width: 16px; height: 16px;">
                <span class="form-label" style="margin-bottom: 0;">Kích hoạt tích hợp ADY</span>
            </label>
        </div>
        
        <button type="submit" class="btn btn-primary">💾 Lưu cấu hình</button>
    </form>
</div>

<div class="admin-card" style="max-width: 600px;">
    <div class="admin-card-title">Hướng dẫn</div>
    <div style="color: #94a3b8; font-size: 13px; line-height: 1.6;">
        <p>ADY Unlocker là dịch vụ mở khóa điện thoại chuyên nghiệp.</p>
        <ul style="margin: 12px 0; padding-left: 20px;">
            <li>Đăng ký tài khoản tại <a href="https://shop.adyunlocker.com" target="_blank" style="color: #3b82f6;">shop.adyunlocker.com</a></li>
            <li>Vào Profile → API Settings → Tạo API Access</li>
            <li>Copy Access Token và paste vào ô API Key ở trên</li>
            <li>Thêm IP server của bạn vào Allowed IPs trên ADY</li>
        </ul>
        <p style="margin-top: 12px;"><strong>Công thức tính giá:</strong></p>
        <code style="background: #1e293b; padding: 8px 12px; border-radius: 4px; display: block; margin-top: 8px;">
            Giá VND = Giá USD × Tỷ giá × (1 + Markup%)
        </code>
    </div>
</div>
@endsection
