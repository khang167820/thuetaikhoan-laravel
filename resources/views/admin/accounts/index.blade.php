@extends('admin.layouts.app')

@section('title', 'Quản lý Tài khoản')
@section('page-title', 'Quản lý Tài khoản')

@section('content')
<style>
    /* ============================================
       ADMIN ACCOUNTS - Premium Modern Design
       ============================================ */
    
    /* Stats Cards */
    .acc-stats { display: flex; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
    .acc-stat-item { 
        background: #fff; 
        border-radius: 12px; 
        padding: 16px 24px; 
        min-width: 140px; 
        border-left: 4px solid;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .acc-stat-item.total { border-color: #3b82f6; }
    .acc-stat-item.available { border-color: #10b981; }
    .acc-stat-item.renting { border-color: #f97316; }
    .acc-stat-item.expired { border-color: #ef4444; }
    .acc-stat-label { font-size: 12px; color: #64748b; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px; }
    .acc-stat-value { font-size: 32px; font-weight: 800; }
    .acc-stat-item.total .acc-stat-value { color: #3b82f6; }
    .acc-stat-item.available .acc-stat-value { color: #10b981; }
    .acc-stat-item.renting .acc-stat-value { color: #f97316; }
    .acc-stat-item.expired .acc-stat-value { color: #ef4444; }
    
    /* Type Tabs - Matching Reference */
    .type-tabs { 
        display: flex; 
        gap: 8px; 
        margin-bottom: 24px; 
        flex-wrap: wrap;
        background: #f8fafc;
        padding: 8px;
        border-radius: 12px;
    }
    .type-tab { 
        padding: 10px 18px; 
        border-radius: 8px; 
        font-size: 13px; 
        font-weight: 600; 
        border: 2px solid transparent; 
        background: #fff; 
        color: #475569; 
        cursor: pointer; 
        text-decoration: none; 
        transition: all 0.2s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .type-tab:hover { 
        border-color: #3b82f6; 
        color: #3b82f6;
        background: #eff6ff;
    }
    .type-tab.active { 
        background: #1e40af; 
        border-color: #1e40af; 
        color: #fff;
        box-shadow: 0 2px 8px rgba(30,64,175,0.3);
    }
    
    /* Add Form - Clean Design */
    .add-form { 
        background: #fff; 
        border-radius: 12px; 
        padding: 20px; 
        margin-bottom: 24px; 
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .add-form-grid { display: flex; gap: 16px; align-items: flex-end; flex-wrap: wrap; }
    .add-form-field { flex: 1; min-width: 150px; }
    .add-form-field label { 
        display: block; 
        font-size: 12px; 
        color: #64748b; 
        margin-bottom: 6px; 
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .add-form-field input, .add-form-field select { 
        width: 100%; 
        padding: 10px 14px; 
        border: 2px solid #e2e8f0; 
        border-radius: 8px; 
        font-size: 14px;
        transition: all 0.2s;
    }
    .add-form-field input:focus, .add-form-field select:focus { 
        outline: none; 
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
    }
    .add-form-field input[readonly] {
        background: #f1f5f9;
        color: #64748b;
    }
    .btn-add {
        padding: 10px 24px;
        background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        white-space: nowrap;
    }
    .btn-add:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59,130,246,0.3);
    }
    
    /* Action Bar */
    .action-bar { 
        display: flex; 
        gap: 12px; 
        margin-bottom: 16px; 
        align-items: center; 
        justify-content: space-between; 
        flex-wrap: wrap;
    }
    .action-bar-left { 
        font-size: 14px; 
        color: #64748b;
        font-weight: 500;
    }
    .action-bar-right { display: flex; gap: 10px; flex-wrap: wrap; }
    .action-btn { 
        padding: 10px 16px; 
        border-radius: 8px; 
        font-size: 13px; 
        font-weight: 600; 
        border: none; 
        cursor: pointer; 
        display: inline-flex; 
        align-items: center; 
        gap: 6px;
        text-decoration: none;
        transition: all 0.2s;
    }
    .action-btn.blue { background: #3b82f6; color: #fff; }
    .action-btn.blue:hover { background: #2563eb; }
    .action-btn.yellow { background: #eab308; color: #fff; }
    .action-btn.yellow:hover { background: #ca8a04; }
    .action-btn.red { background: #ef4444; color: #fff; }
    .action-btn.red:hover { background: #dc2626; }
    
    /* Table - Modern Style */
    .acc-table { 
        width: 100%; 
        border-collapse: collapse; 
        background: #fff; 
        border-radius: 12px; 
        overflow: hidden;
    }
    .acc-table thead { background: #f8fafc; }
    .acc-table th { 
        padding: 14px 16px; 
        text-align: left; 
        font-size: 11px; 
        font-weight: 700; 
        color: #64748b; 
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0; 
    }
    .acc-table td { 
        padding: 14px 16px; 
        border-bottom: 1px solid #f1f5f9; 
        vertical-align: middle; 
    }
    .acc-table tr:hover { background: #fafbfc; }
    .acc-table tr:last-child td { border-bottom: none; }
    
    /* Account Info */
    .acc-username { 
        font-weight: 700; 
        color: #1e40af; 
        font-size: 14px;
        margin-bottom: 2px;
    }
    .acc-password { 
        font-size: 13px; 
        color: #1e40af; 
        font-weight: 700;
    }
    .acc-btns { display: flex; gap: 6px; margin-top: 8px; }
    .copy-btn { 
        padding: 5px 12px; 
        font-size: 11px; 
        font-weight: 600;
        border: 1px solid #e2e8f0; 
        background: #fff; 
        border-radius: 6px; 
        cursor: pointer;
        transition: all 0.2s;
    }
    .copy-btn:hover { background: #f1f5f9; border-color: #cbd5e1; }
    .edit-btn { 
        padding: 5px 12px; 
        font-size: 11px;
        font-weight: 600;
        border: none; 
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); 
        color: #fff; 
        border-radius: 6px; 
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
    }
    .edit-btn:hover { transform: translateY(-1px); }
    
    /* Status Badges - Matching Reference */
    .status-badge { 
        padding: 6px 14px; 
        border-radius: 6px; 
        font-size: 12px; 
        font-weight: 700; 
        display: inline-block;
        text-align: center;
        min-width: 80px;
    }
    .status-badge.renting { 
        background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); 
        color: #fff; 
    }
    .status-badge.available { 
        background: linear-gradient(135deg, #10b981 0%, #059669 100%); 
        color: #fff; 
    }
    .status-badge.expired { 
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); 
        color: #fff; 
    }
    .status-time { 
        font-size: 12px; 
        color: #10b981; 
        margin-top: 6px; 
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .status-time.expired { color: #ef4444; }
    
    /* Action Buttons */
    .action-btns { display: flex; flex-direction: column; gap: 6px; align-items: flex-start; }
    .action-btns-row { display: flex; gap: 6px; }
    .toggle-btn { 
        padding: 7px 14px; 
        font-size: 11px; 
        font-weight: 700; 
        border: none; 
        border-radius: 6px; 
        cursor: pointer;
        transition: all 0.2s;
    }
    .toggle-btn.green { 
        background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); 
        color: #fff; 
    }
    .toggle-btn.blue { 
        background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); 
        color: #fff; 
    }
    .toggle-btn:hover { transform: translateY(-1px); }
    .pass-btn { 
        padding: 7px 14px; 
        font-size: 11px; 
        font-weight: 700; 
        border: none; 
        border-radius: 6px; 
        cursor: pointer; 
        background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); 
        color: #fff;
        transition: all 0.2s;
    }
    .pass-btn:hover { transform: translateY(-1px); }
    .action-note { 
        font-size: 11px; 
        color: #94a3b8; 
        margin-top: 2px;
    }
    
    /* Countdown Animation */
    .countdown { font-weight: 700; }
    @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
    .countdown.urgent { animation: blink 1s infinite; color: #ef4444 !important; }
    
    /* Responsive */
    @media (max-width: 768px) {
        .acc-stats { gap: 8px; }
        .acc-stat-item { min-width: 100px; padding: 12px 16px; }
        .acc-stat-value { font-size: 24px; }
        .type-tabs { padding: 6px; gap: 6px; }
        .type-tab { padding: 8px 12px; font-size: 12px; }
        .add-form-grid { flex-direction: column; }
        .add-form-field { min-width: 100%; }
        .acc-table { font-size: 12px; }
        .acc-table th, .acc-table td { padding: 10px 12px; }
    }
</style>

<!-- Stats -->
<div class="acc-stats">
    <div class="acc-stat-item total">
        <div class="acc-stat-label">Tổng {{ $currentType }}</div>
        <div class="acc-stat-value">{{ $stats['total'] }}</div>
    </div>
    <div class="acc-stat-item available">
        <div class="acc-stat-label">Chờ thuê</div>
        <div class="acc-stat-value">{{ $stats['available'] }}</div>
    </div>
    <div class="acc-stat-item renting">
        <div class="acc-stat-label">Đang thuê</div>
        <div class="acc-stat-value">{{ $stats['renting'] }}</div>
    </div>
    <div class="acc-stat-item expired">
        <div class="acc-stat-label">Cần đổi mật khẩu</div>
        <div class="acc-stat-value">0</div>
    </div>
</div>

<!-- Type Tabs -->
<div class="type-tabs">
    @foreach($allowedTypes as $type)
        <a href="{{ route('admin.accounts', ['type' => $type]) }}" 
           class="type-tab {{ $currentType === $type ? 'active' : '' }}">
            {{ $type }}
        </a>
    @endforeach
</div>

<!-- Add Form -->
<div class="add-form">
    <form action="{{ route('admin.accounts.add') }}" method="POST">
        @csrf
        <input type="hidden" name="type" value="{{ $currentType }}">
        <div class="add-form-grid">
            <div class="add-form-field">
                <label>Tên đăng nhập</label>
                <input type="text" name="username" required placeholder="">
            </div>
            <div class="add-form-field">
                <label>Mật khẩu</label>
                <input type="text" name="password" required placeholder="">
            </div>
            <div class="add-form-field">
                <label>Loại</label>
                <input type="text" value="{{ $currentType }}" readonly style="background: #f1f5f9;">
            </div>
            <div class="add-form-field">
                <label>Ngày gia hạn</label>
                <input type="date" name="expires_at" placeholder="mm/dd/yyyy">
            </div>
            <div class="add-form-field">
                <label>Ghi chú</label>
                <input type="text" name="note" placeholder="">
            </div>
            <button type="submit" class="btn-add">+ Thêm</button>
        </div>
    </form>
</div>

<!-- Action Bar -->
<div class="action-bar">
    <div class="action-bar-left">
        Tổng {{ $stats['total'] }} tài khoản
    </div>
    <div class="action-bar-right">
        @if($currentType === 'Unlocktool')
        <a href="https://unlocktool.net" target="_blank" class="action-btn blue">🔗 Unlocktool.net</a>
        @endif
        <form action="{{ route('admin.accounts.lock-with-notes') }}" method="POST" style="display: inline;" onsubmit="return confirm('Khóa tất cả tài khoản có ghi chú của {{ $currentType }}?');">
            @csrf
            <input type="hidden" name="type" value="{{ $currentType }}">
            <button type="submit" class="action-btn yellow">🔒 Khóa TK có ghi chú</button>
        </form>
        <button class="action-btn red">💾 Lưu trạng thái</button>
    </div>
</div>

<!-- Table -->
<div class="admin-card" style="padding: 0; overflow: hidden;">
    <table class="acc-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tài khoản / Mật khẩu</th>
                <th>Trạng thái & Thời gian</th>
                <th>Ghi chú</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($accounts as $account)
            <tr>
                <td style="color: #94a3b8; font-weight: 600;">{{ $account->id }}</td>
                <td>
                    <div class="acc-username">TK: {{ $account->username }}</div>
                    <div class="acc-password">MK: {{ $account->password }}</div>
                    <div class="acc-btns">
                        <button class="copy-btn" onclick="copyToClipboard('{{ $account->username }}\n{{ $account->password }}')">Copy</button>
                        <a href="{{ route('admin.accounts.edit', $account->id) }}" class="edit-btn">Sửa</a>
                    </div>
                </td>
                <td>
                    @if($account->is_available ?? false)
                        <span class="status-badge available">Chờ thuê</span>
                        @if(isset($account->sorting_expires_at) && $account->sorting_expires_at)
                            @php
                                $lastExpired = \Carbon\Carbon::parse($account->sorting_expires_at);
                                $isExpired = $lastExpired->isPast();
                            @endphp
                            @if($isExpired)
                                @php
                                    $diff = $lastExpired->diff(now());
                                    $totalHours = ($diff->days * 24) + $diff->h;
                                    $waitingTime = $totalHours . 'h ' . $diff->i . 'p';
                                @endphp
                                <div class="status-time idle-timer" style="color: #64748b; font-size: 11px;" data-since="{{ $lastExpired->toIso8601String() }}">
                                    ⏱️ {{ $waitingTime }}
                                </div>
                            @endif
                        @endif
                    @else
                        <span class="status-badge renting">Đang thuê</span>
                        @if(isset($account->rental_expires_at) && $account->rental_expires_at)
                            @php
                                $expiresAt = \Carbon\Carbon::parse($account->rental_expires_at);
                                $isExpired = $expiresAt->isPast();
                            @endphp
                            <div class="countdown status-time {{ $isExpired ? '' : 'active' }}" data-expires="{{ $expiresAt->toIso8601String() }}">
                                {{ $isExpired ? '⚠️ HẾT HẠN' : '⏳ Đang tính...' }}
                            </div>
                        @else
                            <div class="status-time">⚠️ HẾT HẠN</div>
                        @endif
                    @endif
                </td>
                <td>
                    @if($account->note ?? null)
                        <span style="color: #1e293b; font-size: 12px; font-weight: 500;">{{ $account->note }}</span>
                    @else
                        <span style="color: #cbd5e1;">-</span>
                    @endif
                </td>
                <td>
                    <div class="action-btns">
                        <div style="display: flex; gap: 4px;">
                            <form action="{{ route('admin.accounts.toggle', $account->id) }}" method="POST" style="margin:0;">
                                @csrf
                                <button type="submit" class="toggle-btn {{ $account->is_available ? 'blue' : 'green' }}">
                                    {{ $account->is_available ? 'Chuyển TT' : 'Chuyển TT' }}
                                </button>
                            </form>
                            <button class="pass-btn" onclick="promptChangePassword({{ $account->id }}, '{{ $account->password }}')">Đổi pass</button>
                        </div>
                        <div class="action-note">Ngày kích hoạt: -</div>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 40px; color: #64748b;">
                    Chưa có tài khoản nào
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if($accounts->hasPages())
<div class="pagination" style="margin-top: 16px;">
    {{ $accounts->links() }}
</div>
@endif

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text);
    // Toast notification
    const toast = document.createElement('div');
    toast.textContent = '✅ Đã copy!';
    toast.style.cssText = 'position:fixed;bottom:20px;right:20px;background:#10b981;color:#fff;padding:12px 20px;border-radius:8px;font-weight:600;z-index:9999;';
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 2000);
}

function promptChangePassword(id, currentPass) {
    const newPass = prompt('Nhập mật khẩu mới:', currentPass);
    if (newPass && newPass !== currentPass) {
        // Submit form to change password
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/accounts/' + id + '/change-pass';
        form.innerHTML = '@csrf<input name="password" value="' + newPass + '">';
        document.body.appendChild(form);
        form.submit();
    }
}

// Real-time countdown
function updateCountdowns() {
    document.querySelectorAll('.countdown').forEach(el => {
        const expires = new Date(el.dataset.expires);
        const now = new Date();
        const diff = expires - now;
        
        if (diff <= 0) {
            el.textContent = '⚠️ HẾT HẠN';
            el.classList.remove('active');
            el.classList.add('urgent');
            return;
        }
        
        const hours = Math.floor(diff / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((diff % (1000 * 60)) / 1000);
        
        el.classList.add('active');
        el.classList.remove('urgent');
        
        if (hours < 1) {
            el.classList.add('urgent');
        }
        
        // Always show full format: Xh XXp XXs
        el.textContent = `⏱️ ${hours}h ${String(minutes).padStart(2,'0')}p ${String(seconds).padStart(2,'0')}s`;
    });
}

updateCountdowns();
setInterval(updateCountdowns, 1000);

// Real-time idle timer (accounts waiting to be rented)
function updateIdleTimers() {
    document.querySelectorAll('.idle-timer').forEach(el => {
        const since = new Date(el.dataset.since);
        const now = new Date();
        const diff = now - since;
        
        if (diff <= 0) return;
        
        const totalHours = Math.floor(diff / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((diff % (1000 * 60)) / 1000);
        
        el.textContent = `⏱️ ${totalHours}h ${String(minutes).padStart(2,'0')}p ${String(seconds).padStart(2,'0')}s`;
    });
}

updateIdleTimers();
setInterval(updateIdleTimers, 1000);
</script>
@endsection
