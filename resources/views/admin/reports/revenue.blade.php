@extends('admin.layouts.app')

@section('title', 'Báo cáo Doanh thu')
@section('page-title', 'Báo cáo Doanh thu')

@section('content')
<!-- Period Filter -->
<div class="filter-bar" style="margin-bottom: 20px;">
    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
        <a href="?period=today" class="btn {{ request('period', 'month') === 'today' ? 'btn-primary' : 'btn-secondary' }}">Hôm nay</a>
        <a href="?period=week" class="btn {{ request('period') === 'week' ? 'btn-primary' : 'btn-secondary' }}">Tuần này</a>
        <a href="?period=month" class="btn {{ request('period') === 'month' ? 'btn-primary' : 'btn-secondary' }}">Tháng này</a>
        <a href="?period=year" class="btn {{ request('period') === 'year' ? 'btn-primary' : 'btn-secondary' }}">Năm nay</a>
    </div>
</div>

<!-- Revenue Stats -->
<div class="stats-grid" style="grid-template-columns: repeat(4, 1fr);">
    <div class="stat-card" style="background: linear-gradient(135deg, #10b981, #059669); border: none;">
        <div class="stat-info" style="width: 100%; text-align: center;">
            <div class="stat-label" style="color: rgba(255,255,255,0.8);">Tổng doanh thu</div>
            <div class="stat-value" style="color: #fff;">{{ number_format($totalRevenue) }}đ</div>
        </div>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #3b82f6, #2563eb); border: none;">
        <div class="stat-info" style="width: 100%; text-align: center;">
            <div class="stat-label" style="color: rgba(255,255,255,0.8);">Tổng đơn hàng</div>
            <div class="stat-value" style="color: #fff;">{{ number_format($totalOrders) }}</div>
        </div>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); border: none;">
        <div class="stat-info" style="width: 100%; text-align: center;">
            <div class="stat-label" style="color: rgba(255,255,255,0.8);">Trung bình/đơn</div>
            <div class="stat-value" style="color: #fff;">{{ $totalOrders > 0 ? number_format($totalRevenue / $totalOrders) : 0 }}đ</div>
        </div>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #f59e0b, #d97706); border: none;">
        <div class="stat-info" style="width: 100%; text-align: center;">
            <div class="stat-label" style="color: rgba(255,255,255,0.8);">Users mới</div>
            <div class="stat-value" style="color: #fff;">{{ number_format($newUsers) }}</div>
        </div>
    </div>
</div>

<!-- Revenue Chart -->
<div class="admin-card">
    <div class="admin-card-title">📈 Biểu đồ Doanh thu</div>
    <div style="height: 300px; position: relative;">
        <canvas id="revenueChart"></canvas>
    </div>
</div>

<!-- Revenue by Service -->
<div class="admin-card">
    <div class="admin-card-title">💰 Doanh thu theo Dịch vụ</div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Dịch vụ</th>
                <th>Số đơn</th>
                <th>Doanh thu</th>
                <th>Tỷ lệ</th>
            </tr>
        </thead>
        <tbody>
            @forelse($revenueByService as $service)
            <tr>
                <td style="font-weight: 600;">{{ $service->service_type ?? 'Không xác định' }}</td>
                <td>{{ number_format($service->order_count) }}</td>
                <td style="color: #10b981; font-weight: 600;">{{ number_format($service->total_revenue) }}đ</td>
                <td>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div style="flex: 1; height: 8px; background: #334155; border-radius: 4px; overflow: hidden;">
                            <div style="width: {{ $totalRevenue > 0 ? ($service->total_revenue / $totalRevenue) * 100 : 0 }}%; height: 100%; background: linear-gradient(90deg, #3b82f6, #8b5cf6);"></div>
                        </div>
                        <span style="font-size: 12px; color: #94a3b8;">{{ $totalRevenue > 0 ? round(($service->total_revenue / $totalRevenue) * 100, 1) : 0 }}%</span>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; color: #64748b; padding: 40px;">Chưa có dữ liệu</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Top Users -->
<div class="admin-card">
    <div class="admin-card-title">👑 Top Khách hàng</div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Khách hàng</th>
                <th>Email</th>
                <th>Số đơn</th>
                <th>Tổng chi tiêu</th>
            </tr>
        </thead>
        <tbody>
            @forelse($topUsers as $index => $user)
            <tr>
                <td>
                    @if($index < 3)
                        <span style="font-size: 20px;">{{ ['🥇', '🥈', '🥉'][$index] }}</span>
                    @else
                        {{ $index + 1 }}
                    @endif
                </td>
                <td style="font-weight: 600;">{{ $user->name ?? 'N/A' }}</td>
                <td style="font-size: 12px; color: #94a3b8;">{{ $user->email ?? 'N/A' }}</td>
                <td>{{ $user->order_count }}</td>
                <td style="color: #10b981; font-weight: 600;">{{ number_format($user->total_spent) }}đ</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; color: #64748b; padding: 40px;">Chưa có dữ liệu</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('revenueChart').getContext('2d');
const chartData = @json($chartData);

new Chart(ctx, {
    type: 'line',
    data: {
        labels: chartData.labels,
        datasets: [{
            label: 'Doanh thu (VNĐ)',
            data: chartData.data,
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#3b82f6',
            pointRadius: 4,
            pointHoverRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: '#1e293b',
                titleColor: '#f1f5f9',
                bodyColor: '#94a3b8',
                borderColor: '#334155',
                borderWidth: 1,
                padding: 12,
                displayColors: false,
                callbacks: {
                    label: function(context) {
                        return new Intl.NumberFormat('vi-VN').format(context.raw) + 'đ';
                    }
                }
            }
        },
        scales: {
            x: {
                grid: {
                    color: '#334155',
                    drawBorder: false
                },
                ticks: {
                    color: '#64748b'
                }
            },
            y: {
                grid: {
                    color: '#334155',
                    drawBorder: false
                },
                ticks: {
                    color: '#64748b',
                    callback: function(value) {
                        return new Intl.NumberFormat('vi-VN', { notation: 'compact' }).format(value);
                    }
                }
            }
        }
    }
});
</script>
@endsection
