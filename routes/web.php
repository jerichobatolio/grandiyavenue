<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\NotificationController; // ✅ Add this
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\EventBookingController;
use App\Http\Controllers\EventTypeController;
use App\Http\Controllers\VenueTypeController;
use App\Http\Controllers\ReturnRefundController;
use App\Http\Controllers\Admin\ReturnRefundController as AdminReturnRefundController;
use Illuminate\Support\Facades\Response as FacadeResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

// Welcome page route - Main landing page
Route::get('/', function () {
    $reviews = collect();

    if (Schema::hasTable('reviews')) {
        try {
            $reviews = \App\Models\Review::where('status', 'approved')
                ->orderBy('created_at', 'desc')
                ->take(9)
                ->get();
        } catch (\Illuminate\Database\QueryException $e) {
            // If the table is corrupted or missing in the engine, fail silently and continue.
        }
    }

    return view('welcome', compact('reviews'));
})->name('welcome');

// Dedicated route for About Us background image so it always works in production
Route::get('/about-bg', function () {
    $path = public_path('assets/imgs/about-section.jpg');
    if (! file_exists($path)) {
        abort(404);
    }
    return FacadeResponse::file($path);
})->name('about.background');

// Serve user profile photos directly from the public storage disk
Route::get('/user-profile-photo/{user}', function (\App\Models\User $user) {
    if (! $user->profile_photo_path) {
        abort(404);
    }

    if (! Storage::disk('public')->exists($user->profile_photo_path)) {
        abort(404);
    }

    return Storage::disk('public')->response($user->profile_photo_path);
})->name('user.profile.photo');

// Serve order payment proofs from the public storage disk (used by admin View Proof)
Route::get('/admin/payment-proof/{path}', function (string $path) {
    if (! Storage::disk('public')->exists($path)) {
        abort(404);
    }

    $url = Storage::disk('public')->url($path);

    return view('admin.payment_proof_view', [
        'imageUrl' => $url,
    ]);
})->where('path', '.*')->name('admin.payment_proof');

// Frontend/Home routes - moved to /home
Route::get('/home', [HomeController::class,'my_home'])->name('home'); 
Route::get('/dashboard', [HomeController::class,'index']);

// Category page route
Route::get('/category/{type}', [HomeController::class, 'showFoodsByType']);

// Subcategory page route
Route::get('/category/{type}/subcategory/{subcategory}', [HomeController::class, 'showFoodsBySubcategory']);

// Food package helper route: given a package name (e.g. "Chicken"),
// return the list of foods that belong to that category/type as JSON.
Route::get('/food-packages/{name}/foods', [HomeController::class, 'getFoodsForPackage'])
    ->name('food_packages.foods');

// Drinks subcategory route (for backward compatibility)
Route::get('/drinks/{subcategory}', [HomeController::class, 'showDrinksBySubcategory']); 

// Cart routes
Route::post('/add_cart/{id}', [HomeController::class,'add_cart']);
Route::post('/add_bundle_to_cart/{type}', [HomeController::class,'add_bundle_to_cart']);
Route::get('/my_cart', [HomeController::class,'my_cart'])->name('my_cart'); 
Route::get('/remove_cart/{id}', [HomeController::class,'remove_cart']);
Route::post('/update_cart/{id}', [HomeController::class, 'update_cart']);

// Orders routes
Route::get('/my_orders', [HomeController::class,'my_orders'])->name('my_orders')->middleware('auth');

// Clean Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{foodId}', [CartController::class, 'addToCart']);
Route::post('/cart/add-bundle/{bundleId}', [CartController::class, 'addBundleToCart']);
Route::get('/cart/remove/{cartId}', [CartController::class, 'removeFromCart']);
Route::post('/cart/update/{cartId}', [CartController::class, 'updateQuantity']);
Route::post('/cart/clear', [CartController::class, 'clearCart']);
Route::get('/cart/count', [CartController::class, 'getCartCount']);

// Checkout / Place Order
Route::post('/place_order', [OrderController::class, 'placeOrder'])->name('place_order');

// Table booking
Route::post('/book_table', [HomeController::class,'book_table']);
Route::get('/booking/receipt/{id}', [HomeController::class,'downloadReceipt'])->name('booking.receipt');

// Public route to show booking form (no auth required)
Route::get('/book-event', [EventBookingController::class, 'showBookingForm'])->name('book.event');

// Public API: check if a date/time conflicts with existing bookings/reservations (no PII)
Route::get('/api/booking-conflicts', [EventBookingController::class, 'checkBookingConflicts'])->name('booking.conflicts');

// Event booking routes - require authentication
Route::middleware(['auth'])->group(function () {
    Route::post('/book-table/payment-proof', [HomeController::class, 'uploadTablePaymentProof'])->name('book.table.payment.proof');
    Route::post('/book-event', [EventBookingController::class, 'storeBooking'])->name('book.event.store');
    Route::post('/upload-payment-proof', [EventBookingController::class, 'uploadPaymentProof'])->name('book.event.payment.proof');
    Route::post('/cancel-booking', [EventBookingController::class, 'cancelPendingBooking'])->name('book.event.cancel');
    Route::get('/booking/{id}', [EventBookingController::class, 'getBooking'])->name('book.event.get');
    Route::get('/event-booking/receipt/{id}', [EventBookingController::class, 'downloadReceipt'])->name('event.booking.receipt');
});

// Public route to check authentication status
Route::get('/check-auth', [EventBookingController::class, 'checkAuth'])->name('check.auth');






// API endpoint for calendar reservations
Route::get('/api/reservations/calendar', [HomeController::class,'getCalendarReservations']);

// Admin food management
Route::get('/add_food', [AdminController::class,'add_food']);
Route::post('/upload_food', [AdminController::class,'upload_food']);
Route::get('/view_food', [AdminController::class,'view_food']);
Route::get('/delete_food/{id}', [AdminController::class,'delete_food']);
Route::get('/update_food/{id}', [AdminController::class,'update_food']);
Route::put('/edit_food/{id}', [AdminController::class,'edit_food']);

// Admin dashboard analytics
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/dashboard/stats', [AdminController::class, 'dashboardStats'])->name('admin.dashboard.stats');

// Admin category management
Route::get('/categories', [AdminController::class,'categories']);
Route::post('/add_category', [AdminController::class,'add_category']);
Route::post('/update_category/{id}', [AdminController::class,'update_category']);
Route::get('/delete_category/{id}', [AdminController::class,'delete_category']);
Route::post('/add_subcategory', [AdminController::class,'add_subcategory']);
Route::post('/update_subcategory/{id}', [AdminController::class,'update_subcategory']);
Route::get('/delete_subcategory/{id}', [AdminController::class,'delete_subcategory']);
Route::get('/get_subcategories/{categoryId}', [AdminController::class,'get_subcategories']);

// Admin bundle management
Route::get('/bundles', [AdminController::class,'bundles'])->name('admin.bundles');
Route::post('/create_bundle', [AdminController::class,'createBundle'])->name('admin.create_bundle');
Route::post('/update_bundle/{id}', [AdminController::class,'updateBundle'])->name('admin.update_bundle');
Route::get('/delete_bundle/{id}', [AdminController::class,'deleteBundle'])->name('admin.delete_bundle');
Route::get('/toggle_bundle_status/{id}', [AdminController::class,'toggleBundleStatus'])->name('admin.toggle_bundle_status');
Route::post('/add_food_to_bundle/{bundleId}', [AdminController::class,'addFoodToBundle'])->name('admin.add_food_to_bundle');
Route::post('/update_food_quantity_in_bundle/{bundleId}/{foodId}', [AdminController::class,'updateFoodQuantityInBundle'])->name('admin.update_food_quantity_in_bundle');
Route::get('/remove_food_from_bundle/{bundleId}/{foodId}', [AdminController::class,'removeFoodFromBundle'])->name('admin.remove_food_from_bundle');

// Admin Pax options management (for event guest/pax presets)
Route::get('/pax-options', [AdminController::class,'paxOptions'])->name('admin.pax.index');
Route::post('/pax-options', [AdminController::class,'storePaxOption'])->name('admin.pax.store');
Route::put('/pax-options/{id}', [AdminController::class,'updatePaxOption'])->name('admin.pax.update');
Route::delete('/pax-options/{id}', [AdminController::class,'deletePaxOption'])->name('admin.pax.delete');

// Admin simple Food Package items management (for listing items like chicken, vegetable, unlimited rice)
Route::get('/food-packages', [AdminController::class,'foodPackageItems'])->name('admin.food_packages.index');
Route::post('/food-packages', [AdminController::class,'storeFoodPackageItem'])->name('admin.food_packages.store');
Route::put('/food-packages/{id}', [AdminController::class,'updateFoodPackageItem'])->name('admin.food_packages.update');
Route::delete('/food-packages/{id}', [AdminController::class,'deleteFoodPackageItem'])->name('admin.food_packages.delete');

// Admin order management
Route::get('/orders', [AdminController::class,'orders']);
Route::get('/archived-orders', [AdminController::class,'archivedOrders'])->name('admin.archived_orders');
Route::get('/create-test-notification', [AdminController::class,'createTestNotification']);

// ✅ Single route to handle all status updates dynamically (single order)
Route::get('/order/status/{id}/{status}', [AdminController::class, 'updateOrderStatus'])->name('order.status');
Route::get('/order/delete/{id}', [AdminController::class, 'deleteOrder'])->name('order.delete');

// ✅ Group status update route for multiple orders (used by admin/orders bulk actions)
Route::get('/orders/group-status', [AdminController::class, 'updateGroupOrderStatus'])->name('orders.group_status');

// Optional: keep your old routes for backward compatibility
Route::get('/on_the_way/{id}', [AdminController::class,'on_the_way']);
Route::get('/delivered/{id}', [AdminController::class,'delivered']);

// Admin event booking management
Route::get('/event_bookings', [AdminController::class,'eventBookings'])->name('admin.event_bookings');
Route::get('/archived-event-bookings', [AdminController::class,'archivedEventBookings'])->name('admin.archived_event_bookings');
Route::post('/event_booking/status/{id}', [AdminController::class,'updateEventBookingStatus'])->name('admin.event_booking.status');
Route::get('/event_booking/delete/{id}', [AdminController::class,'deleteEventBooking'])->name('admin.event_booking.delete');
Route::get('/event_booking/view/{id}', [AdminController::class,'viewEventBooking'])->name('admin.event_booking.view');
Route::get('/event_booking/stats', [AdminController::class,'getEventBookingStats'])->name('admin.event_booking.stats');

// Notification routes
Route::get('/notifications', [AdminController::class,'notifications'])->name('admin.notifications');
Route::get('/notifications/mark-read/{id}', [AdminController::class,'markNotificationAsRead'])->name('admin.notification.mark_read');
Route::get('/notifications/mark-all-read', [AdminController::class,'markAllNotificationsAsRead'])->name('admin.notification.mark_all_read');
Route::delete('/notifications/{id}', [AdminController::class,'deleteNotification'])->name('admin.notification.delete');

Route::get('/cancel/{id}', [AdminController::class,'cancel']);

// Admin reservations
Route::get('/reservations', [AdminController::class,'reservations']);
Route::get('/archived-reservations', [AdminController::class,'archivedReservations'])->name('admin.archived_reservations');
Route::post('/admin/reservations/{id}/approve', [AdminController::class,'approveReservation'])->name('admin.reservations.approve');
Route::post('/admin/reservations/{id}/cancel', [AdminController::class,'cancelReservation'])->name('admin.reservations.cancel');

// Test routes
Route::post('/test-approve/{id}', [AdminController::class,'approveReservation']);
Route::post('/test-cancel/{id}', [AdminController::class,'cancelReservation']);
Route::post('/admin/reservations/{id}/delete', [AdminController::class,'deleteReservation']);
Route::post('/admin/reservations/{id}/force-delete', [AdminController::class,'forceDeleteReservation'])->name('admin.reservations.force_delete');
Route::get('/admin/reservations/{id}/test', [AdminController::class,'testDeleteReservation']);
Route::get('/admin/simple-test', [AdminController::class,'simpleTest']);
Route::post('/admin/test-route', [AdminController::class,'simpleTest']);
Route::get('/admin/create-test-reservation', [AdminController::class,'createTestReservation']);

// Admin table management
Route::get('/table_management', [AdminController::class,'table_management']);
Route::get('/table-layout', [AdminController::class,'getTableLayout']);
Route::post('/table-layout', [AdminController::class,'saveTableLayout']);
Route::get('/table-status', [AdminController::class,'getTableStatus']);
Route::post('/table-status', [AdminController::class,'updateTableStatus']);
Route::get('/test-table-route', [AdminController::class, 'testTableRoute']);

// Admin section image upload (for table management sections)
Route::post('/admin/section/upload-image', [AdminController::class, 'uploadSectionImage'])->name('admin.section.upload-image');


// Gallery management routes
Route::resource('gallery', GalleryController::class);
Route::get('manage_gallery', [GalleryController::class, 'index'])->name('manage_gallery');
Route::get('add_gallery_item', [GalleryController::class, 'create'])->name('add_gallery_item');
Route::get('delete_gallery_item', [GalleryController::class, 'index'])->name('delete_gallery_item');

// Review submission (public)
Route::post('/submit-review', [HomeController::class,'submitReview'])->name('submit_review');

// Admin review management
Route::get('/reviews', [AdminController::class,'reviews'])->name('admin.reviews');
Route::get('/review/approve/{id}', [AdminController::class,'approveReview'])->name('admin.review.approve');
Route::get('/review/reject/{id}', [AdminController::class,'rejectReview'])->name('admin.review.reject');
Route::get('/review/edit/{id}', [AdminController::class,'editReview'])->name('admin.review.edit');
Route::post('/review/update/{id}', [AdminController::class,'updateReview'])->name('admin.review.update');
Route::get('/review/delete/{id}', [AdminController::class,'deleteReview'])->name('admin.review.delete');

// Admin announcement management
Route::get('/announcements', [AdminController::class,'announcements'])->name('admin.announcements');
Route::post('/announcements', [AdminController::class,'storeAnnouncement'])->name('admin.announcements.store');
Route::post('/announcements/{id}', [AdminController::class,'updateAnnouncement'])->name('admin.announcements.update');
Route::get('/announcements/delete/{id}', [AdminController::class,'deleteAnnouncement'])->name('admin.announcements.delete');
Route::get('/announcements/approve/{id}', [AdminController::class,'approveAnnouncement'])->name('admin.announcements.approve');
Route::get('/announcements/reject/{id}', [AdminController::class,'rejectAnnouncement'])->name('admin.announcements.reject');

// Admin FAQ management for Grandiya Assistant
Route::get('/admin/faqs', [AdminController::class, 'faqs'])->name('admin.faqs');
Route::post('/admin/faqs', [AdminController::class, 'storeFaq'])->name('admin.faqs.store');
Route::post('/admin/faqs/{id}', [AdminController::class, 'updateFaq'])->name('admin.faqs.update');
Route::get('/admin/faqs/{id}/delete', [AdminController::class, 'deleteFaq'])->name('admin.faqs.delete');

// Event Type management routes - unified interface
Route::get('event_types', [EventTypeController::class, 'index'])->name('event_types.index');
Route::post('event_types', [EventTypeController::class, 'store'])->name('event_types.store');
Route::get('event_types/create', [EventTypeController::class, 'create'])->name('event_types.create');
Route::put('event_types/{eventType}', [EventTypeController::class, 'update'])->name('event_types.update');
Route::delete('event_types/{eventType}', [EventTypeController::class, 'destroy'])->name('event_types.destroy');
Route::post('event_types/{eventType}/toggle-status', [EventTypeController::class, 'toggleStatus'])->name('event_types.toggle-status');
Route::delete('event_types/{eventType}/qr-code', [EventTypeController::class, 'deleteEventTypeQrCode'])->name('event_types.delete-qr-code');
// Global time slots (for all event types) - must be before {eventType} routes
Route::post('event_types/time-slots', [EventTypeController::class, 'storeTimeSlot'])->name('event_types.time-slots.store');
Route::put('event_types/time-slots/{timeSlot}', [EventTypeController::class, 'updateTimeSlot'])->name('event_types.time-slots.update');
Route::delete('event_types/time-slots/{timeSlot}', [EventTypeController::class, 'destroyTimeSlot'])->name('event_types.time-slots.destroy');

// Global Package Inclusions management (used in Event Types admin)
Route::post('package-inclusions', function (\Illuminate\Http\Request $request) {
    $price = (float) str_replace(',', '', $request->price ?? '');
    $paxMin = $request->filled('pax_min') ? (int) $request->pax_min : null;
    $paxMax = $request->filled('pax_max') ? (int) $request->pax_max : null;
    $request->validate([
        'name' => 'required|string|max:255',
        'pax_min' => 'nullable|integer|min:0',
        'pax_max' => 'nullable|integer|min:0',
        'details' => 'nullable|string',
    ]);
    if ($price < 0) {
        return redirect(route('event_types.index') . '?tab=inclusions')->withErrors(['price' => 'Price must be zero or greater.'])->withInput();
    }
    if ($paxMin !== null && $paxMax !== null && $paxMax < $paxMin) {
        return redirect(route('event_types.index') . '?tab=inclusions')->withErrors(['pax_max' => 'Pax max must be greater than or equal to pax min.'])->withInput();
    }

    \App\Models\PackageInclusion::create([
        'name' => $request->name,
        'pax_min' => $paxMin,
        'pax_max' => $paxMax,
        'price' => $price,
        'details' => $request->details,
    ]);

    return redirect(route('event_types.index') . '?tab=inclusions')->with('success', 'Package inclusion added successfully!');
})->name('admin.package_inclusions.store');

Route::put('package-inclusions/{inclusion}', function (\Illuminate\Http\Request $request, \App\Models\PackageInclusion $inclusion) {
    $price = (float) str_replace(',', '', $request->price ?? '');
    $paxMin = $request->filled('pax_min') ? (int) $request->pax_min : null;
    $paxMax = $request->filled('pax_max') ? (int) $request->pax_max : null;
    $request->validate([
        'name' => 'required|string|max:255',
        'pax_min' => 'nullable|integer|min:0',
        'pax_max' => 'nullable|integer|min:0',
        'details' => 'nullable|string',
    ]);
    if ($price < 0) {
        return redirect(route('event_types.index') . '?tab=inclusions')->withErrors(['price' => 'Price must be zero or greater.'])->withInput();
    }
    if ($paxMin !== null && $paxMax !== null && $paxMax < $paxMin) {
        return redirect(route('event_types.index') . '?tab=inclusions')->withErrors(['pax_max' => 'Pax max must be greater than or equal to pax min.'])->withInput();
    }

    $inclusion->update([
        'name' => $request->name,
        'pax_min' => $paxMin,
        'pax_max' => $paxMax,
        'price' => $price,
        'details' => $request->details,
    ]);

    return redirect(route('event_types.index') . '?tab=inclusions')->with('success', 'Package inclusion updated successfully!');
})->name('admin.package_inclusions.update');

Route::delete('package-inclusions/{inclusion}', function (\App\Models\PackageInclusion $inclusion) {
    $inclusion->delete();

    return redirect(route('event_types.index') . '?tab=inclusions')->with('success', 'Package inclusion deleted successfully!');
})->name('admin.package_inclusions.delete');

// Global QR Code management routes
Route::put('admin/qr-code', [EventTypeController::class, 'updateGlobalQrCode'])->name('admin.qr-code.update');
Route::delete('admin/qr-code', [EventTypeController::class, 'deleteGlobalQrCode'])->name('admin.qr-code.delete');

// Venue Type management routes
Route::post('venue_types', [VenueTypeController::class, 'store'])->name('venue_types.store');
Route::put('venue_types/{venueType}', [VenueTypeController::class, 'update'])->name('venue_types.update');
Route::post('venue_types/{venueType}/toggle-status', [VenueTypeController::class, 'toggleStatus'])->name('venue_types.toggle-status');
Route::delete('venue_types/{venueType}', [VenueTypeController::class, 'destroy'])->name('venue_types.destroy');

// Test route for QR code debugging
Route::get('admin/test-qr', function() {
    $globalQrCode = session('global_qr_code');
    return response()->json([
        'qr_code' => $globalQrCode,
        'exists' => $globalQrCode ? \Storage::disk('public')->exists($globalQrCode) : false,
        'url' => $globalQrCode ? \Storage::disk('public')->url($globalQrCode) : null
    ]);
});

// Test route for admin structure
Route::get('/admin/test-event-types', function () {
    return view('admin.test-event-types');
})->name('admin.test-event-types');




// ✅ Notification routes for JS polling and marking as read
Route::middleware('auth')->group(function () {
    Route::get('/customer/notifications', [NotificationController::class, 'getNotifications'])->name('customer.notifications');
    Route::post('/customer/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('customer.notifications.read');
    Route::delete('/customer/notifications/{id}', [NotificationController::class, 'deleteNotification'])->name('customer.notifications.delete');
});

// Return/Refund routes for customers
Route::middleware('auth')->group(function () {
    Route::get('/return-refunds', [ReturnRefundController::class, 'index'])->name('return_refunds.index');
    Route::get('/return-refunds/create', [ReturnRefundController::class, 'create'])->name('return_refunds.create');
    Route::post('/return-refunds', [ReturnRefundController::class, 'store'])->name('return_refunds.store');
    Route::get('/return-refunds/{id}', [ReturnRefundController::class, 'show'])->name('return_refunds.show');
    Route::post('/return-refunds/{id}/cancel', [ReturnRefundController::class, 'cancel'])->name('return_refunds.cancel');
});

// Admin Return/Refund management routes
Route::get('/admin/return-refunds', [AdminReturnRefundController::class, 'index'])->name('admin.return_refunds.index');
Route::get('/admin/return-refunds/filter', [AdminReturnRefundController::class, 'filter'])->name('admin.return_refunds.filter');
Route::get('/admin/return-refunds/{id}', [AdminReturnRefundController::class, 'show'])->name('admin.return_refunds.show');
Route::post('/admin/return-refunds/{id}/approve', [AdminReturnRefundController::class, 'approve'])->name('admin.return_refunds.approve');
Route::post('/admin/return-refunds/{id}/reject', [AdminReturnRefundController::class, 'reject'])->name('admin.return_refunds.reject');
Route::post('/admin/return-refunds/{id}/refunded', [AdminReturnRefundController::class, 'markRefunded'])->name('admin.return_refunds.refunded');



// Auth / Dashboard - Custom admin/user logic
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Inline profile update routes (navbar dropdown)
    Route::post('/profile/inline-update', [HomeController::class, 'inlineProfileUpdate'])->name('profile.inline.update');
    Route::post('/profile/inline-photo', [HomeController::class, 'inlineProfilePhoto'])->name('profile.inline.photo');
});
