<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('admin.css')
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .return-refunds-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            margin: 20px;
            padding: 30px;
            min-height: 80vh;
        }

        .page-title {
            color: #2c3e50;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
            background: linear-gradient(45deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card.stat-pending { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
        .stat-card.stat-approved { background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%); }
        .stat-card.stat-refunded { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
        .stat-card.stat-rejected { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }
        .stat-card.stat-amount { background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); }

        .stat-badge {
            display: inline-block;
            margin-top: 8px;
            padding: 3px 10px;
            background: rgba(255,255,255,0.25);
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 1rem;
            opacity: 0.9;
        }

        .section-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .section-tab {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            padding: 12px 20px;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            color: #6c757d;
        }

        .section-tab.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: #667eea;
        }

        .section-tab:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .section-tab .tab-count {
            display: inline-block;
            margin-left: 6px;
            padding: 2px 8px;
            background: rgba(255,255,255,0.3);
            border-radius: 12px;
            font-size: 0.8rem;
        }

        .section-tab.active .tab-count {
            background: rgba(255,255,255,0.35);
        }

        .search-filter {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .search-input, .filter-select {
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 25px;
            font-size: 14px;
            transition: all 0.3s ease;
            min-width: 200px;
        }

        .search-input:focus, .filter-select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .return-refunds-section {
            display: none;
        }

        .return-refunds-section.active {
            display: block;
        }

        .orders-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        th {
            font-weight: 600;
            font-size: 12px;
            text-align: left;
            padding: 10px 6px;
            white-space: nowrap;
            color: white;
            border-bottom: 2px solid #5a6fd8;
        }

        tbody tr {
            border-bottom: 1px solid #e5e7eb;
            transition: all 0.3s ease;
        }

        tbody tr:hover {
            background-color: #f9fafb;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        td {
            padding: 8px 6px;
            color: #1f2937;
            font-size: 12px;
            vertical-align: middle;
            word-wrap: break-word;
            max-width: 120px;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 15px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-approved {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-rejected {
            background: #f8d7da;
            color: #721c24;
        }

        .status-refunded {
            background: #d4edda;
            color: #155724;
        }

        .status-cancelled {
            background: #e2e3e5;
            color: #383d41;
        }

        .action-buttons {
            display: flex;
            gap: 4px;
            flex-wrap: wrap;
        }

        .btn-action {
            padding: 4px 8px;
            border: none;
            border-radius: 15px;
            font-size: 0.7rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 3px;
        }

        .btn-view {
            background: #17a2b8;
            color: white;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .no-data {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .no-data i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .alert {
            border-radius: 10px;
            border: none;
            font-weight: 500;
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
        }

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
        }

        .amount {
            font-weight: bold;
            color: #28a745;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            th, td {
                padding: 6px 4px;
                font-size: 11px;
            }
            
            .page-title {
                font-size: 24px;
            }
        }

        @media (max-width: 768px) {
            .return-refunds-container {
                margin: 10px;
                padding: 15px;
            }

            .page-title {
                font-size: 1.8rem;
            }

            .stats-cards {
                grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            }

            .search-filter {
                flex-direction: column;
            }

            .search-input, .filter-select {
                min-width: 100%;
            }
            
            th, td {
                padding: 4px 2px;
                font-size: 10px;
            }

            .action-buttons {
                flex-direction: column;
                gap: 2px;
            }

            .btn-action {
                font-size: 0.6rem;
                padding: 3px 6px;
            }
        }
    </style>
</head>
<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <div class="return-refunds-container">
                    <h1 class="page-title" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
                        <span><i class="fas fa-sync-alt" aria-hidden="true" style="margin-right: 8px;"></i>Return/Refund Management</span>
                    </h1>
                    
                    <!-- Success/Error Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            ✅ {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            ❌ {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif
                    
                    <!-- Statistics Cards -->
                    <div class="stats-cards">
                        <div class="stat-card stat-total">
                            <div class="stat-number">{{ $stats['total'] }}</div>
                            <div class="stat-label">Total Requests</div>
                        </div>
                        <div class="stat-card stat-pending">
                            <div class="stat-number">{{ $stats['pending'] }}</div>
                            <div class="stat-label">Pending</div>
                            @if($stats['pending'] > 0)
                                <span class="stat-badge">Needs attention</span>
                            @endif
                        </div>
                        <div class="stat-card stat-approved">
                            <div class="stat-number">{{ $stats['approved'] }}</div>
                            <div class="stat-label">Approved</div>
                        </div>
                        <div class="stat-card stat-rejected">
                            <div class="stat-number">{{ $stats['rejected'] }}</div>
                            <div class="stat-label">Rejected</div>
                        </div>
                        <div class="stat-card stat-amount">
                            <div class="stat-number">₱{{ number_format($stats['total_amount'], 0) }}</div>
                            <div class="stat-label">Total Amount</div>
                        </div>
                    </div>

                    <!-- Section Tabs -->
                    <div class="section-tabs">
                        <div class="section-tab active" data-section="all">📊 All Requests</div>
                        <div class="section-tab" data-section="pending">
                            ⏳ Pending
                            @if($stats['pending'] > 0)
                                <span class="tab-count">{{ $stats['pending'] }}</span>
                            @endif
                        </div>
                        <div class="section-tab" data-section="approved">✅ Approved</div>
                        <div class="section-tab" data-section="rejected">❌ Rejected</div>
                    </div>

                    <!-- Search and Filter -->
                    <div class="search-filter">
                        <input type="text" class="search-input" placeholder="🔍 Search by ID, customer, email, or amount..." id="searchInput" aria-label="Search requests">
                        <select class="filter-select" id="typeFilter" aria-label="Filter by type">
                            <option value="Order" selected>Order</option>
                        </select>
                    </div>

                    <!-- All Requests Section -->
                    <div id="all-section" class="return-refunds-section active">
                        <div class="orders-container">
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>👤 Customer</th>
                                        <th>📦 Type</th>
                                        <th>📝 Item</th>
                                        <th><i class="fas fa-sync-alt" aria-hidden="true" style="margin-right: 6px;"></i>Request Type</th>
                                        <th>💰 Amount</th>
                                        <th>📊 Status</th>
                                        <th>📅 Date</th>
                                        <th>⚡ Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($returnRefunds as $returnRefund)
                                    @php
                                        $refundable = $returnRefund->refundable;
                                        $itemName = 'N/A';

                                        if ($refundable) {
                                            if ($returnRefund->refundable_type === 'App\Models\EventBooking') {
                                                $eventName = $refundable->eventType->name ?? 'Event';
                                                $eventDate = $refundable->event_date
                                                    ? \Carbon\Carbon::parse($refundable->event_date)->format('M d, Y')
                                                    : null;
                                                $itemName = trim($eventName . ($eventDate ? ' - ' . $eventDate : ''));
                                            } else {
                                                $itemName = $refundable->title ?? ('Order #' . ($refundable->id ?? ''));
                                            }
                                        } else {
                                            $itemName = $returnRefund->refundable_type === 'App\Models\EventBooking'
                                                ? 'Event Booking (missing record)'
                                                : 'Order (missing record)';
                                        }
                                    @endphp
                                    <tr>
                                        <td>#{{ $returnRefund->id }}</td>
                                        <td>
                                            <strong>{{ optional($returnRefund->user)->name ?? 'N/A' }}</strong><br>
                                            <small style="color: #6c757d;">{{ optional($returnRefund->user)->email ?? '' }}</small>
                                        </td>
                                        <td>
                                            {{ $returnRefund->refundable_type === 'App\Models\EventBooking' ? 'Event Booking' : 'Order' }}
                                        </td>
                                        <td>
                                            <span title="{{ $itemName }}">{{ \Illuminate\Support\Str::limit($itemName, 30) }}</span>
                                        </td>
                                        <td>{{ ucfirst($returnRefund->type) }}</td>
                                        <td>
                                            <span class="amount">₱{{ number_format($returnRefund->refund_amount, 2) }}</span>
                                        </td>
                                        <td>
                                            <span class="status-badge status-{{ $returnRefund->status }}">
                                                {{ ucfirst($returnRefund->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div style="font-size: 11px; color: #6b7280;">
                                                {{ $returnRefund->created_at->format('M d, Y') }}<br>
                                                <small>{{ $returnRefund->created_at->format('h:i A') }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="{{ route('admin.return_refunds.show', $returnRefund->id) }}" class="btn-action btn-view">
                                                    <i class="fa fa-eye"></i> View
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="no-data">
                                            <i class="fas fa-undo"></i>
                                            <h4>No Return/Refund Requests</h4>
                                            <p>Return/refund requests will appear here when customers submit them.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Filtered Sections -->
                    @foreach(['pending', 'approved', 'rejected'] as $status)
                    <div id="{{ $status }}-section" class="return-refunds-section">
                        <div class="orders-container">
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>👤 Customer</th>
                                        <th>📦 Type</th>
                                        <th>📝 Item</th>
                                        <th><i class="fas fa-sync-alt" aria-hidden="true" style="margin-right: 6px;"></i>Request Type</th>
                                        <th>💰 Amount</th>
                                        <th>📊 Status</th>
                                        <th>📅 Date</th>
                                        <th>⚡ Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $filteredRequests = $returnRefunds->where('status', $status);
                                    @endphp
                                    @forelse($filteredRequests as $returnRefund)
                                    @php
                                        $refundable = $returnRefund->refundable;
                                        $itemName = 'N/A';

                                        if ($refundable) {
                                            if ($returnRefund->refundable_type === 'App\Models\EventBooking') {
                                                $eventName = $refundable->eventType->name ?? 'Event';
                                                $eventDate = $refundable->event_date
                                                    ? \Carbon\Carbon::parse($refundable->event_date)->format('M d, Y')
                                                    : null;
                                                $itemName = trim($eventName . ($eventDate ? ' - ' . $eventDate : ''));
                                            } else {
                                                $itemName = $refundable->title ?? ('Order #' . ($refundable->id ?? ''));
                                            }
                                        } else {
                                            $itemName = $returnRefund->refundable_type === 'App\Models\EventBooking'
                                                ? 'Event Booking (missing record)'
                                                : 'Order (missing record)';
                                        }
                                    @endphp
                                    <tr>
                                        <td>#{{ $returnRefund->id }}</td>
                                        <td>
                                            <strong>{{ optional($returnRefund->user)->name ?? 'N/A' }}</strong><br>
                                            <small style="color: #6c757d;">{{ optional($returnRefund->user)->email ?? '' }}</small>
                                        </td>
                                        <td>
                                            {{ $returnRefund->refundable_type === 'App\Models\EventBooking' ? 'Event Booking' : 'Order' }}
                                        </td>
                                        <td>
                                            <span title="{{ $itemName }}">{{ \Illuminate\Support\Str::limit($itemName, 30) }}</span>
                                        </td>
                                        <td>{{ ucfirst($returnRefund->type) }}</td>
                                        <td>
                                            <span class="amount">₱{{ number_format($returnRefund->refund_amount, 2) }}</span>
                                        </td>
                                        <td>
                                            <span class="status-badge status-{{ $returnRefund->status }}">
                                                {{ ucfirst($returnRefund->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div style="font-size: 11px; color: #6b7280;">
                                                {{ $returnRefund->created_at->format('M d, Y') }}<br>
                                                <small>{{ $returnRefund->created_at->format('h:i A') }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="{{ route('admin.return_refunds.show', $returnRefund->id) }}" class="btn-action btn-view">
                                                    <i class="fa fa-eye"></i> View
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="no-data">
                                            <i class="fas fa-undo"></i>
                                            <h4>No {{ ucfirst($status) }} Requests</h4>
                                            <p>There are no {{ $status }} return/refund requests at the moment.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @include('admin.js')
    <script>
        (function () {
            const sectionTabs = document.querySelectorAll('.section-tab');
            const sections = document.querySelectorAll('.return-refunds-section');
            const searchInput = document.getElementById('searchInput');
            const typeFilterEl = document.getElementById('typeFilter');

            function getActiveSection() {
                return document.querySelector('.return-refunds-section.active');
            }

            function ensureNoMatchesRow(tbody, colCount) {
                let row = tbody.querySelector('tr.no-matches-row');
                if (!row) {
                    row = document.createElement('tr');
                    row.className = 'no-matches-row';

                    const td = document.createElement('td');
                    td.colSpan = colCount;
                    td.className = 'no-data';
                    td.innerHTML = `
                        <i class="fas fa-search"></i>
                        <h4>No matching results</h4>
                        <p>Try adjusting your search or filter.</p>
                    `;

                    row.appendChild(td);
                    tbody.appendChild(row);
                }
                return row;
            }

            function applyFilters() {
                const activeSection = getActiveSection();
                if (!activeSection) return;

                const table = activeSection.querySelector('table');
                if (!table) return;

                const tbody = table.querySelector('tbody');
                if (!tbody) return;

                const noDataCell = tbody.querySelector('td.no-data');
                const emptyState = noDataCell ? noDataCell.closest('tr') : null;
                if (emptyState && !emptyState.classList.contains('no-matches-row')) {
                    // If there is no data at all (server-rendered empty state), keep it visible.
                    emptyState.style.display = '';
                    return;
                }

                const searchTerm = (searchInput?.value || '').trim().toLowerCase();
                const typeFilter = (typeFilterEl?.value || '').trim();
                const searchId = searchTerm.replace(/^#/, ''); // allow #123 or 123

                const headerCount = table.querySelectorAll('thead th').length || 9;
                const noMatchesRow = ensureNoMatchesRow(tbody, headerCount);

                let visibleCount = 0;
                const rows = Array.from(tbody.querySelectorAll('tr')).filter(r => !r.classList.contains('no-matches-row'));

                rows.forEach(row => {
                    let show = true;

                    if (typeFilter) {
                        const typeCell = row.cells?.[2]; // Type column
                        const typeText = typeCell ? typeCell.textContent.trim() : '';
                        if (typeText !== typeFilter) show = false;
                    }

                    if (show && searchTerm) {
                        const text = (row.textContent || '').toLowerCase();
                        const rowId = (row.cells?.[0]?.textContent || '').replace(/^#/, '').trim();
                        const matchesText = text.includes(searchTerm);
                        const matchesId = searchId && rowId === searchId;
                        if (!matchesText && !matchesId) show = false;
                    }

                    row.style.display = show ? '' : 'none';
                    if (show) visibleCount++;
                });

                noMatchesRow.style.display = visibleCount === 0 ? '' : 'none';
            }

            // Tab switching
            sectionTabs.forEach(tab => {
                tab.addEventListener('click', function () {
                    sectionTabs.forEach(t => t.classList.remove('active'));
                    sections.forEach(s => s.classList.remove('active'));

                    this.classList.add('active');
                    const sectionId = this.getAttribute('data-section') + '-section';
                    const sectionEl = document.getElementById(sectionId);
                    if (sectionEl) sectionEl.classList.add('active');

                    applyFilters();
                });
            });

            // Search + filter (combined)
            if (searchInput) searchInput.addEventListener('input', applyFilters);
            if (typeFilterEl) typeFilterEl.addEventListener('change', applyFilters);

            // Initial filter render
            applyFilters();

        // Auto-hide any server-rendered success alerts after 5 seconds
        const initialSuccess = document.querySelectorAll('.alert.alert-success');
        if (initialSuccess.length) {
            setTimeout(() => {
                initialSuccess.forEach(el => el.remove());
            }, 5000);
        }
        })();
    </script>
</body>
</html>
