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
<link rel="stylesheet" href="/css/price-modal.css">
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

{{-- Modal Popup - Using Homepage Structure --}}
<div id="price-modal" class="price-modal">
    <div class="price-modal-backdrop" onclick="closePackageModal()"></div>
    <div class="price-modal-content">
        <button class="price-modal-close" onclick="closePackageModal()">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
        
        <!-- Modal Header -->
        <div class="pm-header">
            <h2 class="pm-title">Chọn gói thuê</h2>
            <p class="pm-subtitle">Chọn gói thuê cho tài khoản: <strong style="color: {{ $service['color'] }}">{{ strtoupper($service['name']) }}</strong></p>
            <p style="font-size: 12px; color: #92400e; margin: 6px 0 0 0; padding: 8px 10px; background: linear-gradient(135deg, #fef3c7, #fef9c3); border-radius: 8px;">💡 Tích lũy điểm, khuyến mại và mã giảm giá sẽ được áp dụng ở bước thanh toán.</p>
        </div>
        
        <!-- Price Options List -->
        <div class="pm-options-scroll">
            <div class="pm-options" id="pm-options">
                @foreach($info['packages'] as $idx => $pkg)
                @php
                    $pkgPrice = (int)$pkg->price;
                    $pkgOld = (int)($pkg->original_price ?? $pkgPrice);
                    $pkgDisc = $pkg->discount_percent ?? 0;
                    $isHot = $idx === 0;
                    $isFlashSale = $pkgDisc >= 30;
                @endphp
                <div class="pm-option{{ $idx === 0 ? ' selected' : '' }}" data-id="{{ $pkg->id }}" data-price="{{ $pkgPrice }}" onclick="selectOption(this)">
                    <div class="pm-option-radio"></div>
                    <div class="pm-option-info">
                        <div class="pm-option-tags">
                            @if($isHot)
                            <span class="pm-tag hot">HOT</span>
                            @endif
                            @if($isFlashSale)
                            <span class="pm-tag flash-sale">FLASH SALE</span>
                            @elseif($pkgDisc > 0)
                            <span class="pm-tag promo">KHUYẾN MÃI</span>
                            @endif
                            <span class="pm-tag duration">{{ $pkg->hours_label }}</span>
                        </div>
                        <div class="pm-option-name">{{ $service['name'] }} {{ $pkg->hours_label }}</div>
                        <div class="pm-option-duration">Thời hạn: {{ $pkg->hours }} giờ</div>
                    </div>
                    <div class="pm-option-price">
                        <div class="pm-option-current" style="color: {{ $service['color'] }}">{{ number_format($pkgPrice) }} VND</div>
                        @if($pkgOld > $pkgPrice)
                        <div class="pm-option-old">{{ number_format($pkgOld) }} VND</div>
                        @endif
                        @if($pkgDisc > 0)
                        <div class="pm-option-discount">Giảm {{ $pkgDisc }}%</div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <!-- Discount Section -->
        <div class="pm-discount-section">
            <!-- Use Points Checkbox -->
            <label class="pm-checkbox" id="pm-use-points-wrapper">
                <input type="checkbox" id="pm-use-points" onchange="updatePriceDisplay()">
                <span class="pm-checkbox-mark"></span>
                <span class="pm-checkbox-label">Sử dụng điểm tích lũy (3.000 VND)</span>
            </label>
            
            <!-- Use Coupon Checkbox -->
            <label class="pm-checkbox">
                <input type="checkbox" id="pm-use-coupon" onchange="toggleCouponSection()">
                <span class="pm-checkbox-mark"></span>
                <span class="pm-checkbox-label">Sử dụng mã giảm giá</span>
            </label>
            
            <!-- Coupon Selection -->
            <div class="pm-coupon-section" id="pm-coupon-section" style="display:none;">
                <div class="pm-coupon-title">
                    <span>🎫</span> Chọn mã giảm giá:
                </div>
                <div class="pm-coupon-list" id="pm-coupon-list">
                    <div class="pm-coupon-item" data-code="THUE2000" onclick="selectCoupon('THUE2000')">
                        <div class="pm-coupon-code">THUE2000</div>
                        <div class="pm-coupon-info">
                            <div class="pm-coupon-value">Giảm 2,000đ</div>
                            <div class="pm-coupon-limit">Không giới hạn</div>
                        </div>
                        <span class="pm-coupon-use">Dùng</span>
                    </div>
                    <div class="pm-coupon-item" data-code="GIAM10" onclick="selectCoupon('GIAM10')">
                        <div class="pm-coupon-code">GIAM10</div>
                        <div class="pm-coupon-info">
                            <div class="pm-coupon-value">Giảm 10%</div>
                            <div class="pm-coupon-limit">Không giới hạn</div>
                        </div>
                        <span class="pm-coupon-use">Dùng</span>
                    </div>
                </div>
                
                <!-- Coupon Result Display -->
                <div id="pm-coupon-result" style="display: none; margin-top: 12px; padding: 12px; background: #f0fdf4; border: 1px solid #86efac; border-radius: 10px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <span style="font-size: 12px; color: #15803d; font-weight: 600;">✓ Mã <span id="pm-coupon-code-display"></span></span>
                        <button type="button" onclick="removeCoupon()" style="background: none; border: none; color: #dc2626; font-size: 11px; cursor: pointer;">Xóa</button>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 13px;">
                        <span style="color: #64748b;">Giá gốc:</span>
                        <span id="pm-original-price" style="color: #64748b; text-decoration: line-through;"></span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 13px;">
                        <span style="color: #16a34a;">Giảm:</span>
                        <span id="pm-discount-amount" style="color: #16a34a; font-weight: 600;"></span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 15px; margin-top: 6px; padding-top: 6px; border-top: 1px dashed #86efac;">
                        <span style="color: #1e293b; font-weight: 700;">Thành tiền:</span>
                        <span id="pm-final-price" style="color: #dc2626; font-weight: 800;"></span>
                    </div>
                </div>
                
                <!-- Error Message -->
                <div id="pm-coupon-error" style="display: none; margin-top: 8px; padding: 8px 12px; background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; color: #dc2626; font-size: 12px;"></div>
            </div>
        </div>
        
        <!-- Modal Footer -->
        <div class="pm-footer">
            <button type="button" class="pm-btn-cancel" onclick="closePackageModal()">Hủy</button>
            <button type="button" class="pm-btn-confirm" onclick="confirmPackage()" style="background: linear-gradient(135deg, {{ $service['color'] }} 0%, {{ $service['color'] }}cc 100%);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                    <line x1="1" y1="10" x2="23" y2="10"/>
                </svg>
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
    document.getElementById('price-modal').classList.add('open');
    document.body.classList.add('modal-open');
}

function closePackageModal() {
    document.getElementById('price-modal').classList.remove('open');
    document.body.classList.remove('modal-open');
}

function selectPackage(id) {
    // Find and select the option
    document.querySelectorAll('.pm-option').forEach(opt => {
        opt.classList.remove('selected');
        if (opt.dataset.id == id) {
            opt.classList.add('selected');
        }
    });
    openPackageModal();
}

function selectOption(el) {
    document.querySelectorAll('.pm-option').forEach(opt => opt.classList.remove('selected'));
    el.classList.add('selected');
}

function toggleCouponSection() {
    const checkbox = document.getElementById('pm-use-coupon');
    const section = document.getElementById('pm-coupon-section');
    section.style.display = checkbox.checked ? 'block' : 'none';
    if (!checkbox.checked) {
        removeCoupon();
    }
}

function selectCoupon(code) {
    // Remove previous selection
    document.querySelectorAll('.pm-coupon-item').forEach(item => {
        item.classList.remove('selected');
    });
    
    // Highlight selected
    const selectedItem = document.querySelector(`.pm-coupon-item[data-code="${code}"]`);
    if (selectedItem) {
        selectedItem.classList.add('selected');
    }
    
    // Get price and call API
    const price = getCurrentPackagePrice();
    if (price === 0) {
        alert('Vui lòng chọn gói thuê trước.');
        return;
    }
    
    // Call coupon validation API
    fetch('/api/coupons/validate?code=' + encodeURIComponent(code) + '&price=' + price)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                window.appliedCoupon = {
                    code: data.coupon.code,
                    discount: data.discount_amount,
                    finalPrice: data.final_price
                };
                updatePriceDisplay();
            } else {
                alert(data.message || 'Mã giảm giá không hợp lệ.');
                removeCoupon();
            }
        })
        .catch(err => {
            alert('Có lỗi xảy ra. Vui lòng thử lại.');
        });
}

function removeCoupon() {
    document.querySelectorAll('.pm-coupon-item').forEach(item => {
        item.classList.remove('selected');
    });
    document.getElementById('pm-coupon-result').style.display = 'none';
    window.appliedCoupon = null;
    updatePriceDisplay();
}

function formatVND(amount) {
    return new Intl.NumberFormat('vi-VN').format(amount) + ' VND';
}

// Fixed loyalty points value
const SERVICE_LOYALTY_POINTS = 3000;

// Get current package price from selected option
function getCurrentPackagePrice() {
    const selected = document.querySelector('.pm-option.selected');
    if (!selected) return 0;
    return parseInt(selected.dataset.price) || 0;
}

// Update price display with combined points + coupon
function updatePriceDisplay() {
    const resultBox = document.getElementById('pm-coupon-result');
    const usePoints = document.getElementById('pm-use-points')?.checked || false;
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
        document.getElementById('pm-coupon-code-display').textContent = discountLabel;
        document.getElementById('pm-original-price').textContent = formatVND(price);
        document.getElementById('pm-discount-amount').textContent = '-' + formatVND(totalDiscount);
        document.getElementById('pm-final-price').textContent = formatVND(finalPrice);
        resultBox.style.display = 'block';
    } else {
        resultBox.style.display = 'none';
    }
}

// Recalculate when package changes
document.querySelectorAll('.pm-option').forEach(opt => {
    opt.addEventListener('click', function() {
        if (window.appliedCoupon) {
            removeCoupon();
        }
    });
});

function confirmPackage() {
    console.log('confirmPackage called');
    const selected = document.querySelector('.pm-option.selected');
    console.log('Selected option:', selected);
    
    if (!selected) {
        alert('Vui lòng chọn một gói thuê.');
        return;
    }
    
    const priceId = selected.dataset.id;
    console.log('Price ID:', priceId);
    
    const coupon = window.appliedCoupon?.code || '';
    const usePoints = document.getElementById('pm-use-points')?.checked;
    
    let url = '/thanh-toan?price_id=' + priceId + '&service=' + SERVICE_TYPE;
    if (coupon) url += '&coupon=' + encodeURIComponent(coupon);
    if (usePoints) url += '&use_points=1';
    
    console.log('Redirecting to:', url);
    window.location.href = url;
}

document.getElementById('price-modal').addEventListener('click', function(e) {
    if (e.target === this) closePackageModal();
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closePackageModal();
});
</script>
@endsection
