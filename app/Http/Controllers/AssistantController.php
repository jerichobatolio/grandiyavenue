<?php

namespace App\Http\Controllers;

use App\Models\AssistantMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssistantController extends Controller
{
    /**
     * Send a message from the customer (saved for admin to reply).
     */
    public function send(Request $request)
    {
        $request->validate(['message' => 'required|string|max:2000']);

        $user = Auth::user();
        if (! $user) {
            return response()->json(['success' => false, 'message' => 'Please log in to send a message.'], 401);
        }

        AssistantMessage::create([
            'user_id' => $user->id,
            'message' => trim($request->message),
            'is_from_admin' => false,
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Get the current user's conversation thread (messages + admin replies).
     */
    public function messages(Request $request)
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json(['messages' => []]);
        }

        $messages = AssistantMessage::where('user_id', $user->id)
            ->orderBy('created_at')
            ->get()
            ->map(function ($m) {
                return [
                    'id' => $m->id,
                    'body' => $m->message,
                    'is_from_admin' => $m->is_from_admin,
                    'created_at' => $m->created_at->toIso8601String(),
                ];
            });

        return response()->json(['messages' => $messages]);
    }
}
