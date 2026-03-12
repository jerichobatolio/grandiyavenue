<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Food;
use App\Models\Order;
use App\Models\Book;
use App\Models\Cart;
use App\Models\Notification; // ✅ Add Notification model
use App\Models\Gallery;
use App\Models\TableStatus;
use App\Models\EventType; // ✅ Add EventType model
use App\Models\AdminQrCode; // ✅ Add AdminQrCode model
use App\Models\VenueType; // ✅ Add VenueType model
use App\Models\Category; // ✅ Add Category model
use App\Models\Subcategory; // ✅ Add Subcategory model
use App\Models\Bundle; // ✅ Add Bundle model
use App\Models\Review; // ✅ Add Review model
use App\Models\PaxOption; // ✅ Pax options for event booking
use App\Models\FoodPackageItem; // ✅ Simple food package items for events
use App\Models\Announcement; // ✅ Announcements for home page
use App\Models\Faq; // ✅ FAQs for Grandiya Assistant
use App\Models\EventBooking; // ✅ Event bookings for calendar
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function my_home()
    {
        $data = Food::all();
        $galleries = Gallery::active()->ordered()->get();
        // Show all event types on home (no active filter)
        $eventTypes = EventType::orderBy('name')->get();
        $venueTypes = VenueType::orderBy('name')->get(); // ✅ Get all venue types (admin manages visibility)
        // ✅ Load Pax options for Book Event form (safe if table not migrated yet)
        $paxOptions = collect();
        if (Schema::hasTable('pax_options')) {
            $paxOptions = PaxOption::active()
                ->orderBy('sort_order')
                ->orderBy('value')
                ->get();
        }
        // ✅ Load simple Food Package items (chicken, vegetable, unlimited rice, etc.)
        $foodPackageItems = FoodPackageItem::orderBy('sort_order')
            ->orderBy('name')
            ->get();
        
        // ✅ Get QR code for payment section
        $adminQrCode = AdminQrCode::getActiveGlobalQrCode();
        
        // ✅ Load package inclusions for Book Event display
        $packageInclusions = collect();
        if (class_exists(\App\Models\PackageInclusion::class)) {
            $packageInclusions = \App\Models\PackageInclusion::orderBy('price')->orderBy('name')->get();
        }

        // ✅ Load active FAQs for Grandiya Assistant chatbot
        $faqs = Faq::active()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
        
        // ✅ Fetch notifications for the authenticated user
        $notifications = [];
        $notifCount = 0;
        if (Auth::check()) {
            $notifications = Notification::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
            $notifCount = Notification::where('user_id', Auth::id())
                ->where('is_read', false)
                ->count();
        }
        
        // Get real table status from database
        $tableStatus = $this->getTableStatus();
        $reservations = $this->getReservationsForCalendar();
        
        // Get approved reviews for display (show more reviews)
        $reviews = Review::approved()->orderBy('created_at', 'desc')->take(9)->get();
        
        // Get approved and active announcements for display on home page
        $announcements = Announcement::activeAndApproved()->orderBy('created_at', 'desc')->get();
        
        return view('home.index', compact(
            'data',
            'galleries',
            'eventTypes',
            'venueTypes',
            'paxOptions',
            'foodPackageItems',
            'adminQrCode',
            'packageInclusions',
            'notifications',
            'notifCount',
            'tableStatus',
            'reservations',
            'reviews',
            'announcements',
            'faqs'
        ));
    }

    public function getFoodsForPackage(string $name)
    {
        $name = urldecode($name);

        // Only use the admin-configured FoodPackageItem for this package
        $package = FoodPackageItem::where('name', $name)->first();
        $items = [];

        if ($package && $package->dishes) {
            $lines = preg_split('/\r\n|\r|\n/', $package->dishes);
            foreach ($lines as $line) {
                $title = trim($line);
                if ($title === '') {
                    continue;
                }
                $items[] = [
                    'id' => null,
                    'title' => $title,
                    'detail' => null,
                    'price' => null,
                    'image_url' => null,
                ];
            }
        }

        return response()->json([
            'success' => true,
            'items' => $items,
        ]);
    }

    public function index()
    {
        if (Auth::id()) {
            $usertype = Auth()->user()->usertype;

            if ($usertype == 'user') {
                $data = Food::all();
                $galleries = Gallery::active()->ordered()->get();
                // Show all event types on home (no active filter)
                $eventTypes = EventType::orderBy('name')->get();
                $venueTypes = VenueType::orderBy('name')->get(); // ✅ Get all venue types (admin manages visibility)
                // ✅ Load Pax options for Book Event form (safe if table not migrated yet)
                $paxOptions = collect();
                if (Schema::hasTable('pax_options')) {
                    $paxOptions = PaxOption::active()
                        ->orderBy('sort_order')
                        ->orderBy('value')
                        ->get();
                }
                // ✅ Load simple Food Package items (chicken, vegetable, unlimited rice, etc.)
                $foodPackageItems = FoodPackageItem::orderBy('sort_order')
                    ->orderBy('name')
                    ->get();
                
                // ✅ Get QR code for payment section
                $adminQrCode = AdminQrCode::getActiveGlobalQrCode();

                // ✅ Load package inclusions for Book Event display
                $packageInclusions = collect();
                if (class_exists(\App\Models\PackageInclusion::class)) {
                    $packageInclusions = \App\Models\PackageInclusion::orderBy('price')->orderBy('name')->get();
                }

                // ✅ Load active FAQs for Grandiya Assistant chatbot
                $faqs = Faq::active()
                    ->orderBy('sort_order')
                    ->orderBy('id')
                    ->get();

                // ✅ Fetch notifications for the authenticated user
                $notifications = Notification::where('user_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->take(10)
                    ->get();
                $notifCount = Notification::where('user_id', Auth::id())
                    ->where('is_read', false)
                    ->count();

                // Get real table status from database
                $tableStatus = $this->getTableStatus();
                $reservations = $this->getReservationsForCalendar();
                
                // Get approved reviews for display
                $reviews = Review::approved()->orderBy('created_at', 'desc')->take(9)->get();
                
                // Get approved and active announcements for display on home page
                $announcements = Announcement::activeAndApproved()->orderBy('created_at', 'desc')->get();
                
                return view('home.index', compact(
                    'data',
                    'galleries',
                    'eventTypes',
                    'venueTypes',
                    'paxOptions',
                    'foodPackageItems',
                    'adminQrCode',
                    'packageInclusions',
                    'notifications',
                    'notifCount',
                    'tableStatus',
                    'reservations',
                    'reviews',
                    'announcements',
                    'faqs'
                ));
            } else {
                // Admin dashboard with analytics
                return app(\App\Http\Controllers\AdminController::class)->dashboard();
            }
        } else {
            return redirect('login');
        }
    }

    public function add_cart(Request $request, $id)
    {
        if (Auth::id()) {
            $food = Food::find($id);

            $cart_title = $food->title;
            $cart_detail = $food->detail;
            
            // Check if this food belongs to a bundle package
            $category = Category::where('name', $food->type)->first();
            $isBundle = $category && strtolower($food->type) == 'bundle package';
            
            // Use bundle price if it's a bundle package, otherwise use individual price
            $cart_price = $isBundle && $food->bundle_price ? $food->bundle_price : $food->price;
            
            $cart_image = $food->image;

            $data = new Cart;
            $data->title = $cart_title;
            $data->detail = $cart_detail;
            $data->price = $cart_price * $request->qty;
            $data->image = $cart_image;
            $data->quantity = $request->qty;
            $data->userid = Auth()->user()->id;

            $data->save();

            return redirect()->route('my_cart')->with('success', 'Item added to cart!');
        } else {
            return redirect("login");
        }
    }
    
    public function add_bundle_to_cart(Request $request, $type)
    {
        if (Auth::id()) {
            // Get all foods in the bundle package
            $foods = Food::where('type', $type)->get();
            
            if ($foods->isEmpty()) {
                return redirect()->back()->with('error', 'No items in this bundle package!');
            }
            
            // Get the bundle price from the first food (they should all have the same bundle_price)
            $bundlePrice = $foods->first()->bundle_price ?? $foods->first()->price;
            
            // Create one cart entry for the entire bundle
            $bundleTitle = $type . ' - Bundle Package';
            $bundleDetail = 'Bundle includes: ' . $foods->pluck('title')->implode(', ');
            $cartImage = $foods->first()->image ?? 'default.jpg';
            
            $data = new Cart;
            $data->title = $bundleTitle;
            $data->detail = $bundleDetail;
            $data->price = $bundlePrice;
            $data->image = $cartImage;
            $data->quantity = 1;
            $data->userid = Auth()->user()->id;
            
            $data->save();
            
            return redirect()->route('my_cart')->with('success', 'Bundle package added to cart!');
        } else {
            return redirect("login");
        }
    }

    public function my_cart()
    {
        $user_id = Auth()->user()->id;
        $cartItems = Cart::where('userid', '=', $user_id)->get();
        
        $total = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        // ✅ Fetch notifications for the authenticated user
        $notifications = Notification::where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        $notifCount = Notification::where('user_id', $user_id)
            ->where('is_read', false)
            ->count();

        // ✅ Get admin QR code for GCash payment
        $adminQrCode = AdminQrCode::getActiveGlobalQrCode();

        return view('home.my_cart', compact('cartItems', 'total', 'notifications', 'notifCount', 'adminQrCode'));
    }

    public function remove_cart($id)
    {
        $data = Cart::find($id);
        if ($data) {
            $data->delete();
        }

        return redirect()->back();
    }

    public function confirm_order(Request $request)
    {
        $user_id = Auth()->user()->id;
        $cart = Cart::where('userid', '=', $user_id)->get();

        foreach ($cart as $cartItem) {
            $order = new Order;
            $order->user_id = $user_id;
            $order->name = $request->name;
            $order->email = $request->email;
            $order->phone = $request->phone;
            $order->address = $request->address;
            $order->title = $cartItem->title;
            $order->quantity = $cartItem->quantity;
            $order->price = $cartItem->price;
            $order->image = $cartItem->image;

            $order->save();

            // Remove item from cart
            $cartItem->delete();
        }

        return redirect()->back()->with('success', 'Your order has been confirmed!');
    }

    public function my_orders()
    {
        $user_id = Auth()->user()->id;
        $orders = Order::where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->get();

        // ✅ Fetch notifications for the authenticated user
        $notifications = Notification::where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        $notifCount = Notification::where('user_id', $user_id)
            ->where('is_read', false)
            ->count();

        return view('home.my_orders', compact('orders', 'notifications', 'notifCount'));
    }

    public function book_table(Request $request)
    {
        try {
            // Get table capacity from database
            $tableNumber = $request->table_number;
            $tableStatus = TableStatus::where('table_number', $tableNumber)->first();
            $tableCapacity = $tableStatus ? ($tableStatus->seat_capacity ?? 8) : 8;
            
            $request->validate([
                'name' => 'required|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'phone' => 'required|string|digits:11',
                'guest' => 'required|integer|min:1|max:' . $tableCapacity,
                'date' => 'required|date|after_or_equal:today',
                // Table reservations are only allowed from 10:00 AM to 9:00 PM.
                // Since we auto-set Time Out to +4 hours, the latest allowed Time In is 5:00 PM.
                'time_in' => 'required|date_format:H:i|after_or_equal:10:00|before_or_equal:17:00',
                'table_number' => 'required|string',
                'table_section' => 'nullable|string|max:255',
                'occasion' => 'nullable|string',
                'special_requests' => 'nullable|string|max:500'
            ]);

            // Block table reservations if there is a whole-day event booking on the same date.
            $hasWholeDayEvent = EventBooking::query()
                ->whereDate('event_date', $request->date)
                ->where('is_archived', false)
                ->where('status', '!=', 'Cancelled')
                ->where(function ($q) {
                    $q->whereNull('time_in')
                        ->orWhereNull('time_out');
                })
                ->exists();

            if ($hasWholeDayEvent) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'date' => ['This date is fully booked for an event. Please choose another date.'],
                ]);
            }

            // Combine date and time for datetime fields
            $dateTimeIn = $request->date . ' ' . $request->time_in . ':00';
            // Automatically set time_out to 4 hours after time_in
            $dateTimeOut = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $dateTimeIn)
                ->copy()
                ->addHours(4)
                ->format('Y-m-d H:i:s');
            
            $data = new Book;
            $data->name = $request->name;
            $data->last_name = $request->last_name;
            $data->phone = $request->phone;
            $data->guest = $request->guest;
            $data->date = $request->date;
            $data->time = $dateTimeIn; // Store as datetime
            $data->time_in = $dateTimeIn; // Store as datetime
            $data->time_out = $dateTimeOut; // Store as datetime
            $data->table_number = $request->table_number;
            $data->table_section = $request->table_section ?? '';
            $data->occasion = $request->occasion ?? null;
            $data->special_requests = $request->special_requests ?? null;
            $data->status = $request->status ?? 'pending';
            $data->user_id = Auth::id(); // Will be null if not authenticated, which is fine

            $data->save();

            // Create notification for the customer if authenticated
            if (Auth::check() && $data->user_id) {
                // Format date and time
                $dateFormatted = $data->date instanceof \Carbon\Carbon 
                    ? $data->date->format('Y-m-d') 
                    : $data->date;
                $timeFormatted = $data->time_in instanceof \Carbon\Carbon 
                    ? $data->time_in->format('H:i') 
                    : (is_string($data->time_in) ? substr($data->time_in, 0, 5) : $data->time_in);
                $timeOutFormatted = $data->time_out instanceof \Carbon\Carbon
                    ? $data->time_out->format('H:i')
                    : (is_string($data->time_out) ? substr($data->time_out, 11, 5) : $data->time_out);
                
                Notification::create([
                    'user_id' => $data->user_id,
                    'type' => 'reservation_pending',
                    'message' => "Your table reservation has been submitted and is pending approval.",
                    'is_read' => false,
                    'data' => [
                        'reservation_id' => $data->id,
                        'date' => $dateFormatted,
                        'time' => $timeFormatted,
                        'time_out' => $timeOutFormatted,
                        'table' => $data->table_number,
                        'guests' => $data->guest,
                        'status' => 'Pending'
                    ]
                ]);
            }

            return redirect()->route('booking.receipt', ['id' => $data->id])
                ->with('success', 'Table reservation submitted successfully! Please wait for admin approval.');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Please check your input and try again.');
                
        } catch (\Exception $e) {
            \Log::error('Table booking error: ' . $e->getMessage());
            \Log::error('Table booking stack trace: ' . $e->getTraceAsString());
            \Log::error('Request data: ' . json_encode($request->all()));
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Sorry, there was an error processing your reservation. Please try again. Error: ' . $e->getMessage());
        }
    }

    // ------------------ UPDATE CART QUANTITY (+/-) ------------------
    public function update_cart(Request $request, $id)
    {
        $cartItem = Cart::find($id);

        if (!$cartItem) {
            return redirect()->back()->with('error', 'Item not found.');
        }

        $unitPrice = $cartItem->price / $cartItem->quantity;

        if ($request->action == 'increase') {
            $cartItem->quantity += 1;
        } elseif ($request->action == 'decrease') {
            if ($cartItem->quantity > 1) {
                $cartItem->quantity -= 1;
            }
        }

        $cartItem->price = $unitPrice * $cartItem->quantity;
        $cartItem->save();

        return redirect()->back();
    }

    // ------------------ CATEGORY FOODS ------------------
    public function showFoodsByType($type)
    {
        // Get category info (be tolerant to typos/case)
        $category = Category::where('name', $type)->first();
        if (!$category) {
            $category = Category::whereRaw('LOWER(name) = ?', [strtolower($type)])->first();
        }
        if (!$category && str_contains(strtolower($type), 'bundle')) {
            // Fallback: try to find any category that looks like bundle package
            $category = Category::whereRaw("LOWER(name) LIKE '%bundle%package%'").first();
        }
        
        // Check if category has subcategories
        if ($category && $category->subcategories()->count() > 0) {
            // ✅ Fetch notifications for the authenticated user
            $notifications = [];
            $notifCount = 0;
            if (Auth::check()) {
                $notifications = Notification::where('user_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->take(10)
                    ->get();
                $notifCount = Notification::where('user_id', Auth::id())
                    ->where('is_read', false)
                    ->count();
            }
            
            // Get subcategories for this category
            $subcategories = $category->subcategories()->where('is_active', true)->get();
            
            return view('home.category_subcategories', compact('type', 'subcategories', 'notifications', 'notifCount'));
        }
        
        // Check if this is a bundle package category (handle both "Bundle Package" and "Bunddle Package")
        $isBundle = $category && (strtolower($type) == 'bundle package' || strtolower($type) == 'bunddle package');
        
        if ($isBundle) {
            // For bundle packages, show ALL bundles from bundle management
            // First try to get bundles matching the category
            $bundles = Bundle::with('foods')
                            ->where('category_id', $category?->id)
                            ->get();

            // If none found by category, try by category name like "%bundle%package%"
            if ($bundles->isEmpty()) {
                $bundles = Bundle::with('foods')
                                ->whereHas('category', function($q) {
                                    $q->whereRaw("LOWER(name) LIKE '%bundle%package%'");
                                })
                                ->get();
            }
            
            // If still none found, show ALL bundles regardless of category
            if ($bundles->isEmpty()) {
                $bundles = Bundle::with('foods')->get();
            }

            $foods = collect(); // Empty collection since we're showing bundles
        } else {
            // For regular categories, show individual foods
            $foods = Food::where('type', $type)->get();
            $bundles = collect(); // Empty collection for regular foods
        }

        // ✅ Fetch notifications for the authenticated user
        $notifications = [];
        $notifCount = 0;
        if (Auth::check()) {
            $notifications = Notification::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
            $notifCount = Notification::where('user_id', Auth::id())
                ->where('is_read', false)
                ->count();
        }

        return view('home.home', compact('foods', 'bundles', 'type', 'isBundle', 'notifications', 'notifCount'));
    }

    // ------------------ SUBCATEGORY FOODS ------------------
    public function showFoodsBySubcategory($type, $subcategory)
    {
        // Get category info to check if it's a bundle package (tolerant to typos/case)
        $category = Category::where('name', $type)->first();
        if (!$category) {
            $category = Category::whereRaw('LOWER(name) = ?', [strtolower($type)])->first();
        }
        if (!$category && str_contains(strtolower($type), 'bundle')) {
            $category = Category::whereRaw("LOWER(name) LIKE '%bundle%package%'").first();
        }
        $isBundle = $category && (strtolower($type) == 'bundle package' || strtolower($type) == 'bunddle package');
        
        if ($isBundle) {
            // For bundle packages, show ALL bundles from bundle management
            $subcategoryModel = Subcategory::where('name', $subcategory)->where('category_id', $category?->id)->first();
            if ($subcategoryModel) {
                // First try to get bundles matching category and subcategory
                $bundles = Bundle::with('foods')
                                ->where('category_id', $category?->id)
                                ->where('subcategory_id', $subcategoryModel->id)
                                ->get();
                
                // If none found, try just by category
                if ($bundles->isEmpty()) {
                    $bundles = Bundle::with('foods')
                                    ->where('category_id', $category?->id)
                                    ->get();
                }
            } else {
                // Try by category name like "%bundle%package%" if subcategory lookup failed
                $bundles = Bundle::with('foods')
                                ->whereHas('category', function($q) {
                                    $q->whereRaw("LOWER(name) LIKE '%bundle%package%'");
                                })
                                ->get();
            }
            
            // If still none found, show ALL bundles regardless of category/subcategory
            if ($bundles->isEmpty()) {
                $bundles = Bundle::with('foods')->get();
            }
            
            $foods = collect(); // Empty collection since we're showing bundles
        } else {
            // For regular categories, show individual foods
            $foods = Food::where('type', $type)
                        ->where('subcategory', $subcategory)
                        ->get();
            $bundles = collect(); // Empty collection for regular foods
        }

        // ✅ Fetch notifications for the authenticated user
        $notifications = [];
        $notifCount = 0;
        if (Auth::check()) {
            $notifications = Notification::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
            $notifCount = Notification::where('user_id', Auth::id())
                ->where('is_read', false)
                ->count();
        }

        return view('home.home', compact('foods', 'bundles', 'type', 'subcategory', 'isBundle', 'notifications', 'notifCount'));
    }

    // ------------------ DRINKS SUBCATEGORY ------------------
    public function showDrinksBySubcategory($subcategory)
    {
        $foods = Food::where('type', 'Drinks')
                    ->where('subcategory', $subcategory)
                    ->get();

        $type = 'Drinks';
        
        // ✅ Fetch notifications for the authenticated user
        $notifications = [];
        $notifCount = 0;
        if (Auth::check()) {
            $notifications = Notification::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
            $notifCount = Notification::where('user_id', Auth::id())
                ->where('is_read', false)
                ->count();
        }
        
        return view('home.home', compact('foods', 'subcategory', 'type', 'notifications', 'notifCount'));
    }

    // ------------------ INLINE PROFILE UPDATE (Navbar) ------------------
    public function inlineProfileUpdate(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated'], 401);
            }
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email,'.$user->id],
            'phone' => ['nullable','string','max:20'],
            'address' => ['nullable','string','max:255'],
        ]);

        $user->fill($validated)->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Profile updated.',
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'address' => $user->address,
                    'updated_at' => $user->updated_at?->timestamp,
                ],
            ]);
        }

        return redirect()->back()->with('success', 'Profile updated.');
    }

    public function inlineProfilePhoto(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated'], 401);
            }
            return redirect()->route('login');
        }

        try {
            $request->validate([
                'photo' => ['required','image','mimes:jpg,jpeg,png','max:1024'],
            ]);

            if ($request->hasFile('photo')) {
                // Uses Jetstream's HasProfilePhoto trait method
                $user->updateProfilePhoto($request->file('photo'));
            }

            // Touch updated_at so avatar cache-busting query param changes
            $user->touch();

            if ($request->expectsJson()) {
                $version = $user->updated_at?->timestamp;
                return response()->json([
                    'message' => 'Profile photo updated.',
                    'photo_url' => $user->profile_photo_url . ($version ? ('?v=' . $version) : ''),
                    'updated_at' => $version,
                ]);
            }

            return redirect()->back()->with('success', 'Profile photo updated successfully!');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Upload failed: ' . $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', 'Upload failed: ' . $e->getMessage());
        }
    }

    // ------------------ HELPER METHODS FOR REAL DATA ------------------
    
    /**
     * Get real table status from database reservations
     */
    private function getTableStatus()
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
     * Get reservations for calendar display
     *
     * Includes both table reservations and event bookings so the calendar
     * reflects all "done" (paid/approved) bookings.
     */
    private function getReservationsForCalendar(bool $includePast = false)
    {
        // === Table reservations ===
        $reservationsQuery = Book::where('is_archived', false)
            ->where(function ($query) {
                $query->where('status', 'approved')
                    ->orWhere('status', 'confirmed')
                    ->orWhere('status', 'pending')
                    ->orWhere('status', 'paid')
                    ->orWhere('status', 'cancelled')
                    ->orWhereNull('status'); // Include null status as pending
            })
            ->orderBy('date')
            ->orderBy('time_in');

        if (!$includePast) {
            $reservationsQuery->whereDate('date', '>=', now()->toDateString());
        }

        $reservations = $reservationsQuery->get();

        $calendarData = [];

        foreach ($reservations as $reservation) {
            $date = $reservation->date->format('Y-m-d');
            if (!isset($calendarData[$date])) {
                $calendarData[$date] = [];
            }

            // Format time_in and time_out - extract just the time portion in 12-hour format with AM/PM
            $timeIn = 'N/A';
            $timeOut = 'N/A';

            if ($reservation->time_in) {
                try {
                    // Handle different formats: datetime object, ISO string, or time string
                    if ($reservation->time_in instanceof \DateTime || $reservation->time_in instanceof \Carbon\Carbon) {
                        $timeIn = $reservation->time_in->format('g:i A');
                    } elseif (is_string($reservation->time_in)) {
                        // Check if it's a full datetime string (contains T or space)
                        if (strpos($reservation->time_in, 'T') !== false || strpos($reservation->time_in, ' ') !== false) {
                            $timeIn = \Carbon\Carbon::parse($reservation->time_in)->format('g:i A');
                        } else {
                            // It's already a time string like "10:22" - convert to 12-hour format
                            if (preg_match('/(\d{2}):(\d{2})/', $reservation->time_in, $matches)) {
                                $hour = (int) $matches[1];
                                $minute = $matches[2];
                                $period = $hour >= 12 ? 'PM' : 'AM';
                                $hour12 = $hour > 12 ? $hour - 12 : ($hour == 0 ? 12 : $hour);
                                $timeIn = $hour12 . ':' . $minute . ' ' . $period;
                            } else {
                                $timeIn = $reservation->time_in;
                            }
                        }
                    }
                } catch (\Exception $e) {
                    // If parsing fails, try to extract time from string
                    if (is_string($reservation->time_in)) {
                        if (preg_match('/(\d{2}):(\d{2})/', $reservation->time_in, $matches)) {
                            $hour = (int) $matches[1];
                            $minute = $matches[2];
                            $period = $hour >= 12 ? 'PM' : 'AM';
                            $hour12 = $hour > 12 ? $hour - 12 : ($hour == 0 ? 12 : $hour);
                            $timeIn = $hour12 . ':' . $minute . ' ' . $period;
                        } else {
                            $timeIn = $reservation->time_in;
                        }
                    }
                }
            }

            if ($reservation->time_out) {
                try {
                    // Handle different formats: datetime object, ISO string, or time string
                    if ($reservation->time_out instanceof \DateTime || $reservation->time_out instanceof \Carbon\Carbon) {
                        $timeOut = $reservation->time_out->format('g:i A');
                    } elseif (is_string($reservation->time_out)) {
                        // Check if it's a full datetime string (contains T or space)
                        if (strpos($reservation->time_out, 'T') !== false || strpos($reservation->time_out, ' ') !== false) {
                            $timeOut = \Carbon\Carbon::parse($reservation->time_out)->format('g:i A');
                        } else {
                            // It's already a time string like "17:22" - convert to 12-hour format
                            if (preg_match('/(\d{2}):(\d{2})/', $reservation->time_out, $matches)) {
                                $hour = (int) $matches[1];
                                $minute = $matches[2];
                                $period = $hour >= 12 ? 'PM' : 'AM';
                                $hour12 = $hour > 12 ? $hour - 12 : ($hour == 0 ? 12 : $hour);
                                $timeOut = $hour12 . ':' . $minute . ' ' . $period;
                            } else {
                                $timeOut = $reservation->time_out;
                            }
                        }
                    }
                } catch (\Exception $e) {
                    // If parsing fails, try to extract time from string
                    if (is_string($reservation->time_out)) {
                        if (preg_match('/(\d{2}):(\d{2})/', $reservation->time_out, $matches)) {
                            $hour = (int) $matches[1];
                            $minute = $matches[2];
                            $period = $hour >= 12 ? 'PM' : 'AM';
                            $hour12 = $hour > 12 ? $hour - 12 : ($hour == 0 ? 12 : $hour);
                            $timeOut = $hour12 . ':' . $minute . ' ' . $period;
                        } else {
                            $timeOut = $reservation->time_out;
                        }
                    }
                }
            }

            $calendarData[$date][] = [
                'id' => $reservation->id,
                'table' => $reservation->table_number ?? 'N/A',
                'time' => $timeIn,
                'guests' => $reservation->guest ?? 'N/A',
                'phone' => $reservation->phone ?? 'N/A',
                'name' => $reservation->name ?? 'N/A',
                'last_name' => $reservation->last_name ?? null,
                'status' => $reservation->status ?? 'pending',
                'occasion' => $reservation->occasion ?? 'N/A',
                'time_in' => $timeIn,
                'time_out' => $timeOut,
                'duration_hours' => $reservation->duration_hours ?? 'N/A',
                'special_requests' => $reservation->special_requests ?? '',
                'created_at' => $reservation->created_at ? $reservation->created_at->format('Y-m-d H:i:s') : 'N/A',
                'updated_at' => $reservation->updated_at ? $reservation->updated_at->format('Y-m-d H:i:s') : 'N/A',
            ];
        }

        // === Event bookings (Paid / Pending) ===
        $eventBookingsQuery = EventBooking::where('is_archived', false)
            ->whereIn('status', ['Pending', 'Paid'])
            ->with(['eventType', 'venueType', 'packageInclusion'])
            ->orderBy('event_date')
            ->orderBy('time_in');

        if (!$includePast) {
            $eventBookingsQuery->whereDate('event_date', '>=', now()->toDateString());
        }

        $eventBookings = $eventBookingsQuery->get();

        foreach ($eventBookings as $booking) {
            $date = $booking->event_date->format('Y-m-d');
            if (!isset($calendarData[$date])) {
                $calendarData[$date] = [];
            }

            $timeIn = 'N/A';
            $timeOut = 'N/A';
            $timeInRaw = null;  // "HH:MM" for client-side comparisons
            $timeOutRaw = null; // "HH:MM" for client-side comparisons

            if ($booking->time_in) {
                $timeIn = $booking->time_in->format('g:i A');
                $timeInRaw = $booking->time_in->format('H:i');
            }

            if ($booking->time_out) {
                $timeOut = $booking->time_out->format('g:i A');
                $timeOutRaw = $booking->time_out->format('H:i');
            }

            $eventLabelParts = [];
            if ($booking->eventType) {
                $eventLabelParts[] = $booking->eventType->name;
            }
            if ($booking->venueType) {
                $eventLabelParts[] = $booking->venueType->name;
            }
            $eventLabel = implode(' @ ', array_filter($eventLabelParts));
            if ($eventLabel === '') {
                $eventLabel = 'Event Booking';
            }

            // Derive first and last name from full_name so calendars can
            // display Name and Last Name separately.
            $fullName = trim($booking->full_name ?? '');
            $derivedFirstName = null;
            $derivedLastName = null;
            if ($fullName !== '') {
                $nameParts = preg_split('/\s+/', $fullName);
                $derivedFirstName = $nameParts[0];
                if (count($nameParts) > 1) {
                    array_shift($nameParts); // remove first name
                    $derivedLastName = implode(' ', $nameParts);
                }
            }

            $calendarData[$date][] = [
                'id' => 'event-' . $booking->id,
                'table' => $eventLabel,
                'time' => $timeIn,
                'guests' => $booking->number_of_guests ?? 'N/A',
                'phone' => $booking->contact_number ?? 'N/A',
                // Use first name only for the "Name" field so
                // Last Name can be shown separately in the UI.
                'name' => $derivedFirstName ?? ($booking->full_name ?? 'N/A'),
                'last_name' => $derivedLastName,
                'status' => $booking->status ?? 'Pending',
                // Occasion / event type (e.g., Birthday, Christening)
                'occasion' => $booking->eventType ? $booking->eventType->name : 'Event Booking',
                'event_type_id' => $booking->event_type_id,
                'venue_type_id' => $booking->venue_type_id,
                // Extra fields so calendars can show the exact package & pax label
                // the customer selected (e.g., "No decor, 50–80 pax").
                'event_type_name' => $booking->eventType ? $booking->eventType->name : null,
                'venue_type_name' => $booking->venueType ? $booking->venueType->name : null,
                'package_label' => $booking->packageInclusion ? $booking->packageInclusion->name : null,
                'package_pax_min' => $booking->packageInclusion ? $booking->packageInclusion->pax_min : null,
                'package_pax_max' => $booking->packageInclusion ? $booking->packageInclusion->pax_max : null,
                'time_in' => $timeIn,
                'time_out' => $timeOut,
                'time_in_raw' => $timeInRaw,
                'time_out_raw' => $timeOutRaw,
                'is_whole_day' => is_null($timeInRaw) || is_null($timeOutRaw),
                'duration_hours' => 'N/A',
                'special_requests' => $booking->additional_notes ?? '',
                'created_at' => $booking->created_at ? $booking->created_at->format('Y-m-d H:i:s') : 'N/A',
                'updated_at' => $booking->updated_at ? $booking->updated_at->format('Y-m-d H:i:s') : 'N/A',
            ];
        }

        return $calendarData;
    }
    
    /**
     * API endpoint to get calendar reservations for real-time updates
     */
    public function getCalendarReservations(Request $request)
    {
        try {
            $scope = strtolower((string) $request->query('scope', 'upcoming'));
            $includePast = $scope === 'all';

            if ($includePast) {
                if (!Auth::check() || (string) (Auth::user()->usertype ?? 'user') === 'user') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unauthorized'
                    ], 403);
                }
            }

            $reservations = $this->getReservationsForCalendar($includePast);
            
            return response()->json([
                'success' => true,
                'reservations' => $reservations,
                'timestamp' => now()->toISOString()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching reservations: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Submit a customer review
     */
    public function submitReview(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'description' => 'nullable|string|max:1000',
        ]);

        $review = Review::create([
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'rating' => $request->rating,
            'description' => $request->description,
            'status' => 'pending', // Reviews need admin approval
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you for your review! It will be published after admin approval.'
            ]);
        }

        return redirect()->back()->with('message', 'Thank you for your review! It will be published after admin approval.');
    }

    /**
     * Display booking receipt
     */
    public function downloadReceipt($id)
    {
        $booking = Book::findOrFail($id);
        
        // Check if user is authorized to view this receipt
        if (Auth::check() && $booking->user_id && $booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this receipt.');
        }
        
        return view('receipts.booking_receipt', compact('booking'));
    }
}
