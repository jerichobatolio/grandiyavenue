    <div class="d-flex align-items-stretch">
      <!-- Sidebar Navigation-->
      <nav id="sidebar" style="padding-bottom: 70px; overflow-y: auto; height: 100vh; position: fixed; top: 0; left: 0; z-index: 1000;">
        <!-- Sidebar Header - Admin Profile Dropdown -->
        <div class="sidebar-header">
          <div class="admin-profile-dropdown">
            <!-- Profile Display -->
            <div class="profile-display d-flex align-items-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="avatar-container">
                @if(auth()->user() && auth()->user()->profile_photo_path)
                  <img id="sidebar-profile-photo" src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" class="img-fluid rounded-circle" style="width: 50px; height: 50px; object-fit: cover; border: 2px solid #007bff;">
                @else
                  <img id="sidebar-profile-photo" src="{{ asset('admin-assets/img/avatar-6.jpg') }}" alt="Admin" class="img-fluid rounded-circle" style="width: 50px; height: 50px; object-fit: cover; border: 2px solid #007bff;">
                @endif
              </div>
              <div class="profile-info ml-3">
                <h6 class="mb-0 text-white" style="font-size: 14px; font-weight: bold;">
                  {{ auth()->user() ? auth()->user()->name : 'Admin' }}
                </h6>
                <small class="text-light" style="font-size: 11px;">
                  {{ auth()->user() && auth()->user()->email ? auth()->user()->email : 'admin@example.com' }}
                </small>
              </div>
              <div class="ml-auto">
                <i class="fa fa-chevron-down text-white" style="font-size: 12px;"></i>
              </div>
            </div>

            <!-- Dropdown Menu -->
            <div class="dropdown-menu profile-dropdown-menu" style="width: 100%; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.15); border-radius: 10px; padding: 0; margin-top: 5px;">
              <!-- Profile Header in Dropdown -->
              <div class="dropdown-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 10px 10px 0 0; padding: 15px; text-align: center;">
                <div class="profile-photo-container mb-2">
                  <div class="avatar-container position-relative d-inline-block">
                    @if(auth()->user() && auth()->user()->profile_photo_path)
                      <img id="dropdown-profile-photo" src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" class="img-fluid rounded-circle" style="width: 60px; height: 60px; object-fit: cover; border: 3px solid white;">
                    @else
                      <img id="dropdown-profile-photo" src="{{ asset('admin-assets/img/avatar-6.jpg') }}" alt="Admin" class="img-fluid rounded-circle" style="width: 60px; height: 60px; object-fit: cover; border: 3px solid white;">
                    @endif
                    <button type="button" class="btn btn-sm btn-light position-absolute" style="bottom: -2px; right: -2px; border-radius: 50%; width: 22px; height: 22px; padding: 0; font-size: 10px;" onclick="document.getElementById('dropdown-photo-input').click()" title="Change Photo">
                      <i class="fa fa-camera"></i>
                    </button>
                  </div>
                  <input type="file" id="dropdown-photo-input" style="display: none;" accept="image/*" onchange="uploadDropdownPhoto()">
                </div>
                <h6 class="mb-0">
                  {{ auth()->user() ? auth()->user()->name : 'Admin' }}
                </h6>
                <small class="opacity-75">
                  {{ auth()->user() ? auth()->user()->email : 'admin@example.com' }}
                </small>
              </div>

              <!-- Profile Edit Form -->
              <div class="dropdown-body" style="padding: 20px; background: white;">
                <form id="profile-edit-form">
                  <div class="form-group mb-3">
                    <label class="form-label" style="font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">
                      <i class="fa fa-user mr-1"></i>Full Name
                    </label>
                    <input type="text" id="dropdown-name" class="form-control form-control-sm" value="{{ auth()->user() ? auth()->user()->name : '' }}" placeholder="Enter full name" style="border-radius: 5px; border: 1px solid #ddd;">
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label" style="font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">
                      <i class="fa fa-envelope mr-1"></i>Email Address
                    </label>
                    <input type="email" id="dropdown-email" class="form-control form-control-sm" value="{{ auth()->user() ? auth()->user()->email : 'admin@example.com' }}" placeholder="Enter email address" style="border-radius: 5px; border: 1px solid #ddd;">
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label" style="font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">
                      <i class="fa fa-phone mr-1"></i>Phone Number
                    </label>
                    <input type="tel" id="dropdown-phone" class="form-control form-control-sm" value="{{ auth()->user() ? auth()->user()->phone : '' }}" placeholder="Enter phone number" style="border-radius: 5px; border: 1px solid #ddd;">
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label" style="font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">
                      <i class="fa fa-map-marker mr-1"></i>Address
                    </label>
                    <textarea id="dropdown-address" class="form-control form-control-sm" rows="2" placeholder="Enter address" style="border-radius: 5px; border: 1px solid #ddd; resize: none;">{{ auth()->user() ? auth()->user()->address : '' }}</textarea>
                  </div>

                  <!-- Action Button -->
                  <div class="d-flex">
                    <button type="button" class="btn btn-success btn-sm flex-fill" onclick="saveDropdownProfile()" style="font-size: 11px; padding: 6px 12px; border-radius: 5px;">
                      <i class="fa fa-save mr-1"></i>Save Changes
                    </button>
                  </div>
                </form>
              </div>

              <!-- Dropdown Footer -->
              <div class="dropdown-footer" style="background: #f8f9fa; padding: 10px 15px; border-radius: 0 0 10px 10px; text-align: center;">
                <small class="text-muted">
                  <i class="fa fa-info-circle mr-1"></i>
                  Last updated: {{ auth()->user() && auth()->user()->updated_at ? auth()->user()->updated_at->format('M d, Y') : 'Never' }}
                </small>
              </div>
            </div>
          </div>
        </div>
        <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
        <ul class="list-unstyled">
                <li class="active"><a href="{{url('dashboard')}}"> <i class="icon-home"></i>Home </a></li>
               
                <li><a href="#exampledropdownDropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-food"></i>🍽️ Food </a>
                  <ul id="exampledropdownDropdown" class="collapse list-unstyled ">
                    <li><a href="{{url('add_food')}}">➕ Add Food</a></li>
                    <li><a href="{{url('view_food')}}">👁️ View Food</a></li>
                    <li><a href="{{url('categories')}}">📂 Manage Categories</a></li>
                    <li><a href="{{url('bundles')}}">📦 Bundle Packages</a></li>
                  </ul>
                </li>
                <li><a href="{{url('orders')}}"> <i class="icon-shopping-cart"></i>🛒 Orders
                  @php
                    $inProgressOrders = \App\Models\Order::where('is_archived', false)
                      ->where('delivery_status', 'In Progress')
                      ->get();
                    $uniqueCustomersCount = $inProgressOrders->groupBy(function($order) {
                      return $order->name . '|' . $order->email . '|' . $order->phone . '|' . $order->address;
                    })->count();
                  @endphp
                  <span id="order-badge" class="reservation-badge" style="display: {{ $uniqueCustomersCount > 0 ? 'inline-block' : 'none' }};">{{ $uniqueCustomersCount }}</span>
                </a></li>

                <li><a href="{{url('reservations')}}"> <i class="icon-calendar"></i>📅 Reservations
                  @php
                    $pendingReservationsCount = \App\Models\Book::where('is_archived', false)
                      ->where(function($query) {
                        $query->where('status', 'pending')
                              ->orWhereNull('status')
                              ->orWhere('status', '');
                      })
                      ->count();
                  @endphp
                  <span id="reservation-badge" class="reservation-badge" style="display: {{ $pendingReservationsCount > 0 ? 'inline-block' : 'none' }};">{{ $pendingReservationsCount }}</span>
                </a></li>

               <li><a href="{{url('event_bookings')}}"> <i class="icon-star"></i>🎉 Event Bookings
                  @php
                    $pendingEventBookingsCount = \App\Models\EventBooking::where('is_archived', false)
                      ->where('status', 'Pending')
                      ->count();
                  @endphp
                  <span id="event-booking-badge" class="reservation-badge" style="display: {{ $pendingEventBookingsCount > 0 ? 'inline-block' : 'none' }};">{{ $pendingEventBookingsCount }}</span>
                </a></li>

               <li><a href="{{url('notifications')}}"> <i class="icon-bell"></i>🔔 Notifications
                  @php
                    $unreadNotificationsCount = \App\Models\Notification::where('is_read', false)->count();
                  @endphp
                  <span id="notification-badge" class="reservation-badge" style="display: {{ $unreadNotificationsCount > 0 ? 'inline-block' : 'none' }};">{{ $unreadNotificationsCount }}</span>
               </a></li>

                <li><a href="{{route('admin.return_refunds.index')}}"> <i class="icon-undo"></i>🔄 Return/Refunds
                  @php
                    $pendingReturnRefundsCount = \App\Models\ReturnRefund::where('status', 'pending')->count();
                  @endphp
                  <span id="return-refund-badge" class="reservation-badge" style="display: {{ $pendingReturnRefundsCount > 0 ? 'inline-block' : 'none' }};">{{ $pendingReturnRefundsCount }}</span>
                </a></li>

                <li><a href="{{route('admin.reviews')}}"> <i class="icon-star"></i>⭐ Customer Reviews</a></li>

                <li><a href="{{route('admin.announcements')}}"> <i class="icon-bullhorn"></i>📢 Announcements</a></li>

                <li><a href="{{ route('admin.faqs') }}"> <i class="icon-question"></i>🤖 Grandiya Assistant</a></li>

                <li><a href="#eventTypesDropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-star"></i>🎪 Event Types</a>
                  <ul id="eventTypesDropdown" class="collapse list-unstyled ">
                    <li><a href="{{route('event_types.index')}}">📋 View All Event Types</a></li>
                  </ul>
                </li>

                <li><a href="{{url('table_management')}}"> <i class="icon-table"></i>🪑 Table Management</a></li>

                <li><a href="#galleryDropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-picture"></i>Menu</a>
                  <ul id="galleryDropdown" class="collapse list-unstyled ">
                    <li><a href="{{url('add_gallery_item')}}">➕ Create Menu Item</a></li>
                    <li><a href="{{url('manage_gallery')}}">✏️ Update Menu Item</a></li>
                  </ul>
                </li>

                


        
      </nav>
      <!-- Sidebar Navigation end-->

      <!-- Logout Section - Fixed at Bottom -->
      <div class="logout-section" style="position: fixed; bottom: 0; left: 0; width: 280px; padding: 10px; background: #2c2c2c; border-top: 1px solid #444; z-index: 1001;">
          <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
              @csrf
              <button type="submit" class="btn btn-danger btn-sm" style="width: 100%; margin: 0; background: #dc3545; border: none; color: white; padding: 8px 12px; border-radius: 4px; cursor: pointer;">
                  <i class="fa fa-sign-out"></i> Logout
              </button>
          </form>
      </div>
      <!-- Sidebar Navigation end-->

      <!-- Profile Management Styles -->
      <style>
        #sidebar {
          position: fixed !important;
          top: 0;
          left: 0;
          z-index: 1000;
          overflow-y: auto !important;
          overflow-x: hidden !important;
        }
        
        .sidebar-header {
          position: static !important;
        }
        
        /* Ensure body and html don't scroll when sidebar is fixed */
        html, body {
          overflow: hidden !important;
          height: 100%;
          margin: 0;
          padding: 0;
        }
        
        /* Ensure header accounts for fixed sidebar */
        .header {
          margin-left: 280px;
          position: fixed;
          top: 0;
          right: 0;
          width: calc(100% - 280px);
          z-index: 999;
        }
        
        .page-content.active ~ .header,
        body:has(.page-content.active) .header {
          margin-left: 0;
          width: 100%;
        }
        
        /* Ensure page content scrolls independently */
        .page-content {
          margin-left: 280px;
          overflow-y: auto;
          overflow-x: hidden;
          height: 100vh;
          position: fixed;
          top: 0;
          right: 0;
          width: calc(100% - 280px);
          padding-top: 70px;
          box-sizing: border-box;
        }
        
        .page-content.active {
          margin-left: 0;
          width: 100%;
        }
        
        .admin-profile-dropdown {
          position: relative;
        }
        
        .profile-display {
          padding: 15px;
          background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
          border-radius: 10px;
          margin: 10px;
          cursor: pointer;
          transition: all 0.3s ease;
        }
        
        .profile-display:hover {
          transform: translateY(-2px);
          box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        
        .profile-dropdown-menu {
          position: absolute !important;
          top: 100% !important;
          left: 0 !important;
          right: 0 !important;
          transform: none !important;
          z-index: 1000;
          max-height: 80vh;
          overflow-y: auto;
        }
        
        .profile-dropdown-menu.show {
          display: block !important;
        }
        
        .avatar-container:hover img {
          transform: scale(1.05);
          transition: transform 0.3s ease;
        }
        
        .form-control:focus {
          border-color: #007bff !important;
          box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
          outline: none;
        }
        
        .btn-sm {
          font-size: 11px;
          padding: 6px 12px;
        }
        
        .dropdown-header {
          border-bottom: none !important;
        }
        
        .dropdown-body {
          border-top: 1px solid #e9ecef;
        }
        
        .dropdown-footer {
          border-top: 1px solid #e9ecef;
        }
        
        /* Custom scrollbar for dropdown */
        .profile-dropdown-menu::-webkit-scrollbar {
          width: 6px;
        }
        
        .profile-dropdown-menu::-webkit-scrollbar-track {
          background: #f1f1f1;
          border-radius: 3px;
        }
        
        .profile-dropdown-menu::-webkit-scrollbar-thumb {
          background: #c1c1c1;
          border-radius: 3px;
        }
        
        .profile-dropdown-menu::-webkit-scrollbar-thumb:hover {
          background: #a8a8a8;
        }
        
        /* Reservation Notification Badge */
        .reservation-badge {
          display: inline-block;
          background-color: #dc3545;
          color: white;
          border-radius: 50%;
          padding: 2px 6px;
          font-size: 11px;
          font-weight: bold;
          min-width: 18px;
          height: 18px;
          line-height: 14px;
          text-align: center;
          margin-left: 8px;
          vertical-align: middle;
          animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
          0% {
            box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7);
          }
          70% {
            box-shadow: 0 0 0 6px rgba(220, 53, 69, 0);
          }
          100% {
            box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
          }
        }
        
        #sidebar li a {
          position: relative;
        }
      </style>

      <!-- Profile Management JavaScript -->
      <script>
        // Upload profile photo from dropdown
        function uploadDropdownPhoto() {
          const fileInput = document.getElementById('dropdown-photo-input');
          const file = fileInput.files[0];
          
          if (!file) return;
          
          // Validate file size (1MB max)
          if (file.size > 1024 * 1024) {
            showDropdownAlert('error', 'File size must be less than 1MB');
            return;
          }
          
          // Validate file type
          if (!file.type.match('image.*')) {
            showDropdownAlert('error', 'Please select an image file');
            return;
          }
          
          const formData = new FormData();
          formData.append('photo', file);
          formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
          
          // Show loading state
          const sidebarPhoto = document.getElementById('sidebar-profile-photo');
          const dropdownPhoto = document.getElementById('dropdown-profile-photo');
          sidebarPhoto.style.opacity = '0.5';
          dropdownPhoto.style.opacity = '0.5';
          
          fetch('{{ route('profile.inline.photo') }}', {
            method: 'POST',
            body: formData,
            headers: {
              'X-Requested-With': 'XMLHttpRequest',
              'Accept': 'application/json'
            }
          })
          .then(response => response.json().then(data => ({ ok: response.ok, data })))
          .then(({ ok, data }) => {
            sidebarPhoto.style.opacity = '1';
            dropdownPhoto.style.opacity = '1';
            
            if (ok && data.photo_url) {
              // Update both profile photos
              sidebarPhoto.src = data.photo_url;
              dropdownPhoto.src = data.photo_url;
              showDropdownAlert('success', data.message || 'Profile photo updated.');
            } else {
              showDropdownAlert('error', data.message || 'Error uploading photo');
            }
          })
          .catch(error => {
            sidebarPhoto.style.opacity = '1';
            dropdownPhoto.style.opacity = '1';
            console.error('Error:', error);
            showDropdownAlert('error', 'An error occurred while uploading the photo');
          });
        }
        
        // Save profile information from dropdown
        function saveDropdownProfile() {
          const name = document.getElementById('dropdown-name').value;
          const email = document.getElementById('dropdown-email').value;
          const phone = document.getElementById('dropdown-phone').value;
          const address = document.getElementById('dropdown-address').value;
          
          // Basic validation
          if (!name.trim()) {
            showDropdownAlert('error', 'Name is required');
            return;
          }
          
          if (!email.trim() || !email.includes('@')) {
            showDropdownAlert('error', 'Valid email is required');
            return;
          }
          
          const formData = new FormData();
          formData.append('name', name);
          formData.append('email', email);
          formData.append('phone', phone);
          formData.append('address', address);
          formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
          
          // Show loading state
          const saveBtn = document.querySelector('button[onclick="saveDropdownProfile()"]');
          const originalText = saveBtn.innerHTML;
          saveBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving...';
          saveBtn.disabled = true;
          
          fetch('{{ route('profile.inline.update') }}', {
            method: 'POST',
            body: formData,
            headers: {
              'X-Requested-With': 'XMLHttpRequest',
              'Accept': 'application/json'
            }
          })
          .then(response => response.json().then(data => ({ ok: response.ok, status: response.status, data })))
          .then(({ ok, data }) => {
            saveBtn.innerHTML = originalText;
            saveBtn.disabled = false;
            
            if (ok && (data.success || data.user)) {
              // Update sidebar display
              const sidebarName = document.querySelector('.profile-info h6');
              if (sidebarName) {
                sidebarName.textContent = (data.user && data.user.name) ? data.user.name : name;
              }
              
              showDropdownAlert('success', data.message || 'Profile updated successfully!');
              
              // Close dropdown after successful save
              setTimeout(() => {
                const dropdown = document.querySelector('.profile-dropdown-menu');
                if (dropdown) {
                  dropdown.classList.remove('show');
                }
              }, 1500);
            } else {
              let errorMessage = 'Error updating profile';
              if (data && data.errors) {
                try {
                  const allErrors = Object.values(data.errors).flat();
                  if (allErrors.length) {
                    errorMessage = allErrors.join(' ');
                  }
                } catch (e) {
                  if (data.message) {
                    errorMessage = data.message;
                  }
                }
              } else if (data && data.message) {
                errorMessage = data.message;
              }
              showDropdownAlert('error', errorMessage);
            }
          })
          .catch(error => {
            saveBtn.innerHTML = originalText;
            saveBtn.disabled = false;
            console.error('Error:', error);
            showDropdownAlert('error', 'An error occurred while saving');
          });
        }
        
        // Reset profile information
        function resetDropdownProfile() {
          if (confirm('Are you sure you want to reset the form? All unsaved changes will be lost.')) {
            location.reload();
          }
        }
        
        // Show alert message for dropdown
        function showDropdownAlert(type, message) {
          // Remove existing alerts
          const existingAlert = document.querySelector('.dropdown-alert');
          if (existingAlert) {
            existingAlert.remove();
          }
          
          const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
          const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
          
          const alertHtml = `
            <div class="dropdown-alert alert ${alertClass} alert-dismissible fade show" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px; border-radius: 8px;">
              <i class="fa ${iconClass}"></i> ${message}
              <button type="button" class="close" onclick="this.parentElement.remove()">
                <span>&times;</span>
              </button>
            </div>
          `;
          
          document.body.insertAdjacentHTML('beforeend', alertHtml);
          
          // Auto-hide after 3 seconds
          setTimeout(() => {
            const alert = document.querySelector('.dropdown-alert');
            if (alert) {
              alert.remove();
            }
          }, 3000);
        }
        
        // Initialize dropdown functionality
        document.addEventListener('DOMContentLoaded', function() {
          // Handle dropdown toggle
          const profileDisplay = document.querySelector('.profile-display');
          const dropdownMenu = document.querySelector('.profile-dropdown-menu');
          
          if (profileDisplay && dropdownMenu) {
            profileDisplay.addEventListener('click', function(e) {
              e.preventDefault();
              e.stopPropagation();
              
              // Toggle dropdown
              dropdownMenu.classList.toggle('show');
              
              // Close dropdown when clicking outside
              document.addEventListener('click', function closeDropdown(e) {
                if (!profileDisplay.contains(e.target) && !dropdownMenu.contains(e.target)) {
                  dropdownMenu.classList.remove('show');
                  document.removeEventListener('click', closeDropdown);
                }
              });
            });
          }
          
          // Add focus effects to form inputs
          const inputs = document.querySelectorAll('#profile-edit-form input, #profile-edit-form textarea');
          inputs.forEach(input => {
            input.addEventListener('focus', function() {
              this.style.borderColor = '#007bff';
              this.style.boxShadow = '0 0 0 0.2rem rgba(0, 123, 255, 0.25)';
            });
            
            input.addEventListener('blur', function() {
              this.style.borderColor = '#ddd';
              this.style.boxShadow = 'none';
            });
          });
        });
      </script>