@extends('layouts.app')

@section('title', 'Thuê ' . $service['name'] . ' - Giá Rẻ Từ ' . number_format($info['min']) . ' VND')

@section('service_color', $service['color'])

@section('styles')
<link rel="stylesheet" href="/css/service-page.css">
<style>
/* Dark Mode for Service Page */
[data-theme="dark"] h1, [data-theme="dark"] .service-section-title { color: var(--ink) !important; }
[data-theme="dark"] .fo-card { background: var(--bg-card); border-color: #475569; }
[data-theme="dark"] .fo-title { color: var(--ink); }
[data-theme="dark"] .fo-subline { color: var(--muted); }
[data-theme="dark"] .package-card { background: var(--bg-card); border-color: #475569; }
[data-theme="dark"] .package-duration { color: var(--ink); }
[data-theme="dark"] .package-price { color: var(--primary); }
[data-theme="dark"] .features-card { background: var(--bg-card); border-color: #334155; }
[data-theme="dark"] .features-title { color: var(--ink); }
[data-theme="dark"] .features-desc { color: var(--muted); }
[data-theme="dark"] .tool-ad-container { background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border-color: #334155; }
[data-theme="dark"] .faq-item { background: var(--bg-card); border-color: #334155; }
[data-theme="dark"] .faq-question { color: var(--ink); }
[data-theme="dark"] .faq-answer { color: var(--muted); }
[data-theme="dark"] .service-section { background: var(--bg); }
[data-theme="dark"] p { color: var(--muted); }
</style>
@endsection

@section('content')
{{-- Section 1: Service Card --}}
<div style="max-width: 1200px; margin: 40px auto; padding: 0 20px;">
    <div style="text-align: center; margin-bottom: 30px;">
        <h1 style="font-size: 28px; font-weight: 700; color: #1e293b; margin-bottom: 10px;">Thuê nhanh {{ $service['name'] }}</h1>
        <p style="color: #64748b; font-size: 16px;">Sau khi thanh toán, chỉ cần quay lại trang thanh toán — hệ thống sẽ tự chuyển bạn đến trang nhận tài khoản.</p>
    </div>
    
    <div style="display: flex; justify-content: center;">
        <article class="fo-card" style="max-width: 400px; width: 100%;">
            <div class="fo-ribbon">Flash Sale</div>
            <a class="fo-coupon-pill" href="/ma-giam-gia">Mã giảm giá</a>

            <div class="fo-logo-wrap">
                <div class="fo-logo-circle">
                    <img src="{{ $service['logo'] }}" alt="{{ $service['name'] }}">
                </div>
            </div>

            <div class="fo-title">{{ $service['name'] }}</div>
            <div class="fo-subline">{{ $service['description'] }}</div>

            @php
                $hasDiscount = $info['discMax'] > 0;
            @endphp

            @if($hasDiscount)
            <div class="fo-event">
                <div class="fo-event-line1">% Đang giảm giá đến {{ $info['discMax'] }}%</div>
                <div class="fo-event-line2">Sự kiện Flash Sale: Khung giờ vàng</div>
            </div>
            @endif

            <ul class="fo-features">
                @foreach($service['features'] as $feature)
                <li>
                    <span class="fo-dot {{ $feature['dot'] }}"></span>
                    <span class="fo-feature-text">{{ $feature['text'] }}</span>
                </li>
                @endforeach
            </ul>

            <div class="fo-divider"></div>

            <div class="fo-price-row">
                <div class="fo-price-left">
                    <div class="fo-price-label">Từ</div>
                    <div class="fo-price-main">
                        <span class="fo-price-from">{{ number_format($info['min']) }} VND</span>
                        @if($hasDiscount)
                        <span class="fo-price-badge">-{{ $info['discMax'] }}%</span>
                        @endif
                    </div>
                </div>
                <div class="fo-price-right">
                    <span class="fo-package-pill">{{ $info['count'] }} gói thuê</span>
                </div>
            </div>

            @if($info['available'])
            <button class="fo-bottom-btn" type="button" onclick="openPackageModal()">
                <span>🛒</span>
                <span>Flash Sale</span>
            </button>
            @else
            <button class="fo-bottom-btn fo-bottom-btn--disabled" type="button" disabled>
                <span>Hết tài khoản</span>
            </button>
            @endif
        </article>
    </div>
</div>

{{-- Section 2: Packages Grid --}}
<section class="service-section" id="packages">
    <h2 class="service-section-title">Các Gói Thuê {{ strtoupper($service['name']) }}</h2>
    
    <div class="packages-grid">
        @foreach($info['packages'] as $pkg)
        @php
            $pkgPrice = (int)$pkg->price;
            $pkgOld = (int)($pkg->original_price ?? $pkgPrice);
            $pkgDisc = $pkg->discount_percent ?? 0;
        @endphp
        <div class="package-card">
            @if($pkgDisc > 0)
            <div class="package-badge">Giảm {{ $pkgDisc }}%</div>
            @endif
            
            <div class="package-duration">{{ $service['name'] }} {{ $pkg->hours_label }}</div>
            
            <div class="package-price">
                {{ number_format($pkgPrice) }} VND
                @if($pkgOld > $pkgPrice)
                <span class="package-price-old">{{ number_format($pkgOld) }} VND</span>
                @endif
            </div>
            
            <ul class="package-features">
                <li>Truy cập đầy đủ tính năng</li>
                <li>Tự động nhận tài khoản sau thanh toán</li>
                <li>Bảo hành trong thời gian thuê</li>
            </ul>
            
            @if($info['available'])
            <button class="package-btn" onclick="selectPackage({{ $pkg->id }})">Thuê ngay</button>
            @else
            <button class="package-btn package-btn--disabled" disabled>Hết tài khoản</button>
            @endif
        </div>
        @endforeach
    </div>
    
    <div style="text-align: center; margin-top: 40px;">
        <a href="/ma-giam-gia" style="color: {{ $service['color'] }}; text-decoration: none; font-weight: 600;">
            🎁 Áp dụng mã giảm giá để tiết kiệm thêm
        </a>
    </div>
</section>

{{-- Section 3: Why Choose --}}
@php
    $whyChoose = $service['whyChoose'] ?? [];
@endphp
@if(count($whyChoose) > 0)
<section class="service-section" style="background: #f8fafc; padding: 60px 20px;">
    <div style="max-width: 1200px; margin: 0 auto;">
        <h2 class="service-section-title">Tại sao chọn {{ $service['name'] }}?</h2>
        <div class="features-grid">
            @foreach($whyChoose as $feature)
            <div class="feature-item">
                <div class="feature-icon">{{ $feature['icon'] }}</div>
                <div class="feature-title">{{ $feature['title'] }}</div>
                <div class="feature-desc">{{ $feature['desc'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Section 4: FAQ --}}
@php
    $faqList = $service['faq'] ?? [];
@endphp
@if(count($faqList) > 0)
<section class="service-section">
    <h2 class="service-section-title">Câu hỏi thường gặp (FAQ)</h2>
    <div style="max-width: 800px; margin: 0 auto;">
        @foreach($faqList as $faq)
        <details style="background: #f8fafc; padding: 20px; margin-bottom: 16px; border-radius: 12px; cursor: pointer;">
            <summary style="font-weight: 600; font-size: 18px; color: #1e293b;">{{ $faq['q'] }}</summary>
            <p style="margin-top: 12px; color: #64748b; line-height: 1.8;">{{ $faq['a'] }}</p>
        </details>
        @endforeach
    </div>
</section>
@endif

{{-- Modal Popup - Redesigned --}}
<div class="pkg-modal-overlay" id="pkg-modal">
    <div class="pkg-modal">
        <div class="pkg-modal-header">
            <div>
                <div class="pkg-modal-title">Chọn gói thuê</div>
                <div class="pkg-modal-sub">Chọn gói thuê cho: <strong style="color: {{ $service['color'] }}">{{ strtoupper($service['name']) }}</strong></div>
            </div>
            <button class="pkg-modal-close" onclick="closePackageModal()">&times;</button>
        </div>
        
        <div class="pkg-modal-body">
            {{-- Info Banner --}}
            <div style="margin: 12px 0; padding: 10px 12px; background: linear-gradient(135deg, #fef3c7, #fef9c3); border: 1px solid #fcd34d; border-radius: 10px; display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 16px;">💡</span>
                <span style="font-size: 12px; color: #92400e;">Tích lũy điểm, khuyến mại và mã giảm giá sẽ được áp dụng ở bước thanh toán.</span>
            </div>
            
            <div class="pkg-options">
                @foreach($info['packages'] as $idx => $pkg)
                @php
                    $pkgPrice = (int)$pkg->price;
                    $pkgOld = (int)($pkg->original_price ?? $pkgPrice);
                    $pkgDisc = $pkg->discount_percent ?? 0;
                    $isHot = $idx === 0;
                    $isFlashSale = $pkgDisc >= 30;
                @endphp
                <label class="pkg-item">
                    <input type="radio" name="package_select" value="{{ $pkg->id }}" class="pkg-radio"{{ $idx === 0 ? ' checked' : '' }}>
                    <div class="pkg-card">
                        {{-- Tags --}}
                        <div class="pkg-tags">
                            @if($isHot)
                            <span class="pkg-tag pink">🔥 HOT</span>
                            @endif
                            @if($isFlashSale)
                            <span class="pkg-tag green">⚡ FLASH SALE</span>
                            @elseif($pkgDisc > 0)
                            <span class="pkg-tag blue">🎁 KHUYẾN MÃI</span>
                            @endif
                            <span class="pkg-tag" style="background: #f1f5f9; color: #475569; border-color: #e2e8f0;">{{ $pkg->hours_label }}</span>
                        </div>
                        
                        <div class="pkg-card-main">
                            <div class="pkg-left">
                                <div class="pkg-name">{{ $service['name'] }} {{ $pkg->hours_label }}</div>
                                <div class="pkg-duration">Thời hạn: {{ $pkg->hours }} giờ</div>
                            </div>
                            <div class="pkg-right">
                                <div class="pkg-price-line">
                                    <span class="pkg-price" style="color: {{ $service['color'] }}; font-size: 16px;">{{ number_format($pkgPrice) }} VND</span>
                                </div>
                                @if($pkgOld > $pkgPrice)
                                <span class="pkg-price-old">{{ number_format($pkgOld) }} VND</span>
                                @endif
                                @if($pkgDisc > 0)
                                <span class="pkg-discount">Tiết kiệm {{ $pkgDisc }}%</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </label>
                @endforeach
            </div>
            
            {{-- Voucher Section --}}
            <div class="pkg-coupon">
                <div class="pkg-voucher-box" style="display: block;">
                    <div style="font-size: 12px; color: #6b7280; margin-bottom: 8px; display: flex; align-items: center; gap: 6px;">
                        <span>🎟️</span> Sử dụng mã giảm giá
                    </div>
                    <div class="pkg-voucher-row">
                        <input type="text" class="pkg-voucher-input" id="voucher-code" placeholder="Nhập mã giảm giá">
                        <button type="button" class="pkg-voucher-btn" onclick="applyVoucher()">Áp dụng</button>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Footer --}}
        <div class="pkg-modal-footer">
            <button class="pkg-btn" onclick="closePackageModal()">Hủy</button>
            <button class="pkg-btn pkg-btn-primary" onclick="confirmPackage()" style="background: {{ $service['color'] }}; border-color: {{ $service['color'] }};">
                Xác nhận thuê
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const SERVICE_TYPE = '{{ $type }}';

function openPackageModal() {
    document.getElementById('pkg-modal').classList.add('active');
    document.body.classList.add('modal-open');
}

function closePackageModal() {
    document.getElementById('pkg-modal').classList.remove('active');
    document.body.classList.remove('modal-open');
}

function selectPackage(id) {
    document.querySelector('input[value="'+id+'"]').checked = true;
    openPackageModal();
}

function applyVoucher() {
    const code = document.getElementById('voucher-code').value.trim();
    if (!code) {
        alert('Vui lòng nhập mã giảm giá.');
        return;
    }
    alert('Mã giảm giá sẽ được áp dụng tại bước thanh toán.');
}

function confirmPackage() {
    const selected = document.querySelector('input[name="package_select"]:checked');
    if (!selected) {
        alert('Vui lòng chọn một gói thuê.');
        return;
    }
    
    const priceId = selected.value;
    const voucher = document.getElementById('voucher-code').value.trim();
    
    let url = '/thanh-toan?price_id=' + priceId + '&service=' + SERVICE_TYPE;
    if (voucher) url += '&coupon=' + encodeURIComponent(voucher);
    
    window.location.href = url;
}

document.getElementById('pkg-modal').addEventListener('click', function(e) {
    if (e.target === this) closePackageModal();
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closePackageModal();
});
</script>
@endsection
