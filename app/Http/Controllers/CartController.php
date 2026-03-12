<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Food;
use App\Models\Bundle;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Display the cart page
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user_id = Auth::id();
        $cartItems = Cart::where('userid', $user_id)
                        ->with(['food', 'bundle.foods'])
                        ->get();

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

        return view('home.my_cart', compact('cartItems', 'total', 'notifications', 'notifCount'));
    }

    /**
     * Add item to cart
     */
    public function addToCart(Request $request, $foodId)
    {
        if (!Auth::check()) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please login to add items to cart'
                ], 401);
            }
            return redirect()->route('login');
        }

        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid quantity'
                ], 400);
            }
            return redirect()->back()->with('error', 'Invalid quantity');
        }

        $food = Food::find($foodId);
        if (!$food) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Food item not found'
                ], 404);
            }
            return redirect()->back()->with('error', 'Food item not found');
        }

        $user_id = Auth::id();
        $quantity = $request->quantity;

        // Check if this food belongs to a bundle package
        $category = \App\Models\Category::where('name', $food->type)->first();
        $isBundle = $category && strtolower($food->type) == 'bundle package';
        
        // Use bundle price if it's a bundle package, otherwise use individual price
        $itemPrice = $isBundle && $food->bundle_price ? $food->bundle_price : $food->price;

        // Check if item already exists in cart
        $existingCartItem = Cart::where('userid', $user_id)
                                ->where('food_id', $foodId)
                                ->first();

        if ($existingCartItem) {
            // Update existing item quantity
            $existingCartItem->quantity += $quantity;
            $existingCartItem->save();
        } else {
            // Create new cart item
            Cart::create([
                'title' => $food->title,
                'detail' => $food->detail,
                'price' => $itemPrice,
                'image' => $food->image,
                'quantity' => $quantity,
                'userid' => $user_id,
                'food_id' => $foodId
            ]);
        }

        $cartCount = Cart::where('userid', $user_id)->sum('quantity');

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Item added to cart successfully!',
                'cart_count' => $cartCount
            ]);
        }
        return redirect()->route('my_cart')->with('success', 'Item added to cart successfully!');
    }

    /**
     * Remove item from cart
     */
    public function removeFromCart($cartId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $cartItem = Cart::where('id', $cartId)
                       ->where('userid', Auth::id())
                       ->first();

        if (!$cartItem) {
            return redirect()->back()->with('error', 'Item not found in cart');
        }

        $cartItem->delete();

        return redirect()->back()->with('success', 'Item removed from cart');
    }

    /**
     * Update cart item quantity
     */
    public function updateQuantity(Request $request, $cartId)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login'
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid quantity'
            ], 400);
        }

        $cartItem = Cart::where('id', $cartId)
                       ->where('userid', Auth::id())
                       ->first();

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found'
            ], 404);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        $total = $cartItem->price * $cartItem->quantity;
        $cartCount = Cart::where('userid', Auth::id())->sum('quantity');

        return response()->json([
            'success' => true,
            'total' => number_format($total, 2),
            'cart_count' => $cartCount
        ]);
    }

    /**
     * Clear entire cart
     */
    public function clearCart()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        Cart::where('userid', Auth::id())->delete();

        return redirect()->back()->with('success', 'Cart cleared successfully');
    }

    /**
     * Get cart count for header
     */
    public function getCartCount()
    {
        if (!Auth::check()) {
            return response()->json(['count' => 0]);
        }

        $count = Cart::where('userid', Auth::id())->sum('quantity');
        return response()->json(['count' => $count]);
    }

    /**
     * Add bundle to cart
     */
    public function addBundleToCart(Request $request, $bundleId)
    {
        if (!Auth::check()) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please login to add bundles to cart'
                ], 401);
            }
            return redirect()->route('login');
        }

        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid quantity'
                ], 400);
            }
            return redirect()->back()->with('error', 'Invalid quantity');
        }

        $bundle = Bundle::with('foods')->find($bundleId);
        if (!$bundle) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bundle not found'
                ], 404);
            }
            return redirect()->back()->with('error', 'Bundle not found');
        }

        // Note: Previously blocked inactive bundles. Requested change: allow adding even if inactive.

        $user_id = Auth::id();
        $quantity = $request->quantity;

        // Check if bundle already exists in cart
        $existingCartItem = Cart::where('userid', $user_id)
                                ->where('bundle_id', $bundleId)
                                ->first();

        if ($existingCartItem) {
            // Update existing bundle quantity
            $existingCartItem->quantity += $quantity;
            $existingCartItem->save();
        } else {
            // Create new bundle cart item
            Cart::create([
                'title' => $bundle->name,
                'detail' => $bundle->description,
                'price' => $bundle->bundle_price,
                'image' => $bundle->image,
                'quantity' => $quantity,
                'userid' => $user_id,
                'bundle_id' => $bundleId,
                'food_id' => null
            ]);
        }

        $cartCount = Cart::where('userid', $user_id)->sum('quantity');

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Bundle added to cart successfully!',
                'cart_count' => $cartCount
            ]);
        }
        return redirect()->route('my_cart')->with('success', 'Bundle added to cart successfully!');
    }
}
