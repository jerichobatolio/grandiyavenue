<!DOCTYPE html>
<html>
  <head> 
   <meta name="csrf-token" content="{{ csrf_token() }}">
   @include('admin.css')

   <style>
         .reservations-container {
          margin: 20px auto;
          max-width: 1200px;
          padding: 20px;
         }

         .page-title {
         text-align: center;
         color: #fff !important;
          margin-bottom: 30px;
          font-size: 2.5em;
          font-weight: bold;
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
          padding: 20px;
          border-radius: 15px;
          text-align: center;
          box-shadow: 0 4px 15px rgba(0,0,0,0.1);
         }

         .stat-number {
          font-size: 2em;
          font-weight: bold;
          margin-bottom: 5px;
         }

         .stat-label {
          font-size: 0.9em;
          opacity: 0.9;
         }

         .section-tabs {
          display: flex;
          justify-content: center;
          margin-bottom: 30px;
          gap: 10px;
         }

         .section-tab {
          padding: 12px 24px;
          background-color: #f8f9fa;
          border: 2px solid #dee2e6;
          border-radius: 25px;
          cursor: pointer;
          transition: all 0.3s ease;
          font-weight: bold;
         }

         .section-tab.active {
          background-color: #007bff;
          color: white;
          border-color: #007bff;
         }

         .section-tab:hover {
          transform: translateY(-2px);
          box-shadow: 0 4px 8px rgba(0,0,0,0.1);
         }

         .reservations-section {
          display: none;
         }

         .reservations-section.active {
          display: block;
         }

         .reservations-table {
          background: white;
          border-radius: 15px;
          overflow: hidden;
          box-shadow: 0 4px 15px rgba(0,0,0,0.1);
          margin-bottom: 20px;
         }

         .table-wrapper {
          overflow-x: auto;
          -webkit-overflow-scrolling: touch;
          position: relative;
          max-height: 80vh;
          overflow-y: auto;
         }

         .table-wrapper::-webkit-scrollbar {
          height: 8px;
          width: 8px;
         }

         .table-wrapper::-webkit-scrollbar-track {
          background: #f1f1f1;
          border-radius: 10px;
         }

         .table-wrapper::-webkit-scrollbar-thumb {
          background: #888;
          border-radius: 10px;
         }

         .table-wrapper::-webkit-scrollbar-thumb:hover {
          background: #555;
         }

         .table-header {
          background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
          color: white;
          padding: 20px;
          text-align: center;
          font-size: 1.2em;
          font-weight: bold;
         }

         table {
          width: 100%;
          border-collapse: collapse;
          margin: 0;
          min-width: 1200px;
         }

         th {
          background-color: #f8f9fa;
          padding: 12px 8px;
          text-align: center;
          color: #333;
          font-size: 14px;
          font-weight: bold;
          border-bottom: 2px solid #dee2e6;
          white-space: nowrap;
         }

         th:nth-child(1), td:nth-child(1) { min-width: 100px; } /* Name */
         th:nth-child(2), td:nth-child(2) { min-width: 100px; } /* Last Name */
         th:nth-child(3), td:nth-child(3) { min-width: 80px; }  /* Table */
         th:nth-child(4), td:nth-child(4) { min-width: 120px; } /* Phone */
         th:nth-child(5), td:nth-child(5) { min-width: 70px; }  /* Guests */
         th:nth-child(6), td:nth-child(6) { min-width: 110px; } /* Date */
         th:nth-child(7), td:nth-child(7) { min-width: 90px; }  /* Time In */
         th:nth-child(8), td:nth-child(8) { min-width: 110px; } /* Section */
         th:nth-child(9), td:nth-child(9) { min-width: 100px; } /* Occasion */
         th:nth-child(10), td:nth-child(10) { min-width: 100px; } /* Status */
         th:nth-child(11), td:nth-child(11) { min-width: 200px; } /* Actions */

         td {
          padding: 12px 8px;
          text-align: center;
          color: #333;
          border-bottom: 1px solid #dee2e6;
          font-size: 14px;
          white-space: nowrap;
         }

         tr:hover {
          background-color: #f8f9fa;
         }

         .table-badge {
          display: inline-block;
          padding: 5px 12px;
          border-radius: 20px;
          font-size: 0.8em;
          font-weight: bold;
          color: white;
         }

         .table-badge.top { background-color: #28a745; }
         .table-badge.hallway { background-color: #17a2b8; }
         .table-badge.vip { background-color: #ffc107; color: #333; }
         .table-badge.garden { background-color: #20c997; color: white; }

         .status-badge {
          display: inline-block;
          padding: 5px 12px;
          border-radius: 20px;
          font-size: 0.8em;
          font-weight: bold;
          color: white;
         }

         .status-badge.confirmed { background-color: #28a745; color: white; }
         .status-badge.approved { background-color: #28a745; color: white; }
        .status-badge.pending { background-color: #ffc107; color: #000; }
         .status-badge.cancelled { background-color: #dc3545; color: white; }

         /* Action Buttons */
         .action-buttons {
          display: flex;
          gap: 8px;
          flex-wrap: wrap;
         }

         .btn-approve, .btn-cancel, .btn-delete {
          padding: 6px 10px;
          border: none;
          border-radius: 6px;
          font-size: 0.75em;
          font-weight: bold;
          cursor: pointer;
          transition: all 0.3s ease;
          min-width: 70px;
          white-space: nowrap;
         }

         .btn-approve {
          background-color: #28a745;
          color: white;
         }

         .btn-approve:hover {
          background-color: #218838;
          transform: translateY(-1px);
         }

         .btn-cancel {
          background-color: #dc3545;
          color: white;
         }

         .btn-cancel:hover {
          background-color: #c82333;
          transform: translateY(-1px);
         }

         .btn-delete {
          background-color: #6c757d;
          color: white;
         }

         .btn-delete:hover {
          background-color: #5a6268;
          transform: translateY(-1px);
         }

         .btn-approve:disabled, .btn-cancel:disabled, .btn-delete:disabled {
          opacity: 0.6;
          cursor: not-allowed;
          transform: none;
         }

         /* Admin Calendar Styles */
         .calendar-container {
          background-color: rgba(255,255,255,0.1);
          padding: 20px;
          border-radius: 15px;
          backdrop-filter: blur(10px);
          max-width: 1200px;
          margin: 0 auto;
          display: flex;
          flex-direction: column;
          gap: 20px;
         }
         
         @media (min-width: 992px) {
           .calendar-container {
             flex-direction: row;
             flex-wrap: wrap;
             align-items: flex-start;
             gap: 30px;
           }
           
           .calendar-header-wrapper {
             display: flex;
             flex-direction: column;
             min-width: 200px;
             gap: 15px;
             order: 1;
           }
           
           .calendar-header {
             flex-direction: column;
             align-items: flex-start;
             margin-bottom: 0;
             padding: 0;
           }
           
           .calendar-header h4 {
             margin-bottom: 10px;
             text-align: left;
           }
           
           .calendar-header .btn {
             width: 100%;
             margin: 5px 0;
           }
           
           .calendar-grid-wrapper {
             flex: 1;
             order: 2;
             min-width: 600px;
           }
           
           .calendar-legend {
             width: 100%;
             order: 3;
           }
         }

         .calendar-header {
          display: flex;
          justify-content: space-between;
          align-items: center;
          margin-bottom: 20px;
          padding: 0 10px;
          flex-wrap: wrap;
          gap: 15px;
         }

         .calendar-header h4 {
          margin: 0;
          color: #fff !important;
          font-size: 1.5em;
          font-weight: bold;
          flex: 1;
          min-width: 200px;
          text-align: center;
          visibility: visible !important;
          display: block !important;
          text-shadow: 0 1px 2px rgba(0,0,0,0.15);
         }
         
         .calendar-header .btn {
          white-space: nowrap;
         }
         
         .calendar-grid-wrapper {
          width: 100%;
         }

         .calendar-grid {
          display: grid;
          grid-template-columns: repeat(7, 1fr);
          gap: 2px;
          background-color: rgba(255,255,255,0.1);
          padding: 10px;
          border-radius: 10px;
         }

        .calendar-day-header {
         background-color: rgba(0,123,255,0.3);
         color: white;
         padding: 10px 5px;
         text-align: center;
         font-weight: bold;
         border-radius: 5px;
         font-size: 0.9em;
        }

         .calendar-day {
          background-color: rgba(255,255,255,0.1);
          color: white;
          padding: 15px 5px;
          text-align: center;
          border-radius: 5px;
          cursor: pointer;
          transition: all 0.3s ease;
          min-height: 80px;
          display: flex;
          flex-direction: column;
          justify-content: center;
          position: relative;
          border: 2px solid transparent;
         }

         .calendar-day:hover {
          background-color: rgba(255,255,255,0.2);
          transform: scale(1.05);
         }

         .calendar-day.other-month {
          opacity: 0.3;
          cursor: default;
         }

         .calendar-day.today {
          background-color: rgba(255,193,7,0.3);
          border-color: #ffc107;
         }

         .calendar-day.pending {
          background-color: rgba(255,193,7,0.3);
          border-color: #ffc107;
         }

         .calendar-day.approved {
          background-color: rgba(40,167,69,0.3);
          border-color: #28a745;
         }

         .calendar-day.cancelled {
          background-color: rgba(220,53,69,0.3);
          border-color: #dc3545;
         }

         .calendar-day.available {
          background-color: rgba(108,117,125,0.3);
          border-color: #6c757d;
         }

         .calendar-day-number {
          font-weight: bold;
          font-size: 1.1em;
         }

         .calendar-day-info {
          font-size: 0.7em;
          margin-top: 2px;
          opacity: 0.8;
         }

         .calendar-legend {
          display: flex;
          justify-content: center;
          gap: 20px;
          flex-wrap: wrap;
         }

         .legend-item {
          display: flex;
          align-items: center;
          gap: 8px;
          color: #fff;
          font-size: 0.9em;
         }

         .legend-color {
          width: 20px;
          height: 20px;
          border-radius: 3px;
          border: 2px solid;
         }

         .legend-color.available {
          background-color: rgba(108,117,125,0.3);
          border-color: #6c757d;
         }

         .legend-color.pending {
          background-color: rgba(255,193,7,0.3);
          border-color: #ffc107;
         }

         .legend-color.approved {
          background-color: rgba(40,167,69,0.3);
          border-color: #28a745;
         }

         .legend-color.cancelled {
          background-color: rgba(220,53,69,0.3);
          border-color: #dc3545;
         }

         .legend-color.today {
          background-color: rgba(255,193,7,0.3);
          border-color: #ffc107;
         }

         .duration-badge {
          display: inline-block;
          padding: 5px 12px;
          border-radius: 20px;
          font-size: 0.8em;
          font-weight: bold;
          color: white;
          background-color: #6f42c1;
         }

         .occasion-badge {
          display: inline-block;
          padding: 5px 12px;
          border-radius: 20px;
          font-size: 0.8em;
          font-weight: bold;
          color: white;
          background-color: #17a2b8; /* Default casual color */
         }

         .occasion-badge.casual { background-color: #17a2b8; }
         .occasion-badge.business { background-color: #6c757d; }
         .occasion-badge.celebration { background-color: #fd7e14; }
         .occasion-badge.date { background-color: #e83e8c; }
         .occasion-badge.family { background-color: #20c997; }
         .occasion-badge.birthday { background-color: #e83e8c; }
         .occasion-badge.anniversary { background-color: #fd7e14; }
         .occasion-badge.other { background-color: #6f42c1; }

         .no-reservations {
          text-align: center;
          padding: 40px;
          color: #6c757d;
          font-style: italic;
         }

         .search-filter {
          margin-bottom: 20px;
          display: flex;
          gap: 15px;
          align-items: center;
          flex-wrap: wrap;
         }

         .search-input {
          padding: 10px 15px;
          border: 2px solid #dee2e6;
          border-radius: 25px;
          outline: none;
          transition: border-color 0.3s ease;
         }

         .search-input:focus {
          border-color: #007bff;
         }

         .filter-select {
          padding: 10px 15px;
          border: 2px solid #dee2e6;
          border-radius: 25px;
          outline: none;
          background: white;
         }

         @media (max-width: 768px) {
          .stats-cards {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
          }
          
          .section-tabs {
            flex-direction: column;
            align-items: center;
          }
          
          .search-filter {
            flex-direction: column;
            align-items: stretch;
          }
          
          .search-input, .filter-select {
            width: 100%;
          }

          table {
            min-width: 1000px;
          }

          th, td {
            padding: 10px 6px;
            font-size: 12px;
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
           
          <div class="reservations-container">
            <h1 class="page-title" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
              <span>Table Reservations Management</span>
              <a href="{{ route('admin.archived_reservations') }}" style="background: rgba(108, 117, 125, 0.2); padding: 8px 16px; border-radius: 6px; text-decoration: none; color: #6c757d; font-size: 14px; font-weight: normal; border: 1px solid #6c757d;">
                View Archived Reservations
              </a>
            </h1>
            
            <!-- Success/Error Messages -->
            @if(session('message'))
              <div style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; text-align: center;">
                ✅ {{ session('message') }}
              </div>
            @endif
            
            @if(session('error'))
              <div style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; text-align: center;">
                ❌ {{ session('error') }}
              </div>
            @endif
            
            
            <!-- Statistics Cards -->
            <div class="stats-cards">
              <div class="stat-card">
                <div class="stat-number">{{ $book->count() }}</div>
                <div class="stat-label">Total Reservations</div>
              </div>
              <div class="stat-card">
                <div class="stat-number">{{ $book->where('date', '>=', now()->format('Y-m-d'))->count() }}</div>
                <div class="stat-label">Upcoming Reservations</div>
              </div>
              <div class="stat-card">
                <div class="stat-number">{{ $book->where('date', now()->format('Y-m-d'))->count() }}</div>
                <div class="stat-label">Today's Reservations</div>
              </div>
              <div class="stat-card">
                <div class="stat-number">{{ $book->sum('guest') }}</div>
                <div class="stat-label">Total Guests</div>
              </div>
            </div>

            <!-- Section Tabs -->
            <div class="section-tabs">
              <div class="section-tab active" data-section="all">📊 All Reservations</div>
              <div class="section-tab" data-section="pending">⏳ Pending Approval</div>
              <div class="section-tab" data-section="calendar">📅 Calendar View</div>
              <div class="section-tab" data-section="top">Section B</div>
              <div class="section-tab" data-section="hallway">Section A</div>
              <div class="section-tab" data-section="garden">Garden</div>
              <div class="section-tab" data-section="vip">VIP Cabin Room</div>
            </div>

            <!-- Search and Filter -->
            <div class="search-filter">
              <input type="text" class="search-input" placeholder="🔍 Search by phone, table, or date..." id="searchInput">
              <select class="filter-select" id="dateFilter">
                <option value="">📅 All Dates</option>
                <option value="today">Today</option>
                <option value="tomorrow">Tomorrow</option>
                <option value="week">This Week</option>
                <option value="month">This Month</option>
              </select>
              
            </div>

            <!-- All Reservations Section -->
            <div id="all-section" class="reservations-section active">
              <div class="reservations-table">
                <div class="table-header">📊 All Table Reservations</div>
                <div class="table-wrapper">
         <table>
                  <thead>
                    <tr>
                      <th>👤 Name</th>
                      <th>👤 Last Name</th>
                      <th>🪑 Table</th>
                      <th>📱 Phone</th>
                      <th>👥 Guests</th>
                      <th>📅 Date</th>
                      <th>🕐 Time In</th>
                      <th>🕑 Time Out</th>
                      <th>📍 Section</th>
                      <th>🎯 Occasion</th>
                      <th>📊 Status</th>
                      <th>⚡ Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($book as $reservation)
                    <tr>
                      <td>{{ $reservation->name ?? 'N/A' }}</td>
                      <td>{{ (!empty($reservation->last_name) && $reservation->last_name !== 'N/A') ? $reservation->last_name : '' }}</td>
                      <td>
                        <span class="table-badge {{ $reservation->table_number ? (strpos($reservation->table_number, 'B') === 0 ? 'top' : (strpos($reservation->table_number, 'A') === 0 || strpos($reservation->table_number, 'H') === 0 ? 'hallway' : (strpos($reservation->table_number, 'V') === 0 ? 'vip' : (strpos($reservation->table_number, 'G') === 0 ? 'garden' : 'top')))) : 'top' }}">
                          {{ $reservation->table_number ?? 'B1' }}
                        </span>
                      </td>
                      <td>{{ $reservation->phone }}</td>
                      <td>{{ $reservation->guest }}</td>
                      <td>{{ \Carbon\Carbon::parse($reservation->date)->format('M d, Y') }}</td>
                      <td>{{ $reservation->time_in ? \Carbon\Carbon::parse($reservation->time_in)->format('g:i A') : ($reservation->time ? \Carbon\Carbon::parse($reservation->time)->format('g:i A') : 'N/A') }}</td>
                      <td>{{ $reservation->time_out ? \Carbon\Carbon::parse($reservation->time_out)->format('g:i A') : 'N/A' }}</td>
                      <td>
                        @if($reservation->table_section)
                          {{ $reservation->table_section }}
                        @elseif($reservation->table_number)
                          @if(strpos($reservation->table_number, 'B') === 0)
                            Section B
                          @elseif(strpos($reservation->table_number, 'A') === 0 || strpos($reservation->table_number, 'H') === 0)
                            Section A
                          @elseif(strpos($reservation->table_number, 'V') === 0)
                            VIP Cabin Room
                          @elseif(strpos($reservation->table_number, 'G') === 0)
                            Garden
                          @else
                            Section B
                          @endif
                        @else
                          Section B
                        @endif
                      </td>
                      <td>
                        @if($reservation->occasion)
                          <span class="occasion-badge {{ $reservation->occasion }}">
                            @switch($reservation->occasion)
                              @case('casual') 🍽️ Casual @break
                              @case('business') 💼 Business @break
                              @case('celebration') 🎉 Celebration @break
                              @case('date') 💕 Date Night @break
                              @case('family') 👨‍👩‍👧‍👦 Family @break
                              @default 🎯 {{ ucfirst($reservation->occasion) }} @break
                            @endswitch
                          </span>
                        @else
                          <span class="occasion-badge casual">🍽️ Casual</span>
                        @endif
                      </td>
                      <td>
                        @php
                          $status = $reservation->status ?? 'pending';
                        @endphp
                        @if($status == 'approved' || $status == 'confirmed')
                          <span class="status-badge confirmed">Approved</span>
                        @elseif($status == 'cancelled')
                          <span class="status-badge cancelled">❌ Cancelled</span>
                        @else
                          <span class="status-badge pending">⏳ Pending</span>
                        @endif
                      </td>
                      <td>
                        <div class="action-buttons">
                          <button class="btn-approve" onclick="approveReservation({{ $reservation->id }})" title="Approve Reservation">
                            ✅ Approve
                          </button>
                          <button class="btn-cancel" onclick="cancelReservation({{ $reservation->id }})" title="Cancel Reservation">
                            ❌ Cancel
                          </button>
                          <button class="btn-delete" onclick="archiveReservation({{ $reservation->id }})" title="Archive Reservation">
                            📦 Archive
                          </button>
                        </div>
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="12" class="no-reservations">
                        📭 No reservations found
                      </td>
               </tr>
                    @endforelse
                  </tbody>
                </table>
                </div>
              </div>
            </div>

            <!-- Pending Reservations Section -->
            <div id="pending-section" class="reservations-section">
              <div class="reservations-table">
                <div class="table-header">⏳ Reservations Pending Approval</div>
                <div class="table-wrapper">
                <table>
                  <thead>
                    <tr>
                      <th>👤 Name</th>
                      <th>👤 Last Name</th>
                      <th>🪑 Table</th>
                      <th>📱 Phone</th>
                      <th>👥 Guests</th>
                      <th>📅 Date</th>
                      <th>🕐 Time In</th>
                      <th>📍 Section</th>
                      <th>🎯 Occasion</th>
                      <th>📊 Status</th>
                      <th>⚡ Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                      $pendingReservations = $book->filter(function($reservation) {
                        return ($reservation->status === 'pending' || $reservation->status === null || $reservation->status === '');
                      });
                    @endphp
                    @forelse($pendingReservations as $reservation)
                    <tr>
                      <td>{{ $reservation->name ?? 'N/A' }}</td>
                      <td>{{ (!empty($reservation->last_name) && $reservation->last_name !== 'N/A') ? $reservation->last_name : '' }}</td>
                      <td>
                        <span class="table-badge {{ $reservation->table_number ? (strpos($reservation->table_number, 'B') === 0 ? 'top' : (strpos($reservation->table_number, 'A') === 0 || strpos($reservation->table_number, 'H') === 0 ? 'hallway' : (strpos($reservation->table_number, 'V') === 0 ? 'vip' : (strpos($reservation->table_number, 'G') === 0 ? 'garden' : 'top')))) : 'top' }}">
                          {{ $reservation->table_number ?? 'B1' }}
                        </span>
                      </td>
                      <td>{{ $reservation->phone }}</td>
                      <td>{{ $reservation->guest }}</td>
                      <td>{{ \Carbon\Carbon::parse($reservation->date)->format('M d, Y') }}</td>
                      <td>{{ $reservation->time_in ? \Carbon\Carbon::parse($reservation->time_in)->format('g:i A') : ($reservation->time ? \Carbon\Carbon::parse($reservation->time)->format('g:i A') : 'N/A') }}</td>
                      <td>
                        @if($reservation->table_section)
                          {{ $reservation->table_section }}
                        @elseif($reservation->table_number)
                          @if(strpos($reservation->table_number, 'B') === 0)
                            Section B
                          @elseif(strpos($reservation->table_number, 'A') === 0 || strpos($reservation->table_number, 'H') === 0)
                            Section A
                          @elseif(strpos($reservation->table_number, 'V') === 0)
                            VIP Cabin Room
                          @elseif(strpos($reservation->table_number, 'G') === 0)
                            Garden
                          @else
                            Section B
                          @endif
                        @else
                          Section B
                        @endif
                      </td>
                      <td>
                        @if($reservation->occasion)
                          <span class="occasion-badge {{ $reservation->occasion }}">
                            @switch($reservation->occasion)
                              @case('birthday') 🎂 Birthday @break
                              @case('anniversary') 💕 Anniversary @break
                              @case('business') 💼 Business @break
                              @case('date') 💕 Date Night @break
                              @case('family') 👨‍👩‍👧‍👦 Family @break
                              @default 🎯 {{ ucfirst($reservation->occasion) }} @break
                            @endswitch
                          </span>
                        @else
                          <span class="occasion-badge casual">🍽️ Casual</span>
                        @endif
                      </td>
                      <td>
                        <span class="status-badge pending">⏳ Pending</span>
                      </td>
                      <td>
                        <div class="action-buttons">
                          <button class="btn-approve" onclick="approveReservation({{ $reservation->id }})" title="Approve Reservation">
                            ✅ Approve
                          </button>
                          <button class="btn-cancel" onclick="cancelReservation({{ $reservation->id }})" title="Cancel Reservation">
                            ❌ Cancel
                          </button>
                          <button class="btn-delete" onclick="archiveReservation({{ $reservation->id }})" title="Archive Reservation">
                            📦 Archive
                          </button>
                        </div>
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="11" class="no-reservations">
                        📭 No pending reservations found
                      </td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
                </div>
              </div>
            </div>

            <!-- Calendar View Section -->
            <div id="calendar-section" class="reservations-section">
              <div class="calendar-container">
                <div class="calendar-header-wrapper">
                  <div class="calendar-header">
                   <h4 id="current-month-year" style="color: #fff !important; visibility: visible !important; display: block !important;">Loading...</h4>
                    <button id="prev-month" class="btn btn-outline-primary">‹ Previous</button>
                    <button id="next-month" class="btn btn-outline-primary">Next ›</button>
                  </div>
                </div>
                <div class="calendar-grid-wrapper">
                  <div class="calendar-grid" id="calendar-grid">
                    <!-- Calendar will be populated by JavaScript -->
                  </div>
                </div>
                <div class="calendar-legend mt-3" style="width: 100%;">
                  <div class="legend-item">
                    <span class="legend-color available"></span>
                    <span>Available</span>
                  </div>
                  <div class="legend-item">
                    <span class="legend-color pending"></span>
                    <span>Pending</span>
                  </div>
                  <div class="legend-item">
                    <span class="legend-color approved"></span>
                    <span>Approved</span>
                  </div>
                  <div class="legend-item">
                    <span class="legend-color cancelled"></span>
                    <span>Cancelled</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Section B -->
            <div id="top-section" class="reservations-section">
              <div class="reservations-table">
                <div class="table-header">Section B Reservations</div>
                <div class="table-wrapper">
                <table>
                  <thead>
                    <tr>
                      <th>👤 Name</th>
                      <th>👤 Last Name</th>
                      <th>🪑 Table</th>
                      <th>📱 Phone</th>
                      <th>👥 Guests</th>
                      <th>📅 Date</th>
                      <th>🕐 Time In</th>
                      <th>🎯 Occasion</th>
                      <th>📊 Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php 
                      $topReservations = $book->filter(function($reservation) { 
                        // Check if table_section is explicitly set to Section B
                        if($reservation->table_section) {
                          $section = strtolower($reservation->table_section);
                          if(strpos($section, 'section b') !== false) {
                            return true;
                          }
                          // If it's set to something else, exclude it
                          return false;
                        }
                        // Only include tables that start with 'B' (Section B tables only - B1, B2, B3, etc.)
                        if($reservation->table_number && strpos($reservation->table_number, 'B') === 0) {
                          return true;
                        }
                        // Exclude everything else (A, H, V, T, etc.)
                        return false;
                      }); 
                    @endphp
                    @forelse($topReservations as $reservation)
                    <tr>
                      <td>{{ $reservation->name ?? 'N/A' }}</td>
                      <td>{{ (!empty($reservation->last_name) && $reservation->last_name !== 'N/A') ? $reservation->last_name : '' }}</td>
                      <td>
                        <span class="table-badge top">{{ $reservation->table_number ?? 'B1' }}</span>
                      </td>
                      <td>{{ $reservation->phone }}</td>
                      <td>{{ $reservation->guest }}</td>
                      <td>{{ \Carbon\Carbon::parse($reservation->date)->format('M d, Y') }}</td>
                      <td>{{ $reservation->time_in ? \Carbon\Carbon::parse($reservation->time_in)->format('g:i A') : ($reservation->time ? \Carbon\Carbon::parse($reservation->time)->format('g:i A') : 'N/A') }}</td>
                      <td>
                        @if($reservation->occasion)
                          <span class="occasion-badge {{ $reservation->occasion }}">
                            @switch($reservation->occasion)
                              @case('casual') 🍽️ Casual @break
                              @case('business') 💼 Business @break
                              @case('celebration') 🎉 Celebration @break
                              @case('date') 💕 Date Night @break
                              @case('family') 👨‍👩‍👧‍👦 Family @break
                              @default 🎯 {{ ucfirst($reservation->occasion) }} @break
                            @endswitch
                          </span>
                        @else
                          <span class="occasion-badge casual">🍽️ Casual</span>
                        @endif
                      </td>
                      <td>
                        @php
                          $status = $reservation->status ?? 'pending';
                        @endphp
                        @if($status == 'approved' || $status == 'confirmed')
                          <span class="status-badge confirmed">Approved</span>
                        @elseif($status == 'cancelled')
                          <span class="status-badge cancelled">❌ Cancelled</span>
                        @else
                          <span class="status-badge pending">⏳ Pending</span>
                        @endif
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="9" class="no-reservations">
                        📭 No Section B reservations found
                      </td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
                </div>
              </div>
            </div>

            <!-- Section A -->
            <div id="hallway-section" class="reservations-section">
              <div class="reservations-table">
                <div class="table-header">Section A Reservations</div>
                <div class="table-wrapper">
                <table>
                  <thead>
                    <tr>
                      <th>👤 Name</th>
                      <th>👤 Last Name</th>
                      <th>🪑 Table</th>
                      <th>📱 Phone</th>
                      <th>👥 Guests</th>
                      <th>📅 Date</th>
                      <th>🕐 Time In</th>
                      <th>🎯 Occasion</th>
                      <th>📊 Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php 
                      $hallwayReservations = $book->filter(function($reservation) { 
                        // Check if table_section is explicitly set to Section A or Hallway
                        if($reservation->table_section) {
                          $section = strtolower($reservation->table_section);
                          if(strpos($section, 'section a') !== false || strpos($section, 'hallway') !== false) {
                            return true;
                          }
                          // If it's set to something else, exclude it
                          return false;
                        }
                        // Check table_number - must start with 'H' for Section A
                        return $reservation->table_number && strpos($reservation->table_number, 'H') === 0;
                      }); 
                    @endphp
                    @forelse($hallwayReservations as $reservation)
                    <tr>
                      <td>{{ $reservation->name ?? 'N/A' }}</td>
                      <td>{{ (!empty($reservation->last_name) && $reservation->last_name !== 'N/A') ? $reservation->last_name : '' }}</td>
                      <td>
                        <span class="table-badge hallway">{{ $reservation->table_number }}</span>
                      </td>
                      <td>{{ $reservation->phone }}</td>
                      <td>{{ $reservation->guest }}</td>
                      <td>{{ \Carbon\Carbon::parse($reservation->date)->format('M d, Y') }}</td>
                      <td>{{ $reservation->time_in ? \Carbon\Carbon::parse($reservation->time_in)->format('g:i A') : ($reservation->time ? \Carbon\Carbon::parse($reservation->time)->format('g:i A') : 'N/A') }}</td>
                      <td>
                        @if($reservation->occasion)
                          <span class="occasion-badge {{ $reservation->occasion }}">
                            @switch($reservation->occasion)
                              @case('casual') 🍽️ Casual @break
                              @case('business') 💼 Business @break
                              @case('celebration') 🎉 Celebration @break
                              @case('date') 💕 Date Night @break
                              @case('family') 👨‍👩‍👧‍👦 Family @break
                              @default 🎯 {{ ucfirst($reservation->occasion) }} @break
                            @endswitch
                          </span>
                        @else
                          <span class="occasion-badge casual">🍽️ Casual</span>
                        @endif
                      </td>
                      <td>
                        @php
                          $status = $reservation->status ?? 'pending';
                        @endphp
                        @if($status == 'approved' || $status == 'confirmed')
                          <span class="status-badge confirmed">Approved</span>
                        @elseif($status == 'cancelled')
                          <span class="status-badge cancelled">❌ Cancelled</span>
                        @else
                          <span class="status-badge pending">⏳ Pending</span>
                        @endif
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="9" class="no-reservations">
                        📭 No Section A reservations found
                      </td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
                </div>
              </div>
            </div>

            <!-- Garden Section -->
            <div id="garden-section" class="reservations-section">
              <div class="reservations-table">
                <div class="table-header">Garden Reservations</div>
                <div class="table-wrapper">
                <table>
                  <thead>
                    <tr>
                      <th>👤 Name</th>
                      <th>👤 Last Name</th>
                      <th>🪑 Table</th>
                      <th>📱 Phone</th>
                      <th>👥 Guests</th>
                      <th>📅 Date</th>
                      <th>🕐 Time In</th>
                      <th>🎯 Occasion</th>
                      <th>📊 Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                      $gardenReservations = $book->filter(function($reservation) {
                        if($reservation->table_section) {
                          $section = strtolower($reservation->table_section);
                          if(strpos($section, 'garden') !== false) return true;
                          return false;
                        }
                        return $reservation->table_number && strpos($reservation->table_number, 'G') === 0;
                      });
                    @endphp
                    @forelse($gardenReservations as $reservation)
                    <tr>
                      <td>{{ $reservation->name ?? 'N/A' }}</td>
                      <td>{{ (!empty($reservation->last_name) && $reservation->last_name !== 'N/A') ? $reservation->last_name : '' }}</td>
                      <td>
                        <span class="table-badge garden">{{ $reservation->table_number ?? 'G1' }}</span>
                      </td>
                      <td>{{ $reservation->phone }}</td>
                      <td>{{ $reservation->guest }}</td>
                      <td>{{ \Carbon\Carbon::parse($reservation->date)->format('M d, Y') }}</td>
                      <td>{{ $reservation->time_in ? \Carbon\Carbon::parse($reservation->time_in)->format('g:i A') : ($reservation->time ? \Carbon\Carbon::parse($reservation->time)->format('g:i A') : 'N/A') }}</td>
                      <td>
                        @if($reservation->occasion)
                          <span class="occasion-badge {{ $reservation->occasion }}">
                            @switch($reservation->occasion)
                              @case('casual') 🍽️ Casual @break
                              @case('business') 💼 Business @break
                              @case('celebration') 🎉 Celebration @break
                              @case('date') 💕 Date Night @break
                              @case('family') 👨‍👩‍👧‍👦 Family @break
                              @default 🎯 {{ ucfirst($reservation->occasion) }} @break
                            @endswitch
                          </span>
                        @else
                          <span class="occasion-badge casual">🍽️ Casual</span>
                        @endif
                      </td>
                      <td>
                        @php
                          $status = $reservation->status ?? 'pending';
                        @endphp
                        @if($status == 'approved' || $status == 'confirmed')
                          <span class="status-badge confirmed">Approved</span>
                        @elseif($status == 'cancelled')
                          <span class="status-badge cancelled">❌ Cancelled</span>
                        @else
                          <span class="status-badge pending">⏳ Pending</span>
                        @endif
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="9" class="no-reservations">
                        📭 No Garden reservations found
                      </td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
                </div>
              </div>
            </div>

            <!-- VIP Section -->
            <div id="vip-section" class="reservations-section">
              <div class="reservations-table">
                <div class="table-header">VIP Cabin Room Reservations</div>
                <div class="table-wrapper">
                <table>
                  <thead>
                    <tr>
                      <th>👤 Name</th>
                      <th>👤 Last Name</th>
                      <th>🪑 Table</th>
                      <th>📱 Phone</th>
                      <th>👥 Guests</th>
                      <th>📅 Date</th>
                      <th>🕐 Time In</th>
                      <th>🕑 Time Out</th>
                      <th>🎯 Occasion</th>
                      <th>📊 Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php 
                      $vipReservations = $book->filter(function($reservation) { 
                        // Check if table_section is explicitly set to VIP Cabin Room
                        if($reservation->table_section) {
                          $section = strtolower($reservation->table_section);
                          if(strpos($section, 'vip') !== false || strpos($section, 'cabin') !== false) {
                            return true;
                          }
                          // If it's set to something else, exclude it
                          return false;
                        }
                        // Check table_number - must start with 'V' for VIP
                        return $reservation->table_number && strpos($reservation->table_number, 'V') === 0;
                      }); 
                    @endphp
                    @forelse($vipReservations as $reservation)
                    <tr>
                      <td>{{ $reservation->name ?? 'N/A' }}</td>
                      <td>{{ (!empty($reservation->last_name) && $reservation->last_name !== 'N/A') ? $reservation->last_name : '' }}</td>
                      <td>
                        <span class="table-badge vip">{{ $reservation->table_number }}</span>
                      </td>
                      <td>{{ $reservation->phone }}</td>
                      <td>{{ $reservation->guest }}</td>
                      <td>{{ \Carbon\Carbon::parse($reservation->date)->format('M d, Y') }}</td>
                      <td>{{ $reservation->time_in ? \Carbon\Carbon::parse($reservation->time_in)->format('g:i A') : ($reservation->time ? \Carbon\Carbon::parse($reservation->time)->format('g:i A') : 'N/A') }}</td>
                      <td>{{ $reservation->time_out ? \Carbon\Carbon::parse($reservation->time_out)->format('g:i A') : 'N/A' }}</td>
                      <td>
                        @if($reservation->occasion)
                          <span class="occasion-badge {{ $reservation->occasion }}">
                            @switch($reservation->occasion)
                              @case('casual') 🍽️ Casual @break
                              @case('business') 💼 Business @break
                              @case('celebration') 🎉 Celebration @break
                              @case('date') 💕 Date Night @break
                              @case('family') 👨‍👩‍👧‍👦 Family @break
                              @default 🎯 {{ ucfirst($reservation->occasion) }} @break
                            @endswitch
                          </span>
                        @else
                          <span class="occasion-badge casual">🍽️ Casual</span>
                        @endif
                      </td>
                      <td>
                        @php
                          $status = $reservation->status ?? 'pending';
                        @endphp
                        @if($status == 'approved' || $status == 'confirmed')
                          <span class="status-badge confirmed">Approved</span>
                        @elseif($status == 'cancelled')
                          <span class="status-badge cancelled">❌ Cancelled</span>
                        @else
                          <span class="status-badge pending">⏳ Pending</span>
                        @endif
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="10" class="no-reservations">
                        📭 No VIP Cabin Room reservations found
                      </td>
               </tr>
@endforelse
                  </tbody>
                </table>
                </div>
              </div>
            </div>

          </div>
</div>
      </div>
    </div>
    <!-- JavaScript files-->
   @include('admin.js')

   <script>
  document.addEventListener('DOMContentLoaded', function() {
       // Section tab switching
       const sectionTabs = document.querySelectorAll('.section-tab');
       const sections = document.querySelectorAll('.reservations-section');
       
       sectionTabs.forEach(tab => {
           tab.addEventListener('click', function() {
               const targetSection = this.getAttribute('data-section');
               
               // Remove active class from all tabs and sections
               sectionTabs.forEach(t => t.classList.remove('active'));
               sections.forEach(section => section.classList.remove('active'));
               
               // Add active class to clicked tab and corresponding section
               this.classList.add('active');
               document.getElementById(targetSection + '-section').classList.add('active');
           });
       });

       // Search functionality
       const searchInput = document.getElementById('searchInput');
       const dateFilter = document.getElementById('dateFilter');
       const guestFilter = null;
       
      function filterReservations() {
          const searchTerm = searchInput.value.toLowerCase();
          const dateFilterValue = dateFilter.value;
          
          const activeSection = document.querySelector('.reservations-section.active');
          const rows = activeSection ? activeSection.querySelectorAll('tbody tr') : document.querySelectorAll('tbody tr');
          
          rows.forEach(row => {
              // Column indexes for All/Pending tables:
              // 0: Name, 1: Last Name, 2: Table, 3: Phone, 4: Guests, 5: Date, 6: Time In
              const phone = row.cells[3]?.textContent.toLowerCase() || '';
              const tableTxt = row.cells[2]?.textContent.toLowerCase() || '';
              const dateTxt = row.cells[5]?.textContent || '';
              
              let showRow = true;
              
              // Search filter
              if (searchTerm && !phone.includes(searchTerm) && !tableTxt.includes(searchTerm) && !dateTxt.toLowerCase().includes(searchTerm)) {
                  showRow = false;
              }
              
              // Date filter (only when a specific option is chosen)
              if (showRow && dateFilterValue) {
                  const today = new Date();
                  const reservationDate = new Date(dateTxt);
                  
                  switch(dateFilterValue) {
                      case 'today':
                          if (reservationDate.toDateString() !== today.toDateString()) showRow = false;
                          break;
                      case 'tomorrow': {
                          const tomorrow = new Date(today);
                          tomorrow.setDate(tomorrow.getDate() + 1);
                          if (reservationDate.toDateString() !== tomorrow.toDateString()) showRow = false;
                          break;
                      }
                      case 'week': {
                          const weekFromNow = new Date(today);
                          weekFromNow.setDate(weekFromNow.getDate() + 7);
                          if (reservationDate < today || reservationDate > weekFromNow) showRow = false;
                          break;
                      }
                      case 'month': {
                          const monthFromNow = new Date(today);
                          monthFromNow.setMonth(monthFromNow.getMonth() + 1);
                          if (reservationDate < today || reservationDate > monthFromNow) showRow = false;
                          break;
                      }
                  }
              }
              
              row.style.display = showRow ? '' : 'none';
          });
      }
       
       searchInput.addEventListener('input', filterReservations);
       dateFilter.addEventListener('change', filterReservations);
       // Guest size filter removed
   });


   function findAdminReservationById(reservationId) {
       const idStr = (reservationId === null || reservationId === undefined) ? '' : String(reservationId);
       if (!idStr) return null;
       if (!Array.isArray(currentReservationsData)) return null;
       return currentReservationsData.find(r => r && (r.id !== null && r.id !== undefined) && String(r.id) === idStr) || null;
   }

   function getAdminBookingNoun(reservationId) {
       const reservation = findAdminReservationById(reservationId);
       return reservation && isAdminEventBooking(reservation) ? 'event booking' : 'reservation';
   }

   function getAdminBookingNounTitle(reservationId) {
       const noun = getAdminBookingNoun(reservationId);
       return noun === 'event booking' ? 'Event Booking' : 'Reservation';
   }

  // Reservation / event booking approval functions
  function approveReservation(reservationId) {
      const reservation = findAdminReservationById(reservationId);
      const isEvent = reservation && isAdminEventBooking(reservation);
      const noun = isEvent ? 'event booking' : 'reservation';
      const nounTitle = isEvent ? 'Event Booking' : 'Reservation';
      console.log(`Approving ${noun} with ID:`, reservationId);
      if (!confirm(`Are you sure you want to approve this ${noun}?`)) {
        return;
      }

      // Optimistic status update in UI
      updateReservationStatus(reservationId, isEvent ? 'paid' : 'approved');

      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      let url;
      let body;

      if (isEvent) {
        // Map "event-123" → 123 for backend
        const idStr = String(reservation && reservation.id ? reservation.id : reservationId);
        let eventId = null;
        const match = idStr.match(/^event-(\d+)$/);
        if (match) {
          eventId = match[1];
        } else if (reservation && reservation.event_booking_id) {
          eventId = reservation.event_booking_id;
        }

        if (!eventId) {
          console.error('Unable to resolve event booking ID for approval from', idStr, reservation);
          updateReservationStatus(reservationId, 'pending');
          showNotification('Error approving event booking: unable to resolve booking ID.', 'error');
          return;
        }

        url = `/event_booking/status/${eventId}`;
        body = JSON.stringify({
          status: 'Paid',
          _token: csrfToken
        });
      } else {
        url = `/test-approve/${reservationId}`;
        body = JSON.stringify({
          _token: csrfToken
        });
      }

      fetch(url, {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': csrfToken,
              'Accept': 'application/json'
          },
          body
      })
      .then(response => {
          if (!response.ok) {
              throw new Error(`HTTP error! status: ${response.status}`);
          }
          
          const contentType = response.headers.get('content-type');
          if (!contentType || !contentType.includes('application/json')) {
              return response.text().then(text => {
                  throw new Error('Server returned HTML instead of JSON. This usually means the route was not found.');
              });
          }
          
          return response.json();
      })
      .then(data => {
          if (data.success) {
              showNotification(`${nounTitle} approved successfully!`, 'success');
              // Status already updated in updateReservationStatus() and badge already updated
              // Just sync with server to ensure data consistency
              updateReservationsData();
              // Sync with customer calendar
              syncAdminReservationsToCustomer();
          } else {
              // Revert status on error
              updateReservationStatus(reservationId, 'pending');
              showNotification(`Error approving ${noun}: ` + data.message, 'error');
          }
      })
      .catch(error => {
          console.error('Error:', error);
          // Revert status on error
          updateReservationStatus(reservationId, 'pending');
          showNotification(`Error approving ${noun}: ` + error.message, 'error');
      });
  }

  function cancelReservation(reservationId) {
      const reservation = findAdminReservationById(reservationId);
      const isEvent = reservation && isAdminEventBooking(reservation);
      const noun = isEvent ? 'event booking' : 'reservation';
      const nounTitle = isEvent ? 'Event Booking' : 'Reservation';
      console.log(`Cancelling ${noun} with ID:`, reservationId);

      if (!confirm(`Are you sure you want to cancel this ${noun}?`)) {
        return;
      }

      // Optimistic status update in UI
      updateReservationStatus(reservationId, 'cancelled');

      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      let url;
      let body;

      if (isEvent) {
        // Map "event-123" → 123 for backend
        const idStr = String(reservation && reservation.id ? reservation.id : reservationId);
        let eventId = null;
        const match = idStr.match(/^event-(\d+)$/);
        if (match) {
          eventId = match[1];
        } else if (reservation && reservation.event_booking_id) {
          eventId = reservation.event_booking_id;
        }

        if (!eventId) {
          console.error('Unable to resolve event booking ID for cancellation from', idStr, reservation);
          updateReservationStatus(reservationId, 'pending');
          showNotification('Error cancelling event booking: unable to resolve booking ID.', 'error');
          return;
        }

        url = `/event_booking/status/${eventId}`;
        body = JSON.stringify({
          status: 'Cancelled',
          _token: csrfToken
        });
      } else {
        // Normal table reservation cancellation
        url = `/test-cancel/${reservationId}`;
        body = JSON.stringify({
          _token: csrfToken
        });
      }

      fetch(url, {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': csrfToken,
              'Accept': 'application/json'
          },
          body
      })
      .then(response => {
          if (!response.ok) {
              throw new Error(`HTTP error! status: ${response.status}`);
          }
          
          const contentType = response.headers.get('content-type');
          if (!contentType || !contentType.includes('application/json')) {
              return response.text().then(text => {
                  throw new Error('Server returned HTML instead of JSON. This usually means the route was not found.');
              });
          }
          
          return response.json();
      })
      .then(data => {
          if (data.success) {
              showNotification(`${nounTitle} cancelled successfully!`, 'success');
              // Status already updated in updateReservationStatus() and badge already updated
              // Just sync with server to ensure data consistency
              updateReservationsData();
              // Sync with customer calendar
              syncAdminReservationsToCustomer();
          } else {
              // Revert status on error
              updateReservationStatus(reservationId, 'pending');
              showNotification(`Error cancelling ${noun}: ` + data.message, 'error');
          }
      })
      .catch(error => {
          console.error('Error:', error);
          // Revert status on error
          updateReservationStatus(reservationId, 'pending');
          showNotification(`Error cancelling ${noun}: ` + error.message, 'error');
      });
  }

  function archiveReservation(reservationId) {
       console.log('Archiving reservation with ID:', reservationId);
       if (confirm('Are you sure you want to archive this reservation? It will be moved to archived reservations.')) {
           // Send request to server
           const url = `/admin/reservations/${reservationId}/delete`;
           fetch(url, {
               method: 'POST',
               headers: {
                   'Content-Type': 'application/json',
                   'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                   'Accept': 'application/json'
               },
               body: JSON.stringify({
                   _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
               })
           })
           .then(response => {
               if (response.ok) {
                   showNotification('Reservation archived successfully!', 'success');
                   // Remove the reservation from local data immediately
                   currentReservationsData = currentReservationsData.filter(r => r.id !== reservationId);
                   // Remove the row from the table
                   const rows = document.querySelectorAll('tbody tr');
                   rows.forEach(row => {
                       const buttons = row.querySelectorAll('button[onclick*="' + reservationId + '"]');
                       if (buttons.length > 0) {
                           row.remove();
                       }
                   });
                   // Update badge immediately since we removed it from local data
                   updateReservationBadge();
                   // Update reservations data from server
                   updateReservationsData();
                   // Sync with customer calendar
                   syncAdminReservationsToCustomer();
               } else {
                   showNotification('Error archiving reservation', 'error');
               }
           })
           .catch(error => {
               console.error('Error:', error);
               showNotification('Error archiving reservation: ' + error.message, 'error');
           });
       }
   }

   /**
    * Permanently delete a reservation (calendar view).
    */
   function forceDeleteReservation(reservationId) {
       console.log('Permanently deleting reservation with ID:', reservationId);
       if (!confirm('Are you sure you want to permanently delete this reservation? This action cannot be undone.')) {
           return;
       }

       const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
       const url = `/admin/reservations/${reservationId}/force-delete`;

       fetch(url, {
           method: 'POST',
           headers: {
               'Content-Type': 'application/json',
               'X-CSRF-TOKEN': csrfToken,
               'Accept': 'application/json'
           },
           body: JSON.stringify({
               _token: csrfToken
           })
       })
       .then(response => {
           if (!response.ok) {
               throw new Error(`HTTP error! status: ${response.status}`);
           }
           const contentType = response.headers.get('content-type') || '';
           if (contentType.includes('application/json')) {
               return response.json();
           }
           return { success: true };
       })
       .then(data => {
           if (data.success) {
               showNotification('Reservation deleted successfully!', 'success');

               // Remove from local data
               if (Array.isArray(currentReservationsData)) {
                   currentReservationsData = currentReservationsData.filter(r => String(r.id) !== String(reservationId));
               }

               // Remove from currently open day-details modal (calendar view)
               const modal = document.querySelector('.admin-calendar-modal');
               if (modal) {
                   const item = modal.querySelector(`.reservation-item[data-reservation-id="${String(reservationId)}"]`);
                   if (item) {
                       item.remove();
                       const remaining = modal.querySelectorAll('.reservation-item').length;
                       if (remaining === 0) {
                           const list = modal.querySelector('.reservations-list');
                           if (list) {
                               list.innerHTML = '<p>No reservations for this date.</p>';
                           }
                       }
                   }
               }

               // Remove any matching rows in the tables (list view)
               const rows = document.querySelectorAll('tbody tr');
               rows.forEach(row => {
                   const buttons = row.querySelectorAll('button[onclick*="' + reservationId + '"]');
                   if (buttons.length > 0) {
                       row.remove();
                   }
               });

               // Update badges and data (also re-renders calendar if visible)
               if (typeof updateReservationBadge === 'function') {
                   updateReservationBadge();
               }
               if (typeof updateReservationsData === 'function') {
                   updateReservationsData(true);
               }
               if (typeof syncAdminReservationsToCustomer === 'function') {
                   syncAdminReservationsToCustomer();
               }
           } else {
               showNotification('Error deleting reservation: ' + (data.message || 'Unknown error'), 'error');
           }
       })
       .catch(error => {
           console.error('Error:', error);
           showNotification('Error deleting reservation: ' + error.message, 'error');
       });
   }

   function deleteEventBooking(eventReservationId) {
       const reservation = findAdminReservationById(eventReservationId);
       const nounTitle = 'Event Booking';
       console.log('Deleting event booking with ID:', eventReservationId, reservation);

       if (!confirm('Are you sure you want to delete this event booking? This action cannot be undone.')) {
           return;
       }

       const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

       // Map "event-123" → 123 for backend
       const idStr = String(eventReservationId || (reservation && reservation.id) || '');
       let eventId = null;
       const match = idStr.match(/^event-(\d+)$/);
       if (match) {
           eventId = match[1];
       } else if (reservation && reservation.event_booking_id) {
           eventId = reservation.event_booking_id;
       }

       if (!eventId) {
           console.error('Unable to resolve event booking ID for deletion from', idStr, reservation);
           showNotification('Error deleting event booking: unable to resolve booking ID.', 'error');
           return;
       }

       // Use same route as admin event bookings list (GET /event_booking/delete/{id})
       const url = `/event_booking/delete/${eventId}`;

       fetch(url, {
           method: 'GET',
           headers: {
               'X-Requested-With': 'XMLHttpRequest',
               'X-CSRF-TOKEN': csrfToken,
               'Accept': 'application/json,text/html'
           }
       })
       .then(response => {
           if (!response.ok) {
               throw new Error(`HTTP error! status: ${response.status}`);
           }
           const contentType = response.headers.get('content-type') || '';
           if (contentType.includes('application/json')) {
               return response.json();
           }
           // When controller redirects back with session flash, treat as success
           return { success: true };
       })
      .then(data => {
          if (data.success) {
              showNotification(`${nounTitle} deleted successfully!`, 'success');

              // Optimistically remove from local data
              if (Array.isArray(currentReservationsData)) {
                  const idStrNorm = String(eventReservationId);
                  currentReservationsData = currentReservationsData.filter(r => {
                      if (!r || r.id === null || r.id === undefined) return true;
                      return String(r.id) !== idStrNorm;
                  });
              }

              // Remove from currently open day-details modal
              const modal = document.querySelector('.admin-calendar-modal');
              if (modal) {
                  const item = modal.querySelector(`.reservation-item[data-reservation-id="${String(eventReservationId)}"]`);
                  if (item) {
                      item.remove();
                      const remaining = modal.querySelectorAll('.reservation-item').length;
                      if (remaining === 0) {
                          const list = modal.querySelector('.reservations-list');
                          if (list) {
                              list.innerHTML = '<p>No reservations for this date.</p>';
                          }
                      }
                  }
              }

              // Refresh reservations and calendar to stay in sync with server
              updateReservationsData(true);
              syncAdminReservationsToCustomer();
          } else {
              showNotification(`Error deleting ${nounTitle.toLowerCase()}: ` + data.message, 'error');
          }
      })
       .catch(error => {
           console.error('Error deleting event booking:', error);
           showNotification(`Error deleting ${nounTitle.toLowerCase()}: ` + error.message, 'error');
       });
   }



   function updateReservationStatus(reservationId, status) {
       // Update the reservation status in local data
      const idStr = (reservationId === null || reservationId === undefined) ? '' : String(reservationId);
      const reservation = Array.isArray(currentReservationsData)
        ? currentReservationsData.find(r => r && (r.id !== null && r.id !== undefined) && String(r.id) === idStr)
        : null;
       if (reservation) {
           const oldStatus = reservation.status;
           reservation.status = status;
           console.log(`Reservation ${reservationId} status changed from "${oldStatus}" to "${status}"`);
       } else {
           console.warn(`Reservation ${reservationId} not found in currentReservationsData`);
       }
       
       // Update badge immediately when status changes (optimistic update)
       updateReservationBadge();
       
       // Find all rows and update matching reservation across all sections
       const rows = document.querySelectorAll('tbody tr');
       let updatedCount = 0;
       
       for (let i = 0; i < rows.length; i++) {
           const row = rows[i];
           // Check if this row contains buttons with this reservation ID
           const buttons = row.querySelectorAll('button[onclick*="' + reservationId + '"]');
           if (buttons.length > 0) {
               const statusCell = row.querySelector('.status-badge');
               if (statusCell) {
                   // Update status badge immediately
                   switch(status) {
                       case 'approved':
                       case 'confirmed':
                           statusCell.className = 'status-badge confirmed';
                           statusCell.textContent = '✅ Approved';
                           break;
                       case 'cancelled':
                           statusCell.className = 'status-badge cancelled';
                           statusCell.textContent = '❌ Cancelled';
                           break;
                       case 'pending':
                           statusCell.className = 'status-badge pending';
                           statusCell.textContent = '⏳ Pending';
                           break;
                       default:
                           statusCell.className = 'status-badge ' + status;
                           statusCell.textContent = status.charAt(0).toUpperCase() + status.slice(1);
                   }
                   updatedCount++;
               }
           }
       }
       
       console.log(`Updated ${updatedCount} reservation(s) with ID ${reservationId} to status: ${status}`);
       
       // If reservation was approved or cancelled, it should disappear from pending section
       if (status === 'approved' || status === 'confirmed' || status === 'cancelled') {
           // Hide the row from pending section if it exists there
           const pendingSection = document.getElementById('pending-section');
           if (pendingSection && pendingSection.classList.contains('active')) {
               rows.forEach(row => {
                   const buttons = row.querySelectorAll('button[onclick*="' + reservationId + '"]');
                   if (buttons.length > 0 && row.closest('#pending-section')) {
                       row.style.display = 'none';
                   }
               });
           }
       }
   }


   function showNotification(message, type) {
       const notification = document.createElement('div');
       notification.className = `notification notification-${type}`;
       notification.style.cssText = `
           position: fixed;
           top: 20px;
           right: 20px;
           padding: 15px 20px;
           border-radius: 8px;
           color: white;
           font-weight: bold;
           z-index: 10000;
           animation: slideInRight 0.3s ease-out;
           max-width: 300px;
       `;
       
       if (type === 'success') {
           notification.style.backgroundColor = '#28a745';
       } else if (type === 'error') {
           notification.style.backgroundColor = '#dc3545';
       }
       
       notification.textContent = message;
       document.body.appendChild(notification);
       
       setTimeout(() => {
           if (notification.parentElement) {
               notification.remove();
           }
       }, 3000);
   }

   // Admin Calendar functionality
   let adminCurrentDate = new Date();
   let adminReservations = [];

  function initializeAdminCalendar() {
    // Ensure we have the latest reservations (including event bookings)
    // so the admin calendar reflects both reserved and booked entries.
    updateReservationsData();
    renderAdminCalendar();
    setupAdminCalendarNavigation();
  }

   function renderAdminCalendar() {
     const calendarGrid = document.getElementById('calendar-grid');
     const currentMonthYear = document.getElementById('current-month-year');
     
     // Check if elements exist
     if (!calendarGrid || !currentMonthYear) {
       console.error('Calendar elements not found');
       return;
     }
     
     // Update month/year display
     const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
                        'July', 'August', 'September', 'October', 'November', 'December'];
     if (currentMonthYear) {
       currentMonthYear.textContent = `${monthNames[adminCurrentDate.getMonth()]} ${adminCurrentDate.getFullYear()}`;
     }
     
     // Clear previous calendar
     calendarGrid.innerHTML = '';
     
     // Add day headers
     const dayHeaders = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
     dayHeaders.forEach(day => {
       const header = document.createElement('div');
       header.className = 'calendar-day-header';
       header.textContent = day;
       calendarGrid.appendChild(header);
     });
     
     // Get first day of month and number of days
     const firstDay = new Date(adminCurrentDate.getFullYear(), adminCurrentDate.getMonth(), 1);
     const lastDay = new Date(adminCurrentDate.getFullYear(), adminCurrentDate.getMonth() + 1, 0);
     const daysInMonth = lastDay.getDate();
     const startingDayOfWeek = firstDay.getDay();
     
     // Add empty cells for days before the first day of the month
     for (let i = 0; i < startingDayOfWeek; i++) {
       const emptyDay = document.createElement('div');
       emptyDay.className = 'calendar-day other-month';
       emptyDay.innerHTML = `
         <div class="calendar-day-number">${new Date(adminCurrentDate.getFullYear(), adminCurrentDate.getMonth(), -startingDayOfWeek + i + 1).getDate()}</div>
       `;
       calendarGrid.appendChild(emptyDay);
     }
     
     // Add days of the month
     for (let day = 1; day <= daysInMonth; day++) {
       const dayElement = document.createElement('div');
       const dateStr = formatAdminDate(new Date(adminCurrentDate.getFullYear(), adminCurrentDate.getMonth(), day));
       const dayReservations = getReservationsForDate(dateStr);
       
       // Determine day status
       const today = new Date();
       const isToday = adminCurrentDate.getFullYear() === today.getFullYear() && 
                     adminCurrentDate.getMonth() === today.getMonth() && 
                     day === today.getDate();
       
       let dayClass = 'calendar-day';
       if (isToday) dayClass += ' today';
       
      // Determine status based on reservations
      if (dayReservations.length > 0) {
        const hasPending = dayReservations.some(r => {
          const status = String(r.status || 'pending').toLowerCase();
          return status === 'pending';
        });
        const hasApprovedOrBooked = dayReservations.some(r => {
          const status = String(r.status || 'pending').toLowerCase();
          return status === 'approved' || status === 'confirmed' || status === 'paid';
        });
        const hasCancelled = dayReservations.some(r => {
          const status = String(r.status || '').toLowerCase();
          return status === 'cancelled';
        });
        
        if (hasApprovedOrBooked) dayClass += ' approved';
        else if (hasPending) dayClass += ' pending';
        else if (hasCancelled) dayClass += ' cancelled';
      } else {
        dayClass += ' available';
      }
       
      dayElement.className = dayClass;
      const hasEventBooking = dayReservations.some(r => {
        const id = r && r.id;
        const idStr = (id === null || id === undefined) ? '' : String(id);
        const occ = r && r.occasion;
        const occStr = (occ === null || occ === undefined) ? '' : String(occ).toLowerCase();
        return idStr.startsWith('event-') || occStr === 'event booking';
      });
      dayElement.innerHTML = `
        <div class="calendar-day-number">${day}</div>
        <div class="calendar-day-info">${hasEventBooking ? 'Event Booking' : `${dayReservations.length} reservations`}</div>
      `;
       
       // Add click event for day details
       dayElement.addEventListener('click', () => showAdminDayDetails(dateStr, dayReservations));
       
       calendarGrid.appendChild(dayElement);
     }
   }

   function setupAdminCalendarNavigation() {
    const prevButton = document.getElementById('prev-month');
    const nextButton = document.getElementById('next-month');
    
    if (!prevButton || !nextButton) {
      console.error('Calendar navigation buttons not found');
      return;
    }
    
    // Remove existing event listeners by cloning and replacing
    const newPrevButton = prevButton.cloneNode(true);
    const newNextButton = nextButton.cloneNode(true);
    prevButton.parentNode.replaceChild(newPrevButton, prevButton);
    nextButton.parentNode.replaceChild(newNextButton, nextButton);
    
    newPrevButton.addEventListener('click', () => {
      // Reset to the 1st to avoid skipping months (e.g., from Jan 31 to Mar 3)
      adminCurrentDate = new Date(
        adminCurrentDate.getFullYear(),
        adminCurrentDate.getMonth() - 1,
        1
      );
      renderAdminCalendar();
    });
    
    newNextButton.addEventListener('click', () => {
      // Reset to the 1st to avoid skipping months when advancing
      adminCurrentDate = new Date(
        adminCurrentDate.getFullYear(),
        adminCurrentDate.getMonth() + 1,
        1
      );
      renderAdminCalendar();
    });
   }

  function formatAdminDate(date) {
    // Use local date formatting to avoid timezone issues
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
  }

   function getReservationsForDate(dateStr) {
     // Get reservations from the current updated data
     return currentReservationsData.filter(reservation => {
       const date = new Date(reservation.date);
       const year = date.getFullYear();
       const month = String(date.getMonth() + 1).padStart(2, '0');
       const day = String(date.getDate()).padStart(2, '0');
       const reservationDate = `${year}-${month}-${day}`;
       return reservationDate === dateStr;
     });
   }
   
   // Global variable to store current reservations data
   let currentReservationsData = @json($book);
   
   // Function to update the reservation badge in sidebar (available globally)
   function updateReservationBadge() {
     // Count pending reservations from current data
     // A reservation is pending if:
     // 1. It's not archived
     // 2. Status is 'pending', empty string, null, or undefined
     const pendingCount = currentReservationsData.filter(reservation => {
       if (reservation.is_archived) {
         return false;
       }
       const status = reservation.status;
       return status === 'pending' || status === '' || status === null || status === undefined;
     }).length;
     
     const badge = document.getElementById('reservation-badge');
     if (badge) {
       if (pendingCount > 0) {
         badge.textContent = pendingCount;
         badge.style.display = 'inline-block';
       } else {
         badge.style.display = 'none';
       }
     }
     
     console.log('Badge updated. Pending count:', pendingCount, 'Total reservations:', currentReservationsData.length);
   }
   
   // Make function available globally
   window.updateReservationBadge = updateReservationBadge;
   
   // Function to update reservations data from server
   function updateReservationsData(updateBadge = false) {
     console.log('Fetching updated reservations data from server...');
    fetch('/api/reservations/calendar?scope=all')
      .then(response => response.json())
       .then(data => {
         if (data.success) {
           console.log('Received updated reservations data:', data.reservations);
           // Convert the calendar data back to reservation format
           const updatedReservations = [];
           Object.keys(data.reservations).forEach(date => {
             data.reservations[date].forEach(reservation => {
               updatedReservations.push({
                // Preserve all properties from the API so
                // event bookings keep their extra fields (venue, package, etc.)
                ...reservation,
                id: reservation.id,
                date: date,
                table_number: reservation.table,
                time_in: reservation.time,
                time_out: reservation.time_out,
                guest: reservation.guests,
                phone: reservation.phone,
                name: reservation.name,
                last_name: reservation.last_name,
                status: reservation.status || null, // Ensure status is properly set
                occasion: reservation.occasion,
                duration_hours: reservation.duration_hours,
                special_requests: reservation.special_requests,
                created_at: reservation.created_at,
                updated_at: reservation.updated_at,
                is_archived: reservation.is_archived || false
               });
             });
           });
           // Use server data as authoritative source
           currentReservationsData = updatedReservations;
           console.log('Updated currentReservationsData. Total:', currentReservationsData.length);
           
           // Only update badge if explicitly requested (for independent calls like visibility change)
           // Badge is already updated optimistically in updateReservationStatus()
           if (updateBadge) {
             updateReservationBadge();
           }
           
           // Re-render calendar if it's currently displayed
           if (document.getElementById('calendar-section').classList.contains('active')) {
             console.log('Re-rendering admin calendar...');
             renderAdminCalendar();
           }
           
           // The table rows will be updated by the existing updateReservationStatus function
         }
       })
       .catch(error => {
         console.log('Error updating reservations data:', error);
         // Even on error, update badge with current local data if requested
         if (updateBadge) {
           updateReservationBadge();
         }
       });
   }

  // Auto-refresh admin calendar and sidebar badge so status changes
  // from other admin pages (e.g. event bookings) are reflected
  // within a few seconds without manual reload.
  let adminCalendarAutoRefreshInterval = null;

  function startAdminCalendarAutoRefresh() {
    if (adminCalendarAutoRefreshInterval !== null) return;

    adminCalendarAutoRefreshInterval = setInterval(() => {
      // Skip work when tab is not visible
      if (document.hidden) return;

      const calendarSection = document.getElementById('calendar-section');
      if (calendarSection && calendarSection.classList.contains('active')) {
        // Also refresh badge count while pulling latest data
        updateReservationsData(true);
      }
    }, 10000); // every 10 seconds
  }

  function stopAdminCalendarAutoRefresh() {
    if (adminCalendarAutoRefreshInterval !== null) {
      clearInterval(adminCalendarAutoRefreshInterval);
      adminCalendarAutoRefreshInterval = null;
    }
  }

  // Sync admin reservations with customer calendar
  function syncAdminReservationsToCustomer() {
    const adminReservations = {};
   
    function sanitizeLastName(value) {
      if (value === null || value === undefined) return '';
      const v = String(value).trim();
      if (!v || v.toUpperCase() === 'N/A') return '';
      return v;
    }
    
    // Group reservations by date using current data, include approved, pending, paid, and cancelled
    currentReservationsData.forEach(reservation => {
      // Sync approved, confirmed, pending, paid (booked), and cancelled reservations to customer calendar
      const rawStatus = reservation.status || 'pending';
      const status = String(rawStatus).toLowerCase();
      if (
        status !== 'approved' &&
        status !== 'confirmed' &&
        status !== 'pending' &&
        status !== 'paid' &&
        status !== 'cancelled'
      ) {
        return;
      }
      
      const date = new Date(reservation.date);
      const year = date.getFullYear();
      const month = String(date.getMonth() + 1).padStart(2, '0');
      const day = String(date.getDate()).padStart(2, '0');
      const dateStr = `${year}-${month}-${day}`;
      if (!adminReservations[dateStr]) {
        adminReservations[dateStr] = [];
      }
      
      // Format reservation for customer calendar
      adminReservations[dateStr].push({
        id: reservation.id,
        table: reservation.table_number || 'N/A',
        time: reservation.time_in || 'N/A',
        guests: reservation.guest || 'N/A',
        phone: reservation.phone || 'N/A',
        name: reservation.name || 'N/A',
        last_name: sanitizeLastName(reservation.last_name),
        status: reservation.status || 'pending',
        occasion: reservation.occasion || 'N/A',
        time_out: reservation.time_out || 'N/A',
        duration_hours: reservation.duration_hours || 'N/A',
        special_requests: reservation.special_requests || '',
        created_at: reservation.created_at || 'N/A',
        updated_at: reservation.updated_at || 'N/A'
      });
    });
    
    // Save to localStorage for customer calendar sync
    localStorage.setItem('adminReservations', JSON.stringify(adminReservations));
    
    // Trigger a custom event to notify other tabs/windows
    window.dispatchEvent(new CustomEvent('reservationUpdated', {
      detail: { reservations: adminReservations }
    }));
  }


   // Initialize sync on page load
   document.addEventListener('DOMContentLoaded', function() {
     syncAdminReservationsToCustomer();
     // Initialize badge count on page load
     updateReservationBadge();
     
     // Update badge when page becomes visible (in case reservation was created in another tab)
     document.addEventListener('visibilitychange', function() {
       if (!document.hidden) {
         // Page became visible, refresh data and update badge
         updateReservationsData(true);
       }
     });
     
     // Also listen for custom events that might be triggered from other pages
     window.addEventListener('reservationUpdated', function() {
       updateReservationBadge();
     });

     // If calendar section is the default visible section on load,
     // start auto-refresh immediately.
     const calendarSection = document.getElementById('calendar-section');
     if (calendarSection && calendarSection.classList.contains('active')) {
       startAdminCalendarAutoRefresh();
     }
   });


  function showAdminDayDetails(date, reservations) {
     const modal = document.createElement('div');
     modal.className = 'admin-calendar-modal';
     modal.style.cssText = `
       position: fixed;
       top: 0;
       left: 0;
       width: 100%;
       height: 100%;
       background-color: rgba(0,0,0,0.8);
       display: flex;
       justify-content: center;
       align-items: center;
       z-index: 10000;
     `;
     
     const modalContent = document.createElement('div');
     modalContent.style.cssText = `
       background-color: white;
       padding: 30px;
       border-radius: 15px;
       max-width: 800px;
       width: 90%;
       max-height: 80vh;
       overflow-y: auto;
       color: #333;
     `;
     
    const sanitizeLastName = (value) => {
      if (value === null || value === undefined) return '';
      const v = String(value).trim();
      if (!v || v.toUpperCase() === 'N/A') return '';
      return v;
    };
    
     modalContent.innerHTML = `
       <h3>📅 ${new Date(date).toLocaleDateString('en-US', { 
         weekday: 'long', 
         year: 'numeric', 
         month: 'long', 
         day: 'numeric' 
       })}</h3>
      <div class="reservations-list">
        ${reservations.length === 0 ? 
          '<p>No reservations for this date.</p>' : 
          reservations.map(reservation => {
            const rawId = reservation && reservation.id;
            const idStr = rawId === null || rawId === undefined ? '' : String(rawId).replace(/'/g, "\\'");
            return `
            <div class="reservation-item" data-reservation-id="${idStr}" style="
              background-color: #f8f9fa;
              padding: 15px;
              margin: 10px 0;
              border-radius: 10px;
              border-left: 4px solid ${getStatusColor(reservation.status)};
            ">
              <div class="reservation-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <div>
                  <div>
                    <strong>${isAdminEventBooking(reservation) ? 'Venue Type' : 'Table'}:</strong>
                    ${isAdminEventBooking(reservation) ? getAdminVenueType(reservation) : (reservation.table_number || 'N/A')}
                  </div>
                </div>
                <div><strong>Status:</strong> <span class="status-badge ${getStatusClass(reservation.status)}">${getStatusText(reservation.status)}</span></div>
              </div>
              <div><strong>Name:</strong> ${reservation.name || 'N/A'}</div>
             <div><strong>Last Name:</strong> ${sanitizeLastName(reservation.last_name)}</div>
             <div><strong>Time:</strong> ${
               isAdminEventBooking(reservation)
                 ? getAdminEventTimeRange(reservation)
                 : formatAdminTimeRange(reservation.time_in || reservation.time, reservation.time_out)
             }</div>
              ${
                isAdminEventBooking(reservation)
                  ? `<div><strong>Package Inclusion (pax):</strong> ${getAdminPackageText(reservation)}</div>`
                  : `<div><strong>Guests:</strong> ${reservation.guest || 'N/A'}</div>`
              }
              <div><strong>Phone:</strong> ${reservation.phone || 'N/A'}</div>
              <div><strong>Occasion:</strong> ${getAdminOccasionText(reservation)}</div>
              ${reservation.special_requests ? `<div><strong>Special Requests:</strong> ${reservation.special_requests}</div>` : ''}
              <div class="reservation-actions" style="margin-top: 10px; display: flex; gap: 10px;">
                ${getActionButtons(reservation)}
              </div>
            </div>
          `;
          }).join('')
        }
      </div>
       <button onclick="this.closest('.admin-calendar-modal').remove()" 
               style="
                 background-color: #dc3545;
                 color: white;
                 border: none;
                 padding: 10px 20px;
                 border-radius: 5px;
                 cursor: pointer;
                 margin-top: 20px;
               ">Close</button>
     `;
     
     modal.appendChild(modalContent);
     document.body.appendChild(modal);
     
     // Close modal when clicking outside
     modal.addEventListener('click', (e) => {
       if (e.target === modal) {
         modal.remove();
       }
     });
   }

  function isAdminEventBooking(reservation) {
    const id = reservation && reservation.id;
    const idStr = (id === null || id === undefined) ? '' : String(id);
    if (idStr.startsWith('event-')) return true;

    const occ = reservation && reservation.occasion;
    const occStr = (occ === null || occ === undefined) ? '' : String(occ).toLowerCase();
    return occStr === 'event booking';
  }

  function getAdminVenueType(reservation) {
    const venue =
      reservation.venue_type_name ||
      reservation.venueTypeName ||
      reservation.venueType ||
      reservation.venue_name ||
      reservation.venue ||
      reservation.location;

    return venue && String(venue).trim() !== '' ? venue : 'Grandiya Venue- Grand Hall';
  }

  function getAdminEventTimeRange(reservation) {
    // Prefer explicit event time slot fields if present
    const slot =
      reservation.time_slot ||
      reservation.timeslot ||
      reservation.event_time ||
      reservation.event_start ||
      reservation.start_time;

    // If we got a direct slot string, format if possible but otherwise return as-is
    if (slot && String(slot).trim() !== '') {
      return formatAdminTime(slot);
    }

    // Fall back to start/end values used by regular reservations
    const range = formatAdminTimeRange(reservation.time_in || reservation.time, reservation.time_out);

    // If both are missing (range === 'N/A'), treat as whole-day booking instead of N/A
    if (range === 'N/A' || range === '') {
      return 'Whole day';
    }

    return range;
  }

  function getAdminPackageText(reservation) {
    // Try to reconstruct the exact label the customer saw,
    // e.g. "No decor, 50–80 pax".
    const name =
      reservation.package_label ||
      reservation.packageLabel ||
      reservation.package_name ||
      reservation.packageInclusionName ||
      reservation.package_inclusion_name ||
      reservation.package_description ||
      reservation.package_desc ||
      reservation.package ||
      reservation.packageInclusion;

    // Prefer explicit min/max pax range if available
    const paxMin =
      reservation.package_pax_min ??
      reservation.pax_min ??
      reservation.package_min_pax ??
      reservation.min_pax;

    const paxMax =
      reservation.package_pax_max ??
      reservation.pax_max ??
      reservation.package_max_pax ??
      reservation.max_pax;

    // Fallback single pax count (what the customer chose)
    const singlePax =
      reservation.package_pax ??
      reservation.package_capacity ??
      reservation.included_pax ??
      reservation.pax ??
      reservation.pax_included ??
      reservation.number_of_guests ??
      reservation.guest;

    // Build a human‑readable pax label
    let paxLabel = '';
    if (paxMin != null && paxMax != null) {
      paxLabel = `${paxMin}–${paxMax} pax`;
    } else if (paxMin != null) {
      paxLabel = `${paxMin} pax`;
    } else if (paxMax != null) {
      paxLabel = `${paxMax} pax`;
    } else if (singlePax != null && singlePax !== '') {
      paxLabel = `${singlePax} pax`;
    }

    // If we have a clear package label from the backend, show it plus pax range
    if (name && String(name).trim() !== '') {
      const safeName = String(name).trim();
      if (paxLabel) {
        return `${safeName}, ${paxLabel}`;
      }
      return safeName;
    }

    // Otherwise just show the pax the customer chose
    return paxLabel || 'N/A';
  }

  function getAdminOccasionText(reservation) {
    let raw =
      reservation.event_type_name ||
      reservation.event_type ||
      reservation.event_title ||
      reservation.title ||
      reservation.occasion;

    if (!raw || String(raw).trim() === '') {
      return isAdminEventBooking(reservation) ? 'N/A' : 'N/A';
    }

    let text = String(raw).trim();

    // Avoid showing the generic "Event Booking" label if we can infer better text
    if (isAdminEventBooking(reservation) && text.toLowerCase() === 'event booking') {
      const alt =
        reservation.event_type_name ||
        reservation.event_type ||
        reservation.event_title ||
        reservation.title;
      if (alt && String(alt).trim().toLowerCase() !== 'event booking') {
        text = String(alt).trim();
      }
    }
    // Ensure values like "birthday" become "Birthday Party" for event bookings
    if (isAdminEventBooking(reservation)) {
      const lower = text.toLowerCase();
      if (lower.includes('birthday') && !lower.includes('party')) {
        return 'Birthday Party';
      }
    }

    return text;
  }

  function getStatusClass(status) {
    const normalized = String(status || 'pending').toLowerCase();
    switch (normalized) {
      case 'approved':
      case 'confirmed':
      case 'paid':
        return 'approved';
      case 'cancelled':
        return 'cancelled';
      case 'pending':
      default:
        return 'pending';
    }
  }

  function getStatusColor(status) {
    const normalized = String(status || 'pending').toLowerCase();
    switch (normalized) {
      case 'approved':
      case 'confirmed':
      case 'paid':
        return '#28a745';
      case 'cancelled':
        return '#dc3545';
      case 'pending':
      default:
        return '#ffc107';
    }
  }

  function getStatusText(status) {
    const normalized = String(status || 'pending').toLowerCase();
    switch (normalized) {
      case 'approved':
      case 'confirmed':
        return 'Approved';
      case 'paid':
        return '✅ Booked';
      case 'cancelled':
        return '❌ Cancelled';
      case 'pending':
      default:
        return '⏳ Pending';
    }
  }

  // Robust time formatter for admin calendar (mirrors public calendar behavior)
  function formatAdminTime(timeValue) {
    if (!timeValue || timeValue === 'N/A') return '';
    
    let hour;
    let minute;
    
    // If it's already in HH:MM format (24-hour or 12-hour with AM/PM)
    if (typeof timeValue === 'string' && /^\d{1,2}:\d{2}\s*(AM|PM)?$/i.test(timeValue)) {
      // If it already has AM/PM, return as-is
      if (/AM|PM/i.test(timeValue)) {
        return timeValue;
      }
      const match = timeValue.match(/(\d{1,2}):(\d{2})/);
      if (match) {
        hour = parseInt(match[1], 10);
        minute = match[2];
      }
    } else if (typeof timeValue === 'string') {
      // Handle ISO format: 2025-10-28T10:22:00.000000Z
      if (timeValue.includes('T')) {
        const timeMatch = timeValue.match(/T(\d{2}):(\d{2})/);
        if (timeMatch) {
          hour = parseInt(timeMatch[1], 10);
          minute = timeMatch[2];
        }
      }
      // Handle other datetime formats: 2025-10-28 10:22:00
      else if (timeValue.includes(' ')) {
        const parts = timeValue.split(' ');
        if (parts.length > 1) {
          const timePart = parts[1].substring(0, 5); // HH:MM
          if (/^\d{2}:\d{2}$/.test(timePart)) {
            hour = parseInt(timePart.substring(0, 2), 10);
            minute = timePart.substring(3, 5);
          }
        }
      }
    }
    
    // If we managed to extract hour & minute, convert to 12-hour format with AM/PM
    if (hour !== undefined && minute !== undefined) {
      const period = hour >= 12 ? 'PM' : 'AM';
      const hour12 = hour > 12 ? hour - 12 : (hour === 0 ? 12 : hour);
      return `${hour12}:${minute} ${period}`;
    }
    
    // Fallback: return original value
    return typeof timeValue === 'string' ? timeValue : '';
  }

  function formatAdminTimeRange(startValue, endValue) {
   const start = formatAdminTime(startValue);
   const end = formatAdminTime(endValue);

   const hasStart = !!start;
   const hasEnd = !!end;

   if (hasStart) {
     if (hasEnd) {
       return `${start} - ${end}`;
     }
     return start;
   }

   return 'N/A';
 }

  function getActionButtons(reservation) {
    const rawStatus = reservation && reservation.status;
    const status = String(rawStatus || 'pending').toLowerCase();
    const isEvent = isAdminEventBooking(reservation);

    const itemLabel = isEvent ? 'Event Booking' : 'Reservation';
    const rawId = reservation && reservation.id;
    const idStr = rawId === null || rawId === undefined ? '' : String(rawId).replace(/'/g, "\\'");

    let buttons = '';

    // Approve/Cancel only while pending
    if (status === 'pending' || status === '') {
      buttons += `<button class="btn-approve" onclick="approveReservation('${idStr}')" title="Approve ${itemLabel}">✅ Approve</button>`;
      buttons += `<button class="btn-cancel" onclick="cancelReservation('${idStr}')" title="Cancel ${itemLabel}">❌ Cancel</button>`;
    }

    // Permanent delete for normal table reservations in calendar view
    if (!isEvent && idStr) {
      buttons += `<button class="btn-delete" onclick="forceDeleteReservation(${idStr})" title="Delete Reservation (Permanent)">🗑 Delete</button>`;
    }

    // Delete for event bookings
    if (isEvent && idStr) {
      buttons += `<button class="btn-delete" onclick="deleteEventBooking('${idStr}')" title="Delete Event Booking">🗑 Delete</button>`;
    }

    return buttons;
  }

   // Update section tab switching to initialize calendar
   document.addEventListener('DOMContentLoaded', function() {
     // Section tab switching
     const sectionTabs = document.querySelectorAll('.section-tab');
     const sections = document.querySelectorAll('.reservations-section');
     
     sectionTabs.forEach(tab => {
       tab.addEventListener('click', function() {
         const targetSection = this.getAttribute('data-section');
         
         // Remove active class from all tabs and sections
         sectionTabs.forEach(t => t.classList.remove('active'));
         sections.forEach(section => section.classList.remove('active'));
         
         // Add active class to clicked tab and corresponding section
         this.classList.add('active');
         document.getElementById(targetSection + '-section').classList.add('active');
         
         // Initialize calendar if calendar section is selected
         if (targetSection === 'calendar') {
           initializeAdminCalendar();
           startAdminCalendarAutoRefresh();
         } else {
           // Stop polling when leaving the calendar to avoid unnecessary requests
           stopAdminCalendarAutoRefresh();
         }
       });
     });
   });
   </script>
  </body>
</html>