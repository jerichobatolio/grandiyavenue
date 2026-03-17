<!DOCTYPE html>
<html>
  <head> 
   <meta name="csrf-token" content="{{ csrf_token() }}">
   @include('admin.css')

   <style>
         .action-buttons {
          display: flex;
          gap: 8px;
          flex-wrap: wrap;
         }

         .action-btn {
          padding: 6px 14px;
          border: none;
          border-radius: 6px;
          font-size: 13px;
          font-weight: 600;
          cursor: pointer;
          transition: all 0.3s;
          text-decoration: none;
          display: inline-flex;
          align-items: center;
          justify-content: center;
         }

         .btn-delete-permanent {
          background: linear-gradient(135deg, #b91c1c, #991b1b);
          color: #fff;
          box-shadow: 0 2px 4px rgba(185,28,28,0.4);
         }

         .btn-delete-permanent:hover {
          transform: translateY(-2px);
          box-shadow: 0 4px 8px rgba(185,28,28,0.6);
         }

         .btn-cancel {
          background: linear-gradient(135deg, #6b7280, #4b5563);
          color: #fff;
         }
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
          display: flex;
          align-items: center;
          justify-content: space-between;
          flex-wrap: wrap;
          gap: 15px;
         }

         .stats-cards {
          display: grid;
          grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
          gap: 20px;
          margin-bottom: 30px;
         }

         .stat-card {
          background: rgba(255,255,255,0.15);
          backdrop-filter: blur(10px);
          color: white;
          padding: 20px;
          border-radius: 15px;
          text-align: center;
          box-shadow: 0 4px 15px rgba(0,0,0,0.1);
          border: 1px solid rgba(255,255,255,0.2);
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

         .reservations-table {
          background: white;
          border-radius: 15px;
          overflow: hidden;
          box-shadow: 0 4px 15px rgba(0,0,0,0.1);
          margin-bottom: 20px;
         }

         .table-header {
          background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
          color: white;
          padding: 20px;
          text-align: center;
          font-size: 1.2em;
          font-weight: bold;
         }

         table {
          width: 100%;
          border-collapse: collapse;
         }

         thead {
          background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
          color: white;
         }

         th {
          padding: 15px;
          text-align: left;
          font-weight: 600;
          color: white;
          border-bottom: 2px solid #5a6268;
         }

         tbody tr {
          border-bottom: 1px solid #e5e7eb;
          transition: all 0.3s ease;
          opacity: 0.85;
         }

         tbody tr:hover {
          background-color: #f9fafb;
          transform: translateY(-1px);
          box-shadow: 0 2px 4px rgba(0,0,0,0.05);
          opacity: 1;
         }

         tbody tr:last-child {
          border-bottom: none;
         }

         td {
          padding: 12px 15px;
          color: #1f2937;
          font-size: 14px;
         }

         .table-badge {
          display: inline-block;
          padding: 6px 12px;
          border-radius: 20px;
          font-weight: 600;
          font-size: 12px;
          text-transform: uppercase;
         }

         .table-badge.top {
          background-color: #dbeafe;
          color: #1e40af;
         }

         .table-badge.hallway {
          background-color: #fce7f3;
          color: #9f1239;
         }

         .table-badge.vip {
          background-color: #fef3c7;
          color: #92400e;
         }

         .status-badge {
          display: inline-block;
          padding: 6px 12px;
          border-radius: 20px;
          font-size: 12px;
          font-weight: 600;
          text-transform: uppercase;
         }

         .status-badge.confirmed {
          background-color: #d1fae5;
          color: #065f46;
         }

         .status-badge.cancelled {
          background-color: #fee2e2;
          color: #991b1b;
         }

         .status-badge.pending {
          background-color: #fef3c7;
          color: #92400e;
         }

         .occasion-badge {
          display: inline-block;
          padding: 4px 10px;
          border-radius: 15px;
          font-size: 11px;
          font-weight: 500;
          background-color: #f3f4f6;
          color: #4b5563;
         }

         .no-reservations {
          text-align: center;
          padding: 60px 20px;
          color: #6c757d;
          font-size: 18px;
         }

         .page-header-content {
          padding: 20px;
          background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
          border-radius: 10px;
          margin-bottom: 30px;
          box-shadow: 0 4px 6px rgba(0,0,0,0.1);
         }

         @media (max-width: 768px) {
          .page-title {
            font-size: 1.8em;
            flex-direction: column;
            align-items: flex-start;
          }

          .stats-cards {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
          }

          table {
            font-size: 12px;
          }

          th, td {
            padding: 8px 10px;
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
           
          <div class="page-header-content">
            <h1 class="page-title">
                <span>Archived Reservations History</span>
                <a href="/reservations" style="background: rgba(255,255,255,0.2); padding: 8px 16px; border-radius: 6px; text-decoration: none; color: white; font-size: 14px; font-weight: normal; border: 1px solid rgba(255,255,255,0.3);">
                    View Active Reservations
                </a>
            </h1>
            
            @if(!$book->isEmpty())
                <div class="stats-cards">
                  <div class="stat-card">
                    <div class="stat-number">{{ $book->count() }}</div>
                    <div class="stat-label">Total Archived Reservations</div>
                  </div>
                  <div class="stat-card">
                    <div class="stat-number">{{ $book->where('status', 'approved')->count() }}</div>
                    <div class="stat-label">Approved</div>
                  </div>
                  <div class="stat-card">
                    <div class="stat-number">{{ $book->where('status', 'cancelled')->count() }}</div>
                    <div class="stat-label">Cancelled</div>
                  </div>
                  <div class="stat-card">
                    <div class="stat-number">{{ $book->sum('guest') }}</div>
                    <div class="stat-label">Total Guests</div>
                  </div>
                </div>
            @endif
          </div>

          <div class="reservations-container">
            @if($book->isEmpty())
                <div class="no-reservations">
                    <h3 style="color: #6b7280; font-size: 24px; margin-bottom: 10px;">No Archived Reservations</h3>
                    <p style="color: #9ca3af; font-size: 16px;">Archived reservations will appear here when you archive them from the active reservations page.</p>
                </div>
            @else
              <div class="reservations-table">
                <div style="display:flex; justify-content:flex-end; align-items:center; gap:8px; margin-bottom:10px;">
                  <button type="button"
                          class="action-btn btn-delete-permanent"
                          id="toggleReservationDeleteMode"
                          onclick="toggleReservationDeleteMode()">
                    🗑 Select to delete
                  </button>
                  <span class="delete-mode-actions-reservations" style="display:none; align-items:center; gap:8px;">
                    <button type="button"
                            class="action-btn btn-delete-permanent"
                            onclick="deleteSelectedReservations()">
                      🗑 Delete Selected
                    </button>
                    <button type="button"
                            class="action-btn btn-cancel"
                            onclick="toggleReservationDeleteMode()">
                      Cancel
                    </button>
                  </span>
                </div>
                <div class="table-header">Archived Table Reservations</div>
                <table>
                  <thead>
                    <tr>
                      <th class="th-checkbox" style="display:none;">
                        <input type="checkbox" id="select-all-reservations">
                      </th>
                      <th>Name</th>
                      <th>Table</th>
                      <th>Phone</th>
                      <th>Guests</th>
                      <th>Date</th>
                      <th>Time In</th>
                      <th>Time Out</th>
                      <th>Section</th>
                      <th>Occasion</th>
                      <th>Status</th>
                      <th>Archived Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($book as $reservation)
                    <tr>
                      <td class="td-checkbox" style="display:none;">
                        <input type="checkbox" class="reservation-select" value="{{ $reservation->id }}">
                      </td>
                      <td>{{ $reservation->name ?? 'N/A' }}</td>
                      <td>
                        <span class="table-badge {{ $reservation->table_number ? (strpos($reservation->table_number, 'T') === 0 ? 'top' : (strpos($reservation->table_number, 'H') === 0 ? 'hallway' : 'vip')) : 'top' }}">
                          {{ $reservation->table_number ?? 'T1' }}
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
                          @if(strpos($reservation->table_number, 'T') === 0)
                            Grazing
                          @elseif(strpos($reservation->table_number, 'H') === 0)
                            Section A
                          @elseif(strpos($reservation->table_number, 'V') === 0)
                            VIP Cabin Room
                          @else
                            Grazing
                          @endif
                        @else
                          Grazing
                        @endif
                      </td>
                      <td>
                        @if($reservation->occasion)
                          <span class="occasion-badge {{ $reservation->occasion }}">
                            @switch($reservation->occasion)
                              @case('casual') Casual @break
                              @case('business') Business @break
                              @case('celebration') Celebration @break
                              @case('date') Date Night @break
                              @case('family') Family @break
                              @default {{ ucfirst($reservation->occasion) }} @break
                            @endswitch
                          </span>
                        @else
                          <span class="occasion-badge casual">Casual</span>
                        @endif
                      </td>
                      <td>
                        @php
                          $status = $reservation->status ?? 'pending';
                        @endphp
                        @if($status == 'approved' || $status == 'confirmed')
                          <span class="status-badge confirmed">Approved</span>
                        @elseif($status == 'cancelled')
                          <span class="status-badge cancelled">Cancelled</span>
                        @else
                          <span class="status-badge pending">Pending</span>
                        @endif
                      </td>
                      <td>
                        <div style="font-size: 12px; color: #6b7280;">
                          {{ $reservation->updated_at->format('M d, Y H:i') }}
                        </div>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @endif
          </div>

          </div>
        </div>
      </div>

   @include('admin.js')
  </body>
  <script>
    function toggleReservationDeleteMode() {
      const on = document.body.classList.toggle('reservations-delete-mode');
      const ths = document.querySelectorAll('th.th-checkbox');
      const tds = document.querySelectorAll('td.td-checkbox');
      const toggleBtn = document.getElementById('toggleReservationDeleteMode');
      const actions = document.querySelector('.delete-mode-actions-reservations');

      ths.forEach(el => el.style.display = on ? 'table-cell' : 'none');
      tds.forEach(el => el.style.display = on ? 'table-cell' : 'none');

      if (toggleBtn) toggleBtn.style.display = on ? 'none' : 'inline-flex';
      if (actions) actions.style.display = on ? 'inline-flex' : 'none';

      if (!on) {
        document.querySelectorAll('.reservation-select').forEach(cb => cb.checked = false);
        const selectAll = document.getElementById('select-all-reservations');
        if (selectAll) selectAll.checked = false;
      }
    }

    function deleteSelectedReservations() {
      const checkboxes = document.querySelectorAll('.reservation-select:checked');
      if (!checkboxes.length) {
        alert('Please select at least one reservation.');
        return;
      }
      if (!confirm('Permanently delete selected reservations? This cannot be undone.')) {
        return;
      }

      const ids = Array.from(checkboxes).map(cb => cb.value);
      const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      let completed = 0;
      const total = ids.length;

      ids.forEach(id => {
        fetch(`/admin/reservations/${id}/force-delete`, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': token,
            'X-Requested-With': 'XMLHttpRequest'
          }
        }).finally(() => {
          completed++;
          if (completed === total) {
            window.location.reload();
          }
        });
      });
    }

    document.addEventListener('DOMContentLoaded', function () {
      const selectAll = document.getElementById('select-all-reservations');
      if (selectAll) {
        selectAll.addEventListener('change', function () {
          document.querySelectorAll('.reservation-select').forEach(cb => {
            cb.checked = selectAll.checked;
          });
        });
      }
    });
  </script>
</html>
