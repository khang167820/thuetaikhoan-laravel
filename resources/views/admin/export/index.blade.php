@extends('admin.layouts.app')

@section('title', 'Xuất Dữ liệu')
@section('page-title', 'Xuất Dữ liệu')

@section('content')
<div class="stats-grid" style="grid-template-columns: repeat(3, 1fr);">
    <!-- Export Orders -->
    <div class="admin-card" style="text-align: center;">
        <div style="font-size: 48px; margin-bottom: 16px;">📦</div>
        <h3 style="color: #f1f5f9; margin-bottom: 8px;">Đơn hàng</h3>
        <p style="color: #64748b; font-size: 13px; margin-bottom: 16px;">Xuất danh sách đơn hàng ra file CSV</p>
        
        <form action="{{ route('admin.export.orders') }}" method="POST">
            @csrf
            <div class="form-group">
                <select name="status" class="form-select" style="margin-bottom: 12px;">
                    <option value="">Tất cả trạng thái</option>
                    <option value="pending">Chờ thanh toán</option>
                    <option value="paid">Đã thanh toán</option>
                    <option value="completed">Hoàn thành</option>
                    <option value="cancelled">Đã hủy</option>
                </select>
            </div>
            <div class="form-group">
                <select name="period" class="form-select" style="margin-bottom: 12px;">
                    <option value="all">Tất cả</option>
                    <option value="today">Hôm nay</option>
                    <option value="week">7 ngày qua</option>
                    <option value="month">30 ngày qua</option>
                    <option value="year">Năm nay</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">
                📥 Xuất CSV
            </button>
        </form>
    </div>
    
    <!-- Export Users -->
    <div class="admin-card" style="text-align: center;">
        <div style="font-size: 48px; margin-bottom: 16px;">👥</div>
        <h3 style="color: #f1f5f9; margin-bottom: 8px;">Users</h3>
        <p style="color: #64748b; font-size: 13px; margin-bottom: 16px;">Xuất danh sách users ra file CSV</p>
        
        <form action="{{ route('admin.export.users') }}" method="POST">
            @csrf
            <div class="form-group">
                <select name="role" class="form-select" style="margin-bottom: 12px;">
                    <option value="">Tất cả roles</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="form-group">
                <select name="status" class="form-select" style="margin-bottom: 12px;">
                    <option value="">Tất cả trạng thái</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success" style="width: 100%;">
                📥 Xuất CSV
            </button>
        </form>
    </div>
    
    <!-- Export Accounts -->
    <div class="admin-card" style="text-align: center;">
        <div style="font-size: 48px; margin-bottom: 16px;">🔑</div>
        <h3 style="color: #f1f5f9; margin-bottom: 8px;">Tài khoản</h3>
        <p style="color: #64748b; font-size: 13px; margin-bottom: 16px;">Xuất danh sách tài khoản ra file CSV</p>
        
        <form action="{{ route('admin.export.accounts') }}" method="POST">
            @csrf
            <div class="form-group">
                <select name="type" class="form-select" style="margin-bottom: 12px;">
                    <option value="">Tất cả loại</option>
                    <option value="Unlocktool">Unlocktool</option>
                    <option value="Vietmap">Vietmap</option>
                    <option value="TSMTool">TSMTool</option>
                    <option value="Griffin">Griffin</option>
                    <option value="AMT">AMT</option>
                </select>
            </div>
            <div class="form-group">
                <select name="status" class="form-select" style="margin-bottom: 12px;">
                    <option value="">Tất cả trạng thái</option>
                    <option value="1">Còn trống</option>
                    <option value="0">Đang thuê</option>
                </select>
            </div>
            <button type="submit" class="btn btn-secondary" style="width: 100%;">
                📥 Xuất CSV
            </button>
        </form>
    </div>
</div>

<!-- Import Section -->
<div class="admin-card">
    <div class="admin-card-title">📤 Import Tài khoản</div>
    <p style="color: #64748b; font-size: 13px; margin-bottom: 16px;">
        Upload file CSV để import tài khoản hàng loạt. Format: <code>type,username,password,note</code>
    </p>
    
    <form action="{{ route('admin.import.accounts') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="display: flex; gap: 16px; align-items: end;">
            <div class="form-group" style="flex: 1; margin-bottom: 0;">
                <label class="form-label">Chọn file CSV</label>
                <input type="file" name="file" accept=".csv,.txt" class="form-input" required>
            </div>
            <button type="submit" class="btn btn-primary">
                📤 Import
            </button>
        </div>
    </form>
    
    <div style="margin-top: 16px; padding: 16px; background: #0f172a; border-radius: 8px;">
        <div style="font-weight: 600; color: #f1f5f9; margin-bottom: 8px;">📋 Mẫu file CSV:</div>
        <code style="font-size: 12px; color: #94a3b8;">
            type,username,password,note<br>
            Unlocktool,user1@email.com,password123,Note 1<br>
            Vietmap,user2@email.com,password456,Note 2
        </code>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success" style="margin-top: 16px;">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert alert-danger" style="margin-top: 16px;">{{ session('error') }}</div>
@endif
@endsection
