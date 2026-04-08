<?php

namespace App\Services;

use App\Mail\EmailOtpMail;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class EmailOtpService
{
    public function issue(User $user): void
    {
        $otp = (string) random_int(100000, 999999);

        $user->forceFill([
            'email_otp_code' => Hash::make($otp),
            'email_otp_expires_at' => Carbon::now()->addMinutes(10),
            'email_otp_verified_at' => null,
        ])->save();

        Mail::to($user->email)->send(new EmailOtpMail($user, $otp));
    }
}
