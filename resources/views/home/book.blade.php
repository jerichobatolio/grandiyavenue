<div class="container-fluid has-bg-overlay text-center text-light has-height-lg middle-items" id="book-table">
    <style>
        /* Improved Typography for Book Table Section */
        #book-table .section-title {
            color: white !important;
            font-size: 2.5rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        
        #book-table h4 {
            color: white !important;
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: 0.3px;
        }
        
        #book-table h3 {
            color: white !important;
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        
        #book-table .text-muted,
        #book-table small.text-muted,
        #book-table span.text-muted,
        #book-table p.text-muted {
            color: #e0e0e0 !important;
            font-weight: 600;
            font-size: 0.95rem;
        }
        
        #book-table label,
        #book-table .form-label {
            color: white !important;
            font-size: 1rem;
            font-weight: 600;
            letter-spacing: 0.3px;
        }
        
        #book-table input,
        #book-table select,
        #book-table textarea {
            font-size: 1rem;
            font-weight: 500;
        }
        
        #book-table button,
        #book-table .btn {
            font-size: 1rem;
            font-weight: 600;
            letter-spacing: 0.3px;
        }
        
        #book-table .legend-item span {
            font-size: 1rem;
            font-weight: 500;
            color: white !important;
        }
    </style>
    <div class="">
        <h2 class="section-title mb-5" style="color: white !important;"> RESERVE A TABLE</h2>
        
        <!-- Section Selection Buttons -->
        <div class="section-buttons mb-4" id="section-buttons">
            <!-- Sections will be populated by JavaScript -->
            <button class="btn btn-success section-btn" data-section="calendar">📅 Calendar View</button>
        </div>

        <!-- Dynamic Sections Container -->
        <div id="dynamic-sections-container">
            <!-- Sections will be populated by JavaScript -->
        </div>

        <!-- Calendar View Section -->
        <div id="calendar-section" class="restaurant-section">
            <h3 class="mb-4">📅 Reservation Calendar</h3>
            <div class="calendar-container">
                <div class="calendar-header">
                    <button id="prev-month" class="btn btn-outline-light">‹ Previous</button>
                    <h4 id="current-month-year"></h4>
                    <button id="next-month" class="btn btn-outline-light">Next ›</button>
                </div>
                <div class="calendar-grid" id="calendar-grid">
                    <!-- Calendar will be populated by JavaScript -->
                </div>
                <div class="calendar-legend mt-3">
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

        

        <!-- Reservation Form -->
        <div class="booking-form mt-5">
            <h4 class="mb-3" style="color: white !important;">📝 Complete Your Table Reservation</h4>
            
            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-bottom: 20px;">
                    <i class="fas fa-check-circle mr-2"></i>
                    <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            
            <!-- Error Message -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            
            <!-- Validation Errors -->
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            
            <div id="selected-table-info" class="alert alert-info" style="display: none;">
                <strong>Selected Table:</strong> <span id="selected-table-name"></span>
            </div>

            @if (Route::has('login'))
                @auth
                    @php
                        $user = auth()->user();

                        if ($user) {
                            $defaultFirstName = $user->first_name ?? '';
                            $defaultLastName = $user->last_name ?? '';

                            // If first/last are not set but a full name exists, split it.
                            if ((!$defaultFirstName || !$defaultLastName) && !empty($user->name)) {
                                $nameParts = explode(' ', trim($user->name), 2);
                                $defaultFirstName = $defaultFirstName ?: ($nameParts[0] ?? '');
                                $defaultLastName = $defaultLastName ?: ($nameParts[1] ?? '');
                            }
                        } else {
                            $defaultFirstName = '';
                            $defaultLastName = '';
                        }

                        $defaultPhone = $user ? ($user->phone ?? '') : '';
                    @endphp
                    <!-- If logged in, normal reservation -->
                    <form action="{{ url('book_table') }}" method="POST" id="booking-form">
                        @csrf
                        <input type="hidden" name="table_number" id="table_number" required>
                        <input type="hidden" name="table_section" id="table_section" required>
                        <input type="hidden" name="status" value="pending">
                        <div class="row mb-3">
                            <div class="col-sm-6 col-md-3 col-xs-12 mb-3">
                                <label for="res_name" class="text-white-50 mb-1">First Name</label>
                                <input id="res_name" type="text" class="form-control form-control-lg custom-form-control" 
                                       name="name" value="{{ old('name', $defaultFirstName) }}" required>
                            </div>
                            <div class="col-sm-6 col-md-3 col-xs-12 mb-3">
                                <label for="res_last_name" class="text-white-50 mb-1">Last Name</label>
                                <input id="res_last_name" type="text" class="form-control form-control-lg custom-form-control" 
                                       name="last_name" value="{{ old('last_name', $defaultLastName) }}">
                            </div>
                            <div class="col-sm-6 col-md-3 col-xs-12 mb-3">
                                <label for="res_phone" class="text-white-50 mb-1">Phone Number</label>
                                <input id="res_phone" type="text" class="form-control form-control-lg custom-form-control" 
                                       name="phone" value="{{ old('phone', $defaultPhone) }}" required
                                       maxlength="11" pattern="[0-9]{11}" inputmode="numeric"
                                       title="Enter exactly 11 digits (numbers only)" placeholder="11 digits">
                            </div>
                            <div class="col-sm-6 col-md-3 col-xs-12 mb-3">
                                <label for="guest_count" class="text-white-50 mb-1">Number of Guests</label>
                                <input type="number" class="form-control form-control-lg custom-form-control" 
                                       name="guest" id="guest_count" min="1" value="{{ old('guest') }}" required>
                                <div id="capacity-warning" class="capacity-warning" style="display: none; margin-top: 5px;">
                                    <small class="text-danger">⚠️ Exceeds table capacity!</small>
                                </div>
                                <div id="capacity-info" class="capacity-info" style="display: none; margin-top: 5px;">
                                    <small class="text-info">ℹ️ Table capacity: <span id="table-capacity-display"></span> pax</small>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6 col-md-3 col-xs-12 mb-3">
                                <label for="res_date" class="text-white-50 mb-1">Date</label>
                                <input id="res_date" type="date" class="form-control form-control-lg custom-form-control" 
                                       name="date" value="{{ old('date') }}" required>
                            </div>
                            <div class="col-sm-6 col-md-3 col-xs-12 mb-3">
                                <label for="res_time_in" class="text-white-50 mb-1">Time In</label>
                                <input id="res_time_in" type="time" class="form-control form-control-lg custom-form-control" 
                                       name="time_in" value="{{ old('time_in') }}" min="10:00" max="17:00" required>
                            </div>
                            <div class="col-sm-6 col-md-3 col-xs-12 mb-3">
                                <label for="res_time_out" class="text-white-50 mb-1">Time Out</label>
                                <input id="res_time_out" type="time" class="form-control form-control-lg custom-form-control"
                                       name="time_out" value="{{ old('time_out') }}" min="14:00" max="21:00" readonly required>
                                <small class="text-muted d-block mt-1">Auto set to 4 hours after Time In</small>
                            </div>
                            <div class="col-sm-6 col-md-3 col-xs-12 mb-3">
                                <label for="res_occasion" class="text-white-50 mb-1">Select Occasion</label>
                                <select id="res_occasion" class="form-control form-control-lg custom-form-control" name="occasion">
                                    <option value="">Select Occasion</option>
                                    <option value="casual" {{ old('occasion') == 'casual' ? 'selected' : '' }}>Casual Dining</option>
                                    <option value="business" {{ old('occasion') == 'business' ? 'selected' : '' }}>Business Meeting</option>
                                    <option value="celebration" {{ old('occasion') == 'celebration' ? 'selected' : '' }}>Celebration</option>
                                    <option value="date" {{ old('occasion') == 'date' ? 'selected' : '' }}>Date Night</option>
                                    <option value="family" {{ old('occasion') == 'family' ? 'selected' : '' }}>Family Gathering</option>
                                    <option value="other" {{ old('occasion') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 mb-3">
                                <label for="res_requests" class="text-white-50 mb-1">Special Requests (Optional)</label>
                                <textarea id="res_requests" class="form-control form-control-lg custom-form-control" 
                                       name="special_requests" rows="2" style="resize: none; overflow: hidden;">{{ old('special_requests') }}</textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-lg btn-success" id="book-btn" disabled>
                            📅 Book Selected Table
                        </button>
                    </form>
                @else
                    <!-- If guest, show same form but redirect to login -->
                    <form action="{{ route('login') }}" method="GET" id="booking-form">
                        <input type="hidden" name="table_number" id="table_number" required>
                        <input type="hidden" name="table_section" id="table_section_guest" required>
                        <div class="row mb-3">
                            <div class="col-sm-6 col-md-3 col-xs-12 mb-3">
                                <label for="guest_name" class="text-white-50 mb-1">First Name</label>
                                <input id="guest_name" type="text" class="form-control form-control-lg custom-form-control" 
                                       name="name" value="{{ old('name') }}" required>
                            </div>
                            <div class="col-sm-6 col-md-3 col-xs-12 mb-3">
                                <label for="guest_last_name" class="text-white-50 mb-1">Last Name</label>
                                <input id="guest_last_name" type="text" class="form-control form-control-lg custom-form-control" 
                                       name="last_name" value="{{ old('last_name') }}">
                            </div>
                            <div class="col-sm-6 col-md-3 col-xs-12 mb-3">
                                <label for="guest_phone" class="text-white-50 mb-1">Phone Number</label>
                                <input id="guest_phone" type="text" class="form-control form-control-lg custom-form-control" 
                                       name="phone" value="{{ old('phone') }}" required
                                       maxlength="11" pattern="[0-9]{11}" inputmode="numeric"
                                       title="Enter exactly 11 digits (numbers only)" placeholder="11 digits">
                            </div>
                            <div class="col-sm-6 col-md-3 col-xs-12 mb-3">
                                <label for="guest_count_guest" class="text-white-50 mb-1">Number of Guests</label>
                                <input type="number" class="form-control form-control-lg custom-form-control" 
                                       name="guest" id="guest_count_guest" min="1" required>
                                <div id="capacity-warning-guest" class="capacity-warning" style="display: none; margin-top: 5px;">
                                    <small class="text-danger">⚠️ Exceeds table capacity!</small>
                                </div>
                                <div id="capacity-info-guest" class="capacity-info" style="display: none; margin-top: 5px;">
                                    <small class="text-info">ℹ️ Table capacity: <span id="table-capacity-display-guest"></span> pax</small>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6 col-md-3 col-xs-12 mb-3">
                                <label for="guest_date" class="text-white-50 mb-1">Date</label>
                                <input id="guest_date" type="date" class="form-control form-control-lg custom-form-control" 
                                       name="date" value="{{ old('date') }}" required>
                            </div>
                            <div class="col-sm-6 col-md-3 col-xs-12 mb-3">
                                <label for="guest_time_in" class="text-white-50 mb-1">Time In</label>
                                <input id="guest_time_in" type="time" class="form-control form-control-lg custom-form-control" 
                                       name="time_in" value="{{ old('time_in') }}" min="10:00" max="17:00" required>
                            </div>
                            <div class="col-sm-6 col-md-3 col-xs-12 mb-3">
                                <label for="guest_time_out" class="text-white-50 mb-1">Time Out</label>
                                <input id="guest_time_out" type="time" class="form-control form-control-lg custom-form-control"
                                       name="time_out" value="{{ old('time_out') }}" min="14:00" max="21:00" readonly required>
                                <small class="text-muted d-block mt-1">Auto set to 4 hours after Time In</small>
                            </div>
                            <div class="col-sm-6 col-md-3 col-xs-12 mb-3">
                                <label for="guest_occasion" class="text-white-50 mb-1">Select Occasion</label>
                                <select id="guest_occasion" class="form-control form-control-lg custom-form-control" name="occasion">
                                    <option value="">Select Occasion</option>
                                    <option value="casual" {{ old('occasion') == 'casual' ? 'selected' : '' }}>Casual Dining</option>
                                    <option value="business" {{ old('occasion') == 'business' ? 'selected' : '' }}>Business Meeting</option>
                                    <option value="celebration" {{ old('occasion') == 'celebration' ? 'selected' : '' }}>Celebration</option>
                                    <option value="date" {{ old('occasion') == 'date' ? 'selected' : '' }}>Date Night</option>
                                    <option value="family" {{ old('occasion') == 'family' ? 'selected' : '' }}>Family Gathering</option>
                                    <option value="other" {{ old('occasion') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 mb-3">
                                <label for="guest_requests" class="text-white-50 mb-1">Special Requests (Optional)</label>
                                <textarea id="guest_requests" class="form-control form-control-lg custom-form-control" 
                                       name="special_requests" rows="2" style="resize: none; overflow: hidden;"></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-lg btn-success" id="book-btn" disabled>
                            📅 Book Selected Table
                        </button>
                    </form>
                @endauth
            @endif
        </div>


<style>
/* Section Buttons */
.section-buttons {
    display: flex;
    justify-content: center;
    gap: 15px;
    flex-wrap: wrap;
}

.section-btn {
    padding: 12px 24px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 25px;
    transition: all 0.3s ease;
    border: 2px solid #007bff;
}

.section-btn.active {
    background-color: #28a745;
    border-color: #28a745;
    color: white;
}

.section-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

/* Restaurant Sections */
.restaurant-section {
    display: none;
    animation: fadeIn 0.5s ease-in;
}

.restaurant-section.active {
    display: block;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Tables Grid */
.tables-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 20px;
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

/* Section info summary (image + inclusions) */
.section-info-card {
    max-width: 900px;
    margin: 0 auto 20px auto;
    background: rgba(0, 0, 0, 0.3);
    border-radius: 15px;
    padding: 20px;
    display: none;
}

.section-info-grid {
    display: grid;
    grid-template-columns: 1.2fr 1.8fr;
    gap: 20px;
    align-items: center;
}

.section-info-image img {
    width: 100%;
    border-radius: 12px;
    object-fit: cover;
    max-height: 220px;
}

.section-info-placeholder {
    width: 100%;
    height: 220px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    background: rgba(255, 255, 255, 0.08);
    border: 1px dashed rgba(255, 255, 255, 0.3);
}

.section-info-details h4 {
    color: #ffffff !important;
    margin-bottom: 10px;
}

.section-info-details table {
    width: 100%;
    color: #f8f9fa;
}

.section-info-details th {
    width: 120px;
    font-weight: 600;
    opacity: 0.85;
}

.section-info-details td {
    opacity: 0.95;
}

.vip-tables {
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    max-width: 500px;
}

/* Table Items */
.table-item {
    background-color: #f8f9fa;
    border: 3px solid #6c757d;
    border-radius: 15px;
    padding: 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    color: #333;
    position: relative;
    min-height: 120px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.table-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    border-color: #007bff;
}

.table-item.selected {
    background-color: #28a745;
    border-color: #28a745;
    color: white;
    transform: scale(1.05);
}

.table-item.selected .table-icon {
    animation: bounce 0.6s ease-in-out;
}

.table-item.reserved {
    background-color: #dc3545;
    border-color: #dc3545;
    color: white;
    cursor: not-allowed;
    opacity: 0.7;
}

.table-item.reserved:hover {
    transform: none;
    box-shadow: none;
}

.table-item.reserved .table-icon {
    opacity: 0.5;
}

.table-status {
    font-size: 0.8em;
    font-weight: bold;
    margin-top: 5px;
    padding: 3px 8px;
    border-radius: 10px;
    background-color: rgba(255,255,255,0.2);
}

.table-item.reserved .table-status {
    background-color: rgba(255,255,255,0.3);
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
    40% { transform: translateY(-10px); }
    60% { transform: translateY(-5px); }
}

@keyframes slideInRight {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

.table-icon {
    font-size: 2.5em;
    margin-bottom: 10px;
}

.table-number {
    font-size: 1.2em;
    font-weight: bold;
    margin-bottom: 5px;
}

.table-seats {
    font-size: 0.9em;
    opacity: 0.8;
}

/* VIP Room Styling */
.vip-room {
    margin-bottom: 30px;
}

.room-title {
    color: #ffd700;
    font-size: 1.5em;
    margin-bottom: 15px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
}

.vip-table {
    background-color: #fff3cd;
    border-color: #ffc107;
}

.vip-table:hover {
    border-color: #ffd700;
    background-color: #ffeaa7;
}

.vip-table.selected {
    background-color: #28a745;
    border-color: #28a745;
    color: white;
}

/* Reservation Form */
.booking-form {
    background-color: rgba(255,255,255,0.1);
    padding: 30px;
    border-radius: 15px;
    backdrop-filter: blur(10px);
    max-width: 1200px;
    margin: 0 auto;
}

.booking-form .row {
    margin-left: -15px;
    margin-right: -15px;
}

.booking-form .row > [class*="col-"] {
    padding-left: 15px;
    padding-right: 15px;
}

.booking-form .form-control,
.booking-form .custom-form-control {
    height: 45px;
    width: 100%;
}

.booking-form label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
}

.booking-form .mb-3 {
    margin-bottom: 1rem !important;
}

#selected-table-info {
    background-color: rgba(13, 202, 240, 0.2);
    border: 1px solid #0dcaf0;
    color: #0dcaf0;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 20px;
}

#book-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

/* Capacity Warning Styles */
.capacity-warning {
    margin-top: 5px;
    padding: 5px 10px;
    background-color: rgba(220, 53, 69, 0.1);
    border: 1px solid #dc3545;
    border-radius: 5px;
    animation: shake 0.5s ease-in-out;
}

.capacity-info {
    margin-top: 5px;
    padding: 5px 10px;
    background-color: rgba(13, 202, 240, 0.1);
    border: 1px solid #0dcaf0;
    border-radius: 5px;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

.capacity-warning small {
    font-weight: bold;
    display: flex;
    align-items: center;
    gap: 5px;
}

.capacity-info small {
    font-weight: bold;
    display: flex;
    align-items: center;
    gap: 5px;
}


/* Calendar Styles */
.calendar-container {
    background-color: rgba(255,255,255,0.1);
    padding: 20px;
    border-radius: 15px;
    backdrop-filter: blur(10px);
    max-width: 800px;
    margin: 0 auto;
}

.calendar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding: 0 10px;
}

.calendar-header h4 {
    margin: 0;
    color: #fff;
    font-size: 1.5em;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
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
    min-height: 60px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative;
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
    border: 2px solid #ffc107;
}

.calendar-day.reserved {
    background-color: rgba(220,53,69,0.3);
    border: 2px solid #dc3545;
}

.calendar-day.pending {
    background-color: rgba(255,193,7,0.3);
    border: 2px solid #ffc107;
}

.calendar-day.approved {
    background-color: rgba(40,167,69,0.3);
    border: 2px solid #28a745;
}

.calendar-day.cancelled {
    background-color: rgba(220,53,69,0.3);
    border: 2px solid #dc3545;
}

.calendar-day.available {
    background-color: rgba(108,117,125,0.3);
    border: 2px solid #6c757d;
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
    color: white;
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

.legend-color.reserved {
    background-color: rgba(40,167,69,0.3);
    border-color: #28a745;
}

.legend-color.today {
    background-color: rgba(255,193,7,0.3);
    border-color: #ffc107;
}

/* Status badge styles for public calendar */
.status-badge {
    display: inline-block;
    padding: 3px 8px;
    border-radius: 12px;
    font-size: 0.7em;
    font-weight: bold;
    color: white;
}

.status-badge.confirmed,
.status-badge.approved,
.status-badge.reserved {
    background-color: #28a745;
}

.status-badge.pending {
    background-color: #ffc107;
    color: #333;
}

.status-badge.cancelled {
    background-color: #dc3545;
}

/* Event Booking Button Styles */
.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    padding: 15px 30px;
    border-radius: 25px;
    font-weight: bold;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    color: white;
}


.qr-code-placeholder {
    border: 2px dashed #dee2e6;
}

/* Comprehensive Text Color Fixes for Better Readability */
.form-control, .custom-form-control {
    color: #333 !important;
    background-color: #ffffff !important;
    border: 2px solid #dee2e6 !important;
}

.form-control:focus, .custom-form-control:focus {
    color: #333 !important;
    background-color: #ffffff !important;
    border-color: #007bff !important;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
}

.form-control::placeholder, .custom-form-control::placeholder {
    color: #6c757d !important;
    opacity: 1;
}

/* Fix all text colors in forms */
label, .form-label {
    color: #333 !important;
    font-weight: 600;
}

.form-text, .form-help {
    color: #6c757d !important;
}

/* Fix button text colors */
.btn {
    color: #ffffff !important;
    font-weight: 600;
}

.btn-outline-light {
    color: #ffffff !important;
    border-color: #ffffff !important;
}

.btn-outline-light:hover {
    color: #000000 !important;
    background-color: #ffffff !important;
    border-color: #ffffff !important;
}

/* Fix alert text colors */
.alert {
    color: #333 !important;
}

.alert-info {
    background-color: #d1ecf1 !important;
    border-color: #bee5eb !important;
    color: #0c5460 !important;
}

.alert-success {
    background-color: #d4edda !important;
    border-color: #c3e6cb !important;
    color: #155724 !important;
}

.alert-danger {
    background-color: #f8d7da !important;
    border-color: #f5c6cb !important;
    color: #721c24 !important;
}

.alert-warning {
    background-color: #fff3cd !important;
    border-color: #ffeaa7 !important;
    color: #856404 !important;
}

/* Fix table text colors */
.table-item {
    color: #333 !important;
}

.table-number {
    color: #333 !important;
    font-weight: 700;
}

.table-seats {
    color: #666 !important;
}

.table-status {
    color: #ffffff !important;
    font-weight: 600;
}

/* Fix section headers */
.section-title, h2, h3, h4, h5, h6 {
    color: #333 !important;
}

/* Fix progress step colors */
.step-label {
    color: #6c757d !important;
}

.step.active .step-label {
    color: #007bff !important;
    font-weight: 600;
}

.step.completed .step-label {
    color: #28a745 !important;
    font-weight: 600;
}


/* Responsive Design */
@media (max-width: 768px) {
    .tables-grid {
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 15px;
        padding: 15px;
    }
    
    .section-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .section-btn {
        width: 200px;
        margin-bottom: 10px;
    }
    
    .table-item {
        min-height: 100px;
        padding: 15px;
    }
    
    .table-icon {
        font-size: 2em;
    }
    
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
            function addHoursToTime(timeStr, hoursToAdd) {
                if (!timeStr || typeof timeStr !== 'string') return '';
                const m = timeStr.match(/^(\d{1,2}):(\d{2})$/);
                if (!m) return '';
                const h = parseInt(m[1], 10);
                const min = parseInt(m[2], 10);
                if (!Number.isFinite(h) || !Number.isFinite(min)) return '';
                const base = new Date(2000, 0, 1, h, min, 0, 0);
                base.setHours(base.getHours() + (Number(hoursToAdd) || 0));
                const hh = String(base.getHours()).padStart(2, '0');
                const mm = String(base.getMinutes()).padStart(2, '0');
                return `${hh}:${mm}`;
            }

            function wireAutoTimeOut(timeInId, timeOutId, hoursToAdd) {
                const timeIn = document.getElementById(timeInId);
                const timeOut = document.getElementById(timeOutId);
                if (!timeIn || !timeOut) return;

                const update = function () {
                    const v = (timeIn.value || '').trim();
                    if (!v) {
                        timeOut.value = '';
                        return;
                    }

                    // Hard window: 10:00 AM to 9:00 PM only.
                    // With +4 hours Time Out, latest allowed Time In is 17:00 (5:00 PM).
                    const minIn = '10:00';
                    const maxIn = '17:00';
                    if (v < minIn || v > maxIn) {
                        alert('Reservation time must be between 10:00 AM and 5:00 PM (time out will be 4 hours later, up to 9:00 PM).');
                        timeIn.value = '';
                        timeOut.value = '';
                        return;
                    }
                    const computed = addHoursToTime(v, hoursToAdd);
                    timeOut.value = computed;
                };

                timeIn.addEventListener('input', update);
                timeIn.addEventListener('change', update);
                update(); // initial (supports old() values)
            }

            // Auto-resize Special Requests textarea fields
            function autoResize(el){
                el.style.height = 'auto';
                el.style.height = (el.scrollHeight) + 'px';
            }
            ['res_requests','guest_requests'].forEach(function(id){
                var el = document.getElementById(id);
                if(el){
                    autoResize(el);
                    el.addEventListener('input', function(){ autoResize(el); });
                }
            });

            // Table reservation: auto-set Time Out = Time In + 4 hours
            wireAutoTimeOut('res_time_in', 'res_time_out', 4);
            wireAutoTimeOut('guest_time_in', 'guest_time_out', 4);
    // Load real table status from database
    const realTableStatus = @json($tableStatus ?? []);
    let tableStatus = realTableStatus;
    // Merge in any admin-provided status from localStorage (takes precedence)
    try {
        const lsStatus = JSON.parse(localStorage.getItem('tableStatus') || 'null');
        if (lsStatus && typeof lsStatus === 'object') {
            tableStatus = Object.assign({}, tableStatus, lsStatus);
        }
    } catch (e) { /* ignore */ }

    // Fallback: fetch latest status from server in case page wasn't rendered with tableStatus
    async function loadLiveTableStatus() {
        try {
            const resp = await fetch('/table-status');
            const data = await resp.json();
            if (data && data.success && data.tableStatus) {
                // Merge server status with current (admin/local) status; admin/local wins if already set
                tableStatus = Object.assign({}, data.tableStatus, tableStatus);
                // Re-apply statuses to current DOM
                document.querySelectorAll('.table-item').forEach(el => {
                    const num = el.getAttribute('data-table');
                    const st = tableStatus[num] || 'available';
                    el.setAttribute('data-status', st);
                    el.classList.remove('available', 'reserved');
                    el.classList.add(st);
                    const statusEl = el.querySelector('.table-status');
                    if (statusEl) statusEl.textContent = st === 'available' ? 'Available' : 'Reserved';
                });
            }
        } catch (e) {
            console.log('Failed to load live table status', e);
        }
    }
    
    // Load complete table data from admin panel
    // ---- Admin-sourced data (tables/sections) ----
    // Normalize tables to an object map: { [tableNumber]: table }
    function normalizeTables(raw) {
        if (!raw) return {};
        // If saved as array, de-dupe by table.number
        if (Array.isArray(raw)) {
            return raw.reduce((acc, t) => {
                const num = t && (t.number || t.tableNumber);
                if (!num) return acc;
                acc[String(num).trim()] = {
                    ...t,
                    number: String(num).trim(),
                    seats: typeof t.seats === 'number' ? t.seats : (typeof t.paxCapacity === 'number' ? t.paxCapacity : t.seats),
                };
                return acc;
            }, {});
        }
        // If saved as object map already
        if (typeof raw === 'object') {
            const out = {};
            Object.keys(raw).forEach(k => {
                const t = raw[k];
                const num = (t && t.number) ? t.number : k;
                if (!num) return;
                out[String(num).trim()] = { ...t, number: String(num).trim() };
            });
            return out;
        }
        return {};
    }

    // Load tables from localStorage (admin is source of truth)
    let restaurantTables = normalizeTables(JSON.parse(localStorage.getItem('restaurantTables') || 'null'));

    // Default/canonical sections (guaranteed)
    const canonicalSections = {
        'hallway': { 
            name: 'Section A', 
            icon: '🪑', 
            value: 'hallway',
            image: '',
            capacity: '4 – 10 pax',
            inclusions: 'Standard setup with comfortable seating and full dining service.'
        },
        'top': { 
            name: 'Section B', 
            icon: '🪑', 
            value: 'top',
            image: '',
            capacity: '',
            inclusions: ''
        },
        'garden': { 
            name: 'Garden', 
            icon: '🌿', 
            value: 'garden',
            image: '',
            capacity: '',
            inclusions: ''
        },
        'vip': { 
            name: 'VIP Cabin Room', 
            icon: '👑', 
            value: 'vip',
            image: '',
            capacity: '',
            inclusions: ''
        }
    };

    // Optional: static fallback images per section (ensure these files exist)
    const sectionImageMap = {
        hallway: "{{ asset('assets/imgs/sections/section-a.jpg') }}", // Section A
        top: "{{ asset('assets/imgs/sections/section-b.jpg') }}",     // Section B
        vip: "{{ asset('assets/imgs/sections/vip-cabin.jpg') }}",     // VIP Cabin Room
        garden: "{{ asset('assets/imgs/sections/garden.jpg') }}"      // Garden
    };

    // Sections and order (prefer admin/localStorage, but keep canonical sections)
    let restaurantSections = { ...canonicalSections };
    let sectionOrder = Object.keys(restaurantSections);
    
    // Initialize table statuses and capacities
    function initializeTableStatuses() {
        // Load sections and tables from admin panel data
        loadSectionsFromAdminData();
        loadTablesFromAdminData();
        
        const tableItems = document.querySelectorAll('.table-item');
        tableItems.forEach(table => {
            const tableNumber = table.getAttribute('data-table');
            const status = tableStatus[tableNumber] || 'available';
            
            // Update status
            table.setAttribute('data-status', status);
            table.classList.remove('available', 'reserved', 'selected');
            table.classList.add(status);
            
            const statusElement = table.querySelector('.table-status');
            if (statusElement) {
                statusElement.textContent = status === 'available' ? 'Available' : 'Reserved';
            }
            
            // Update seat capacity from admin data
            if (restaurantTables[tableNumber]) {
                const seats = restaurantTables[tableNumber].seats || 8;
                table.setAttribute('data-seats', seats);
                
                const seatsElement = table.querySelector('.table-seats');
                if (seatsElement) {
                    seatsElement.textContent = `${seats} pax`;
                }
            }
        });
    }
    
    // Load sections from admin panel data
    function loadSectionsFromAdminData() {
        // Load from localStorage (admin-managed)
        let storedSections = null;
        let storedOrder = null;
        try {
            storedSections = JSON.parse(localStorage.getItem('restaurantSections') || 'null');
            storedOrder = JSON.parse(localStorage.getItem('sectionOrder') || 'null');
        } catch (e) { /* ignore */ }

        // Merge: stored sections + canonical (canonical always present)
        const merged = { ...(storedSections && typeof storedSections === 'object' ? storedSections : {}) };
        Object.keys(canonicalSections).forEach(k => {
            if (!merged[k]) {
                merged[k] = canonicalSections[k];
            } else {
                // Merge stored section with canonical, preserving stored fields (image, capacity, inclusions)
                merged[k] = {
                    ...canonicalSections[k],
                    ...merged[k], // Stored data takes precedence
                    name: merged[k].name || canonicalSections[k].name,
                    value: merged[k].value || canonicalSections[k].value || k
                };
            }
        });
        restaurantSections = merged;

        // Use stored order if valid; otherwise build from keys
        const keys = Object.keys(restaurantSections);
        if (Array.isArray(storedOrder) && storedOrder.length) {
            sectionOrder = storedOrder.filter(k => keys.includes(k));
            // append any missing keys
            keys.forEach(k => { if (!sectionOrder.includes(k)) sectionOrder.push(k); });
        } else {
            sectionOrder = keys;
        }

        renderSectionButtons();
    }
    
    // Load tables from admin panel data
    function loadTablesFromAdminData() {
        // Load tables from admin panel (localStorage)
        const adminTables = normalizeTables(JSON.parse(localStorage.getItem('restaurantTables') || 'null'));
        
        // If admin has created tables, use ONLY admin tables (admin is the source of truth)
        if (Object.keys(adminTables).length > 0) {
            restaurantTables = adminTables;
            console.log('Loaded tables from admin:', Object.keys(restaurantTables));
        } else {
            // No admin data - use defaults
            restaurantTables = {
                // Section A tables (A1–A4)
                'A1': { number: 'A1', section: 'hallway', seats: 8, status: 'available', description: 'Section A table' },
                'A2': { number: 'A2', section: 'hallway', seats: 8, status: 'available', description: 'Section A table' },
                'A3': { number: 'A3', section: 'hallway', seats: 8, status: 'available', description: 'Section A table' },
                'A4': { number: 'A4', section: 'hallway', seats: 8, status: 'available', description: 'Section A table' },

                // Section B tables (B1–B4)
                'B1': { number: 'B1', section: 'top', seats: 8, status: 'available', description: 'Section B table' },
                'B2': { number: 'B2', section: 'top', seats: 8, status: 'available', description: 'Section B table' },
                'B3': { number: 'B3', section: 'top', seats: 8, status: 'available', description: 'Section B table' },
                'B4': { number: 'B4', section: 'top', seats: 8, status: 'available', description: 'Section B table' },

                // Garden tables (G1–G4)
                'G1': { number: 'G1', section: 'garden', seats: 6, status: 'available', description: 'Garden table' },
                'G2': { number: 'G2', section: 'garden', seats: 6, status: 'available', description: 'Garden table' },
                'G3': { number: 'G3', section: 'garden', seats: 8, status: 'available', description: 'Garden table' },
                'G4': { number: 'G4', section: 'garden', seats: 8, status: 'available', description: 'Garden table' },

                // VIP Cabin Room Tables (3 rooms, 3 tables each)
                'V11': { number: 'V11', section: 'vip', seats: 8, status: 'available', room: 1, description: 'VIP Cabin Room 1' },
                'V12': { number: 'V12', section: 'vip', seats: 8, status: 'available', room: 1, description: 'VIP Cabin Room 1' },
                'V13': { number: 'V13', section: 'vip', seats: 8, status: 'available', room: 1, description: 'VIP Cabin Room 1' },
                'V21': { number: 'V21', section: 'vip', seats: 8, status: 'available', room: 2, description: 'VIP Cabin Room 2' },
                'V22': { number: 'V22', section: 'vip', seats: 8, status: 'available', room: 2, description: 'VIP Cabin Room 2' },
                'V23': { number: 'V23', section: 'vip', seats: 8, status: 'available', room: 2, description: 'VIP Cabin Room 2' },
                'V31': { number: 'V31', section: 'vip', seats: 8, status: 'available', room: 3, description: 'VIP Cabin Room 3' },
                'V32': { number: 'V32', section: 'vip', seats: 8, status: 'available', room: 3, description: 'VIP Cabin Room 3' },
                'V33': { number: 'V33', section: 'vip', seats: 8, status: 'available', room: 3, description: 'VIP Cabin Room 3' }
            };
            console.log('Using default tables (no admin data)');
        }
        
        // Render all sections with the loaded data
        renderAllTableSections();
    }
    
    // Resolve the order of sections for rendering
    function getOrderedSectionKeys() {
        const keys = Object.keys(restaurantSections);
        if (Array.isArray(sectionOrder) && sectionOrder.length) {
            const filtered = sectionOrder.filter(k => keys.includes(k));
            const remaining = keys.filter(k => !filtered.includes(k));
            // de-dupe keys just in case
            return Array.from(new Set(filtered.concat(remaining)));
        }
        return Array.from(new Set(keys));
    }

    // Helper function to check if emoji should be removed from a section
    function shouldRemoveEmoji(sectionKey, sectionName) {
        const nameLower = (sectionName || '').toLowerCase();
        const keyLower = (sectionKey || '').toLowerCase();
        
        return keyLower === 'vip' || 
               keyLower === 'garden' ||
               keyLower === 'a' ||
               keyLower === 'b' ||
               nameLower.includes('section a') ||
               nameLower.includes('section b') ||
               nameLower.includes('grazing table') ||
               nameLower.includes('grazing');
    }
    
    // Render section buttons
    function renderSectionButtons() {
        const sectionButtonsContainer = document.getElementById('section-buttons');
        if (!sectionButtonsContainer) return;
        
        // Clear existing buttons except calendar
        const calendarButton = sectionButtonsContainer.querySelector('[data-section="calendar"]');
        sectionButtonsContainer.innerHTML = '';
        
        // Add section buttons
        // de-dupe by displayed section name to avoid duplicates in UI
        const usedNames = new Set();
        getOrderedSectionKeys().forEach(sectionKey => {
            const section = restaurantSections[sectionKey];
            if (!section) return;
            const nameKey = String(section.name || sectionKey).toLowerCase();
            if (usedNames.has(nameKey)) return;
            usedNames.add(nameKey);
            const button = document.createElement('button');
            button.className = 'btn btn-primary section-btn';
            button.setAttribute('data-section', sectionKey);
            const displayText = shouldRemoveEmoji(sectionKey, section.name) 
                ? section.name 
                : `${section.icon} ${section.name}`;
            button.innerHTML = displayText;
            sectionButtonsContainer.appendChild(button);
        });
        
        // Add calendar button back
        if (calendarButton) {
            sectionButtonsContainer.appendChild(calendarButton);
        }

        // Re-setup section button event listeners
        setupSectionButtonListeners();
    }
    
    // Render all table sections dynamically
    function renderAllTableSections() {
        const container = document.getElementById('dynamic-sections-container');
        if (!container) return;
        
        container.innerHTML = '';
        
        // Create sections dynamically
        const usedNames = new Set();
        getOrderedSectionKeys().forEach(sectionKey => {
            const section = restaurantSections[sectionKey];
            if (!section) return;
            const nameKey = String(section.name || sectionKey).toLowerCase();
            if (usedNames.has(nameKey)) return;
            usedNames.add(nameKey);
            const sectionDiv = document.createElement('div');
            sectionDiv.id = `${sectionKey}-section`;
            sectionDiv.className = 'restaurant-section';

            const sectionHeader = shouldRemoveEmoji(sectionKey, section.name) 
                ? section.name 
                : `${section.icon} ${section.name}`;
            
            sectionDiv.innerHTML = `
                <h3 class="mb-4">${sectionHeader}</h3>
                <div class="section-info-card" id="${sectionKey}-section-info">
                    <!-- Section image + inclusions will be populated when section is selected -->
                </div>
                <div class="tables-grid" id="${sectionKey}-section-tables">
                    <!-- Tables will be populated by JavaScript -->
                </div>
            `;
            
            container.appendChild(sectionDiv);
        });
        
        // Render tables for each section
        getOrderedSectionKeys().forEach(sectionKey => {
            renderSectionTables(sectionKey);
        });
    }
    
    // Get unique tables for a specific section
    function getSectionTables(sectionKey) {
        const seenTableNumbers = new Set();
        return Object.values(restaurantTables)
            .filter(table => table && table.section === sectionKey)
            .filter(table => {
                const num = String(table.number || '').trim();
                if (!num) return false;
                if (seenTableNumbers.has(num)) return false;
                seenTableNumbers.add(num);
                return true;
            });
    }
    
    // Render tables for a specific section
    function renderSectionTables(sectionKey) {
        const sectionTablesContainer = document.getElementById(`${sectionKey}-section-tables`);
        if (!sectionTablesContainer) return;
        
        sectionTablesContainer.innerHTML = '';
        
        // Get tables for this section
        const sectionTables = getSectionTables(sectionKey);
        
        if (sectionTables.length === 0) {
            sectionTablesContainer.innerHTML = '<p class="text-center">No tables available in this section.</p>';
            return;
        }
        
        // Special handling for VIP sections (group by room)
        if (sectionKey === 'vip') {
            const vipRooms = {};
            sectionTables.forEach(table => {
                const roomNum = table.room || 1;
                if (!vipRooms[roomNum]) {
                    vipRooms[roomNum] = [];
                }
                vipRooms[roomNum].push(table);
            });
            
            // Create room sections
            Object.keys(vipRooms).forEach(roomNum => {
                const roomDiv = document.createElement('div');
                roomDiv.className = 'vip-room mb-4';
                roomDiv.innerHTML = `<h4 class="room-title">Room ${roomNum}</h4>`;
                
                const roomTablesDiv = document.createElement('div');
                roomTablesDiv.className = 'tables-grid vip-tables';
                
                vipRooms[roomNum].forEach(table => {
                    const tableElement = createTableElement(table, true);
                    roomTablesDiv.appendChild(tableElement);
                });
                
                roomDiv.appendChild(roomTablesDiv);
                sectionTablesContainer.appendChild(roomDiv);
            });
        } else {
            // Regular section - just add tables
            sectionTables.forEach(table => {
                const tableElement = createTableElement(table);
                sectionTablesContainer.appendChild(tableElement);
            });
        }
        
        // Setup table selection for newly created tables
        setupTableSelection();
    }
    
    // Setup section button event listeners
    function setupSectionButtonListeners() {
        const sectionButtons = document.querySelectorAll('.section-btn');
        
        sectionButtons.forEach(button => {
            // Remove existing event listeners to avoid duplicates
            button.removeEventListener('click', handleSectionButtonClick);
            button.addEventListener('click', handleSectionButtonClick);
        });
    }
    
    function handleSectionButtonClick() {
        const targetSection = this.getAttribute('data-section');
        
        // Remove active class from all buttons and sections
        document.querySelectorAll('.section-btn').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.restaurant-section').forEach(section => section.classList.remove('active'));
        
        // Add active class to clicked button and corresponding section
        this.classList.add('active');
        const targetSectionElement = document.getElementById(targetSection + '-section');
        if (targetSectionElement) {
            targetSectionElement.classList.add('active');
        }
        
        // Clear any selected table when switching sections
        clearTableSelection();
        
        // Initialize calendar if calendar section is selected
        if (targetSection === 'calendar') {
            initializeCalendar();
        } else {
            // Ensure tables and section info for the chosen section are rendered
            renderSectionTables(targetSection);
            updateSectionInfo(targetSection);
        }
    }

    // Update the section info card (image + inclusions) for a section
    function updateSectionInfo(sectionKey) {
        const infoCard = document.getElementById(`${sectionKey}-section-info`);
        if (!infoCard) return;

        const sectionTables = getSectionTables(sectionKey);

        if (!sectionTables.length) {
            infoCard.style.display = 'none';
            infoCard.innerHTML = '';
            return;
        }

        // Get section data from localStorage (includes image, capacity, inclusions from admin)
        const section = restaurantSections[sectionKey] || {};
        const sectionName = section.name || sectionKey;
        
        // PRIORITY: Use section image from admin (localStorage) FIRST
        // This is the image uploaded from admin panel
        let imageUrl = '';
        if (section.image && typeof section.image === 'string' && section.image.trim()) {
            imageUrl = section.image.trim();
        } else {
            // Fallback: check table images
            for (const t of sectionTables) {
                if (typeof t.image_url === 'string' && t.image_url.trim()) {
                    imageUrl = t.image_url.trim();
                    break;
                }
                if (typeof t.image === 'string' && t.image.trim()) {
                    imageUrl = t.image.trim();
                    break;
                }
                if (typeof t.photo === 'string' && t.photo.trim()) {
                    imageUrl = t.photo.trim();
                    break;
                }
            }
            // If no per-table image, fall back to static section image
            if (!imageUrl && sectionImageMap[sectionKey]) {
                imageUrl = sectionImageMap[sectionKey];
            }
        }
        
        // Use section capacity if available, otherwise derive from tables
        let capacityText = section.capacity || '';
        if (!capacityText) {
            const capacities = sectionTables
                .map(t => {
                    const seats = typeof t.seats === 'number' ? t.seats :
                                  typeof t.paxCapacity === 'number' ? t.paxCapacity : null;
                    return seats;
                })
                .filter(v => v && !isNaN(v));

            if (capacities.length) {
                const minCap = Math.min.apply(null, capacities);
                const maxCap = Math.max.apply(null, capacities);
                capacityText = minCap === maxCap ? `${minCap} pax` : `${minCap} – ${maxCap} pax`;
            } else {
                capacityText = 'N/A';
            }
        }

        // Use section inclusions if available, otherwise derive from tables
        let inclusionsText = section.inclusions || '';
        if (!inclusionsText) {
            for (const t of sectionTables) {
                if (Array.isArray(t.inclusions) && t.inclusions.length) {
                    inclusionsText = t.inclusions.join(', ');
                    break;
                }
                if (typeof t.inclusions === 'string' && t.inclusions.trim()) {
                    inclusionsText = t.inclusions.trim();
                    break;
                }
                if (typeof t.inclusion === 'string' && t.inclusion.trim()) {
                    inclusionsText = t.inclusion.trim();
                    break;
                }
                if (typeof t.description === 'string' && t.description.trim()) {
                    inclusionsText = t.description.trim();
                }
            }
            if (!inclusionsText) {
                inclusionsText = 'Standard setup with comfortable seating and full dining service.';
            }
        }

        infoCard.innerHTML = `
            <div class="section-info-grid">
                <div class="section-info-image">
                    ${
                        imageUrl
                            ? `<img src="${imageUrl}" alt="${sectionName}">`
                            : `<div class="section-info-placeholder">🪑</div>`
                    }
                </div>
                <div class="section-info-details text-left">
                    <h4>${sectionName}</h4>
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <th>Capacity</th>
                            <td>${capacityText}</td>
                        </tr>
                        <tr>
                            <th>Inclusions</th>
                            <td>${inclusionsText}</td>
                        </tr>
                    </table>
                </div>
            </div>
        `;

        infoCard.style.display = 'block';
    }
    
    // Create table element
    function createTableElement(table, isVip = false) {
        const tableDiv = document.createElement('div');
        const status = tableStatus[table.number] || table.status || 'available';
        const seats = table.seats || 8;
        const section = table.section || '';
        
        tableDiv.className = `table-item ${isVip ? 'vip-table' : ''} ${status}`;
        tableDiv.setAttribute('data-table', table.number);
        tableDiv.setAttribute('data-seats', seats);
        tableDiv.setAttribute('data-status', status);
        tableDiv.setAttribute('data-section', section);
        
        tableDiv.innerHTML = `
            <div class="table-icon">🪑</div>
            <div class="table-number">${table.number}</div>
            <div class="table-seats">${seats} pax</div>
            <div class="table-status">${status === 'available' ? 'Available' : 'Reserved'}</div>
        `;
        
        return tableDiv;
    }
    
    // Initialize on page load
    initializeTableStatuses();
    loadLiveTableStatus();
    setupRealTimeUpdates();
    
    // Periodically check for table updates from admin (every 2 seconds)
    setInterval(function() {
        const adminTables = normalizeTables(JSON.parse(localStorage.getItem('restaurantTables') || 'null'));
        const currentCount = Object.keys(restaurantTables).length;
        const adminCount = Object.keys(adminTables).length;
        
        // If admin has more/different tables, reload
        if (adminCount > 0 && (adminCount !== currentCount || JSON.stringify(adminTables) !== JSON.stringify(restaurantTables))) {
            console.log('Admin tables changed, reloading...');
            restaurantTables = adminTables;
            renderAllTableSections();
        }
    }, 2000);
    
    // Real-time table status updates
    function setupRealTimeUpdates() {
        console.log('Setting up real-time updates...');
        
        // Listen for table status updates from admin (compat old event)
        window.addEventListener('tableStatusUpdated', function(event) {
            console.log('Received table status update event:', event.detail);
            const updateData = event.detail;
            updateTableStatus(updateData.table_number, updateData.status);
        });

        // Listen for tableStatusChanged (admin dispatches this on save)
        window.addEventListener('tableStatusChanged', function(event) {
            try {
                const statusMap = (event.detail && event.detail.tableStatus) ? event.detail.tableStatus : null;
                if (statusMap) {
                    tableStatus = Object.assign({}, tableStatus, statusMap);
                    // Apply all statuses
                    Object.keys(statusMap).forEach(num => updateTableStatus(num, statusMap[num]));
                }
            } catch (e) { console.error('error processing tableStatusChanged', e); }
        });
        
        // Check for updates in localStorage (fallback)
        setInterval(checkForTableUpdates, 1000); // Check every second
        
        // Listen for storage events (when admin updates from another tab)
        window.addEventListener('storage', function(event) {
            console.log('Storage event detected:', event.key);
            if (event.key === 'tableStatusUpdate') {
                try {
                    const updateData = JSON.parse(event.newValue);
                    console.log('Processing storage update:', updateData);
                    updateTableStatus(updateData.table_number, updateData.status);
                } catch (error) {
                    console.error('Error parsing storage update:', error);
                }
            }
        });
        
        // Also listen for custom events from admin panel
        window.addEventListener('message', function(event) {
            if (event.data && event.data.type === 'tableStatusUpdate') {
                console.log('Received message update:', event.data);
                updateTableStatus(event.data.table_number, event.data.status);
            }
        });
    }
    
    // Check for table updates in localStorage
    function checkForTableUpdates() {
        const updateData = localStorage.getItem('tableStatusUpdate');
        if (updateData) {
            try {
                const update = JSON.parse(updateData);
                updateTableStatus(update.table_number, update.status);
                localStorage.removeItem('tableStatusUpdate'); // Clear after processing
            } catch (error) {
                console.error('Error parsing table update:', error);
            }
        }
    }
    
    // Update table status in the UI
    function updateTableStatus(tableNumber, status) {
        const tableElement = document.querySelector(`[data-table="${tableNumber}"]`);
        if (tableElement) {
            // Update the table status
            tableElement.setAttribute('data-status', status);
            
            // Update the visual appearance
            const isVip = tableElement.classList.contains('vip-table');
            tableElement.className = `table-item ${isVip ? 'vip-table' : ''} ${status}`;
            
            // Update the status text
            const statusElement = tableElement.querySelector('.table-status');
            if (statusElement) {
                statusElement.textContent = status === 'available' ? 'Available' : 'Reserved';
                statusElement.className = `table-status ${status}`;
            }
            
            // Update the global table status
            tableStatus[tableNumber] = status;
            
            // Show update notification
            showTableStatusUpdateNotification(tableNumber, status);
        }
    }
    
    // Listen for table data changes from admin panel
    window.addEventListener('tableDataChanged', function(event) {
        console.log('Table data changed event received:', event.detail);
        if (event.detail && event.detail.tableData) {
            restaurantTables = event.detail.tableData;
            renderAllTableSections();
        }
    });
    
    // Listen for section data changes from admin panel (ignore - use fixed sections only)
    window.addEventListener('sectionDataChanged', function(event) {
        console.log('Section data changed event received:', event.detail);
        // Prefer event payload, but keep canonical sections
        try {
            if (event.detail && event.detail.sectionData && typeof event.detail.sectionData === 'object') {
                restaurantSections = { ...event.detail.sectionData };
                Object.keys(canonicalSections).forEach(k => {
                    if (!restaurantSections[k]) restaurantSections[k] = canonicalSections[k];
                });
            }
            if (event.detail && Array.isArray(event.detail.sectionOrder)) {
                sectionOrder = event.detail.sectionOrder;
            }
        } catch (e) {
            console.error('Error processing sectionDataChanged:', e);
        }
        renderSectionButtons();
        renderAllTableSections();
    });
    
    // Listen for storage changes (when admin adds new tables or sections)
    window.addEventListener('storage', function(event) {
        if (event.key === 'restaurantTables') {
            console.log('Restaurant tables updated from admin panel');
            try {
                const updatedTables = JSON.parse(event.newValue);
                if (updatedTables) {
                    restaurantTables = updatedTables;
                    renderAllTableSections();
                }
            } catch (error) {
                console.error('Error parsing updated restaurant tables:', error);
            }
        } else if (event.key === 'restaurantSections' || event.key === 'sectionOrder') {
            console.log('Section update from admin panel detected');
            // Reload sections + order and re-render
            loadSectionsFromAdminData();
            renderAllTableSections();
        } else if (event.key === 'tableStatus') {
            console.log('Table status map updated from admin panel');
            try {
                const lsStatus = JSON.parse(event.newValue || 'null');
                if (lsStatus && typeof lsStatus === 'object') {
                    tableStatus = Object.assign({}, tableStatus, lsStatus);
                    Object.keys(lsStatus).forEach(num => updateTableStatus(num, lsStatus[num]));
                }
            } catch (error) {
                console.error('Error parsing updated table status map:', error);
            }
        }
    });
    
    // Show notification when table status changes
    function showTableStatusUpdateNotification(tableNumber, status) {
        const notification = document.createElement('div');
        notification.className = 'table-status-notification';
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${status === 'available' ? '#28a745' : '#dc3545'};
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            z-index: 9999;
            font-weight: bold;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            animation: slideInRight 0.3s ease-out;
        `;
        
        notification.innerHTML = `
            ${status === 'available' ? '✅' : '❌'} Table ${tableNumber} is now ${status}
        `;
        
        // Add animation styles
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        `;
        document.head.appendChild(style);
        
        document.body.appendChild(notification);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            if (notification.parentElement) {
                notification.style.animation = 'slideInRight 0.3s ease-out reverse';
                setTimeout(() => {
                    if (notification.parentElement) {
                        notification.remove();
                    }
                }, 300);
            }
        }, 3000);
    }
    
    // Section switching functionality is now handled by setupSectionButtonListeners()
    
    // Table selection functionality
    let selectedTable = null;
    
    // Setup table selection for dynamically created tables
    function setupTableSelection() {
        const tableItems = document.querySelectorAll('.table-item');
        
        tableItems.forEach(table => {
            // Remove existing event listeners to avoid duplicates
            table.removeEventListener('click', handleTableClick);
            table.addEventListener('click', handleTableClick);
        });
    }
    
    function handleTableClick() {
        const status = this.getAttribute('data-status');
        
        // Don't allow selection of reserved tables (no popup)
        if (status === 'reserved') {
            return;
        }
        
        // Remove selected class from all tables
        const allTableItems = document.querySelectorAll('.table-item');
        allTableItems.forEach(t => t.classList.remove('selected'));
        
        // Add selected class to clicked table
        this.classList.add('selected');
        
        // Get table information
        const tableNumber = this.getAttribute('data-table');
        const seats = this.getAttribute('data-seats');
        const sectionKey = this.getAttribute('data-section');
        
        // Get section name from restaurantSections
        const sectionName = sectionKey && restaurantSections[sectionKey] 
            ? restaurantSections[sectionKey].name 
            : '';
        
        selectedTable = {
            number: tableNumber,
            seats: seats,
            status: status,
            section: sectionKey,
            sectionName: sectionName
        };
        
        // Update form
        updateReservationForm(tableNumber, seats, sectionKey, sectionName);
        
        // Removed popup alert for selection
    }
    
    function updateReservationForm(tableNumber, seats, sectionKey, sectionName) {
        document.getElementById('table_number').value = tableNumber;
        
        // Update section fields
        const tableSectionInput = document.getElementById('table_section');
        const tableSectionInputGuest = document.getElementById('table_section_guest');
        if (tableSectionInput) {
            tableSectionInput.value = sectionName || '';
        }
        if (tableSectionInputGuest) {
            tableSectionInputGuest.value = sectionName || '';
        }
        
        // Update display with table number and section
        const displayText = sectionName 
            ? `Table ${tableNumber} - ${sectionName} (${seats} pax)`
            : `Table ${tableNumber} (${seats} pax)`;
        document.getElementById('selected-table-name').textContent = displayText;
        document.getElementById('selected-table-info').style.display = 'block';
        document.getElementById('book-btn').disabled = false;
        
        // Update guest input max value and capacity info
        const guestInputs = document.querySelectorAll('input[name="guest"]');
        guestInputs.forEach(guestInput => {
            guestInput.max = seats;
            guestInput.setAttribute('data-table-capacity', seats);
        });
        
        // Show capacity info
        showCapacityInfo(seats);
        
        // Validate current guest count
        validateGuestCapacity();
    }
    
    function showCapacityInfo(capacity) {
        // Show capacity info for both forms
        const capacityInfoElements = document.querySelectorAll('#capacity-info, #capacity-info-guest');
        const capacityDisplayElements = document.querySelectorAll('#table-capacity-display, #table-capacity-display-guest');
        
        capacityInfoElements.forEach(element => {
            element.style.display = 'block';
        });
        
        capacityDisplayElements.forEach(element => {
            element.textContent = capacity;
        });
    }
    
    function validateGuestCapacity() {
        const guestInputs = document.querySelectorAll('input[name="guest"]');
        const capacityWarnings = document.querySelectorAll('#capacity-warning, #capacity-warning-guest');
        
        guestInputs.forEach((guestInput, index) => {
            const guestCount = parseInt(guestInput.value) || 0;
            const tableCapacity = parseInt(guestInput.getAttribute('data-table-capacity')) || 8;
            const warningElement = capacityWarnings[index];
            
            if (guestCount > tableCapacity) {
                // Show warning
                warningElement.style.display = 'block';
                guestInput.style.borderColor = '#dc3545';
                guestInput.style.backgroundColor = 'rgba(220, 53, 69, 0.1)';
                
                // Disable reservation button
                const bookBtn = document.getElementById('book-btn');
                if (bookBtn) {
                    bookBtn.disabled = true;
                }
            } else {
                // Hide warning
                warningElement.style.display = 'none';
                guestInput.style.borderColor = '';
                guestInput.style.backgroundColor = '';
                
                // Enable reservation button if table is selected
                const bookBtn = document.getElementById('book-btn');
                if (bookBtn && selectedTable) {
                    bookBtn.disabled = false;
                }
            }
        });
    }
    
    
    // Removed intrusive selection popup function
    function showTableSelectionAlert() { return; }
    
    // Removed intrusive reserved popup function
    function showReservedTableAlert() { return; }
    
    function clearTableSelection() {
        const allTableItems = document.querySelectorAll('.table-item');
        allTableItems.forEach(t => t.classList.remove('selected'));
        document.getElementById('selected-table-info').style.display = 'none';
        document.getElementById('book-btn').disabled = true;
        document.getElementById('table_number').value = '';
        selectedTable = null;
        
        // Clear capacity warnings and info
        const capacityWarnings = document.querySelectorAll('#capacity-warning, #capacity-warning-guest');
        const capacityInfos = document.querySelectorAll('#capacity-info, #capacity-info-guest');
        
        capacityWarnings.forEach(warning => {
            warning.style.display = 'none';
        });
        
        capacityInfos.forEach(info => {
            info.style.display = 'none';
        });
        
        // Reset guest input styling
        const guestInputs = document.querySelectorAll('input[name="guest"]');
        guestInputs.forEach(guestInput => {
            guestInput.style.borderColor = '';
            guestInput.style.backgroundColor = '';
            guestInput.removeAttribute('data-table-capacity');
        });
        
        // Clear section fields
        const tableSectionInput = document.getElementById('table_section');
        const tableSectionInputGuest = document.getElementById('table_section_guest');
        if (tableSectionInput) {
            tableSectionInput.value = '';
        }
        if (tableSectionInputGuest) {
            tableSectionInputGuest.value = '';
        }
    }
    
    
    // Event listeners for capacity validation
    const guestInputs = document.querySelectorAll('input[name="guest"]');
    guestInputs.forEach(guestInput => {
        guestInput.addEventListener('input', validateGuestCapacity);
        guestInput.addEventListener('change', validateGuestCapacity);
    });
    
    // Phone number: digits only, max 11
    const phoneInputs = document.querySelectorAll('#res_phone, #guest_phone');
    phoneInputs.forEach(function(phoneInput) {
        if (!phoneInput) return;
        phoneInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').slice(0, 11);
        });
        phoneInput.addEventListener('paste', function(e) {
            e.preventDefault();
            const pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '').slice(0, 11);
            this.value = pasted;
        });
    });
    
    // Form validation
    const bookingForm = document.getElementById('booking-form');
    if (bookingForm) {
        bookingForm.addEventListener('submit', function(e) {
            console.log('Form submission started');
            console.log('Selected table:', selectedTable);
            
            if (!selectedTable) {
                e.preventDefault();
                alert('Please select a table first!');
                return false;
            }
            
            // Validate capacity
            const guestInput = document.querySelector('input[name="guest"]');
            if (guestInput) {
                const guestCount = parseInt(guestInput.value) || 0;
                const tableCapacity = parseInt(guestInput.getAttribute('data-table-capacity')) || 8;
                
                if (guestCount > tableCapacity) {
                    e.preventDefault();
                    // Capacity warning is shown inline; avoid intrusive popup
                    return false;
                }
            }
            
            // Validate phone: exactly 11 digits
            const phoneInput = bookingForm.querySelector('input[name="phone"]');
            if (phoneInput && phoneInput.value) {
                const phone = phoneInput.value.replace(/\D/g, '');
                if (phone.length !== 11) {
                    e.preventDefault();
                    alert('Phone number must be exactly 11 digits.');
                    phoneInput.focus();
                    return false;
                }
            }
            
            // If all validations pass, allow form submission
            console.log('All validations passed, submitting form...');
            
            // Show loading state
            const submitBtn = document.getElementById('book-btn');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '⏳ Processing...';
            }
            
            // Show immediate success message
            setTimeout(() => {
                const successAlert = document.createElement('div');
                successAlert.className = 'alert alert-success alert-dismissible fade show';
                successAlert.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                successAlert.innerHTML = `
                    <i class="fas fa-check-circle mr-2"></i>
                    <strong>Success!</strong> Your reservation is being processed...
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                `;
                document.body.appendChild(successAlert);
                
                // Auto remove after 5 seconds
                setTimeout(() => {
                    if (successAlert.parentElement) {
                        successAlert.remove();
                    }
                }, 5000);
            }, 1000);
            
            return true;
        });
    }
    
    // Removed intrusive capacity exceeded popup function
    function showCapacityExceededAlert() { return; }
    
    // Calendar functionality
    let currentDate = new Date();
    // Load all reservations (approved, pending, paid, and cancelled events)
    let initialReservations = @json($reservations ?: []);
    let reservations = {};
    Object.keys(initialReservations).forEach(date => {
        const visibleReservations = initialReservations[date].filter(r => {
            const rawStatus = r.status || 'pending';
            const status = String(rawStatus).toLowerCase();
            return (
                status === 'approved' ||
                status === 'confirmed' ||
                status === 'pending' ||
                status === 'paid' ||
                status === 'cancelled'
            );
        });
        if (visibleReservations.length > 0) {
            reservations[date] = visibleReservations;
        }
    });
    
    // Track dates that are fully blocked due to whole-day event bookings
    const fullyBlockedDates = new Set();

    function isWholeDayEventBooking(reservation) {
        if (!isEventBooking(reservation)) return false;

        const status = String(reservation.status || 'pending').toLowerCase();
        // Cancelled events should not block the date
        if (status === 'cancelled') return false;

        const start = reservation.time_in || reservation.time || null;
        const end = reservation.time_out || null;
        const startIsNA = !start || start === 'N/A';
        const endIsNA = !end || end === 'N/A';

        // If both start and end are missing/N.A, treat as whole-day event
        if (startIsNA && endIsNA) {
            return true;
        }

        // Fallback: use the human-readable range text
        const rangeText = getEventTimeRange(reservation);
        return String(rangeText).toLowerCase().includes('whole day');
    }

    function recomputeFullyBlockedDates() {
        fullyBlockedDates.clear();
        Object.keys(reservations).forEach(date => {
            const dayReservations = reservations[date] || [];
            const hasWholeDayEvent = dayReservations.some(r => isWholeDayEventBooking(r));
            if (hasWholeDayEvent) {
                fullyBlockedDates.add(date);
            }
        });
    }

    // Initialize fully blocked dates from initial data
    recomputeFullyBlockedDates();

    // Prevent booking on fully blocked dates in the table reservation form
    const dateInputs = document.querySelectorAll('#res_date, #guest_date');
    dateInputs.forEach(input => {
        if (!input) return;
        input.addEventListener('change', function () {
            const selectedDate = this.value; // YYYY-MM-DD
            if (!selectedDate) return;
            if (fullyBlockedDates.has(selectedDate)) {
                alert('This date is fully booked for an event. Please choose another date.');
                this.value = '';
                const timeInputId = this.id === 'res_date' ? 'res_time_in' : 'guest_time_in';
                const timeInput = document.getElementById(timeInputId);
                if (timeInput) {
                    timeInput.value = '';
                }
                        const timeOutId = this.id === 'res_date' ? 'res_time_out' : 'guest_time_out';
                        const timeOut = document.getElementById(timeOutId);
                        if (timeOut) {
                            timeOut.value = '';
                        }
            }
        });
    });
    
    function initializeCalendar() {
        renderCalendar();
        recomputeFullyBlockedDates();
        setupCalendarNavigation();
        // Start polling for updates every 10 seconds for faster updates
        setInterval(refreshReservations, 10000);
        
        // Listen for localStorage changes (when admin updates reservations)
        window.addEventListener('storage', function(e) {
            if (e.key === 'adminReservations') {
                console.log('Admin reservations updated, refreshing calendar...');
                refreshReservations();
            }
        });
        
        // Listen for custom reservation update events
        window.addEventListener('reservationUpdated', function(e) {
            console.log('Reservation update event received, refreshing calendar...');
            if (e.detail && e.detail.reservations) {
                // Filter to include approved and pending reservations
                reservations = filterVisibleReservations(e.detail.reservations);
                recomputeFullyBlockedDates();
                renderCalendar();
            }
        });
        
        // Also check for updates immediately on page load
        refreshReservations();
    }
    
    // Function to filter reservations to show approved, pending, paid, and cancelled ones
    function filterVisibleReservations(reservationsData) {
        const filtered = {};
        Object.keys(reservationsData).forEach(date => {
            const visibleReservations = reservationsData[date].filter(r => {
                const rawStatus = r.status || 'pending';
                const status = String(rawStatus).toLowerCase();
                return (
                    status === 'approved' ||
                    status === 'confirmed' ||
                    status === 'pending' ||
                    status === 'paid' ||
                    status === 'cancelled'
                );
            });
            if (visibleReservations.length > 0) {
                filtered[date] = visibleReservations;
            }
        });
        return filtered;
    }
    
    // Function to refresh reservations data
    function refreshReservations() {
        // First check localStorage for admin updates
        const adminReservations = localStorage.getItem('adminReservations');
        if (adminReservations) {
            try {
                const adminData = JSON.parse(adminReservations);
                // Filter to include approved and pending reservations
                const filteredAdminData = filterVisibleReservations(adminData);
                // Merge admin data with current reservations
                Object.keys(filteredAdminData).forEach(date => {
                    if (reservations[date]) {
                        // Update existing reservations with admin data
                        reservations[date] = filteredAdminData[date];
                    } else {
                        // Add new reservations from admin
                        reservations[date] = filteredAdminData[date];
                    }
                });
                // Also filter existing reservations
                reservations = filterVisibleReservations(reservations);
                recomputeFullyBlockedDates();
                renderCalendar(); // Re-render calendar with updated data
                return; // Exit early if we got data from localStorage
            } catch (e) {
                console.log('Error parsing admin reservations from localStorage:', e);
            }
        }
        
        // Fallback to API if no localStorage data
        fetch('/api/reservations/calendar')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Filter to include approved and pending reservations
                    reservations = filterVisibleReservations(data.reservations);
                    recomputeFullyBlockedDates();
                    renderCalendar(); // Re-render calendar with updated data
                }
            })
            .catch(error => {
                console.log('Error refreshing reservations:', error);
            });
    }
    
    function renderCalendar() {
        const calendarGrid = document.getElementById('calendar-grid');
        const currentMonthYear = document.getElementById('current-month-year');
        
        // Update month/year display
        const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
                           'July', 'August', 'September', 'October', 'November', 'December'];
        currentMonthYear.textContent = `${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}`;
        
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
        const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
        const lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
        const daysInMonth = lastDay.getDate();
        const startingDayOfWeek = firstDay.getDay();
        
        // Add empty cells for days before the first day of the month
        for (let i = 0; i < startingDayOfWeek; i++) {
            const emptyDay = document.createElement('div');
            emptyDay.className = 'calendar-day other-month';
            emptyDay.innerHTML = `
                <div class="calendar-day-number">${new Date(currentDate.getFullYear(), currentDate.getMonth(), -startingDayOfWeek + i + 1).getDate()}</div>
            `;
            calendarGrid.appendChild(emptyDay);
        }
        
        // Add days of the month
        for (let day = 1; day <= daysInMonth; day++) {
            const dayElement = document.createElement('div');
            const dateStr = formatDate(new Date(currentDate.getFullYear(), currentDate.getMonth(), day));
            const dayReservations = reservations[dateStr] || [];
            const hasEventBooking = dayReservations.some(r => isEventBooking(r));
            const hasWholeDayEventBooking = dayReservations.some(r => isWholeDayEventBooking(r));
            
            let dayClass = 'calendar-day';
            // Removed 'today' class - no longer highlighting today
            
            // Determine status based on reservations
            if (dayReservations.length > 0) {
                const hasPending = dayReservations.some(r => {
                    const status = String(r.status || 'pending').toLowerCase();
                    return status === 'pending';
                });
                const hasApproved = dayReservations.some(r => {
                    const status = String(r.status || 'pending').toLowerCase();
                    return (
                        status === 'approved' ||
                        status === 'confirmed' ||
                        status === 'paid'
                    );
                });
                const hasCancelled = dayReservations.some(r => {
                    const status = String(r.status || '').toLowerCase();
                    return status === 'cancelled';
                });
                
                // Priority: cancelled (red) > approved (green) > pending (yellow)
                // This ensures cancelled event bookings also turn the day red,
                // even if there are other approved/pending bookings.
                if (hasCancelled) dayClass += ' cancelled';
                else if (hasApproved) dayClass += ' approved';
                else if (hasPending) dayClass += ' pending';
            } else {
                dayClass += ' available';
            }
            
            dayElement.className = dayClass;
            dayElement.innerHTML = `
                <div class="calendar-day-number">${day}</div>
                <div class="calendar-day-info">${
                    hasWholeDayEventBooking
                        ? 'Event Booking (Fully Booked)'
                        : (hasEventBooking ? 'Event Booking' : `${dayReservations.length} reservations`)
                }</div>
            `;
            
            // Add click event for day details
            dayElement.addEventListener('click', () => showDayDetails(dateStr, dayReservations));
            
            calendarGrid.appendChild(dayElement);
        }
    }
    
    function setupCalendarNavigation() {
        document.getElementById('prev-month').addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        });
        
        document.getElementById('next-month').addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        });
    }
    
    function formatDate(date) {
        // Use local date formatting to avoid timezone issues
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }
    
    function showDayDetails(date, reservations) {
        const modal = document.createElement('div');
        modal.className = 'calendar-modal';
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
            background-color: rgba(255,255,255,0.1);
            padding: 30px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            max-width: 800px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            color: white;
        `;
        
        modalContent.innerHTML = `
            <h3 style="color: #ffffff !important;">📅 ${new Date(date).toLocaleDateString('en-US', { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            })}</h3>
            <div class="reservations-list">
                ${reservations.length === 0 ? 
                    '<p style="color: #ffffff;">No reservations for this date.</p>' : 
                    reservations.map(reservation => `
                        <div class="reservation-item" style="
                            background-color: rgba(255,255,255,0.1);
                            padding: 15px;
                            margin: 10px 0;
                            border-radius: 10px;
                            border-left: 4px solid ${getStatusColor(reservation.status)};
                        ">
                            ${
                              isEventBooking(reservation)
                                ? `
                                  <div class="reservation-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                    <div><strong>Venue Type:</strong> ${getEventVenueType(reservation)}</div>
                                    <div><strong>Status:</strong> <span class="status-badge ${reservation.status || 'pending'}">${getStatusText(reservation.status)}</span></div>
                                  </div>
                                  <div><strong>Booked by:</strong> ${maskCustomerName(getReservationCustomerName(reservation))}</div>
                                  <div><strong>Time:</strong> ${getEventTimeRange(reservation)}</div>
                                  <div><strong>Package Inclusion (pax):</strong> ${getEventPackageText(reservation)}</div>
                                  <div><strong>Phone:</strong> ${reservation.phone || reservation.contact_number || 'N/A'}</div>
                                  <div><strong>Occasion:</strong> ${getEventOccasionText(reservation)}</div>
                                  ${reservation.special_requests ? `<div><strong>Special Requests:</strong> ${reservation.special_requests}</div>` : ''}
                                `
                                : `
                                  <div class="reservation-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                    <div>
                                      <div><strong>Table:</strong> ${getReservationTitle(reservation)}</div>
                                    </div>
                                    <div><strong>Status:</strong> <span class="status-badge ${reservation.status || 'pending'}">${getStatusText(reservation.status)}</span></div>
                                  </div>
                                  <div><strong>Booked by:</strong> ${maskCustomerName(getReservationCustomerName(reservation))}</div>
                                  <div><strong>Time In:</strong> ${formatTime(getReservationTimeIn(reservation))}</div>
                                  <div><strong>Time Out:</strong> ${formatTime(reservation.time_out || 'N/A')}</div>
                                  <div><strong>Guests:</strong> ${getGuestCount(reservation)}</div>
                                  <div><strong>Occasion:</strong> ${getOccasionText(reservation)}</div>
                                  ${reservation.special_requests ? `<div><strong>Special Requests:</strong> ${reservation.special_requests}</div>` : ''}
                                `
                            }
                        </div>
                    `).join('')
                }
            </div>
            <button onclick="this.closest('.calendar-modal').remove()" 
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

    function isEventBooking(reservation) {
        const id = reservation?.id;
        const idStr = (id === null || id === undefined) ? '' : String(id);
        if (idStr.startsWith('event-')) return true;

        const occ = reservation?.occasion;
        const occStr = (occ === null || occ === undefined) ? '' : String(occ).toLowerCase();
        return occStr === 'event booking';
    }
    
    function getEventVenueType(reservation) {
        const venue =
            reservation.venue_type_name ||
            reservation.venueTypeName ||
            reservation.venueType ||
            reservation.venue_name ||
            reservation.venue ||
            reservation.location;
        return venue && String(venue).trim() !== '' ? venue : 'Grandiya Venue- Grand Hall';
    }

    function getEventTimeRange(reservation) {
        const start = reservation.time_in || reservation.time || null;
        const end = reservation.time_out || null;

        // If both are missing or N/A, treat as whole day
        const startIsNA = !start || start === 'N/A';
        const endIsNA = !end || end === 'N/A';
        if (startIsNA && endIsNA) {
            return 'Whole day';
        }

        const startText = startIsNA ? '' : formatTime(start);
        const endText = endIsNA ? '' : formatTime(end);

        if (startText && endText) return `${startText} – ${endText}`;
        if (startText) return startText;
        if (endText) return endText;
        return 'N/A';
    }

    // Build a user-friendly title for the reservation/event
    function getReservationTitle(reservation) {
        if (isEventBooking(reservation)) {
            // Prefer explicit event name/title fields if present
            const title =
                reservation.event_title ||
                reservation.eventName ||
                reservation.event_name ||
                reservation.title ||
                reservation.occasion ||
                'Event Booking';

            // If venue information exists, use it; otherwise default to Grandiya Venue- Grand Hall
            const venue =
                reservation.venue ||
                reservation.venue_name ||
                reservation.location ||
                'Grandiya Venue- Grand Hall';

            return `${title} @ ${venue}`;
        }

        // For regular table reservations, fall back to table identifier
        return reservation.table || reservation.table_number || reservation.tableName || 'N/A';
    }

    // Normalize "Time In" so event bookings use the event timeslot
    function getReservationTimeIn(reservation) {
        // Event bookings: prefer explicit event timeslot fields
        if (isEventBooking(reservation)) {
            const slot =
                reservation.time_slot ||
                reservation.timeslot ||
                reservation.event_time ||
                reservation.event_start ||
                reservation.start_time ||
                reservation.time ||
                reservation.time_in;

            return slot || 'N/A';
        }

        // Regular table reservations
        return reservation.time_in || reservation.time || 'N/A';
    }

    // Normalize guest name so admin can see who booked
    function getReservationCustomerName(reservation) {
        const firstName =
            reservation.first_name ||
            reservation.firstname ||
            reservation.fname ||
            reservation.customer_first_name;

        const lastName =
            reservation.last_name ||
            reservation.lastname ||
            reservation.lname ||
            reservation.customer_last_name;

        const fullFromParts = [firstName, lastName].filter(Boolean).join(' ').trim();
        if (fullFromParts) return fullFromParts;

        const fullName =
            reservation.name ||
            reservation.full_name ||
            reservation.customer_name ||
            reservation.booked_by ||
            reservation.client_name;

        return fullName && String(fullName).trim() !== '' ? fullName : 'N/A';
    }

    // Mask names for public calendar display: "John D."
    function maskCustomerName(fullName) {
        if (!fullName || fullName === 'N/A') return 'N/A';
        const parts = String(fullName).trim().split(/\s+/).filter(Boolean);
        if (parts.length === 0) return 'N/A';
        if (parts.length === 1) return parts[0];
        const first = parts[0];
        const last = parts.slice(1).join(' ');
        return `${first} ${last.charAt(0).toUpperCase()}.`;
    }

    // Normalize guest count so it's in sync with the customer's/package data
    function getGuestCount(reservation) {
        // For event bookings, use package inclusion pax first
        if (isEventBooking(reservation)) {
            const packageGuests =
                reservation.package_pax ??
                reservation.package_capacity ??
                reservation.included_pax ??
                reservation.pax ??
                reservation.pax_included;

            if (packageGuests !== null && packageGuests !== undefined && packageGuests !== '') {
                return packageGuests;
            }
        }

        // Fallback to generic guest fields
        const guests =
            reservation.guests ??
            reservation.guest ??
            reservation.no_of_guests ??
            reservation.number_of_guests;

        return (guests === null || guests === undefined || guests === '') ? 'N/A' : guests;
    }

    // Normalize occasion so it's consistent with how it was booked
    function getOccasionText(reservation) {
        const occasion =
            reservation.occasion ||
            reservation.event_type ||
            reservation.event_title ||
            reservation.title;

        if (occasion && String(occasion).trim() !== '') {
            return occasion;
        }

        return isEventBooking(reservation) ? 'Event Booking' : 'N/A';
    }

    function getEventOccasionText(reservation) {
        let raw =
            reservation.event_type_name ||
            reservation.event_type ||
            reservation.event_title ||
            reservation.title ||
            reservation.occasion;

        if (!raw || String(raw).trim() === '') {
            return 'N/A';
        }

        let text = String(raw).trim();

        if (text.toLowerCase() === 'event booking') {
            const alt =
                reservation.event_type_name ||
                reservation.event_type ||
                reservation.event_title ||
                reservation.title;
            if (alt && String(alt).trim().toLowerCase() !== 'event booking') {
                text = String(alt).trim();
            }
        }

        const lower = text.toLowerCase();
        if (lower.includes('birthday') && !lower.includes('party')) {
            return 'Birthday Party';
        }

        return text;
    }

    function getEventPackageText(reservation) {
        const label =
            reservation.package_label ||
            reservation.packageLabel ||
            reservation.package_name ||
            reservation.packageInclusionName ||
            reservation.package_inclusion_name ||
            reservation.package_description ||
            reservation.package_desc ||
            reservation.package ||
            reservation.packageInclusion;

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

        const singlePax =
            reservation.package_pax ??
            reservation.package_capacity ??
            reservation.included_pax ??
            reservation.pax ??
            reservation.pax_included ??
            reservation.number_of_guests ??
            reservation.guest;

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

        if (label && String(label).trim() !== '') {
            const safeLabel = String(label).trim();
            return paxLabel ? `${safeLabel}, ${paxLabel}` : safeLabel;
        }

        return paxLabel || 'N/A';
    }
    
    // Helper function to format time (extract HH:MM from datetime string and convert to 12-hour format with AM/PM)
    function formatTime(timeValue) {
        if (!timeValue || timeValue === 'N/A') return 'N/A';
        
        let hour = 0;
        let minute = 0;
        let timeStr = '';
        
        // If it's already in HH:MM format (24-hour), convert to 12-hour
        if (typeof timeValue === 'string' && /^\d{1,2}:\d{2}\s*(AM|PM)?$/i.test(timeValue)) {
            // Check if it already has AM/PM
            if (/AM|PM/i.test(timeValue)) {
                return timeValue;
            }
            // Extract hour and minute
            const match = timeValue.match(/(\d{1,2}):(\d{2})/);
            if (match) {
                hour = parseInt(match[1]);
                minute = match[2];
            }
        } else if (typeof timeValue === 'string') {
            // Handle ISO format: 2025-10-28T10:22:00.000000Z
            if (timeValue.includes('T')) {
                const timeMatch = timeValue.match(/T(\d{2}):(\d{2})/);
                if (timeMatch) {
                    hour = parseInt(timeMatch[1]);
                    minute = timeMatch[2];
                }
            }
            // Handle other datetime formats: 2025-10-28 10:22:00
            else if (timeValue.includes(' ')) {
                const parts = timeValue.split(' ');
                if (parts.length > 1) {
                    const timePart = parts[1].substring(0, 5); // Get HH:MM
                    if (/^\d{2}:\d{2}$/.test(timePart)) {
                        hour = parseInt(timePart.substring(0, 2));
                        minute = timePart.substring(3, 5);
                    }
                }
            }
        }
        
        // Convert to 12-hour format with AM/PM
        if (hour !== undefined && minute !== undefined) {
            const period = hour >= 12 ? 'PM' : 'AM';
            const hour12 = hour > 12 ? hour - 12 : (hour === 0 ? 12 : hour);
            return hour12 + ':' + minute + ' ' + period;
        }
        
        return timeValue;
    }
    
    // Helper function to format datetime for display
    function formatDateTime(dateTimeValue) {
        if (!dateTimeValue || dateTimeValue === 'N/A') return 'N/A';
        
        try {
            // Try to parse and format the datetime
            const date = new Date(dateTimeValue);
            if (!isNaN(date.getTime())) {
                return date.toLocaleString('en-US', {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                });
            }
        } catch (e) {
            // If parsing fails, try to extract date and time manually
            if (typeof dateTimeValue === 'string') {
                // Handle ISO format
                if (dateTimeValue.includes('T')) {
                    const dateMatch = dateTimeValue.match(/(\d{4}-\d{2}-\d{2})T(\d{2}:\d{2})/);
                    if (dateMatch) {
                        return dateMatch[1] + ' ' + dateMatch[2];
                    }
                }
            }
        }
        
        return dateTimeValue;
    }
    
    function getStatusColor(status) {
        const normalized = String(status || 'pending').toLowerCase();
        switch (normalized) {
            case 'approved':
            case 'confirmed':
            case 'reserved':
            case 'paid':
                return '#28a745'; // green for approved/paid
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
            case 'reserved':
            case 'paid':
                return '✅ Reserved';
            case 'cancelled':
                return '❌ Cancelled';
            case 'pending':
            default:
                return '🟡 Pending';
        }
    }
    
    
    
});
</script>
