<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\EmailOtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class EmailOtpVerificationController extends Controller
{
    public function show(Request $request): View
    {
        return view('auth.verify-otp', [
            'email' => old('email', (string) $request->query('email', '')),
        ]);
    }

    public function verify(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'otp' => ['required', 'digits:6'],
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (! $user || ! $user->email_otp_code || ! Hash::check($validated['otp'], $user->email_otp_code)) {
            return back()->withErrors(['otp' => 'Invalid OTP code.'])->withInput();
        }

        if (! $user->email_otp_expires_at || Carbon::now()->greaterThan($user->email_otp_expires_at)) {
            return back()->withErrors(['otp' => 'OTP expired. Please resend a new code.'])->withInput();
        }

        $user->forceFill([
            'email_otp_verified_at' => Carbon::now(),
            'email_otp_code' => null,
            'email_otp_expires_at' => null,
        ])->save();

        return redirect()->route('login')->with('status', 'Email verified. You can now log in.');
    }

    public function resend(Request $request, EmailOtpService $otpService): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (! $user) {
            return back()->withErrors(['email' => 'No account found for this email.'])->withInput();
        }

        if ($user->email_otp_verified_at) {
            return redirect()->route('login')->with('status', 'This email is already verified.');
        }

        $otpService->issue($user);

        return back()->with('status', 'A new OTP has been sent to your email.');
    }
}
