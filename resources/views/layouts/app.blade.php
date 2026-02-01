<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Thuetaikhoan.net - Hệ thống cho thuê tài khoản UnlockTool, Vietmap Live, Griffin, TSM Tool tự động 24/7')">
    <meta name="keywords" content="@yield('meta_keywords', 'thuê tài khoản, unlocktool, vietmap, griffin, tsm tool')">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Thuetaikhoan.net">
    
    <title>@yield('title', 'Thuetaikhoan.net - Cho thuê tài khoản UnlockTool, Vietmap')</title>
    
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title')">
    <meta property="og:description" content="@yield('meta_description')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.png'))">
    
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- Performance optimizations -->
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Font with font-display swap -->
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&display=swap" rel="stylesheet"></noscript>
    
    @yield('schema')
    
    <!-- Shared CSS -->
    <link rel="stylesheet" href="/css/mobile-menu.css?v=1">
    
    <style>
        :root {
            --primary: #1e40af;
            --primary-dark: #1e3a8a;
            --accent: #f97316;
            --accent-dark: #ea580c;
            --ink: #1f2937;
            --muted: #6b7280;
            --light: #f8fafc;
            --line: #e5e7eb;
            --bg: #ffffff;
            --bg-card: #ffffff;
            --service-color: @yield('service_color', '#f97316');
        }
        
        /* Dark Theme */
        [data-theme="dark"] {
            --primary: #60a5fa;
            --primary-dark: #3b82f6;
            --ink: #f1f5f9;
            --muted: #94a3b8;
            --light: #1e293b;
            --line: #334155;
            --bg: #0f172a;
            --bg-card: #1e293b;
        }
        
        *, *::before, *::after { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Be Vietnam Pro', system-ui, sans-serif;
            font-size: 15px;
            line-height: 1.6;
            color: var(--ink);
            background: var(--bg);
            transition: background 0.3s, color 0.3s;
        }
        a { color: inherit; text-decoration: none; }
        img { max-width: 100%; height: auto; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        
        /* HEADER */
        .site-header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: #fff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            transition: background 0.3s;
        }
        [data-theme="dark"] .site-header { background: var(--bg); }
        
        /* Theme Toggle */
        .theme-toggle {
            width: 40px; height: 40px;
            border-radius: 10px; border: 2px solid var(--line);
            background: var(--light); cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; transition: all 0.2s;
        }
        .theme-toggle:hover { border-color: var(--primary); transform: scale(1.05); }
        .header-main {
            padding: 12px 0;
            border-bottom: 1px solid var(--line);
        }
        .header-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            max-width: 100%;
            padding: 0 20px;
        }
        .header-left { display: flex; align-items: center; gap: 4px; }
        .header-right { display: flex; align-items: center; gap: 12px; margin-left: auto; }
        .header-brand { display: flex; align-items: center; gap: 8px; text-decoration: none; flex-shrink: 0; margin-right: 8px; }
        .header-logo { width: 36px; height: 36px; border-radius: 8px; }
        .header-brand-text { display: flex; flex-direction: column; }
        .brand-name { font-size: 16px; font-weight: 800; color: var(--primary); line-height: 1.2; }
        .brand-tagline { font-size: 10px; color: var(--muted); font-weight: 500; white-space: nowrap; }
        
        /* Navigation */
        .header-nav { display: flex; align-items: center; gap: 0; }
        .nav-link {
            display: flex; align-items: center; gap: 4px;
            padding: 6px 8px; font-size: 12px; font-weight: 600;
            color: var(--ink); border-radius: 8px; transition: all 0.2s; white-space: nowrap;
        }
        .nav-link:hover { background: var(--light); color: var(--primary); }
        .nav-link.active { color: var(--primary); background: #eff6ff; }
        .nav-icon-box {
            width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;
            background: #f3f4f6; border-radius: 6px; color: #6b7280; transition: all 0.2s;
        }
        .nav-link:hover .nav-icon-box { background: #dbeafe; color: var(--primary); }
        
        /* Dropdown */
        .nav-dropdown { position: relative; }
        .nav-dropdown-menu {
            position: absolute; top: 100%; left: 0; min-width: 200px;
            background: #fff; border-radius: 12px; box-shadow: 0 8px 30px rgba(0,0,0,0.12);
            padding: 8px; opacity: 0; visibility: hidden; transform: translateY(10px);
            transition: all 0.2s; z-index: 100; display: flex; flex-direction: column; gap: 2px;
        }
        .nav-dropdown:hover .nav-dropdown-menu { opacity: 1; visibility: visible; transform: translateY(0); }
        .nav-dropdown-menu a {
            display: flex; align-items: center; gap: 10px; padding: 10px 14px;
            color: #374151; font-size: 14px; font-weight: 500; border-radius: 6px; transition: all 0.15s;
        }
        .nav-dropdown-menu a:hover { background: #f0f7ff; color: #2563eb; }
        .nav-dropdown-menu a svg { width: 16px; height: 16px; color: #9ca3af; }
        .nav-dropdown-menu a:hover svg { color: #2563eb; }
        
        /* Dropdown CTA Button - Premium Style */
        .nav-dropdown-menu .dropdown-cta {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: #fff !important;
            font-weight: 600;
            border-radius: 8px;
            margin-top: 4px;
            padding: 10px 14px;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(249, 115, 22, 0.25);
            transition: all 0.2s ease;
            white-space: nowrap;
        }
        .nav-dropdown-menu .dropdown-cta:hover {
            background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.35);
        }
        .nav-dropdown-menu .dropdown-cta svg { color: #fff !important; }
        
        /* History Dropdown */
        .header-history-dropdown { position: relative; display: flex; align-items: center; flex-shrink: 0; margin-right: 12px; }
        .header-history-dropdown .nav-dropdown { position: relative; }
        .header-history-dropdown .nav-link {
            display: flex; align-items: center; gap: 8px; padding: 8px 16px;
            background: #fff; border: 1px solid #e5e7eb; border-radius: 12px;
            font-size: 13px; font-weight: 600; color: var(--ink); transition: all 0.2s;
        }
        .header-history-dropdown .nav-link:hover { background: #f9fafb; border-color: var(--primary); color: var(--primary); }
        .header-history-dropdown .nav-icon-box {
            width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;
            background: #f3f4f6; border-radius: 6px; color: #6b7280; transition: all 0.2s;
        }
        .header-history-dropdown .nav-link:hover .nav-icon-box { background: #dbeafe; color: var(--primary); }
        .header-history-dropdown .nav-arrow-icon { margin-left: 2px; opacity: 0.5; }
        .header-history-dropdown .nav-dropdown-menu { right: 0; left: auto; min-width: 260px; }
        .header-history-dropdown .history-menu { padding: 0; }
        .history-search-in-dropdown { padding: 12px; border-top: 1px solid #f1f5f9; }
        .history-search-form-dropdown {
            display: flex; align-items: center;
            background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden;
        }
        .history-search-form-dropdown:focus-within { border-color: var(--primary); background: #fff; box-shadow: 0 0 0 3px rgba(30,64,175,0.1); }
        .history-search-input-dropdown {
            flex: 1; padding: 10px 12px; border: none; background: transparent;
            font-size: 13px; outline: none; color: var(--ink);
        }
        .history-search-input-dropdown::placeholder { color: #9ca3af; }
        .history-search-btn-dropdown {
            padding: 10px 12px; background: var(--primary); border: none; cursor: pointer;
            color: #fff; display: flex; align-items: center; justify-content: center; transition: all 0.2s;
        }
        .history-search-btn-dropdown:hover { background: var(--primary-dark); }
        
        /* Dark mode for history dropdown */
        [data-theme="dark"] .header-history-dropdown .nav-link { background: var(--bg-card); border-color: #334155; }
        [data-theme="dark"] .header-history-dropdown .nav-link:hover { border-color: #60a5fa; }
        [data-theme="dark"] .header-history-dropdown .nav-icon-box { background: #1e293b; color: #94a3b8; }
        [data-theme="dark"] .history-search-in-dropdown { border-color: #334155; }
        [data-theme="dark"] .history-search-form-dropdown { background: #1e293b; border-color: #334155; }
        [data-theme="dark"] .history-search-input-dropdown { color: #f1f5f9; }
        
        /* Auth buttons */
        .header-auth { display: flex; align-items: center; gap: 12px; }
        .auth-login-btn {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 8px 14px; font-size: 13px; font-weight: 600;
            color: #fff; background: var(--primary); border-radius: 8px; border: 2px solid var(--primary); transition: all 0.2s;
        }
        .auth-login-btn:hover { background: var(--primary-dark); border-color: var(--primary-dark); }
        .auth-register-btn {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 8px 14px; font-size: 13px; font-weight: 600;
            color: var(--ink); background: transparent; border-radius: 8px; border: 2px solid #e5e7eb; transition: all 0.2s;
        }
        .auth-register-btn:hover { border-color: var(--primary); color: var(--primary); }
        
        /* User Balance */
        .user-balance {
            display: flex; align-items: center; gap: 6px;
            padding: 6px 12px; font-size: 13px; font-weight: 600;
            background: #ecfdf5; color: #059669; border-radius: 8px;
        }
        .user-balance svg { color: #10b981; }
        
        /* User Dropdown */
        .user-dropdown { position: relative; }
        .user-btn {
            display: flex; align-items: center; gap: 8px;
            padding: 6px 12px; font-size: 13px; font-weight: 600;
            color: var(--ink); border-radius: 10px; cursor: pointer;
            border: 1px solid #e5e7eb; transition: all 0.2s;
        }
        .user-btn:hover { border-color: var(--primary); color: var(--primary); }
        .user-avatar {
            width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: #fff; border-radius: 8px; font-size: 13px; font-weight: 700;
        }
        .user-name { max-width: 100px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .logout-btn {
            display: flex; align-items: center; gap: 10px; width: 100%; padding: 10px 14px;
            background: none; border: none; cursor: pointer;
            color: #dc2626; font-size: 14px; font-weight: 500; border-radius: 6px; transition: all 0.15s;
        }
        .logout-btn:hover { background: #fef2f2; }
        .logout-btn svg { color: #dc2626; }
        
        /* Dark mode for user elements */
        [data-theme="dark"] .user-balance { background: #064e3b; color: #a7f3d0; }
        [data-theme="dark"] .user-btn { border-color: #475569; }
        [data-theme="dark"] .user-btn:hover { border-color: #60a5fa; }
        
        /* Theme Toggle Button */
        .theme-toggle-btn {
            display: flex; align-items: center; justify-content: center;
            width: 40px; height: 40px;
            background: #f1f5f9; border: none; border-radius: 10px;
            cursor: pointer; transition: all 0.2s;
        }
        .theme-toggle-btn:hover { background: #e2e8f0; }
        .theme-toggle-btn svg { color: #64748b; }
        [data-theme="dark"] .theme-toggle-btn { background: #334155; }
        [data-theme="dark"] .theme-toggle-btn:hover { background: #475569; }
        [data-theme="dark"] .theme-toggle-btn svg { color: #fbbf24; }
        
        /* FOOTER */
        .site-footer {
            background: #fff; padding: 40px 0 20px;
            border-top: 1px solid var(--line); margin-top: 60px;
        }
        .footer-copyright { text-align: center; font-size: 14px; color: var(--muted); margin-bottom: 20px; }
        .footer-links { display: flex; justify-content: center; gap: 18px; flex-wrap: wrap; margin-bottom: 25px; }
        .footer-link {
            padding: 6px 14px; border: 1px solid #d1d5db; border-radius: 8px;
            font-size: 13px; color: #374151; text-decoration: none; transition: all 0.2s;
        }
        .footer-link:hover { border-color: var(--primary); color: var(--primary); }
        
        /* SEARCH BAR */
        .tool-search-bar {
            padding: 12px 20px;
            background: linear-gradient(135deg, #f0f4ff 0%, #fdf4ff 100%);
            border-bottom: 1px solid #e5e7eb;
        }
        .tool-search-inner {
            max-width: 900px; margin: 0 auto;
            display: flex; align-items: center; gap: 15px; flex-wrap: wrap;
        }
        .tool-search-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            border-radius: 10px; display: flex; align-items: center; justify-content: center;
            color: #fff; flex-shrink: 0;
        }
        .tool-search-content { flex-shrink: 0; }
        .tool-search-title { display: block; font-size: 14px; font-weight: 700; color: #1f2937; }
        .tool-search-desc { font-size: 12px; color: #6b7280; }
        .tool-search-form {
            flex: 1; display: flex; min-width: 280px;
            background: #fff; border-radius: 25px; border: 2px solid #e5e7eb;
            overflow: hidden; transition: all 0.2s;
        }
        .tool-search-form:focus-within { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.1); }
        .tool-search-input { flex: 1; padding: 10px 18px; border: none; font-size: 14px; outline: none; background: transparent; }
        .tool-search-btn {
            padding: 10px 20px;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: #fff; border: none; font-size: 13px; font-weight: 600; cursor: pointer;
        }
        
        /* RESPONSIVE */
        @media (max-width: 1280px) { .header-nav { display: none !important; } }
        @media (max-width: 768px) { .header-right { display: none !important; } .brand-tagline { display: none; } }
        @media (max-width: 600px) { 
            .tool-search-icon { display: none; } 
            .tool-search-content { text-align: center; width: 100%; } 
            .tool-search-form { min-width: 100%; }
        }
    </style>
    
    @yield('styles')
</head>
<body>

@include('partials.header')

@include('partials.mobile-menu')

<main>
    @yield('content')
</main>

@include('partials.footer')

<script>
// Desktop Theme Toggle Function
function toggleDesktopTheme() {
    const html = document.documentElement;
    const isDark = html.getAttribute('data-theme') === 'dark';
    
    if (isDark) {
        html.removeAttribute('data-theme');
        localStorage.setItem('theme', 'light');
    } else {
        html.setAttribute('data-theme', 'dark');
        localStorage.setItem('theme', 'dark');
    }
    updateThemeIcons(!isDark);
}

function updateThemeIcons(isDark) {
    // Desktop theme toggle
    const desktopBtn = document.getElementById('desktopThemeToggle');
    if (desktopBtn) {
        const sunIcon = desktopBtn.querySelector('.theme-icon-sun');
        const moonIcon = desktopBtn.querySelector('.theme-icon-moon');
        if (sunIcon && moonIcon) {
            sunIcon.style.display = isDark ? 'block' : 'none';
            moonIcon.style.display = isDark ? 'none' : 'block';
        }
    }
    // Mobile theme toggle (if exists)
    const mobileBtn = document.getElementById('mobileThemeToggle');
    if (mobileBtn) {
        const sunIcon = mobileBtn.querySelector('.theme-icon-sun');
        const moonIcon = mobileBtn.querySelector('.theme-icon-moon');
        const textEl = mobileBtn.querySelector('.theme-text');
        if (sunIcon && moonIcon) {
            sunIcon.style.display = isDark ? 'block' : 'none';
            moonIcon.style.display = isDark ? 'none' : 'block';
        }
        if (textEl) {
            textEl.textContent = isDark ? 'Chế độ sáng' : 'Chế độ tối';
        }
    }
}

// Initialize theme on load
(function() {
    const html = document.documentElement;
    const savedTheme = localStorage.getItem('theme');
    const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    
    if (savedTheme === 'dark' || (!savedTheme && systemDark)) {
        html.setAttribute('data-theme', 'dark');
        // Update icons after DOM ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() { updateThemeIcons(true); });
        } else {
            updateThemeIcons(true);
        }
    }
})();

// Mobile Theme Toggle
function toggleMobileTheme() {
    const html = document.documentElement;
    const isDark = html.getAttribute('data-theme') === 'dark';
    
    if (isDark) {
        html.removeAttribute('data-theme');
        localStorage.setItem('theme', 'light');
        updateThemeIcons(false);
    } else {
        html.setAttribute('data-theme', 'dark');
        localStorage.setItem('theme', 'dark');
        updateThemeIcons(true);
    }
}

// Toggle Services Menu
function toggleServicesMenu() {
    const btn = document.querySelector('.mobile-menu-section-toggle');
    const list = document.getElementById('mobileServicesList');
    
    if (btn && list) {
        btn.classList.toggle('collapsed');
        list.classList.toggle('collapsed');
    }
}

// Mobile Menu Toggle
(function() {
    function initMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        const menuBtn = document.getElementById('mobileMenuBtn');
        const menuClose = document.getElementById('mobileMenuClose');
        const overlay = document.getElementById('mobileMenuOverlay');
        
        if (!menu || !menuBtn) return;
        
        function openMenu() {
            menu.classList.add('active');
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        
        function closeMenu() {
            menu.classList.remove('active');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }
        
        menuBtn.addEventListener('click', openMenu);
        if (menuClose) menuClose.addEventListener('click', closeMenu);
        if (overlay) overlay.addEventListener('click', closeMenu);
        
        // Close on ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeMenu();
        });
        
        // Close menu when clicking links
        document.querySelectorAll('.mobile-menu-link').forEach(function(link) {
            link.addEventListener('click', closeMenu);
        });
    }
    
    // Run when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initMobileMenu);
    } else {
        initMobileMenu();
    }
})();
</script>

@yield('scripts')

</body>
</html>
