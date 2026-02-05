@extends('admin.layouts.app')

@section('title', 'Quản lý Tài khoản')
@section('page-title', 'Quản lý Tài khoản')

@section('content')
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
                <tr>
                    <td>{{ $account->id }}</td>
                    <td>
                        <div style="font-weight: 600; color: #3b82f6;">{{ $account->username }}</div>
                        <div style="font-size: 12px; color: #64748b;">MK: {{ $account->password }}</div>
                        <div style="margin-top: 6px; display: flex; gap: 4px;">
                            <button class="btn btn-sm btn-secondary" onclick="copyToClipboard('{{ $account->username }}')">Copy TK</button>
                            <button class="btn btn-sm btn-secondary" onclick="copyToClipboard('{{ $account->password }}')">Copy MK</button>
                        </div>
                    </td>
                    <td>
                        @if($account->is_available ?? false)
                            <span class="badge badge-active">Chờ thuê</span>
                        @else
                            <span class="badge badge-pending">Đang thuê</span>
                        @endif
                    </td>
                    <td>
                        @if($account->note ?? null)
                            <span style="color: #f59e0b; font-size: 12px;">{{ $account->note }}</span>
                        @else
                            <span style="color: #64748b;">—</span>
                        @endif
                    </td>
                    <td style="font-size: 12px;">
                        @if(!($account->is_available ?? true) && isset($account->rental_expires_at) && $account->rental_expires_at)
                            @php
                                $expiresAt = \Carbon\Carbon::parse($account->rental_expires_at);
                                $isExpired = $expiresAt->isPast();
                            @endphp
                            <div style="color: {{ $isExpired ? '#ef4444' : '#10b981' }}; font-weight: 600;">
                                {{ $expiresAt->format('d/m H:i') }}
                            </div>
                            <div class="countdown" data-expires="{{ $expiresAt->toIso8601String() }}" 
                                 style="font-size: 11px; font-weight: 600; color: {{ $isExpired ? '#ef4444' : '#10b981' }};">
                                {{ $isExpired ? 'Đã hết hạn' : 'Đang tính...' }}
                            </div>
                            @if($account->renter_email ?? null)
                                <div style="font-size: 10px; color: #94a3b8; margin-top: 2px;">
                                    📧 {{ Str::limit($account->renter_email, 18) }}
                                </div>
                            @endif
                        @else
                            <span style="color: #64748b;">—</span>
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

// Real-time countdown
function updateCountdowns() {
    document.querySelectorAll('.countdown').forEach(el => {
        const expires = new Date(el.dataset.expires);
        const now = new Date();
        const diff = expires - now;
        
        if (diff <= 0) {
            el.textContent = '⏱️ Đã hết hạn';
            el.style.color = '#ef4444';
            return;
        }
        
        const hours = Math.floor(diff / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((diff % (1000 * 60)) / 1000);
        
        // Color based on urgency
        if (hours < 1) {
            el.style.color = '#f59e0b'; // Warning - less than 1 hour
        } else if (hours < 3) {
            el.style.color = '#eab308'; // Yellow - less than 3 hours
        } else {
            el.style.color = '#10b981'; // Green - plenty of time
        }
        
        if (hours > 0) {
            el.textContent = `⏱️ Còn ${hours}h ${minutes}p ${seconds}s`;
        } else if (minutes > 0) {
            el.textContent = `⚡ Còn ${minutes}p ${seconds}s`;
        } else {
            el.textContent = `🔥 Còn ${seconds}s`;
        }
    });
}

// Update every second
updateCountdowns();
setInterval(updateCountdowns, 1000);
</script>
@endsection
