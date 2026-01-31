@extends('admin.layouts.app')

@section('title', 'Quản lý Users')
@section('page-title', 'Quản lý Users')

@section('content')
<!-- Filter Bar -->
<div class="filter-bar">
    <form action="{{ route('admin.users') }}" method="GET" style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
        <input type="text" name="search" class="form-input" placeholder="Tìm tên, email, SĐT..." value="{{ request('search') }}" style="width: 220px;">
        
        <select name="role" class="form-select" style="width: 140px;">
            <option value="">Tất cả role</option>
            <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
        </select>
        
        <button type="submit" class="btn btn-primary">Lọc</button>
        <a href="{{ route('admin.users') }}" class="btn btn-secondary">Reset</a>
    </form>
</div>

<!-- Users Table -->
<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên / Email</th>
                <th>Số điện thoại</th>
                <th>Số dư</th>
                <th>Role</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>#{{ $user->id }}</td>
                <td>
                    <strong>{{ $user->name ?? 'N/A' }}</strong>
                    <div style="font-size: 11px; color: #64748b;">{{ $user->email ?? 'N/A' }}</div>
                </td>
                <td>{{ $user->phone ?? 'N/A' }}</td>
                <td style="color: #10b981; font-weight: 600;">{{ number_format($user->balance ?? 0, 0, ',', '.') }}đ</td>
                <td>
                    @if($user->role === 'admin')
                        <span class="badge badge-paid">Admin</span>
                    @else
                        <span class="badge" style="background: #f1f5f9; color: #475569;">User</span>
                    @endif
                </td>
                <td>
                    @if($user->is_active)
                        <span class="badge badge-active">Active</span>
                    @else
                        <span class="badge badge-inactive">Inactive</span>
                    @endif
                </td>
                <td>{{ $user->created_at ? $user->created_at->format('d/m/Y') : 'N/A' }}</td>
                <td>
                    <button class="btn btn-sm btn-secondary" onclick="openEditUser({{ $user->id }}, '{{ $user->balance }}', '{{ $user->role }}', {{ $user->is_active ? 1 : 0 }})">Sửa</button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; color: #64748b; padding: 40px;">
                    Không có user nào
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if($users->hasPages())
<div class="pagination">
    {{ $users->links() }}
</div>
@endif

<!-- Edit User Modal -->
<div id="editUserModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.7); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: #1e293b; border-radius: 16px; padding: 24px; width: 400px; max-width: 90%;">
        <h3 style="margin-bottom: 20px; font-size: 16px;">Chỉnh sửa User</h3>
        <form id="editUserForm" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Số dư (VND)</label>
                <input type="number" name="balance" id="editBalance" class="form-input">
            </div>
            <div class="form-group">
                <label class="form-label">Role</label>
                <select name="role" id="editRole" class="form-select">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Trạng thái</label>
                <select name="is_active" id="editActive" class="form-select">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 20px;">
                <button type="button" class="btn btn-secondary" onclick="closeEditUser()">Hủy</button>
                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditUser(id, balance, role, isActive) {
    document.getElementById('editUserForm').action = '/admin/users/' + id;
    document.getElementById('editBalance').value = balance;
    document.getElementById('editRole').value = role;
    document.getElementById('editActive').value = isActive;
    document.getElementById('editUserModal').style.display = 'flex';
}

function closeEditUser() {
    document.getElementById('editUserModal').style.display = 'none';
}

document.getElementById('editUserModal').addEventListener('click', function(e) {
    if (e.target === this) closeEditUser();
});
</script>
@endsection
