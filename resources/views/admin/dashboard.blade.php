@extends('admin.index')

@section('content')
<div class="dashboard-content container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Admin Dashboard</h2>
            <p class="text-muted mb-0">Live overview of orders, reservations, and events</p>
        </div>
        <div class="text-right">
            <small id="dashboard-status" class="text-secondary">Updating...</small><br>
            <small id="dashboard-updated" class="text-muted"></small>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="text-muted small">Total Revenue</div>
                    <div id="metric-total-revenue" class="h4 mb-1 font-weight-bold">₱0.00</div>
                    <div class="text-success small" id="metric-revenue-today">Today: ₱0.00</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="text-muted small">Orders</div>
                    <div id="metric-orders-today" class="h4 mb-1 font-weight-bold">0</div>
                    <div class="small">
                        <span class="badge badge-warning" id="metric-orders-progress">0 In Progress</span>
                        <span class="badge badge-success" id="metric-orders-done">0 Delivered</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="text-muted small">Table Reservations</div>
                    <div id="metric-reservations-pending" class="h4 mb-1 font-weight-bold">0</div>
                    <div class="text-info small" id="metric-reservations-upcoming">Upcoming: 0</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="text-muted small">Event Bookings</div>
                    <div id="metric-events-pending" class="h4 mb-1 font-weight-bold">0</div>
                    <div class="text-success small" id="metric-events-paid">Paid: 0 (₱0.00)</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">7-Day Activity</h5>
                    <small class="text-muted">Orders, Reservations, Events</small>
                </div>
                <div class="card-body" style="max-height:220px;">
                    <canvas id="trendChart" height="90"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Order Status</h5>
                    <small class="text-muted">Live breakdown</small>
                </div>
                <div class="card-body">
                    <canvas id="statusChart" height="180"></canvas>
                    <div class="mt-3" id="status-legend"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Revenue (7 days)</h5>
                    <small class="text-muted">Daily totals</small>
                </div>
                <div class="card-body" style="max-height:220px;">
                    <canvas id="revenueChart" height="90"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Recent Activity</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="font-weight-bold mb-2">Orders</div>
                        <ul class="list-group list-group-flush small" id="recent-orders"></ul>
                    </div>
                    <div class="mb-3">
                        <div class="font-weight-bold mb-2">Reservations</div>
                        <ul class="list-group list-group-flush small" id="recent-reservations"></ul>
                    </div>
                    <div>
                        <div class="font-weight-bold mb-2">Events</div>
                        <ul class="list-group list-group-flush small" id="recent-events"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .dashboard-content .card {
        border-radius: 12px;
    }
    .dashboard-content .list-group-item {
        padding-left: 0;
        padding-right: 0;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Use snapshot data passed from the server; no auto-refresh to keep the system stable
    const initialData = @json($initialStats ?? null);
    let trendChart, revenueChart, statusChart;

    const palette = {
        primary: '#4e79a7',
        success: '#59a14f',
        warning: '#f28e2c',
        danger: '#e15759',
        purple: '#af7aa1',
        gray: '#9fa2a6'
    };

    function formatCurrency(value) {
        const num = Number(value || 0);
        return '₱' + num.toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function escapeHtml(value) {
        if (value === null || value === undefined) return '';
        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }

    function setText(id, value) {
        const el = document.getElementById(id);
        if (el) el.textContent = value;
    }

    function renderSummary(summary = {}) {
        setText('metric-total-revenue', formatCurrency(summary.totalRevenue));
        setText('metric-revenue-today', 'Today: ' + formatCurrency(summary.revenueToday));
        setText('metric-orders-today', summary.ordersToday ?? 0);
        setText('metric-orders-progress', `${summary.ordersInProgress ?? 0} In Progress`);
        setText('metric-orders-done', `${summary.ordersDelivered ?? 0} Delivered`);
        setText('metric-reservations-pending', summary.pendingReservations ?? 0);
        setText('metric-reservations-upcoming', `Upcoming: ${summary.upcomingReservations ?? 0}`);
        setText('metric-events-pending', summary.pendingEventBookings ?? 0);
        setText('metric-events-paid', `Paid: ${summary.paidEventBookings ?? 0} (${formatCurrency(summary.eventRevenue)})`);
    }

    function renderTrend(charts = {}) {
        const labels = charts.labels || [];
        const ctx = document.getElementById('trendChart');
        if (!ctx) return;

        const datasets = [
            { label: 'Orders', data: charts.orders || [], borderColor: palette.primary, backgroundColor: 'rgba(78,121,167,0.08)', fill: true, borderWidth: 2 },
            { label: 'Reservations', data: charts.reservations || [], borderColor: palette.success, backgroundColor: 'rgba(89,161,79,0.1)', fill: true, borderWidth: 2 },
            { label: 'Events', data: charts.events || [], borderColor: palette.purple, backgroundColor: 'rgba(175,122,161,0.1)', fill: true, borderWidth: 2 }
        ];

        if (!trendChart) {
            trendChart = new Chart(ctx, {
                type: 'line',
                data: { labels, datasets },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    tooltips: { mode: 'index', intersect: false },
                    scales: {
                        yAxes: [{ ticks: { beginAtZero: true, precision: 0 } }],
                        xAxes: [{ gridLines: { display: false } }]
                    },
                    legend: { display: true }
                }
            });
        } else {
            trendChart.data.labels = labels;
            trendChart.data.datasets.forEach((ds, i) => ds.data = datasets[i].data);
            trendChart.update();
        }
    }

    function renderRevenue(charts = {}) {
        const ctx = document.getElementById('revenueChart');
        if (!ctx) return;

        if (!revenueChart) {
            revenueChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: charts.labels || [],
                    datasets: [{
                        label: 'Revenue',
                        data: charts.revenue || [],
                        backgroundColor: 'rgba(242,142,44,0.6)',
                        borderColor: palette.warning,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    tooltips: { callbacks: { label: (item) => formatCurrency(item.yLabel) } },
                    scales: {
                        yAxes: [{ ticks: { beginAtZero: true, callback: value => formatCurrency(value) } }],
                        xAxes: [{ gridLines: { display: false } }]
                    },
                    legend: { display: false }
                }
            });
        } else {
            revenueChart.data.labels = charts.labels || [];
            revenueChart.data.datasets[0].data = charts.revenue || [];
            revenueChart.update();
        }
    }

    function renderStatuses(statuses = {}) {
        const ctx = document.getElementById('statusChart');
        if (!ctx) return;

        const orderStats = statuses.orders || {};
        const dataset = [
            orderStats.in_progress || 0,
            orderStats.delivered || 0,
            orderStats.cancelled || 0
        ];

        const labels = ['In Progress', 'Delivered', 'Cancelled'];
        const colors = [palette.warning, palette.success, palette.danger];

        if (!statusChart) {
            statusChart = new Chart(ctx, {
                type: 'doughnut',
                data: { labels, datasets: [{ data: dataset, backgroundColor: colors, borderWidth: 0 }] },
                options: {
                    cutoutPercentage: 70,
                    legend: { display: false },
                    tooltips: { callbacks: { label: (item) => `${labels[item.index]}: ${dataset[item.index]}` } }
                }
            });
        } else {
            statusChart.data.datasets[0].data = dataset;
            statusChart.update();
        }

        const legend = labels.map((label, idx) => {
            return `<div class="d-flex align-items-center mb-1">
                        <span style="display:inline-block;width:10px;height:10px;background:${colors[idx]};border-radius:50%;margin-right:8px;"></span>
                        <span>${escapeHtml(label)}</span>
                        <span class="ml-auto font-weight-bold">${dataset[idx]}</span>
                    </div>`;
        }).join('');

        const legendEl = document.getElementById('status-legend');
        if (legendEl) legendEl.innerHTML = legend;
    }

    function buildList(items, formatter) {
        if (!items || !items.length) {
            return '<li class="list-group-item text-muted">No records</li>';
        }
        return items.map(formatter).join('');
    }

    function renderActivity(activity = {}) {
        const ordersEl = document.getElementById('recent-orders');
        if (ordersEl) {
            ordersEl.innerHTML = buildList(activity.orders, item => {
                const badgeClass = (item.status || '').toLowerCase() === 'delivered' ? 'badge-success' :
                    (item.status || '').toLowerCase() === 'cancelled' ? 'badge-danger' : 'badge-warning';
                return `<li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <div class="font-weight-bold">${escapeHtml(item.title || 'Order #' + item.id)}</div>
                                <small class="text-muted">${escapeHtml(item.customer || 'Guest')}</small>
                            </div>
                            <div class="text-right">
                                <span class="badge ${badgeClass} mb-1">${escapeHtml(item.status || 'New')}</span>
                                <div class="font-weight-bold text-success">${formatCurrency(item.price)}</div>
                            </div>
                        </li>`;
            });
        }

        const reservationsEl = document.getElementById('recent-reservations');
        if (reservationsEl) {
            reservationsEl.innerHTML = buildList(activity.reservations, item => {
                return `<li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <div class="font-weight-bold">${escapeHtml(item.name || 'Guest')}</div>
                                <small class="text-muted">${escapeHtml(item.date || '')} ${escapeHtml(item.time || '')}</small>
                            </div>
                            <span class="badge badge-info">${escapeHtml(item.status || 'pending')}</span>
                        </li>`;
            });
        }

        const eventsEl = document.getElementById('recent-events');
        if (eventsEl) {
            eventsEl.innerHTML = buildList(activity.events, item => {
                return `<li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <div class="font-weight-bold">${escapeHtml(item.name || 'Customer')}</div>
                                <small class="text-muted">${escapeHtml(item.event_date || '')}</small>
                                <div class="text-muted">${escapeHtml(item.event_type || 'Event')} @ ${escapeHtml(item.venue_type || 'Venue')}</div>
                            </div>
                            <div class="text-right">
                                <span class="badge badge-secondary mb-1">${escapeHtml(item.status || 'Pending')}</span>
                                <div class="font-weight-bold text-success">${formatCurrency(item.amount)}</div>
                            </div>
                        </li>`;
            });
        }
    }

    function renderAll(payload) {
        if (!payload) return;
        renderSummary(payload.summary);
        renderTrend(payload.charts);
        renderRevenue(payload.charts);
        renderStatuses(payload.statuses);
        renderActivity(payload.activity);

        setText('dashboard-updated', `Snapshot as of: ${new Date(payload.last_refreshed || Date.now()).toLocaleTimeString()}`);
        setText('dashboard-status', 'Snapshot');
    }

    renderAll(initialData);
});
</script>
@endsection

