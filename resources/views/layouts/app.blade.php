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
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @yield('schema')
    
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
            background: var(--bg);
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            transition: background 0.3s;
        }
        
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
            width: 100%;
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

<header class="site-header">
    <div class="header-main">
        <div class="header-inner">
            <div class="header-left">
                <a class="header-brand" href="/">
                    <img class="header-logo" src="/assets/images/logo.png" alt="logo" onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 36 36%22><rect fill=%22%231e40af%22 width=%2236%22 height=%2236%22 rx=%228%22/><text x=%2218%22 y=%2224%22 fill=%22white%22 font-size=%2218%22 text-anchor=%22middle%22>T</text></svg>'">
                    <div class="header-brand-text">
                        <span class="brand-name">thuetaikhoan.net</span>
                        <span class="brand-tagline">Thuê tài khoản tự động 24/7</span>
                    </div>
                </a>
                
                <nav class="header-nav">
                    <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                        <span class="nav-icon-box">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                                <polyline points="9 22 9 12 15 12 15 22"/>
                            </svg>
                        </span>
                        Trang chủ
                    </a>
                    <div class="nav-dropdown">
                        <a href="#" class="nav-link">
                            <span class="nav-icon-box">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                                    <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                                </svg>
                            </span>
                            Dịch vụ
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="opacity:0.5">
                                <polyline points="6 9 12 15 18 9"/>
                            </svg>
                        </a>
                        <div class="nav-dropdown-menu">
                            <a href="/thue-unlocktool"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 9.9-1"/></svg> Unlocktool</a>
                            <a href="/thue-vietmap"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="10" r="3"/><path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 1 0-16 0c0 3 2.7 7 8 11.7z"/></svg> Vietmap Live</a>
                            <a href="/thue-tsm"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg> TSM Tool</a>
                            <a href="/thue-griffin"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg> Griffin-Unlocker</a>
                            <a href="/thue-amt"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg> Android Multitool</a>
                            <div style="border-top: 1px solid #e5e7eb; margin: 8px 0;"></div>
                            <a href="/ord-services" class="dropdown-cta">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                </svg>
                                Thuê Dịch Vụ Khác
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <a href="#huong-dan" class="nav-link">
                        <span class="nav-icon-box">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                            </svg>
                        </span>
                        Hướng dẫn
                    </a>
                    <a href="/blog" class="nav-link">
                        <span class="nav-icon-box">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                            </svg>
                        </span>
                        Blog
                    </a>
                    <a href="/ord-services" class="nav-link">
                        <span class="nav-icon-box">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="9" cy="21" r="1"/>
                                <circle cx="20" cy="21" r="1"/>
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                            </svg>
                        </span>
                        Thuê Dịch Vụ Khác
                    </a>
                </nav>
            </div>

            <div class="header-right">
                <!-- Lịch sử thuê dropdown -->
                <div class="header-history-dropdown">
                    <div class="nav-dropdown">
                        <a href="#" class="nav-link" id="historyNavLink">
                            <span class="nav-icon-box">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                    <line x1="16" y1="13" x2="8" y2="13"/>
                                    <line x1="16" y1="17" x2="8" y2="17"/>
                                </svg>
                            </span>
                            Lịch sử thuê
                            <svg class="nav-arrow-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="6 9 12 15 18 9"/>
                            </svg>
                        </a>
                        <div class="nav-dropdown-menu history-menu">
                            <a href="/order-history-ip">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                    <line x1="16" y1="13" x2="8" y2="13"/>
                                    <line x1="16" y1="17" x2="8" y2="17"/>
                                </svg>
                                Lịch sử thuê 30 ngày
                            </a>
                            <div class="history-search-in-dropdown">
                                <form class="history-search-form-dropdown" action="/order-detail">
                                    <input type="text" name="code" placeholder="Tìm mã đơn hàng..." class="history-search-input-dropdown">
                                    <button type="submit" class="history-search-btn-dropdown">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="11" cy="11" r="8"/>
                                            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Auth buttons -->
                <div class="header-auth">
                    <a href="/login" class="auth-login-btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                            <polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/>
                        </svg>
                        Đăng nhập
                    </a>
                    <a href="/register" class="auth-register-btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="8.5" cy="7" r="4"/>
                            <line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/>
                        </svg>
                        Đăng ký
                    </a>
                    <button class="theme-toggle" id="theme-toggle" title="Chuyển đổi ban ngày/đêm">
                        <span id="theme-icon">🌙</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- SEARCH BAR - Mua License, Credits & Sơ đồ -->
<div class="tool-search-bar">
    <div class="tool-search-inner">
        <div class="tool-search-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        </div>
        <div class="tool-search-content">
            <span class="tool-search-title">Mua License, Credits & Sơ đồ</span>
            <span class="tool-search-desc">UnlockTool, Chimera, SamKey, Sơ đồ điện thoại...</span>
        </div>
        <form class="tool-search-form" action="/search" method="GET">
            <input type="text" name="q" class="tool-search-input" placeholder="Borneo, UnlockTool, ChatGPT, Credits, Bypass A12+...">
            <button type="submit" class="tool-search-btn">Tìm kiếm</button>
        </form>
    </div>
</div>

<main>
    @yield('content')
</main>

<footer class="site-footer">
    <div class="footer-copyright">
        © {{ date('Y') }} thuetaikhoan.net – Hệ thống cho thuê tài khoản Unlocktool | Vietmap Live tự động
    </div>
    <div class="footer-links">
        <a href="/" class="footer-link">Trang chủ</a>
        <a href="#" class="footer-link">Điều khoản sử dụng</a>
        <a href="#" class="footer-link">Chính sách bảo mật</a>
        <a href="/ma-giam-gia" class="footer-link">Mã giảm giá</a>
        <a href="https://zalo.me/0777333763" target="_blank" class="footer-link">💬 Zalo hỗ trợ</a>
        <a href="https://www.facebook.com/people/Thuetaikhoannet/61586731454108/" target="_blank" class="footer-link">👍 Fanpage</a>
        <a href="tel:0777333763" class="footer-link">📞 Hotline: 0777333763</a>
    </div>
</footer>

<script>
// Dark Mode Toggle
(function() {
    const toggle = document.getElementById('theme-toggle');
    const icon = document.getElementById('theme-icon');
    const html = document.documentElement;
    
    // Check saved preference or system preference
    const savedTheme = localStorage.getItem('theme');
    const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    
    if (savedTheme === 'dark' || (!savedTheme && systemDark)) {
        html.setAttribute('data-theme', 'dark');
        icon.textContent = '☀️';
    } else {
        icon.textContent = '🌙';
    }
    
    toggle.addEventListener('click', function() {
        const isDark = html.getAttribute('data-theme') === 'dark';
        if (isDark) {
            html.removeAttribute('data-theme');
            icon.textContent = '🌙';
            localStorage.setItem('theme', 'light');
        } else {
            html.setAttribute('data-theme', 'dark');
            icon.textContent = '☀️';
            localStorage.setItem('theme', 'dark');
        }
    });
})();
</script>

@yield('scripts')

</body>
</html>
