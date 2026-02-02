@extends('layouts.app')

@section('title', 'Thuê ' . $service['name'] . ' - Giá Rẻ Từ ' . number_format($info['min']) . ' VND')

@section('service_color', $service['color'])

@section('meta_description', 'Thuê ' . $service['name'] . ' giá rẻ từ ' . number_format($info['min']) . ' VND. Tự động nhận tài khoản sau thanh toán. Hỗ trợ 24/7.')

@section('schema')
@include('partials.seo-schemas', [
    'breadcrumbs' => [
        ['name' => 'Trang chủ', 'url' => url('/')],
        ['name' => 'Dịch vụ', 'url' => url('/dich-vu')],
        ['name' => $service['name'], 'url' => url()->current()]
    ],
    'productSchema' => [
        'name' => 'Thuê ' . $service['name'],
        'description' => $service['description'],
        'image' => asset($service['logo']),
        'lowPrice' => $info['min'],
        'highPrice' => $info['max'] ?? $info['min'],
        'offerCount' => count($info['packages']),
        'available' => $info['available']
    ],
    'faqSchema' => $service['faq'] ?? []
])
@endsection

@section('styles')
<link rel="stylesheet" href="/css/service-page.css">
<link rel="stylesheet" href="/css/modern-ui.css">
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
<div style="max-width: 1200px; margin: 20px auto; padding: 0 20px;">
    <div style="text-align: center; margin-bottom: 20px;">
        <h1 style="font-size: 26px; font-weight: 700; color: #1e293b; margin-bottom: 8px;">Thuê nhanh {{ $service['name'] }}</h1>
        <p style="color: #64748b; font-size: 15px;">Sau khi thanh toán, chỉ cần quay lại trang thanh toán — hệ thống sẽ tự chuyển bạn đến trang nhận tài khoản.</p>
    </div>
    
    <div style="display: flex; justify-content: center;">
        <article class="fo-card-compact" style="max-width: 400px; width: 100%;">
            <span class="fo-badge-compact">Flash Sale</span>
            <a class="fo-coupon-compact" href="/ma-giam-gia">Mã giảm giá</a>
            
            <div class="fo-logo-compact">
                <img src="{{ $service['logo'] }}" alt="{{ $service['name'] }}">
            </div>
            
            <h3 class="fo-title-compact">{{ $service['name'] }}</h3>
            <p class="fo-desc-compact">{{ $service['description'] }}</p>
            
            <ul class="fo-features-compact collapsed" id="features-service">
                @foreach($service['features'] as $index => $feature)
                <li class="{{ $index >= 2 ? 'fo-feature-extra' : '' }}">
                    <span class="dot {{ $feature['dot'] }}"></span>{{ $feature['text'] }}
                </li>
                @endforeach
            </ul>
            
            <button class="fo-more-compact" onclick="toggleFeatures('service')">
                <span class="collapse-text" style="display:none">Thu gọn</span>
                <span class="expand-text">Xem thêm</span>
            </button>
            
            @if($info['available'])
            <button type="button" onclick="openPackageModal()" class="fo-cta-compact">
                <span class="fo-price-compact">{{ number_format($info['min']) }} VND</span>
                @if($info['discMax'] > 0)
                <span class="fo-price-old-compact">-{{ $info['discMax'] }}%</span>
                @endif
            </button>
            @else
            <button class="fo-cta-compact" style="background: #9ca3af; cursor: not-allowed;" disabled>
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
            
            <div class="package-header">
                <div class="package-duration">{{ $service['name'] }} {{ $pkg->hours_label }}</div>
            </div>
            
            <div class="package-pricing">
                <span class="package-price-current">{{ number_format($pkgPrice) }}</span>
                <span class="package-price-currency">VND</span>
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
            
            {{-- Points & Voucher Section --}}
            <div class="pkg-coupon">
                {{-- Loyalty Points Checkbox --}}
                <label style="display: flex; align-items: center; gap: 8px; padding: 10px 0; cursor: pointer; font-size: 13px; color: #1f2937;">
                    <input type="checkbox" id="use-points-checkbox" onchange="updateServicePriceDisplay()" style="width: 16px; height: 16px; accent-color: #2563eb;">
                    <span>💰 Sử dụng điểm tích lũy (3.000 VND)</span>
                </label>
                
                <div class="pkg-voucher-box" style="display: block;">
                    <div style="font-size: 12px; color: #6b7280; margin-bottom: 8px; display: flex; align-items: center; gap: 6px;">
                        <span>🎟️</span> Sử dụng mã giảm giá
                    </div>
                    <div class="pkg-voucher-row">
                        <input type="text" class="pkg-voucher-input" id="voucher-code" placeholder="Nhập mã giảm giá">
                        <button type="button" class="pkg-voucher-btn" id="apply-voucher-btn" onclick="applyVoucher()">Áp dụng</button>
                    </div>
                    
                    {{-- Coupon Result --}}
                    <div id="coupon-result" style="display: none; margin-top: 12px; padding: 12px; background: #f0fdf4; border: 1px solid #86efac; border-radius: 10px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                            <span style="font-size: 12px; color: #15803d; font-weight: 600;">✓ Mã <span id="coupon-code-display"></span></span>
                            <button type="button" onclick="removeCoupon()" style="background: none; border: none; color: #dc2626; font-size: 11px; cursor: pointer;">Xóa</button>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 13px;">
                            <span style="color: #64748b;">Giá gốc:</span>
                            <span id="original-price-display" style="color: #64748b; text-decoration: line-through;"></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 13px;">
                            <span style="color: #16a34a;">Giảm:</span>
                            <span id="discount-amount-display" style="color: #16a34a; font-weight: 600;"></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 15px; margin-top: 6px; padding-top: 6px; border-top: 1px dashed #86efac;">
                            <span style="color: #1e293b; font-weight: 700;">Thành tiền:</span>
                            <span id="final-price-display" style="color: #dc2626; font-weight: 800;"></span>
                        </div>
                    </div>
                    
                    {{-- Error Message --}}
                    <div id="coupon-error" style="display: none; margin-top: 8px; padding: 8px 12px; background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; color: #dc2626; font-size: 12px;"></div>
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

function toggleFeatures(id) {
    const features = document.getElementById('features-' + id);
    const card = features.closest('.fo-card-compact');
    if (features.classList.contains('collapsed')) {
        features.classList.remove('collapsed');
        card?.classList.add('expanded');
    } else {
        features.classList.add('collapsed');
        card?.classList.remove('expanded');
    }
}

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
    const btn = document.getElementById('apply-voucher-btn');
    const resultBox = document.getElementById('coupon-result');
    const errorBox = document.getElementById('coupon-error');
    
    // Hide previous results
    resultBox.style.display = 'none';
    errorBox.style.display = 'none';
    
    if (!code) {
        errorBox.textContent = 'Vui lòng nhập mã giảm giá.';
        errorBox.style.display = 'block';
        return;
    }
    
    // Get selected package price
    const selected = document.querySelector('input[name="package_select"]:checked');
    if (!selected) {
        errorBox.textContent = 'Vui lòng chọn gói thuê trước.';
        errorBox.style.display = 'block';
        return;
    }
    
    const priceElement = selected.closest('.pkg-item').querySelector('.pkg-price');
    const priceText = priceElement ? priceElement.textContent : '0';
    const price = parseInt(priceText.replace(/[^\d]/g, '')) || 0;
    
    // Show loading
    btn.textContent = 'Đang kiểm tra...';
    btn.disabled = true;
    
    // Call API
    fetch('/api/coupons/validate?code=' + encodeURIComponent(code) + '&price=' + price)
        .then(res => res.json())
        .then(data => {
            btn.textContent = 'Áp dụng';
            btn.disabled = false;
            
            if (data.success) {
                // Store for combined calculation
                window.appliedCoupon = {
                    code: data.coupon.code,
                    discount: data.discount_amount,
                    finalPrice: data.final_price
                };
                
                // Use updateServicePriceDisplay for combined points + coupon calculation
                updateServicePriceDisplay();
            } else {
                errorBox.textContent = data.message || 'Mã giảm giá không hợp lệ.';
                errorBox.style.display = 'block';
            }
        })
        .catch(err => {
            btn.textContent = 'Áp dụng';
            btn.disabled = false;
            errorBox.textContent = 'Có lỗi xảy ra. Vui lòng thử lại.';
            errorBox.style.display = 'block';
        });
}

function removeCoupon() {
    document.getElementById('voucher-code').value = '';
    document.getElementById('coupon-result').style.display = 'none';
    document.getElementById('coupon-error').style.display = 'none';
    window.appliedCoupon = null;
    updateServicePriceDisplay();
}

function formatVND(amount) {
    return new Intl.NumberFormat('vi-VN').format(amount) + ' VND';
}

// Fixed loyalty points value
const SERVICE_LOYALTY_POINTS = 3000;

// Get current package price
function getCurrentPackagePrice() {
    const selected = document.querySelector('input[name="package_select"]:checked');
    if (!selected) return 0;
    const priceElement = selected.closest('.pkg-item').querySelector('.pkg-price');
    const priceText = priceElement ? priceElement.textContent : '0';
    return parseInt(priceText.replace(/[^\d]/g, '')) || 0;
}

// Update price display with combined points + coupon
function updateServicePriceDisplay() {
    const resultBox = document.getElementById('coupon-result');
    const usePoints = document.getElementById('use-points-checkbox')?.checked || false;
    const price = getCurrentPackagePrice();
    
    if (price === 0) return;
    
    let totalDiscount = 0;
    let discountLabel = '';
    
    // Add loyalty points
    if (usePoints) {
        totalDiscount += SERVICE_LOYALTY_POINTS;
        discountLabel = 'Điểm tích lũy';
    }
    
    // Add coupon
    if (window.appliedCoupon && window.appliedCoupon.discount > 0) {
        totalDiscount += window.appliedCoupon.discount;
        discountLabel = usePoints ? 'Điểm + Mã' : window.appliedCoupon.code;
    }
    
    if (totalDiscount > 0) {
        const finalPrice = Math.max(0, price - totalDiscount);
        document.getElementById('coupon-code-display').textContent = discountLabel;
        document.getElementById('original-price-display').textContent = formatVND(price);
        document.getElementById('discount-amount-display').textContent = '-' + formatVND(totalDiscount);
        document.getElementById('final-price-display').textContent = formatVND(finalPrice);
        resultBox.style.display = 'block';
    } else {
        resultBox.style.display = 'none';
    }
}

// Recalculate when package changes
document.querySelectorAll('input[name="package_select"]').forEach(radio => {
    radio.addEventListener('change', function() {
        if (window.appliedCoupon) {
            removeCoupon();
        }
    });
});

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
