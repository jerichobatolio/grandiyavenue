<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Book;
use App\Models\Order;
use App\Models\Notification; // ✅ Notifications
use App\Models\User;         // ✅ Users
use App\Models\Category;     // ✅ Categories
use App\Models\Subcategory;  // ✅ Subcategories
use App\Models\TableStatus;  // ✅ Table Status
use App\Models\EventBooking; // ✅ Event Bookings
use App\Models\Bundle; // ✅ Bundles
use App\Models\Review; // ✅ Reviews
use App\Models\PaxOption; // ✅ Pax options for event booking
use App\Models\FoodPackageItem; // ✅ Simple food package items for events
use App\Models\Announcement; // ✅ Announcements
use App\Models\ReturnRefund; // ✅ Returns & refunds
use App\Models\Faq; // ✅ FAQs for Grandiya Assistant
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // -------------------- FOOD MANAGEMENT --------------------
    public function add_food()
    {
        $categories = Category::with('subcategories')->get();
        return view('admin.add_food', compact('categories'));
    }

    public function upload_food(Request $request)
    {
        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'detail' => 'nullable|string',
            'price' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $food = new Food();
        $food->title = $request->title;
        $food->detail = $request->detail;
        $food->price = $request->price;
        $food->category_id = $request->category_id;
        $food->subcategory_id = $request->subcategory_id;

        // Keep the old type and subcategory fields for backward compatibility
        $category = Category::find($request->category_id);
        $food->type = $category->name;
        
        if ($request->subcategory_id) {
            $subcategory = Subcategory::find($request->subcategory_id);
            $food->subcategory = $subcategory->name;
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('food_img'), $filename);
            $food->image = $filename;
        }

        $food->save();
        return redirect()->back()->with('message', 'Food Added Successfully');
    }

    public function view_food()
    {
        $allFoods = Food::with(['category', 'bundles'])->get();
        
        // Get all categories from database
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        
        // Group foods by category_id instead of type
        $categorizedFoods = $allFoods->groupBy('category_id');
        
        return view('admin.show_food', compact('categorizedFoods', 'categories', 'allFoods'));
    }

    public function delete_food($id)
    {
        $data = Food::find($id);
        if ($data) {
            $data->delete();
        }
        return redirect()->back()->with('message', 'Food deleted successfully!');
    }

    public function update_food($id)
    {
        $food = Food::find($id);
        return view('admin.update_food', compact('food'));
    }

    public function edit_food(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'detail' => 'nullable|string',
            'price' => 'required|string',
            'type' => 'required|string',
            'subcategory' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = Food::find($id);
        if ($data) {
            $data->title = $request->title;
            $data->detail = $request->detail;
            $data->price = $request->price;
            $data->type = $request->type;
            $data->subcategory = $request->subcategory; // ✅ Handle subcategory

            if ($request->hasFile('image')) {
                // Delete old image if exists
                $oldImagePath = public_path('food_img/' . $data->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
                
                $image = $request->file('image');
                $imagename = time() . '.' . $image->getClientOriginalExtension();
                $image->move('food_img', $imagename);
                $data->image = $imagename;
            }

            $data->save();
            return redirect('view_food')->with('message', 'Food updated successfully!');
        }

        return redirect('view_food')->with('error', 'Food item not found!');
    }

    // -------------------- ORDER MANAGEMENT --------------------
    public function orders()
    {
        $orders = Order::where('is_archived', false)->orderBy('created_at', 'desc')->get();
        
        // Group orders by customer (name, email, phone, address combination)
        $groupedOrders = $orders->groupBy(function($order) {
            return $order->name . '|' . $order->email . '|' . $order->phone . '|' . $order->address;
        });
        
        return view('admin.order', compact('orders', 'groupedOrders'));
    }

    // -------------------- ARCHIVED ORDERS MANAGEMENT --------------------
    public function archivedOrders()
    {
        $orders = Order::where('is_archived', true)->orderBy('created_at', 'desc')->get();
        
        // Group orders by customer (name, email, phone, address combination)
        $groupedOrders = $orders->groupBy(function($order) {
            return $order->name . '|' . $order->email . '|' . $order->phone . '|' . $order->address;
        });
        
        return view('admin.archived_orders', compact('orders', 'groupedOrders'));
    }

    // Test function to create a sample notification
    public function createTestNotification()
    {
        $user = User::first(); // Get first user for testing
        if ($user) {
            // Create order notification
            Notification::create([
                'user_id' => $user->id,
                'order_id' => null,
                'type' => 'test',
                'message' => 'Test notification - Your order status has been updated!',
                'is_read' => false,
                'data' => [
                    'order_id' => 'TEST-001',
                    'status' => 'On the Way',
                    'title' => 'Test Food Item',
                    'price' => 15.99,
                    'quantity' => 2,
                    'delivery_status' => 'On the Way'
                ]
            ]);
            
            // Create reservation notification
            Notification::create([
                'user_id' => $user->id,
                'type' => 'reservation_approved',
                'message' => 'Your table reservation for 2024-01-15 at 19:00 has been approved! 🎉',
                'is_read' => false,
                'data' => [
                    'reservation_id' => 'TEST-RES-001',
                    'date' => '2024-01-15',
                    'time' => '19:00',
                    'table' => 'Table 5',
                    'guests' => 4
                ]
            ]);
            
            return redirect()->back()->with('message', 'Test notifications created!');
        }
        return redirect()->back()->with('error', 'No users found for testing');
    }

    // Change order status and notify all users (single order)
    private function changeOrderStatus(Order $order, $status)
    {
        $order->delivery_status = $status;
        $order->save();

        // Get all users to notify everyone
        $allUsers = User::all();

        // Create notifications for all users
        foreach ($allUsers as $user) {
            $notifMessage = "Order #{$order->id} status has been updated to: {$status}";
            $notification = Notification::create([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'type' => 'order_status',
                'message' => $notifMessage,
                'is_read' => false,
                'data' => [
                    'order_id' => $order->id,
                    'status' => $status,
                    'title' => $order->title,
                    'price' => $order->price,
                    'quantity' => $order->quantity,
                    'delivery_status' => $status,
                    'customer_name' => $order->name,
                    'customer_email' => $order->email
                ]
            ]);
        }
    }

    /**
     * Bulk update the status of multiple orders for the same customer
     * and send ONLY ONE aggregated notification to that customer.
     *
     * Used by the grouped "On Way / Delivered / Cancel" actions
     * in the admin orders table.
     */
    public function updateGroupOrderStatus(Request $request)
    {
        // Expect a comma‑separated list of IDs (e.g. "1,2,3")
        $idsParam = $request->query('ids', '');
        $status = $request->query('status', '');

        if (empty($idsParam) || empty($status)) {
            return response()->json([
                'success' => false,
                'message' => 'Missing order IDs or status',
            ], 422);
        }

        $orderIds = array_filter(array_map('intval', explode(',', $idsParam)));

        if (empty($orderIds)) {
            return response()->json([
                'success' => false,
                'message' => 'No valid order IDs provided',
            ], 422);
        }

        // Normalize status to allowed values
        $allowedStatuses = ['Pending', 'In Progress', 'On the Way', 'Delivered', 'Cancelled'];
        if (!in_array($status, $allowedStatuses, true)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid status value',
            ], 422);
        }

        // Fetch all orders in the group
        $orders = Order::whereIn('id', $orderIds)->get();

        if ($orders->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No orders found for the given IDs',
            ], 404);
        }

        // For safety, ensure all orders belong to the same customer "identity"
        $firstOrder = $orders->first();
        $sameCustomer = $orders->every(function ($order) use ($firstOrder) {
            return $order->name === $firstOrder->name
                && $order->email === $firstOrder->email
                && $order->phone === $firstOrder->phone
                && $order->address === $firstOrder->address;
        });

        if (!$sameCustomer) {
            return response()->json([
                'success' => false,
                'message' => 'Orders do not belong to the same customer',
            ], 422);
        }

        // Update all orders' delivery_status without creating per‑order notifications
        foreach ($orders as $order) {
            $order->delivery_status = $status;
            $order->save();
        }

        // Aggregate totals for notification payload
        $totalItems = $orders->sum('quantity');
        $totalPrice = $orders->sum(function ($order) {
            return (float) $order->price * (int) $order->quantity;
        });

        $itemText = $totalItems === 1 ? 'item' : 'items';

        // Send ONE aggregated notification to the customer (if linked to a user)
        if ($firstOrder->user_id) {
            Notification::create([
                'user_id'  => $firstOrder->user_id,
                'order_id' => $firstOrder->id,
                'type'     => 'order_status',
                'message'  => "Your order with {$totalItems} {$itemText} has been updated to: {$status}.",
                'is_read'  => false,
                'data'     => [
                    'order_id'        => $firstOrder->id,
                    'status'          => $status,
                    'title'           => $totalItems > 1 ? "{$totalItems} items" : $firstOrder->title,
                    'price'           => $totalPrice,
                    'quantity'        => $totalItems,
                    'delivery_status' => $status,
                    'customer_name'   => $firstOrder->name,
                    'customer_email'  => $firstOrder->email,
                    'total_items'     => $totalItems,
                    'total_price'     => $totalPrice,
                    'order_ids'       => $orderIds,
                ],
            ]);
        }

        // Optionally also notify other users (e.g. admins) in aggregated form.
        // This keeps admin notifications concise when a group action is used.
        $otherUsers = User::when($firstOrder->user_id, function ($query) use ($firstOrder) {
            return $query->where('id', '!=', $firstOrder->user_id);
        })->get();

        foreach ($otherUsers as $user) {
            Notification::create([
                'user_id'  => $user->id,
                'order_id' => $firstOrder->id,
                'type'     => 'order_status',
                'message'  => "Customer {$firstOrder->name} now has {$totalItems} {$itemText} updated to {$status}.",
                'is_read'  => false,
                'data'     => [
                    'order_id'        => $firstOrder->id,
                    'status'          => $status,
                    'title'           => $totalItems > 1 ? "{$totalItems} items" : $firstOrder->title,
                    'price'           => $totalPrice,
                    'quantity'        => $totalItems,
                    'delivery_status' => $status,
                    'customer_name'   => $firstOrder->name,
                    'customer_email'  => $firstOrder->email,
                    'total_items'     => $totalItems,
                    'total_price'     => $totalPrice,
                    'order_ids'       => $orderIds,
                ],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => "Updated {$orders->count()} orders to status: {$status}",
        ]);
    }

    public function on_the_way($id)
    {
        $order = Order::find($id);
        if ($order) {
            $this->changeOrderStatus($order, "On the Way");
        }
        return redirect()->back()->with('message', 'Order status updated to On the Way');
    }

    public function delivered($id)
    {
        $order = Order::find($id);
        if ($order) {
            $this->changeOrderStatus($order, "Delivered");
        }
        return redirect()->back()->with('message', 'Order status updated to Delivered');
    }

    public function cancel($id)
    {
        $order = Order::find($id);
        if ($order) {
            $this->changeOrderStatus($order, "Cancelled");
        }
        return redirect()->back()->with('message', 'Order status updated to Cancelled');
    }

    // Unified method to handle all order status updates
    public function updateOrderStatus($id, $status)
    {
        $order = Order::find($id);
        if ($order) {
            $this->changeOrderStatus($order, $status);
            return redirect()->back()->with('message', "Order status updated to {$status}");
        }
        return redirect()->back()->with('error', 'Order not found');
    }

    // Archive order (instead of delete)
    public function deleteOrder($id)
    {
        try {
            $order = Order::find($id);
            
            if (!$order) {
                return redirect()->back()->with('error', 'Order not found');
            }
            
            $order->is_archived = true;
            $order->save();
            
            return redirect()->back()->with('message', 'Order archived successfully');
        } catch (\Exception $e) {
            \Log::error('Error archiving order: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error archiving order: ' . $e->getMessage());
        }
    }

    // -------------------- RESERVATION MANAGEMENT --------------------
    public function reservations()
    {
        // Sort: Newest reservations first (by created_at DESC), oldest bookings at the end
        // This ensures everyone who makes a reservation appears at the top
        $book = Book::where('is_archived', false)
                    ->orderBy('created_at', 'desc')
                    ->get();
        return view('admin.reservations', compact('book'));
    }

    // -------------------- ARCHIVED RESERVATIONS MANAGEMENT --------------------
    public function archivedReservations()
    {
        $book = Book::where('is_archived', true)->orderBy('created_at', 'desc')->get();
        return view('admin.archived_reservations', compact('book'));
    }

    // Test method to verify delete functionality
    public function testDeleteReservation($id)
    {
        try {
            \Log::info('Test delete called with ID: ' . $id);
            $reservation = Book::find($id);
            
            if (!$reservation) {
                return response()->json([
                    'success' => false,
                    'message' => 'Reservation not found'
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Reservation found: ' . $reservation->phone,
                'data' => $reservation
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // Simple test method
    public function simpleTest()
    {
        return response()->json([
            'success' => true,
            'message' => 'Simple test successful',
            'timestamp' => now()
        ]);
    }


    // Create a test reservation
    public function createTestReservation()
    {
        try {
            $reservation = Book::create([
                'phone' => '123-456-7890',
                'guest' => '2',
                'date' => now()->addDay()->format('Y-m-d'),
                'time' => '19:00:00',
                'status' => 'pending',
                'table_number' => 'T1',
                'occasion' => 'test'
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Test reservation created with ID: ' . $reservation->id,
                'reservation' => $reservation
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating test reservation: ' . $e->getMessage()
            ], 500);
        }
    }

    // -------------------- TABLE MANAGEMENT --------------------
    public function table_management()
    {
        return view('admin.table_management');
    }
    
    /**
     * Get current table status for admin management
     */
    public function getTableStatus()
    {
        try {
            $tableStatus = $this->getRealTableStatus();
            return response()->json([
                'success' => true,
                'tableStatus' => $tableStatus
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching table status: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Update table status (available/reserved)
     */
    public function updateTableStatus(Request $request)
    {
        try {
            $request->validate([
                'table_number' => 'required|string',
                'status' => 'required|in:available,reserved'
            ]);
            
            $tableNumber = $request->table_number;
            $status = $request->status;
            
            // Log the table status change
            \Log::info("Admin updating table {$tableNumber} to {$status}");
            
            // Store table status in database
            TableStatus::updateOrCreate(
                ['table_number' => $tableNumber],
                [
                    'status' => $status,
                    'seat_capacity' => $request->seat_capacity ?? 8
                ]
            );
            
            // Broadcast the update to all connected clients
            $this->broadcastTableStatusUpdate($tableNumber, $status);
            
            return response()->json([
                'success' => true,
                'message' => "Table {$tableNumber} status updated to {$status}",
                'tableStatus' => $this->getAllTableStatuses()
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error updating table status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating table status: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Test route for debugging
     */
    public function testTableRoute()
    {
        return response()->json(['message' => 'Test route works', 'timestamp' => now()]);
    }
    
    
    /**
     * Get all table statuses from database
     */
    private function getAllTableStatuses()
    {
        // Define all available tables
        $allTables = [
            // Top Section Tables
            'T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8',
            // Hallway Tables  
            'H9', 'H10', 'H11', 'H12', 'H13', 'H14', 'H15', 'H16',
            // VIP Cabin Room Tables
            'V11', 'V12', 'V13', 'V21', 'V22', 'V23', 'V31', 'V32', 'V33'
        ];
        
        $tableStatus = [];
        $today = now()->format('Y-m-d');
        
        // Initialize all tables as available
        foreach ($allTables as $table) {
            $tableStatus[$table] = 'available';
        }
        
        // Check for reservations today and mark tables as reserved
        $todayReservations = Book::whereDate('date', $today)
            ->whereIn('status', ['pending', 'approved'])
            ->get();
            
        foreach ($todayReservations as $reservation) {
            if ($reservation->table_number && isset($tableStatus[$reservation->table_number])) {
                $tableStatus[$reservation->table_number] = 'reserved';
            }
        }
        
        // Apply admin overrides from database
        $adminOverrides = TableStatus::all()->pluck('status', 'table_number')->toArray();
        foreach ($adminOverrides as $table => $status) {
            if (isset($tableStatus[$table])) {
                $tableStatus[$table] = $status;
            }
        }
        
        return $tableStatus;
    }

    /**
     * Get real table status from database and admin overrides
     */
    private function getRealTableStatus()
    {
        return $this->getAllTableStatuses();
    }
    
    /**
     * Broadcast table status update to all clients
     */
    private function broadcastTableStatusUpdate($tableNumber, $status)
    {
        // This will be used to notify all connected clients about table status changes
        // For now, we'll use a simple approach with localStorage and events
        $updateData = [
            'table_number' => $tableNumber,
            'status' => $status,
            'timestamp' => now()->toISOString()
        ];
        
        // Store the update in session for immediate access
        $updates = session('table_status_updates', []);
        $updates[] = $updateData;
        session(['table_status_updates' => $updates]);
    }

    // -------------------- RESERVATION APPROVAL --------------------
    public function approveReservation(Request $request, $id)
    {
        try {
            \Log::info('=== APPROVE RESERVATION REQUEST ===');
            \Log::info('Attempting to approve reservation ID: ' . $id);
            \Log::info('Request method: ' . $request->method());
            \Log::info('Request URL: ' . $request->fullUrl());
            \Log::info('Request headers: ' . json_encode($request->headers->all()));
            \Log::info('Request data: ' . json_encode($request->all()));
            
            $reservation = Book::findOrFail($id);
            \Log::info('Found reservation: ' . $reservation->toJson());
            
            $reservation->status = 'approved';
            $reservation->save();
            
            // Create notification for the user
            if ($reservation->user_id) {
                // Format date and time exactly as customer entered (no extra formatting)
                $dateFormatted = $reservation->date instanceof \Carbon\Carbon 
                    ? $reservation->date->format('Y-m-d') 
                    : $reservation->date;
                $timeFormatted = $reservation->time_in instanceof \Carbon\Carbon 
                    ? $reservation->time_in->format('H:i') 
                    : (is_string($reservation->time_in) ? substr($reservation->time_in, 11, 5) : $reservation->time_in);
                $timeOutFormatted = $reservation->time_out instanceof \Carbon\Carbon
                    ? $reservation->time_out->format('H:i')
                    : (is_string($reservation->time_out) ? substr($reservation->time_out, 11, 5) : $reservation->time_out);
                
                \App\Models\Notification::create([
                    'user_id' => $reservation->user_id,
                    'type' => 'reservation_approved',
                    'message' => "Your table reservation has been approved! 🎉",
                    'is_read' => false,
                    'data' => [
                        'reservation_id' => $reservation->id,
                        'date' => $dateFormatted,
                        'time' => $timeFormatted,
                        'time_out' => $timeOutFormatted,
                        'table' => $reservation->table_number,
                        'guests' => $reservation->guest
                    ]
                ]);
            }
            
            \Log::info('Reservation approved successfully');
            
            // Trigger real-time update for public calendar
            $this->broadcastReservationUpdate($reservation);

            return response()->json([
                'success' => true,
                'message' => 'Reservation approved successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error approving reservation: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error approving reservation: ' . $e->getMessage()
            ], 500);
        }
    }

    public function cancelReservation(Request $request, $id)
    {
        try {
            \Log::info('=== CANCEL RESERVATION REQUEST ===');
            \Log::info('Attempting to cancel reservation ID: ' . $id);
            \Log::info('Request method: ' . $request->method());
            \Log::info('Request URL: ' . $request->fullUrl());
            \Log::info('Request headers: ' . json_encode($request->headers->all()));
            \Log::info('Request data: ' . json_encode($request->all()));
            
            $reservation = Book::findOrFail($id);
            \Log::info('Found reservation: ' . $reservation->toJson());
            $reservation->status = 'cancelled';
            $reservation->save();
            
            // Create notification for the user
            if ($reservation->user_id) {
                // Format date and time exactly as customer entered (no extra formatting)
                $dateFormatted = $reservation->date instanceof \Carbon\Carbon 
                    ? $reservation->date->format('Y-m-d') 
                    : $reservation->date;
                $timeFormatted = $reservation->time_in instanceof \Carbon\Carbon 
                    ? $reservation->time_in->format('H:i') 
                    : (is_string($reservation->time_in) ? substr($reservation->time_in, 11, 5) : $reservation->time_in);
                $timeOutFormatted = $reservation->time_out instanceof \Carbon\Carbon
                    ? $reservation->time_out->format('H:i')
                    : (is_string($reservation->time_out) ? substr($reservation->time_out, 11, 5) : $reservation->time_out);
                
                \App\Models\Notification::create([
                    'user_id' => $reservation->user_id,
                    'type' => 'reservation_cancelled',
                    'message' => "Your table reservation has been cancelled. 😔",
                    'is_read' => false,
                    'data' => [
                        'reservation_id' => $reservation->id,
                        'date' => $dateFormatted,
                        'time' => $timeFormatted,
                        'time_out' => $timeOutFormatted,
                        'table' => $reservation->table_number,
                        'guests' => $reservation->guest
                    ]
                ]);
            }
            
            // Trigger real-time update for public calendar
            $this->broadcastReservationUpdate($reservation);

            return response()->json([
                'success' => true,
                'message' => 'Reservation cancelled successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error cancelling reservation: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteReservation($id)
    {
        try {
            // Log the attempt
            \Log::info('Attempting to archive reservation with ID: ' . $id);
            
            $reservation = Book::find($id);
            
            if (!$reservation) {
                \Log::warning('Reservation not found with ID: ' . $id);
                return redirect()->back()->with('error', 'Reservation not found');
            }
            
            \Log::info('Found reservation: ' . $reservation->toJson());
            
            $reservation->is_archived = true;
            $reservation->save();
            
            \Log::info('Reservation archived successfully');

            return redirect()->back()->with('message', 'Reservation archived successfully');
        } catch (\Exception $e) {
            \Log::error('Error archiving reservation: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->back()->with('error', 'Error archiving reservation: ' . $e->getMessage());
        }
    }

    /**
     * Permanently delete a reservation (used by admin calendar view).
     */
    public function forceDeleteReservation($id)
    {
        try {
            \Log::info('Attempting to permanently delete reservation with ID: ' . $id);

            $reservation = Book::find($id);

            if (!$reservation) {
                \Log::warning('Reservation not found for permanent delete with ID: ' . $id);
                return response()->json([
                    'success' => false,
                    'message' => 'Reservation not found',
                ], 404);
            }

            $reservation->delete();

            \Log::info('Reservation permanently deleted');

            return response()->json([
                'success' => true,
                'message' => 'Reservation deleted successfully',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error permanently deleting reservation: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Error deleting reservation: ' . $e->getMessage(),
            ], 500);
        }
    }

    // -------------------- CATEGORY MANAGEMENT --------------------
    public function categories()
    {
        $categories = Category::with('subcategories')->get();
        return view('admin.categories', compact('categories'));
    }

    public function add_category(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->subtitle = $request->subtitle;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/imgs'), $filename);
            $category->image = $filename;
        }

        $category->save();

        return redirect()->back()->with('message', 'Category added successfully!');
    }

    public function delete_category($id)
    {
        $category = Category::find($id);
        if ($category) {
            // Delete all foods in this category
            Food::where('category_id', $id)->delete();
            
            $category->delete();
            return redirect()->back()->with('message', 'Category and all related foods deleted successfully!');
        }
        return redirect()->back()->with('error', 'Category not found!');
    }

    // -------------------- SUBCATEGORY MANAGEMENT --------------------
    public function add_subcategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id'
        ]);

        Subcategory::create([
            'name' => $request->name,
            'category_id' => $request->category_id
        ]);

        return redirect()->back()->with('message', 'Subcategory added successfully!');
    }

    public function delete_subcategory($id)
    {
        $subcategory = Subcategory::find($id);
        if ($subcategory) {
            $subcategory->delete();
            return redirect()->back()->with('message', 'Subcategory deleted successfully!');
        }
        return redirect()->back()->with('error', 'Subcategory not found!');
    }

    public function get_subcategories($categoryId)
    {
        $subcategories = Subcategory::where('category_id', $categoryId)->get();
        return response()->json($subcategories);
    }

    public function update_category(Request $request, $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return redirect()->back()->with('error', 'Category not found!');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $category->name = $request->name;
        $category->subtitle = $request->subtitle;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image && file_exists(public_path('assets/imgs/' . $category->image))) {
                unlink(public_path('assets/imgs/' . $category->image));
            }
            
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/imgs'), $filename);
            $category->image = $filename;
        }

        $category->save();

        return redirect()->back()->with('message', 'Category updated successfully!');
    }

    public function update_subcategory(Request $request, $id)
    {
        $subcategory = Subcategory::find($id);
        if (!$subcategory) {
            return redirect()->back()->with('error', 'Subcategory not found!');
        }

        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $subcategory->name = $request->name;
        $subcategory->save();

        return redirect()->back()->with('message', 'Subcategory updated successfully!');
    }
    
    /**
     * Broadcast reservation update to trigger real-time calendar updates
     */
    private function broadcastReservationUpdate($reservation)
    {
        try {
            // Log the update for debugging
            \Log::info('Broadcasting reservation update for ID: ' . $reservation->id . ' with status: ' . $reservation->status);
            
            // For now, we'll use a simple approach with localStorage
            // In a production environment, you might want to use WebSockets or Server-Sent Events
            // This will be handled by the frontend polling mechanism we implemented
            
        } catch (\Exception $e) {
            \Log::error('Error broadcasting reservation update: ' . $e->getMessage());
        }
    }

    // -------------------- EVENT BOOKING MANAGEMENT --------------------
    
    /**
     * Display all event bookings
     */
    public function eventBookings()
    {
        $eventBookings = EventBooking::where('is_archived', false)
            ->with(['eventType', 'venueType', 'packageInclusion'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.event_bookings', compact('eventBookings'));
    }

    /**
     * Display archived event bookings
     */
    public function archivedEventBookings()
    {
        $eventBookings = EventBooking::where('is_archived', true)
            ->with(['eventType', 'venueType', 'packageInclusion'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.archived_event_bookings', compact('eventBookings'));
    }

    /**
     * Update event booking status
     */
    public function updateEventBookingStatus(Request $request, $id)
    {
        try {
            $booking = EventBooking::findOrFail($id);
            $newStatus = $request->input('status');
            
            // Validate status
            $validStatuses = ['Pending', 'Paid', 'Cancelled'];
            if (!in_array($newStatus, $validStatuses)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid status'
                ], 400);
            }

            // Business rule: once a booking is accepted and marked as Paid,
            // it can no longer be cancelled.
            if ($booking->status === 'Paid' && $newStatus === 'Cancelled') {
                return response()->json([
                    'success' => false,
                    'message' => 'Paid bookings cannot be cancelled.'
                ], 400);
            }
            
            if ($newStatus === 'Paid' && is_null($booking->payment_confirmed_at)) {
                $booking->payment_confirmed_at = now();
            }

            $booking->status = $newStatus;
            $booking->save();
            
            // Create notification for the user if they have an account
            if ($booking->email) {
                $this->createEventBookingNotification($booking, $newStatus);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Event booking status updated successfully',
                'booking' => $booking
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error updating event booking status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating event booking status'
            ], 500);
        }
    }

    /**
     * Archive event booking (instead of delete)
     */
    public function deleteEventBooking($id)
    {
        try {
            $booking = EventBooking::findOrFail($id);
            $booking->is_archived = true;
            $booking->save();
            
            return redirect()->back()->with('message', 'Event booking archived successfully');
        } catch (\Exception $e) {
            \Log::error('Error archiving event booking: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error archiving event booking');
        }
    }

    /**
     * View event booking details
     */
    public function viewEventBooking($id)
    {
        $booking = EventBooking::with(['eventType', 'venueType'])->findOrFail($id);
        return view('admin.event_booking_details', compact('booking'));
    }

    /**
     * Create notification for event booking status change
     */
    private function createEventBookingNotification($booking, $status)
    {
        // Ensure related models are available
        $booking->loadMissing('packageInclusion');

        $statusMessages = [
            'Pending' => 'Your event booking is pending approval',
            'Paid' => '✅ Your event booking has been ACCEPTED and payment has been CONFIRMED! Your event is all set.',
            'Cancelled' => 'Your event booking has been cancelled. If you have any questions, please contact us.'
        ];

        $statusTitles = [
            'Pending' => 'Event Booking Pending',
            'Paid' => '🎉 Booking Accepted & Payment Confirmed',
            'Cancelled' => 'Event Booking Cancelled'
        ];

        $message = $statusMessages[$status] ?? 'Your event booking status has been updated';
        $title = $statusTitles[$status] ?? 'Event Booking Update';
        $eventDateFormatted = $booking->event_date->format('M d, Y');

        // Package inclusion name (if any) with pax included
        $package = optional($booking->packageInclusion);
        $packageName = $package->name;
        $paxLabel = null;
        if (!is_null($package->pax_min) || !is_null($package->pax_max)) {
            if (!is_null($package->pax_min) && !is_null($package->pax_max) && $package->pax_min != $package->pax_max) {
                $paxLabel = $package->pax_min . '–' . $package->pax_max . ' pax';
            } else {
                $paxValue = $package->pax_min ?? $package->pax_max;
                if (!is_null($paxValue)) {
                    $paxLabel = $paxValue . ' pax';
                }
            }
        }
        $packageDisplayName = $packageName;
        if ($packageDisplayName && $paxLabel) {
            $packageDisplayName .= ' (' . $paxLabel . ')';
        }

        // Format customer-selected timeslot
        $timeInFormatted = $booking->time_in instanceof \Carbon\Carbon
            ? $booking->time_in->format('g:i A')
            : $booking->time_in;

        $timeOutFormatted = $booking->time_out instanceof \Carbon\Carbon
            ? $booking->time_out->format('g:i A')
            : $booking->time_out;

        $timeSlot = null;
        if ($timeInFormatted && $timeOutFormatted) {
            $timeSlot = $timeInFormatted . ' – ' . $timeOutFormatted;
        } elseif ($timeInFormatted) {
            $timeSlot = $timeInFormatted;
        }

        // Amount to display in notifications:
        // Always show the selected package price so customer clearly sees
        // the package cost, regardless of payment option or status.
        $packagePrice = optional($booking->packageInclusion)->price;
        $amountForNotification = $packagePrice ?? $booking->down_payment_amount;

        // Build readable details for the notification message
        $detailsParts = ["Event on {$eventDateFormatted}"];
        if ($packageDisplayName) {
            $detailsParts[] = "Package: {$packageDisplayName}";
        }
        if ($timeSlot) {
            $detailsParts[] = "Time: {$timeSlot}";
        }
        $detailsText = implode(' | ', $detailsParts);
        
        // Try to find user by email
        $user = User::where('email', $booking->email)->first();
        
        if ($user) {
            Notification::create([
                'user_id' => $user->id,
                'event_booking_id' => $booking->id,
                'title' => $title,
                'message' => $message . ' - ' . $detailsText,
                'type' => 'event_booking',
                'is_read' => false,
                'data' => [
                    'booking_id' => $booking->id,
                    'status' => $status,
                    'event_date' => $booking->event_date->format('Y-m-d'),
                    // New preferred fields for frontend display
                    'package_inclusion' => $packageDisplayName,
                    'time_slot' => $timeSlot,
                    // Amount based on selected package (fallback to down payment if needed)
                    'amount' => $amountForNotification
                ]
            ]);

            // Send email notification if user has email
            if ($booking->email) {
                $this->sendEventBookingEmailNotification($booking, $status, $title, $message);
            }
        }
    }

    /**
     * Send email notification for event booking status change
     */
    private function sendEventBookingEmailNotification($booking, $status, $title, $message)
    {
        try {
            $data = [
                'booking' => $booking,
                'status' => $status,
                'title' => $title,
                'message' => $message,
                'event_date' => $booking->event_date->format('F d, Y'),
                'guests' => $booking->number_of_guests,
                'amount' => number_format($booking->down_payment_amount, 2)
            ];

            \Mail::send('emails.event_booking_status', $data, function($mail) use ($booking, $title) {
                $mail->to($booking->email, $booking->full_name)
                     ->subject($title . ' - ' . config('app.name'));
            });

            \Log::info("Event booking email notification sent to {$booking->email} for booking ID {$booking->id}");
        } catch (\Exception $e) {
            \Log::error("Failed to send event booking email notification: " . $e->getMessage());
        }
    }

    /**
     * Get event booking statistics
     */
    public function getEventBookingStats()
    {
        // Only count active (non-archived) event bookings in stats
        $totalBookings = EventBooking::where('is_archived', false)->count();
        $pendingBookings = EventBooking::where('is_archived', false)
            ->where('status', 'Pending')
            ->count();
        $paidBookings = EventBooking::where('is_archived', false)
            ->where('status', 'Paid')
            ->count();
        $cancelledBookings = EventBooking::where('is_archived', false)
            ->where('status', 'Cancelled')
            ->count();
        
        $totalRevenue = EventBooking::where('is_archived', false)
            ->where('status', 'Paid')
            ->sum(DB::raw('COALESCE(amount_paid, down_payment_amount)'));
        
        return response()->json([
            'total' => $totalBookings,
            'pending' => $pendingBookings,
            'paid' => $paidBookings,
            'cancelled' => $cancelledBookings,
            'revenue' => $totalRevenue
        ]);
    }

    // -------------------- NOTIFICATION MANAGEMENT --------------------
    
    /**
     * Display all notifications
     */
    public function notifications(Request $request)
    {
        $notificationsQuery = Notification::with(['user', 'eventBooking', 'order'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('q')) {
            $q = trim((string) $request->input('q'));
            $notificationsQuery->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('message', 'like', "%{$q}%")
                    ->orWhere('type', 'like', "%{$q}%");
            });
        }

        $notifications = $notificationsQuery->paginate(20)->withQueryString();
            
        $unreadCount = Notification::where('is_read', false)->count();
        
        return view('admin.notifications', compact('notifications', 'unreadCount'));
    }

    /**
     * Mark notification as read
     */
    public function markNotificationAsRead($id)
    {
        try {
            $notification = Notification::findOrFail($id);
            $notification->is_read = true;
            $notification->save();
            
            return redirect()->back()->with('message', 'Notification marked as read');
        } catch (\Exception $e) {
            \Log::error('Error marking notification as read: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error marking notification as read');
        }
    }

    /**
     * Mark all notifications as read
     */
    public function markAllNotificationsAsRead()
    {
        try {
            Notification::where('is_read', false)->update(['is_read' => true]);
            
            return redirect()->back()->with('message', 'All notifications marked as read');
        } catch (\Exception $e) {
            \Log::error('Error marking all notifications as read: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error marking all notifications as read');
        }
    }

    /**
     * Delete a notification (explicit action)
     */
    public function deleteNotification($id)
    {
        try {
            $notification = Notification::findOrFail($id);
            $notification->delete();

            return redirect()->back()->with('message', 'Notification deleted');
        } catch (\Exception $e) {
            \Log::error('Error deleting notification: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error deleting notification');
        }
    }

    // -------------------- BUNDLE MANAGEMENT --------------------
    
    /**
     * Display bundle management page
     */
    public function bundles()
    {
        $bundles = Bundle::with(['category', 'subcategory', 'foods'])->get();
        $categories = Category::where('is_active', true)->get();
        $subcategories = Subcategory::where('is_active', true)->get();
        $foods = Food::all();
        
        return view('admin.bundles', compact('bundles', 'categories', 'subcategories', 'foods'));
    }

    /**
     * Create a new bundle
     */
    public function createBundle(Request $request)
    {
        try {
            \Log::info('Bundle creation request received', $request->all());
            
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'bundle_price' => 'required|numeric|min:0',
                'category_id' => 'required|exists:categories,id',
                'subcategory_id' => 'nullable|exists:subcategories,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'food_ids' => 'nullable|array',
                'food_ids.*' => 'nullable|exists:food,id',
                'quantities' => 'nullable|array',
                'quantities.*' => 'nullable|integer|min:1',
                'new_food_titles' => 'nullable|array',
                'new_food_titles.*' => 'nullable|string|max:255',
                'new_food_descriptions' => 'nullable|array',
                'new_food_descriptions.*' => 'nullable|string',
                'new_food_images' => 'nullable|array',
                'new_food_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $bundle = new Bundle();
            $bundle->name = $request->name;
            $bundle->description = $request->description;
            $bundle->bundle_price = $request->bundle_price;
            $bundle->category_id = $request->category_id;
            $bundle->subcategory_id = $request->subcategory_id;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('food_img'), $filename);
                $bundle->image = $filename;
            }

            $bundle->save();
            \Log::info('Bundle saved with ID: ' . $bundle->id);

            // Attach existing foods to bundle with quantities (only if foods are provided)
            if ($request->food_ids && count($request->food_ids) > 0) {
                $foodData = [];
                foreach ($request->food_ids as $index => $foodId) {
                    if (!empty($foodId)) { // Only add if food is selected and not empty
                        $foodData[$foodId] = ['quantity' => $request->quantities[$index] ?? 1];
                    }
                }
                if (count($foodData) > 0) {
                    $bundle->foods()->attach($foodData);
                    \Log::info('Attached existing foods to bundle');
                }
            }

            // Create new food titles and attach to bundle
            if ($request->new_food_titles && count($request->new_food_titles) > 0) {
                foreach ($request->new_food_titles as $index => $title) {
                    if (!empty($title)) {
                        // Create new food item
                        $newFood = new Food();
                        $newFood->title = $title;
                        $newFood->detail = $request->new_food_descriptions[$index] ?? '';
                        $newFood->price = 0; // No individual price for bundle food titles
                        $newFood->category_id = $bundle->category_id;
                        $newFood->subcategory_id = $bundle->subcategory_id;
                        $newFood->type = 'bundle_food'; // Mark as bundle food
                        
                        // Handle image upload for new food
                        if ($request->hasFile("new_food_images.{$index}")) {
                            $file = $request->file("new_food_images.{$index}");
                            $filename = time() . '_' . $index . '.' . $file->getClientOriginalExtension();
                            $file->move(public_path('food_img'), $filename);
                            $newFood->image = $filename;
                        }
                        
                        $newFood->save();
                        
                        // Attach to bundle with quantity 1
                        $bundle->foods()->attach($newFood->id, ['quantity' => 1]);
                    }
                }
                \Log::info('Created and attached new food titles to bundle');
            }

            return redirect()->back()->with('message', 'Bundle created successfully!');
            
        } catch (\Exception $e) {
            \Log::error('Error creating bundle: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error creating bundle: ' . $e->getMessage());
        }
    }

    /**
     * Update a bundle
     */
    public function updateBundle(Request $request, $id)
    {
        $bundle = Bundle::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'bundle_price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $bundle->name = $request->name;
        $bundle->description = $request->description;
        $bundle->bundle_price = $request->bundle_price;
        $bundle->category_id = $request->category_id;
        $bundle->subcategory_id = $request->subcategory_id;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($bundle->image && file_exists(public_path('food_img/' . $bundle->image))) {
                unlink(public_path('food_img/' . $bundle->image));
            }
            
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('food_img'), $filename);
            $bundle->image = $filename;
        }

        $bundle->save();

        // Note: Foods are managed separately through the Manage Foods modal
        // This update only changes bundle details, not the foods in it

        return redirect()->back()->with('message', 'Bundle updated successfully!');
    }

    /**
     * Delete a bundle
     */
    public function deleteBundle($id)
    {
        $bundle = Bundle::find($id);
        if ($bundle) {
            // Delete image if exists
            if ($bundle->image && file_exists(public_path('food_img/' . $bundle->image))) {
                unlink(public_path('food_img/' . $bundle->image));
            }
            
            $bundle->delete();
            return redirect()->back()->with('message', 'Bundle deleted successfully!');
        }
        return redirect()->back()->with('error', 'Bundle not found!');
    }

    /**
     * Toggle bundle active status
     */
    public function toggleBundleStatus($id)
    {
        $bundle = Bundle::find($id);
        if ($bundle) {
            $bundle->is_active = !$bundle->is_active;
            $bundle->save();
            return redirect()->back()->with('message', 'Bundle status updated successfully!');
        }
        return redirect()->back()->with('error', 'Bundle not found!');
    }

    /**
     * Add food to bundle
     */
    public function addFoodToBundle(Request $request, $bundleId)
    {
        $request->validate([
            'food_name' => 'required|string|max:255',
            'food_description' => 'nullable|string',
            'quantity' => 'required|integer|min:1'
        ]);

        $bundle = Bundle::find($bundleId);
        if (!$bundle) {
            return redirect()->back()->with('error', 'Bundle not found!');
        }

        $foodName = trim($request->food_name);
        $quantity = $request->quantity;
        $foodDescription = $request->food_description;

        // Check if food with this name already exists
        $food = Food::where('title', $foodName)->first();

        if (!$food) {
            // Create new food item
            $food = new Food();
            $food->title = $foodName;
            $food->price = 0; // No individual price, bundle has one price
            $food->detail = $foodDescription;
            $food->category_id = $bundle->category_id;
            $food->subcategory_id = $bundle->subcategory_id;
            
            // Set type and subcategory for backward compatibility
            if ($bundle->category) {
                $food->type = $bundle->category->name;
            }
            if ($bundle->subcategory) {
                $food->subcategory = $bundle->subcategory->name;
            }
            
            $food->save();
        }

        // Check if food is already in bundle
        if ($bundle->foods()->where('food_id', $food->id)->exists()) {
            return redirect()->back()->with('error', 'This food is already in the bundle!');
        }

        // Add food to bundle
        $bundle->foods()->attach($food->id, ['quantity' => $quantity]);

        return redirect()->back()->with('message', 'Food added to bundle successfully!');
    }

    /**
     * Update food quantity in bundle
     */
    public function updateFoodQuantityInBundle(Request $request, $bundleId, $foodId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $bundle = Bundle::find($bundleId);
        if (!$bundle) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Bundle not found!']);
            }
            return redirect()->back()->with('error', 'Bundle not found!');
        }

        $food = Food::find($foodId);
        if (!$food) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Food not found!']);
            }
            return redirect()->back()->with('error', 'Food not found!');
        }

        // Check if food is in bundle
        if (!$bundle->foods()->where('food_id', $foodId)->exists()) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Food is not in this bundle!']);
            }
            return redirect()->back()->with('error', 'Food is not in this bundle!');
        }

        // Update quantity
        $bundle->foods()->updateExistingPivot($foodId, ['quantity' => $request->quantity]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Food quantity updated successfully!']);
        }

        return redirect()->back()->with('message', 'Food quantity updated successfully!');
    }

    /**
     * Remove food from bundle
     */
    public function removeFoodFromBundle($bundleId, $foodId)
    {
        $bundle = Bundle::find($bundleId);
        if (!$bundle) {
            return redirect()->back()->with('error', 'Bundle not found!');
        }

        $food = Food::find($foodId);
        if (!$food) {
            return redirect()->back()->with('error', 'Food not found!');
        }

        // Remove food from bundle
        $bundle->foods()->detach($foodId);

        return redirect()->back()->with('message', 'Food removed from bundle successfully!');
    }

    // -------------------- REVIEW MANAGEMENT --------------------
    /**
     * Display all reviews for admin management
     */
    public function reviews()
    {
        $reviews = Review::orderBy('created_at', 'desc')->get();
        return view('admin.reviews', compact('reviews'));
    }

    /**
     * Approve a review
     */
    public function approveReview($id)
    {
        $review = Review::find($id);
        if ($review) {
            $review->status = 'approved';
            $review->save();
            return redirect()->back()->with('message', 'Review approved successfully!');
        }
        return redirect()->back()->with('error', 'Review not found!');
    }

    /**
     * Reject a review
     */
    public function rejectReview($id)
    {
        $review = Review::find($id);
        if ($review) {
            $review->status = 'rejected';
            $review->save();
            return redirect()->back()->with('message', 'Review rejected successfully!');
        }
        return redirect()->back()->with('error', 'Review not found!');
    }

    /**
     * Edit review description
     */
    public function editReview($id)
    {
        $review = Review::find($id);
        if (!$review) {
            return redirect()->back()->with('error', 'Review not found!');
        }
        return view('admin.edit_review', compact('review'));
    }

    /**
     * Update review description
     */
    public function updateReview(Request $request, $id)
    {
        $request->validate([
            'description' => 'nullable|string|max:1000',
            'customer_name' => 'required|string|max:255',
        ]);

        $review = Review::find($id);
        if (!$review) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['error' => 'Review not found!'], 404);
            }
            return redirect()->back()->with('error', 'Review not found!');
        }

        $review->description = $request->description;
        $review->customer_name = $request->customer_name;
        $review->save();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Review updated successfully!',
                'review' => $review
            ]);
        }

        return redirect()->route('admin.reviews')->with('message', 'Review updated successfully!');
    }

    /**
     * Delete a review
     */
    public function deleteReview($id)
    {
        $review = Review::find($id);
        if ($review) {
            $review->delete();
            return redirect()->back()->with('message', 'Review deleted successfully!');
        }
        return redirect()->back()->with('error', 'Review not found!');
    }

    // -------------------- PAX OPTIONS MANAGEMENT --------------------

    /**
     * Show Pax options CRUD page.
     */
    public function paxOptions()
    {
        // Safeguard: if the migration has not been run yet, don't crash
        if (!Schema::hasTable('pax_options')) {
            $paxOptions = collect();
            return view('admin.pax_management', [
                'paxOptions' => $paxOptions,
            ])->with('error', 'Pax options table does not exist yet. Please run `php artisan migrate` to enable Pax management.');
        }

        // If table exists but has no rows yet, seed it with the same defaults
        if (PaxOption::count() === 0) {
            foreach ([10, 20, 30, 40, 50, 75, 100, 150, 200, 250, 300] as $index => $value) {
                PaxOption::create([
                    'value' => $value,
                    'label' => $value . ' pax',
                    'is_active' => true,
                    'sort_order' => $index,
                ]);
            }
        }

        $paxOptions = PaxOption::orderBy('sort_order')
            ->orderBy('value')
            ->get();

        return view('admin.pax_management', compact('paxOptions'));
    }

    /**
     * Store a new Pax option.
     */
    public function storePaxOption(Request $request)
    {
        // If table doesn't exist yet, don't attempt to write to it
        if (!Schema::hasTable('pax_options')) {
            return redirect()->back()->with('error', 'Pax options table does not exist yet. Please run `php artisan migrate` before adding pax.');
        }

        $request->validate([
            'value' => 'required|integer|min:1',
            'down_payment' => 'required|numeric|min:0',
            'full_price' => 'required|numeric|min:0|gte:down_payment',
        ]);

        $nextSort = (PaxOption::max('sort_order') ?? 0) + 1;

        PaxOption::create([
            'value' => $request->value,
            'label' => $request->value . ' pax',
            'down_payment' => $request->down_payment,
            'full_price' => $request->full_price,
            'is_active' => true,
            'sort_order' => $nextSort,
        ]);

        return redirect()->back()->with('message', 'Pax option added successfully!');
    }

    /**
     * Update an existing Pax option.
     */
    public function updatePaxOption(Request $request, $id)
    {
        if (!Schema::hasTable('pax_options')) {
            return redirect()->back()->with('error', 'Pax options table does not exist yet. Please run `php artisan migrate` before updating pax.');
        }

        $pax = PaxOption::find($id);
        if (!$pax) {
            return redirect()->back()->with('error', 'Pax option not found!');
        }

        $request->validate([
            'value' => 'required|integer|min:1',
            'down_payment' => 'required|numeric|min:0',
            'full_price' => 'required|numeric|min:0|gte:down_payment',
        ]);

        $pax->value = $request->value;
        $pax->label = $request->value . ' pax'; // keep label in sync automatically
        $pax->down_payment = $request->down_payment;
        $pax->full_price = $request->full_price;
        $pax->is_active = true; // always active when edited from this simple UI
        $pax->save();

        return redirect()->back()->with('message', 'Pax option updated successfully!');
    }

    /**
     * Delete a Pax option.
     */
    public function deletePaxOption($id)
    {
        $pax = PaxOption::find($id);
        if (!$pax) {
            return redirect()->back()->with('error', 'Pax option not found!');
        }

        $pax->delete();

        return redirect()->back()->with('message', 'Pax option deleted successfully!');
    }

    // -------------------- SIMPLE FOOD PACKAGE MANAGEMENT --------------------
    // For listing items like "Chicken", "Vegetable", "Unlimited plain rice" only

    /**
     * Show Food Package Items management page.
     */
    public function foodPackageItems()
    {
        $items = FoodPackageItem::orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.food_package_items', compact('items'));
    }

    // -------------------- FAQ MANAGEMENT (GRANDIYA ASSISTANT) --------------------

    /**
     * Display all FAQs for Grandiya Assistant.
     */
    public function faqs()
    {
        // Safeguard: if the migration has not been run yet, don't crash
        if (!Schema::hasTable('faqs')) {
            $faqs = collect();
            return view('admin.faqs', compact('faqs'))
                ->with('error', 'FAQs table does not exist yet. Please run `php artisan migrate` to enable FAQ management.');
        }

        // If table exists but has no rows yet, seed with the same defaults shown on the home chatbot
        if (Faq::count() === 0) {
            $defaults = [
                [
                    'question' => 'How do I reserve a table?',
                    'answer' => "Navigate to the 'Reservation' section, fill in your details and preferred date/time, then submit your reservation.",
                ],
                [
                    'question' => 'How do I book an event?',
                    'answer' => "Go to the 'Book Event' section, provide event details including event type, venue, date, and number of guests, then complete your booking.",
                ],
                [
                    'question' => 'What payment methods do you accept?',
                    'answer' => 'We accept cash and online payments. A deposit is required upon booking with the balance due on event day.',
                ],
                [
                    'question' => 'Can I cancel my reservation?',
                    'answer' => 'Yes. You can cancel reservations from your account. Please review our cancellation policy for any applicable fees.',
                ],
            ];

            foreach ($defaults as $index => $item) {
                Faq::create([
                    'question' => $item['question'],
                    'answer' => $item['answer'],
                    'is_active' => true,
                    'sort_order' => $index,
                ]);
            }
        }

        $faqs = Faq::orderBy('sort_order')->orderBy('id')->get();

        return view('admin.faqs', compact('faqs'));
    }

    /**
     * Store a new FAQ entry.
     */
    public function storeFaq(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'nullable|string',
        ]);

        $nextSort = (Faq::max('sort_order') ?? 0) + 1;

        Faq::create([
            'question' => trim($request->question),
            'answer' => $request->answer ? trim($request->answer) : null,
            'is_active' => true,
            'sort_order' => $nextSort,
        ]);

        return redirect()->back()->with('message', 'FAQ added successfully!');
    }

    /**
     * Update an existing FAQ entry.
     */
    public function updateFaq(Request $request, $id)
    {
        $faq = Faq::find($id);
        if (!$faq) {
            return redirect()->back()->with('error', 'FAQ not found!');
        }

        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'nullable|string',
        ]);

        $faq->question = trim($request->question);
        $faq->answer = $request->answer ? trim($request->answer) : null;
        // Ensure any edited FAQ is active and visible in the chatbot
        $faq->is_active = true;

        if ($request->filled('sort_order')) {
            $faq->sort_order = (int) $request->sort_order;
        }

        $faq->save();

        return redirect()->back()->with('message', 'FAQ updated successfully!');
    }

    /**
     * Delete an FAQ entry.
     */
    public function deleteFaq($id)
    {
        $faq = Faq::find($id);
        if (!$faq) {
            return redirect()->back()->with('error', 'FAQ not found!');
        }

        $faq->delete();

        return redirect()->back()->with('message', 'FAQ deleted successfully!');
    }

    /**
     * Store a new Food Package item.
     */
    public function storeFoodPackageItem(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'dishes' => 'nullable|string',
        ]);

        $nextSort = (FoodPackageItem::max('sort_order') ?? 0) + 1;

        FoodPackageItem::create([
            'name' => trim($request->name),
            'dishes' => $request->dishes ? trim($request->dishes) : null,
            'sort_order' => $nextSort,
        ]);

        return redirect()->back()->with('message', 'Food package item added successfully!');
    }

    /**
     * Update a Food Package item.
     */
    public function updateFoodPackageItem(Request $request, $id)
    {
        $item = FoodPackageItem::find($id);
        if (!$item) {
            return redirect()->back()->with('error', 'Food package item not found!');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'dishes' => 'nullable|string',
        ]);

        $item->name = trim($request->name);
        $item->dishes = $request->dishes ? trim($request->dishes) : null;
        $item->save();

        return redirect()->back()->with('message', 'Food package item updated successfully!');
    }

    /**
     * Delete a Food Package item.
     */
    public function deleteFoodPackageItem($id)
    {
        $item = FoodPackageItem::find($id);
        if (!$item) {
            return redirect()->back()->with('error', 'Food package item not found!');
        }

        $item->delete();

        return redirect()->back()->with('message', 'Food package item deleted successfully!');
    }

    // -------------------- ANNOUNCEMENT MANAGEMENT --------------------

    /**
     * Display all announcements
     */
    public function announcements()
    {
        $announcements = Announcement::orderBy('created_at', 'desc')->get();
        return view('admin.announcements', compact('announcements'));
    }

    /**
     * Store a new announcement
     *
     * New announcements are immediately active and approved
     * so they automatically appear on the home page.
     */
    public function storeAnnouncement(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $announcement = new Announcement();
        $announcement->title = null; // Title removed from form
        $announcement->content = $request->content;
        // Always mark new announcements as active and approved
        $announcement->is_active = true;
        $announcement->status = 'approved';
        $announcement->start_date = null;
        $announcement->end_date = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/imgs'), $filename);
            $announcement->image = $filename;
        }

        $announcement->save();

        return redirect()->route('admin.announcements')->with('message', 'Announcement created successfully!');
    }

    /**
     * Update an existing announcement
     *
     * Keep announcements active so updates remain visible on home.
     */
    public function updateAnnouncement(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $announcement = Announcement::find($id);
        if (!$announcement) {
            return redirect()->back()->with('error', 'Announcement not found!');
        }

        $announcement->content = $request->content;
        // Ensure announcement stays active after update
        $announcement->is_active = true;
        $announcement->start_date = null;
        $announcement->end_date = null;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($announcement->image && file_exists(public_path('assets/imgs/' . $announcement->image))) {
                unlink(public_path('assets/imgs/' . $announcement->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/imgs'), $filename);
            $announcement->image = $filename;
        }

        $announcement->save();

        return redirect()->route('admin.announcements')->with('message', 'Announcement updated successfully!');
    }

    /**
     * Delete an announcement
     */
    public function deleteAnnouncement($id)
    {
        $announcement = Announcement::find($id);
        if (!$announcement) {
            return redirect()->back()->with('error', 'Announcement not found!');
        }

        // Delete image if exists
        if ($announcement->image && file_exists(public_path('assets/imgs/' . $announcement->image))) {
            unlink(public_path('assets/imgs/' . $announcement->image));
        }

        $announcement->delete();

        return redirect()->back()->with('message', 'Announcement deleted successfully!');
    }

    /**
     * Approve an announcement
     */
    public function approveAnnouncement($id)
    {
        $announcement = Announcement::find($id);
        if (!$announcement) {
            return redirect()->back()->with('error', 'Announcement not found!');
        }

        $announcement->status = 'approved';
        $announcement->save();

        return redirect()->back()->with('message', 'Announcement approved successfully!');
    }

    /**
     * Reject an announcement
     */
    public function rejectAnnouncement($id)
    {
        $announcement = Announcement::find($id);
        if (!$announcement) {
            return redirect()->back()->with('error', 'Announcement not found!');
        }

        $announcement->status = 'rejected';
        $announcement->save();

        return redirect()->back()->with('message', 'Announcement rejected successfully!');
    }

    // -------------------- DASHBOARD ANALYTICS --------------------
    
    /**
     * Get dashboard statistics for analytics
     */
    public function dashboardStats()
    {
        $now = now();
        $today = $now->copy()->startOfDay();
        $sevenDaysAgo = $now->copy()->subDays(7)->startOfDay();

        // Summary metrics (net revenue includes orders, event bookings, and processed refunds)
        $orderRevenueTotal = Order::where('delivery_status', 'Delivered')->sum('price');
        $orderRevenueToday = Order::where('delivery_status', 'Delivered')
            ->whereDate('created_at', $today)
            ->sum('price');

        // Event booking revenue (use recorded amount for Paid, non-archived bookings)
        $eventRevenue = EventBooking::where('is_archived', false)
            ->where('status', 'Paid')
            ->sum(DB::raw('COALESCE(amount_paid, down_payment_amount)'));

        $eventRevenueToday = EventBooking::where('is_archived', false)
            ->where('status', 'Paid')
            ->whereDate('created_at', $today)
            ->sum(DB::raw('COALESCE(amount_paid, down_payment_amount)'));

        // Refunds decrease revenue – deduct as soon as approved (and when refunded)
        $refundsTotal = ReturnRefund::whereIn('status', ['approved', 'refunded'])
            ->sum('refund_amount');

        $refundsToday = ReturnRefund::where('status', 'refunded')
            ->whereDate('processed_at', $today)
            ->sum('refund_amount');

        $totalRevenue = ($orderRevenueTotal + $eventRevenue) - $refundsTotal;
        $revenueToday = ($orderRevenueToday + $eventRevenueToday) - $refundsToday;

        // Show grouped (per-customer) active orders in the Orders card so it matches the Orders page
        $activeOrders = Order::where('is_archived', false)
            ->orderBy('created_at', 'desc')
            ->get();

        $groupedOrderStats = $activeOrders->groupBy(function ($order) {
            return $order->name . '|' . $order->email . '|' . $order->phone . '|' . $order->address;
        });

        // These counts now mirror the totals shown in resources/views/admin/order.blade.php
        $ordersToday = $groupedOrderStats->count();
        $ordersInProgress = $groupedOrderStats->filter(function ($customerOrders) {
            $firstOrder = $customerOrders->first();
            return ($firstOrder->delivery_status ?? 'Pending') === 'In Progress';
        })->count();
        $ordersDelivered = $groupedOrderStats->filter(function ($customerOrders) {
            $firstOrder = $customerOrders->first();
            return ($firstOrder->delivery_status ?? 'Pending') === 'Delivered';
        })->count();

        $pendingReservations = Book::where('is_archived', false)
            ->where('status', 'pending')
            ->count();
        $upcomingReservations = Book::where('is_archived', false)
            ->where('status', 'approved')
            ->where('date', '>=', $today)
            ->count();

        // Only count active (non-archived) event bookings in dashboard metrics
        $pendingEventBookings = EventBooking::where('is_archived', false)
            ->where('status', 'Pending')
            ->count();
        $paidEventBookings = EventBooking::where('is_archived', false)
            ->where('status', 'Paid')
            ->count();

        // Chart data - last 7 days
        $labels = [];
        $ordersData = [];
        $reservationsData = [];
        $eventsData = [];
        $revenueData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = $now->copy()->subDays($i);
            $dateStart = $date->copy()->startOfDay();
            $dateEnd = $date->copy()->endOfDay();
            
            $labels[] = $date->format('M d');
            
            $ordersData[] = Order::whereBetween('created_at', [$dateStart, $dateEnd])->count();
            $reservationsData[] = Book::whereBetween('created_at', [$dateStart, $dateEnd])->count();
            $eventsData[] = EventBooking::whereBetween('created_at', [$dateStart, $dateEnd])->count();

            // Net revenue per day (orders + event bookings - refunds)
            $dailyOrderRevenue = Order::where('delivery_status', 'Delivered')
                ->whereBetween('created_at', [$dateStart, $dateEnd])
                ->sum('price');

            $dailyEventRevenue = EventBooking::where('is_archived', false)
                ->where('status', 'Paid')
                ->whereBetween('created_at', [$dateStart, $dateEnd])
                ->sum(DB::raw('COALESCE(amount_paid, down_payment_amount)'));

            $dailyRefunds = ReturnRefund::where('status', 'refunded')
                ->whereBetween('processed_at', [$dateStart, $dateEnd])
                ->sum('refund_amount');

            $revenueData[] = ($dailyOrderRevenue + $dailyEventRevenue) - $dailyRefunds;
        }

        // Status breakdown
        $orderStatuses = [
            'in_progress' => Order::where('is_archived', false)
                ->where('delivery_status', 'In Progress')
                ->count(),
            'delivered' => Order::where('is_archived', false)
                ->where('delivery_status', 'Delivered')
                ->count(),
            'cancelled' => Order::where('is_archived', false)
                ->where('delivery_status', 'Cancelled')
                ->count()
        ];

        // Recent activity
        $recentOrders = Order::where('is_archived', false)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function($order) {
                return [
                    'id' => $order->id,
                    'title' => $order->foodname ?? 'Order #' . $order->id,
                    'customer' => $order->name ?? 'Guest',
                    'status' => $order->delivery_status ?? 'New',
                    'price' => $order->price ?? 0
                ];
            });

        $recentReservations = Book::where('is_archived', false)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function($reservation) {
                return [
                    'id' => $reservation->id,
                    'name' => $reservation->name ?? 'Guest',
                    'date' => $reservation->date ? $reservation->date->format('M d, Y') : '',
                    'time' => $reservation->time_in ? (is_string($reservation->time_in) ? $reservation->time_in : $reservation->time_in->format('g:i A')) : '',
                    'status' => $reservation->status ?? 'pending'
                ];
            });

        $recentEvents = EventBooking::with(['eventType', 'venueType'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function($event) {
                return [
                    'id' => $event->id,
                    'name' => $event->full_name ?? 'Customer',
                    'event_date' => $event->event_date ? $event->event_date->format('M d, Y') : '',
                    'event_type' => $event->eventType ? $event->eventType->name : 'Event',
                    'venue_type' => $event->venueType ? $event->venueType->name : 'Venue',
                    'status' => $event->status ?? 'Pending',
                    'amount' => $event->amount_paid ?? $event->down_payment_amount ?? 0
                ];
            });

        return response()->json([
            'summary' => [
                'totalRevenue' => $totalRevenue,
                'revenueToday' => $revenueToday,
                'ordersToday' => $ordersToday,
                'ordersInProgress' => $ordersInProgress,
                'ordersDelivered' => $ordersDelivered,
                'pendingReservations' => $pendingReservations,
                'upcomingReservations' => $upcomingReservations,
                'pendingEventBookings' => $pendingEventBookings,
                'paidEventBookings' => $paidEventBookings,
                // Keep separate event revenue for the Event Bookings card
                'eventRevenue' => $eventRevenue
            ],
            'charts' => [
                'labels' => $labels,
                'orders' => $ordersData,
                'reservations' => $reservationsData,
                'events' => $eventsData,
                'revenue' => $revenueData
            ],
            'statuses' => [
                'orders' => $orderStatuses
            ],
            'activity' => [
                'orders' => $recentOrders,
                'reservations' => $recentReservations,
                'events' => $recentEvents
            ],
            'last_refreshed' => $now->toIso8601String()
        ]);
    }

    /**
     * Show admin dashboard with analytics
     */
    public function dashboard()
    {
        $now = now();
        $today = $now->copy()->startOfDay();
        $sevenDaysAgo = $now->copy()->subDays(7)->startOfDay();

        // Summary metrics (net revenue includes orders, event bookings, and processed refunds)
        $orderRevenueTotal = Order::where('delivery_status', 'Delivered')->sum('price');
        $orderRevenueToday = Order::where('delivery_status', 'Delivered')
            ->whereDate('created_at', $today)
            ->sum('price');

        // Event booking revenue (use recorded amount for Paid, non-archived bookings)
        $eventRevenue = EventBooking::where('is_archived', false)
            ->where('status', 'Paid')
            ->sum(DB::raw('COALESCE(amount_paid, down_payment_amount)'));

        $eventRevenueToday = EventBooking::where('is_archived', false)
            ->where('status', 'Paid')
            ->whereDate('created_at', $today)
            ->sum(DB::raw('COALESCE(amount_paid, down_payment_amount)'));

        // Refunds decrease revenue – deduct as soon as approved (and when refunded)
        $refundsTotal = ReturnRefund::whereIn('status', ['approved', 'refunded'])
            ->sum('refund_amount');

        $refundsToday = ReturnRefund::where('status', 'refunded')
            ->whereDate('processed_at', $today)
            ->sum('refund_amount');

        $totalRevenue = ($orderRevenueTotal + $eventRevenue) - $refundsTotal;
        $revenueToday = ($orderRevenueToday + $eventRevenueToday) - $refundsToday;

        // Show grouped (per-customer) active orders in the Orders card so it matches the Orders page
        $activeOrders = Order::where('is_archived', false)
            ->orderBy('created_at', 'desc')
            ->get();

        $groupedOrderStats = $activeOrders->groupBy(function ($order) {
            return $order->name . '|' . $order->email . '|' . $order->phone . '|' . $order->address;
        });

        // These counts now mirror the totals shown in resources/views/admin/order.blade.php
        $ordersToday = $groupedOrderStats->count();
        $ordersInProgress = $groupedOrderStats->filter(function ($customerOrders) {
            $firstOrder = $customerOrders->first();
            return ($firstOrder->delivery_status ?? 'Pending') === 'In Progress';
        })->count();
        $ordersDelivered = $groupedOrderStats->filter(function ($customerOrders) {
            $firstOrder = $customerOrders->first();
            return ($firstOrder->delivery_status ?? 'Pending') === 'Delivered';
        })->count();

        $pendingReservations = Book::where('is_archived', false)
            ->where('status', 'pending')
            ->count();
        $upcomingReservations = Book::where('is_archived', false)
            ->where('status', 'approved')
            ->where('date', '>=', $today)
            ->count();

        // Only count active (non-archived) event bookings in dashboard metrics
        $pendingEventBookings = EventBooking::where('is_archived', false)
            ->where('status', 'Pending')
            ->count();
        $paidEventBookings = EventBooking::where('is_archived', false)
            ->where('status', 'Paid')
            ->count();

        // Chart data - last 7 days
        $labels = [];
        $ordersData = [];
        $reservationsData = [];
        $eventsData = [];
        $revenueData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = $now->copy()->subDays($i);
            $dateStart = $date->copy()->startOfDay();
            $dateEnd = $date->copy()->endOfDay();
            
            $labels[] = $date->format('M d');
            
            $ordersData[] = Order::whereBetween('created_at', [$dateStart, $dateEnd])->count();
            $reservationsData[] = Book::whereBetween('created_at', [$dateStart, $dateEnd])->count();
            $eventsData[] = EventBooking::whereBetween('created_at', [$dateStart, $dateEnd])->count();

            // Net revenue per day (orders + event bookings - refunds)
            $dailyOrderRevenue = Order::where('delivery_status', 'Delivered')
                ->whereBetween('created_at', [$dateStart, $dateEnd])
                ->sum('price');

            $dailyEventRevenue = EventBooking::where('is_archived', false)
                ->where('status', 'Paid')
                ->whereBetween('created_at', [$dateStart, $dateEnd])
                ->sum(DB::raw('COALESCE(amount_paid, down_payment_amount)'));

            $dailyRefunds = ReturnRefund::where('status', 'refunded')
                ->whereBetween('processed_at', [$dateStart, $dateEnd])
                ->sum('refund_amount');

            $revenueData[] = ($dailyOrderRevenue + $dailyEventRevenue) - $dailyRefunds;
        }

        // Status breakdown
        $orderStatuses = [
            'in_progress' => Order::where('is_archived', false)
                ->where('delivery_status', 'In Progress')
                ->count(),
            'delivered' => Order::where('is_archived', false)
                ->where('delivery_status', 'Delivered')
                ->count(),
            'cancelled' => Order::where('is_archived', false)
                ->where('delivery_status', 'Cancelled')
                ->count()
        ];

        // Recent activity
        $recentOrders = Order::where('is_archived', false)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function($order) {
                return [
                    'id' => $order->id,
                    'title' => $order->foodname ?? 'Order #' . $order->id,
                    'customer' => $order->name ?? 'Guest',
                    'status' => $order->delivery_status ?? 'New',
                    'price' => $order->price ?? 0
                ];
            });

        $recentReservations = Book::where('is_archived', false)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function($reservation) {
                return [
                    'id' => $reservation->id,
                    'name' => $reservation->name ?? 'Guest',
                    'date' => $reservation->date ? $reservation->date->format('M d, Y') : '',
                    'time' => $reservation->time_in ? (is_string($reservation->time_in) ? $reservation->time_in : $reservation->time_in->format('g:i A')) : '',
                    'status' => $reservation->status ?? 'pending'
                ];
            });

        $recentEvents = EventBooking::with(['eventType', 'venueType'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function($event) {
                return [
                    'id' => $event->id,
                    'name' => $event->full_name ?? 'Customer',
                    'event_date' => $event->event_date ? $event->event_date->format('M d, Y') : '',
                    'event_type' => $event->eventType->name ?? 'Event',
                    'venue_type' => $event->venueType->name ?? 'Venue',
                    'status' => $event->status ?? 'Pending',
                    'amount' => $event->amount_paid ?? $event->down_payment_amount ?? 0
                ];
            });

        $initialStats = [
            'summary' => [
                'totalRevenue' => $totalRevenue,
                'revenueToday' => $revenueToday,
                'ordersToday' => $ordersToday,
                'ordersInProgress' => $ordersInProgress,
                'ordersDelivered' => $ordersDelivered,
                'pendingReservations' => $pendingReservations,
                'upcomingReservations' => $upcomingReservations,
                'pendingEventBookings' => $pendingEventBookings,
                'paidEventBookings' => $paidEventBookings,
                'eventRevenue' => $eventRevenue
            ],
            'charts' => [
                'labels' => $labels,
                'orders' => $ordersData,
                'reservations' => $reservationsData,
                'events' => $eventsData,
                'revenue' => $revenueData
            ],
            'statuses' => [
                'orders' => $orderStatuses
            ],
            'activity' => [
                'orders' => $recentOrders,
                'reservations' => $recentReservations,
                'events' => $recentEvents
            ],
            'last_refreshed' => $now->toIso8601String()
        ];

        return view('admin.dashboard', compact('initialStats'));
    }
    
    /**
     * Upload section image
     */
    public function uploadSectionImage(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'section_key' => 'required|string'
            ]);
            
            // Create sections directory if it doesn't exist
            $sectionsDir = public_path('assets/imgs/sections');
            if (!file_exists($sectionsDir)) {
                mkdir($sectionsDir, 0755, true);
            }
            
            // Get the uploaded file
            $file = $request->file('image');
            $sectionKey = $request->section_key;
            
            // Generate unique filename
            $filename = 'section-' . $sectionKey . '-' . time() . '.' . $file->getClientOriginalExtension();
            
            // Move file to sections directory
            $file->move($sectionsDir, $filename);
            
            // Return the URL path
            $imageUrl = asset('assets/imgs/sections/' . $filename);
            
            return response()->json([
                'success' => true,
                'image_url' => $imageUrl,
                'message' => 'Image uploaded successfully'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error uploading section image: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error uploading image: ' . $e->getMessage()
            ], 500);
        }
    }
}
