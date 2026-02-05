@extends('admin.layouts.app')

@section('title', 'Quản lý Tài khoản')
@section('page-title', 'Quản lý Tài khoản')

@section('content')
<style>
    .acc-stats { display: flex; gap: 20px; margin-bottom: 20px; flex-wrap: wrap; }
    .acc-stat-item { background: #fff; border-radius: 8px; padding: 15px 25px; min-width: 150px; border-left: 4px solid; }
    .acc-stat-item.total { border-color: #3b82f6; }
    .acc-stat-item.available { border-color: #10b981; }
    .acc-stat-item.renting { border-color: #f97316; }
    .acc-stat-item.expired { border-color: #ef4444; }
    .acc-stat-label { font-size: 13px; color: #64748b; margin-bottom: 4px; }
    .acc-stat-value { font-size: 28px; font-weight: 700; }
    .acc-stat-item.total .acc-stat-value { color: #3b82f6; }
    .acc-stat-item.available .acc-stat-value { color: #10b981; }
    .acc-stat-item.renting .acc-stat-value { color: #f97316; }
    .acc-stat-item.expired .acc-stat-value { color: #ef4444; }
    
    .type-tabs { display: flex; gap: 6px; margin-bottom: 20px; flex-wrap: wrap; }
    .type-tab { padding: 8px 16px; border-radius: 6px; font-size: 13px; font-weight: 600; border: 2px solid #e2e8f0; background: #fff; color: #475569; cursor: pointer; text-decoration: none; transition: all 0.2s; }
    .type-tab:hover { border-color: #3b82f6; color: #3b82f6; }
    .type-tab.active { background: #3b82f6; border-color: #3b82f6; color: #fff; }
    
    .add-form { background: #fff; border-radius: 8px; padding: 16px; margin-bottom: 20px; border: 1px solid #e2e8f0; }
    .add-form-grid { display: flex; gap: 12px; align-items: flex-end; flex-wrap: wrap; }
    .add-form-field { flex: 1; min-width: 140px; }
    .add-form-field label { display: block; font-size: 12px; color: #64748b; margin-bottom: 4px; font-weight: 500; }
    .add-form-field input { width: 100%; padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 13px; }
    .add-form-field input:focus { outline: none; border-color: #3b82f6; }
    
    .action-bar { display: flex; gap: 8px; margin-bottom: 16px; align-items: center; justify-content: space-between; flex-wrap: wrap; }
    .action-bar-left { font-size: 14px; color: #64748b; }
    .action-bar-right { display: flex; gap: 8px; }
    .action-btn { padding: 8px 14px; border-radius: 6px; font-size: 12px; font-weight: 600; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; }
    .action-btn.blue { background: #3b82f6; color: #fff; }
    .action-btn.yellow { background: #eab308; color: #fff; }
    .action-btn.red { background: #ef4444; color: #fff; }
    
    .acc-table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 8px; overflow: hidden; }
    .acc-table thead { background: #f8fafc; }
    .acc-table th { padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #475569; text-transform: uppercase; border-bottom: 2px solid #e2e8f0; }
    .acc-table td { padding: 12px 16px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    .acc-table tr:hover { background: #f8fafc; }
    
    .acc-username { font-weight: 600; color: #1e40af; font-size: 13px; }
    .acc-password { font-size: 12px; color: #f97316; font-family: 'Consolas', monospace; }
    .acc-btns { display: flex; gap: 4px; margin-top: 6px; }
    .copy-btn { padding: 4px 10px; font-size: 11px; border: 1px solid #e2e8f0; background: #fff; border-radius: 4px; cursor: pointer; }
    .copy-btn:hover { background: #f1f5f9; }
    .edit-btn { padding: 4px 10px; font-size: 11px; border: none; background: #fbbf24; color: #fff; border-radius: 4px; cursor: pointer; }
    
    .status-badge { padding: 6px 12px; border-radius: 4px; font-size: 11px; font-weight: 700; display: inline-block; }
    .status-badge.renting { background: #ef4444; color: #fff; }
    .status-badge.available { background: #10b981; color: #fff; }
    .status-time { font-size: 11px; color: #ef4444; margin-top: 4px; font-weight: 600; }
    .status-time.active { color: #10b981; }
    
    .action-btns { display: flex; flex-direction: column; gap: 4px; align-items: flex-start; }
    .toggle-btn { padding: 6px 12px; font-size: 11px; font-weight: 600; border: none; border-radius: 4px; cursor: pointer; }
    .toggle-btn.green { background: #10b981; color: #fff; }
    .toggle-btn.blue { background: #3b82f6; color: #fff; }
    .pass-btn { padding: 6px 12px; font-size: 11px; font-weight: 600; border: none; border-radius: 4px; cursor: pointer; background: #f97316; color: #fff; }
    .action-note { font-size: 10px; color: #94a3b8; margin-top: 2px; }
    
    .countdown { font-weight: 700; }
    @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
    .countdown.urgent { animation: blink 1s infinite; }
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
            <button type="submit" class="btn btn-success" style="height: 36px;">+ Thêm</button>
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
        <button class="action-btn yellow">🔒 Khóa TK có ghi chú</button>
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
                        <span style="color: #f59e0b; font-size: 12px;">{{ $account->note }}</span>
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
        form.action = '/admin/accounts/' + id + '/password';
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
</script>
@endsection
