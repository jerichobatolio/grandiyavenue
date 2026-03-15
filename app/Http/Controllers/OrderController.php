<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'contact' => 'required|string|regex:/^\d{11}$/|size:11',
            'address' => 'required|string|max:500',
            'payment' => 'required|in:GCash,Cash On Delivery',
            'notes' => 'nullable|string|max:1000',
            'payment_proof' => 'required_if:payment,GCash|image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'payment_proof.required_if' => 'Please upload a valid GCash receipt before submitting.',
            'payment_proof.image' => 'The uploaded file must be an image.',
            'payment_proof.mimes' => 'Only JPG, PNG, and JPEG images are allowed.',
            'payment_proof.max' => 'The image size must be less than 2MB.',
            'contact.regex' => 'Contact number must be exactly 11 digits (numbers only).',
            'contact.size' => 'Contact number must be exactly 11 digits.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Additional GCash receipt validation (size, type, dimensions)
        if ($request->payment === 'GCash' && $request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $gcashValidation = $this->validateGCashReceipt($file);
            if (! $gcashValidation['valid']) {
                return redirect()->back()
                    ->withErrors(['payment_proof' => $gcashValidation['message']])
                    ->withInput();
            }
            // OCR: only allow images that look like GCash receipts (same as Book Event)
            if (! $this->validateImageIsGCashReceipt($file)) {
                return redirect()->back()
                    ->withErrors(['payment_proof' => 'Only GCash receipts are accepted. The uploaded image does not appear to be a GCash transaction receipt.'])
                    ->withInput();
            }
        }

        // Handle payment proof upload for GCash
        $paymentProofPath = null;
        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $paymentProofPath = $file->storeAs('payment_proofs', $fileName, 'public');
        }

        // Get all cart items for the authenticated user
        $carts = Cart::where('userid', Auth::id())->get();  
        
        // Store all created orders
        $createdOrders = [];
        $totalItems = 0;
        $totalPrice = 0;
        $firstOrder = null;

        foreach ($carts as $cartItem) {
            $order = new Order();
            $order->user_id = Auth::id(); // ✅ Add user_id
            $order->name = $request->fullname;
            $order->email = auth()->user() ? auth()->user()->email : 'Guest';
            $order->phone = $request->contact;
            $order->address = $request->address;
            $order->payment_mode = $request->payment;
            $order->notes = $request->notes;
            $order->title = $cartItem->title;
            $order->price = $cartItem->price;
            $order->quantity = $cartItem->quantity;
            $order->image = $cartItem->image;
            $order->delivery_status = "In Progress";
            $order->payment_proof_path = $paymentProofPath; // ✅ Store payment proof path
            $order->save();
            
            $createdOrders[] = $order;
            $totalItems += $cartItem->quantity;
            $totalPrice += ($cartItem->price * $cartItem->quantity);
            
            if ($firstOrder === null) {
                $firstOrder = $order;
            }
        }

        // ✅ Create notifications for orders
        if ($firstOrder && count($createdOrders) > 0) {
            $itemText = $totalItems == 1 ? 'item' : 'items';
            
            // Create notification for the customer
            if (Auth::check() && $firstOrder->user_id) {
                Notification::create([
                    'user_id' => $firstOrder->user_id,
                    'order_id' => $firstOrder->id,
                    'type' => 'order_status',
                    'message' => "Your order with {$totalItems} {$itemText} has been placed and is pending processing.",
                    'is_read' => false,
                    'data' => [
                        'order_id' => $firstOrder->id,
                        'status' => 'Pending',
                        'title' => $totalItems > 1 ? "{$totalItems} items" : $firstOrder->title,
                        'price' => $totalPrice,
                        'quantity' => $totalItems,
                        'delivery_status' => 'Pending',
                        'customer_name' => $firstOrder->name,
                        'customer_email' => $firstOrder->email,
                        'total_items' => $totalItems,
                        'total_price' => $totalPrice,
                        'order_ids' => array_map(function($order) { return $order->id; }, $createdOrders)
                    ]
                ]);
            }
            
            // Create notification for admin users (excluding the customer who placed the order)
            $allUsers = User::where('id', '!=', Auth::id())->get();
            
            // Create only ONE notification per admin user for the entire order (regardless of number of items)
            foreach ($allUsers as $user) {
                Notification::create([
                    'user_id' => $user->id,
                    'order_id' => $firstOrder->id, // Use first order ID as reference
                    'type' => 'order_placed',
                    'message' => "New order with {$totalItems} {$itemText} has been placed by {$firstOrder->name}!",
                    'is_read' => false,
                    'data' => [
                        'order_id' => $firstOrder->id,
                        'status' => 'In Progress',
                        'title' => $totalItems > 1 ? "{$totalItems} items" : $firstOrder->title,
                        'price' => $totalPrice,
                        'quantity' => $totalItems,
                        'delivery_status' => 'In Progress',
                        'customer_name' => $firstOrder->name,
                        'customer_email' => $firstOrder->email,
                        'total_items' => $totalItems,
                        'total_price' => $totalPrice,
                        'order_ids' => array_map(function($order) { return $order->id; }, $createdOrders) // Store all order IDs for reference
                    ]
                ]);
            }
        }

        // Clear the cart after placing order
        Cart::where('userid', Auth::id())->delete();

        return redirect()->route('home')->with('message', 'Order placed successfully!');
    }

    /**
     * Validate that the uploaded image appears to be a GCash receipt using OCR if available.
     */
    private function validateImageIsGCashReceipt($file): bool
    {
        if (! $file || ! $file->getRealPath()) {
            return false;
        }
        $path = $file->getRealPath();
        $keywords = ['gcash', 'successfully sent', 'successfully paid', 'ref. no', 'ref no', 'express send', 'send money', 'amount due', 'gcash scan'];
        if (PHP_OS_FAMILY === 'Windows') {
            $tesseract = 'tesseract';
        } else {
            $tesseract = trim((string) shell_exec('which tesseract 2>/dev/null') ?: '');
            if ($tesseract === '') {
                return true;
            }
        }
        $outFile = sys_get_temp_dir().'/gcash_ocr_'.uniqid();
        @exec(escapeshellarg($tesseract).' '.escapeshellarg($path).' '.escapeshellarg($outFile).' 2>/dev/null', $out, $exit);
        $text = @file_get_contents($outFile.'.txt');
        @unlink($outFile.'.txt');
        if ($exit !== 0 || $text === false || $text === '') {
            return true;
        }
        $lower = mb_strtolower(preg_replace('/\s+/', ' ', $text));
        foreach ($keywords as $kw) {
            if (str_contains($lower, $kw)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Validate if uploaded file is a GCash receipt (size, type, dimensions)
     */
    private function validateGCashReceipt($file)
    {
        // Check file size (max 2MB)
        if ($file->getSize() > 2 * 1024 * 1024) {
            return [
                'valid' => false,
                'message' => 'File size must be less than 2MB'
            ];
        }

        // Check file type
        $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!in_array($file->getMimeType(), $allowedMimes)) {
            return [
                'valid' => false,
                'message' => 'Only JPG, PNG, and JPEG images are allowed'
            ];
        }

        // Get image dimensions
        $imageInfo = getimagesize($file->getPathname());
        if (!$imageInfo) {
            return [
                'valid' => false,
                'message' => 'Invalid image file'
            ];
        }

        $width = $imageInfo[0];
        $height = $imageInfo[1];

        // Check minimum dimensions
        if ($width < 200 || $height < 200) {
            return [
                'valid' => false,
                'message' => 'Image is too small. Please upload a clear, high-resolution GCash receipt (minimum 200x200 pixels)'
            ];
        }

        // Check if image is not too large (max 4000x4000)
        if ($width > 4000 || $height > 4000) {
            return [
                'valid' => false,
                'message' => 'Image is too large. Please upload a smaller image (maximum 4000x4000 pixels)'
            ];
        }

        return [
            'valid' => true,
            'message' => 'Valid GCash receipt'
        ];
    }
}
