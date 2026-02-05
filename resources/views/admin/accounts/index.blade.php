@extends('admin.layouts.app')

@section('title', 'Quản lý Tài khoản')
@section('page-title', 'Quản lý Tài khoản')

@section('content')
<style>
    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.9; transform: scale(1.02); }
    }
    @keyframes countdown-glow {
        0%, 100% { text-shadow: 0 0 5px currentColor; }
        50% { text-shadow: 0 0 15px currentColor, 0 0 25px currentColor; }
    }
    .countdown.urgent {
        animation: countdown-glow 1s infinite;
    }
    .rental-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .rental-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
</style>
<!-- Tab loại tài khoản -->
<div style="margin-bottom: 20px; display: flex; gap: 8px; flex-wrap: wrap;">
    @foreach($allowedTypes as $type)
        <a href="{{ route('admin.accounts', ['type' => $type]) }}" 
           class="btn {{ $currentType === $type ? 'btn-primary' : 'btn-secondary' }}">
            {{ $type }}
        </a>
    @endforeach
</div>

<!-- Stats -->
<div class="stats-grid" style="grid-template-columns: repeat(3, 1fr);">
    <div class="stat-card">
        <div class="stat-icon blue">📦</div>
        <div class="stat-info">
            <div class="stat-label">Tổng tài khoản</div>
            <div class="stat-value">{{ $stats['total'] }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">✅</div>
        <div class="stat-info">
            <div class="stat-label">Chờ thuê</div>
            <div class="stat-value">{{ $stats['available'] }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange">🔥</div>
        <div class="stat-info">
            <div class="stat-label">Đang thuê</div>
            <div class="stat-value">{{ $stats['renting'] }}</div>
        </div>
    </div>
</div>

<!-- Form thêm tài khoản -->
<div class="admin-card">
    <div class="admin-card-title">Thêm tài khoản mới</div>
    <form action="{{ route('admin.accounts.add') }}" method="POST">
        @csrf
        <input type="hidden" name="type" value="{{ $currentType }}">
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px; align-items: end;">
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Tên đăng nhập</label>
                <input type="text" name="username" class="form-input" required placeholder="username">
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Mật khẩu</label>
                <input type="text" name="password" class="form-input" required placeholder="password">
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Hạn sử dụng</label>
                <input type="date" name="expires_at" class="form-input">
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Ghi chú</label>
                <input type="text" name="note" class="form-input" placeholder="VD: Đã đổi pass">
            </div>
            <button type="submit" class="btn btn-success">+ Thêm</button>
        </div>
    </form>
</div>

<!-- Bảng tài khoản -->
<div class="admin-card">
    <div class="admin-card-title">Danh sách tài khoản {{ $currentType }}</div>
    
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tài khoản / Mật khẩu</th>
                    <th>Trạng thái</th>
                    <th>Ghi chú</th>
                    <th>Hạn sử dụng</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($accounts as $account)
                <tr style="transition: background 0.2s;" onmouseover="this.style.background='rgba(59,130,246,0.05)'" onmouseout="this.style.background=''">
                    <td style="font-weight: 600; color: #64748b;">{{ $account->id }}</td>
                    <td>
                        <div style="font-weight: 700; color: #1e40af; font-size: 13px; margin-bottom: 2px;">{{ $account->username }}</div>
                        <div style="font-size: 12px; color: #64748b; font-family: 'Consolas', monospace; background: #f1f5f9; padding: 2px 6px; border-radius: 4px; display: inline-block;">{{ $account->password }}</div>
                        <div style="margin-top: 8px; display: flex; gap: 4px;">
                            <button class="btn btn-sm btn-secondary" onclick="copyToClipboard('{{ $account->username }}')" style="font-size: 10px; padding: 4px 8px;">📋 TK</button>
                            <button class="btn btn-sm btn-secondary" onclick="copyToClipboard('{{ $account->password }}')" style="font-size: 10px; padding: 4px 8px;">🔑 MK</button>
                        </div>
                    </td>
                    <td>
                        @if($account->is_available ?? false)
                            <span style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; display: inline-block; box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);">
                                ✅ SẴN SÀNG
                            </span>
                        @else
                            <span style="background: linear-gradient(135deg, #f97316, #ea580c); color: white; padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; display: inline-block; box-shadow: 0 2px 4px rgba(249, 115, 22, 0.3); animation: pulse 2s infinite;">
                                🔥 ĐANG THUÊ
                            </span>
                        @endif
                    </td>
                    <td>
                        @if($account->note ?? null)
                            <span style="color: #f59e0b; font-size: 12px;">{{ $account->note }}</span>
                        @else
                            <span style="color: #64748b;">—</span>
                        @endif
                    </td>
                    <td>
                        @if(!($account->is_available ?? true) && isset($account->rental_expires_at) && $account->rental_expires_at)
                            @php
                                $expiresAt = \Carbon\Carbon::parse($account->rental_expires_at);
                                $isExpired = $expiresAt->isPast();
                                $diffMinutes = now()->diffInMinutes($expiresAt, false);
                            @endphp
                            <div style="background: {{ $isExpired ? 'linear-gradient(135deg, #fef2f2, #fee2e2)' : 'linear-gradient(135deg, #f0fdf4, #dcfce7)' }}; 
                                        border: 1px solid {{ $isExpired ? '#fecaca' : '#bbf7d0' }};
                                        border-radius: 10px; 
                                        padding: 10px 12px;
                                        min-width: 160px;">
                                {{-- Countdown timer - prominent --}}
                                <div class="countdown" data-expires="{{ $expiresAt->toIso8601String() }}" 
                                     style="font-size: 15px; font-weight: 800; color: {{ $isExpired ? '#dc2626' : '#16a34a' }}; margin-bottom: 6px; letter-spacing: -0.5px;">
                                    {{ $isExpired ? '⏱️ HẾT HẠN' : '⏳ Đang tính...' }}
                                </div>
                                {{-- Expires time --}}
                                <div style="color: {{ $isExpired ? '#b91c1c' : '#15803d' }}; font-size: 11px; font-weight: 500; margin-bottom: 8px;">
                                    🕐 {{ $expiresAt->format('H:i - d/m/Y') }}
                                </div>
                                {{-- Order code --}}
                                @if($account->rental_order_code ?? null)
                                    <div style="font-size: 11px; color: #2563eb; font-weight: 600; background: #eff6ff; padding: 3px 6px; border-radius: 4px; display: inline-block; margin-bottom: 4px;">
                                        📋 {{ $account->rental_order_code }}
                                    </div>
                                @endif
                                {{-- Renter info --}}
                                <div style="border-top: 1px dashed {{ $isExpired ? '#fecaca' : '#bbf7d0' }}; margin-top: 6px; padding-top: 6px;">
                                    @if($account->renter_email ?? null)
                                        <div style="font-size: 10px; color: #475569; margin-bottom: 2px;" title="{{ $account->renter_email }}">
                                            ✉️ {{ Str::limit($account->renter_email, 20) }}
                                        </div>
                                    @endif
                                    @if($account->renter_ip ?? null)
                                        <div style="font-size: 9px; color: #64748b; font-family: 'Consolas', monospace;" title="{{ $account->renter_ip }}">
                                            🌐 {{ Str::limit($account->renter_ip, 22) }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            <span style="color: #94a3b8; font-style: italic;">Chưa có đơn thuê</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                            <form action="{{ route('admin.accounts.toggle', $account->id) }}" method="POST" style="margin:0;">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $account->is_available ? 'btn-primary' : 'btn-success' }}">
                                    {{ $account->is_available ? 'Chuyển TT' : 'Trả về' }}
                                </button>
                            </form>
                            
                            
                            <a href="{{ route('admin.accounts.edit', $account->id) }}" class="btn btn-sm btn-secondary">Sửa</a>
                            
                            <form action="{{ route('admin.accounts.delete', $account->id) }}" method="POST" style="margin:0;" 
                                  onsubmit="return confirm('Xác nhận xóa tài khoản này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px; color: #64748b;">
                        Chưa có tài khoản nào
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($accounts->hasPages())
        <div class="pagination">
            {{ $accounts->links() }}
        </div>
    @endif
</div>

<!-- Modal sửa tài khoản -->
<div id="editModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.7); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:#1e293b; padding:24px; border-radius:16px; width:400px; max-width:90%;">
        <h3 style="margin-bottom:16px; color:#f1f5f9;">Sửa tài khoản</h3>
        <form id="editForm" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Tên đăng nhập</label>
                <input type="text" name="username" id="edit_username" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Mật khẩu</label>
                <input type="text" name="password" id="edit_password" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Ghi chú</label>
                <input type="text" name="note" id="edit_note" class="form-input">
            </div>
            <div style="display:flex; gap:12px; justify-content:flex-end;">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Hủy</button>
                <button type="submit" class="btn btn-primary">Lưu</button>
            </div>
        </form>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text);
}

function editAccount(account) {
    document.getElementById('editModal').style.display = 'flex';
    document.getElementById('editForm').action = '/admin/accounts/' + account.id;
    document.getElementById('edit_username').value = account.username;
    document.getElementById('edit_password').value = account.password;
    document.getElementById('edit_note').value = account.note || '';
}

function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}

// Real-time countdown with enhanced visuals
function updateCountdowns() {
    document.querySelectorAll('.countdown').forEach(el => {
        const expires = new Date(el.dataset.expires);
        const now = new Date();
        const diff = expires - now;
        
        if (diff <= 0) {
            el.textContent = '⛔ ĐÃ HẾT HẠN';
            el.style.color = '#dc2626';
            el.style.fontSize = '14px';
            el.classList.remove('urgent');
            return;
        }
        
        const hours = Math.floor(diff / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((diff % (1000 * 60)) / 1000);
        
        // Styling based on urgency
        if (hours < 1) {
            el.style.color = '#dc2626'; // Red - urgent
            el.style.fontSize = '16px';
            el.classList.add('urgent');
        } else if (hours < 2) {
            el.style.color = '#ea580c'; // Orange 
            el.style.fontSize = '15px';
            el.classList.remove('urgent');
        } else if (hours < 3) {
            el.style.color = '#d97706'; // Amber
            el.style.fontSize = '15px';
            el.classList.remove('urgent');
        } else {
            el.style.color = '#16a34a'; // Green - plenty of time
            el.style.fontSize = '15px';
            el.classList.remove('urgent');
        }
        
        // Format time remaining
        if (hours > 0) {
            el.textContent = `⏱️ ${hours}h ${String(minutes).padStart(2,'0')}p ${String(seconds).padStart(2,'0')}s`;
        } else if (minutes > 0) {
            el.textContent = `⚡ ${minutes}p ${String(seconds).padStart(2,'0')}s`;
        } else {
            el.textContent = `🔥 ${seconds}s còn lại!`;
        }
    });
}

// Update every second
updateCountdowns();
setInterval(updateCountdowns, 1000);
</script>
@endsection
