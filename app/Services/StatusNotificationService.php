<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class StatusNotificationService
{
    public function sendStatusUpdate(
        ?string $email,
        ?string $phone,
        string $subject,
        string $message
    ): void {
        $this->sendEmail($email, $subject, $message);
        $this->sendSms($phone, $message);
    }

    private function sendEmail(?string $email, string $subject, string $message): void
    {
        if (empty($email)) {
            return;
        }

        try {
            Mail::raw($message, function ($mail) use ($email, $subject) {
                $mail->to($email)->subject($subject);
            });
        } catch (\Throwable $e) {
            Log::warning('Status email notification failed', [
                'email' => $email,
                'subject' => $subject,
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function sendSms(?string $phone, string $message): void
    {
        $apiUrl = (string) config('services.sms.api_url');
        $apiKey = (string) config('services.sms.api_key');
        $from = (string) config('services.sms.from');
        $enabled = (bool) config('services.sms.enabled');

        if (!$enabled || empty($apiUrl) || empty($apiKey) || empty($phone)) {
            return;
        }

        $normalizedPhone = $this->normalizePhone($phone);
        if ($normalizedPhone === null) {
            return;
        }

        try {
            Http::asForm()->post($apiUrl, [
                'apikey' => $apiKey,
                'number' => $normalizedPhone,
                'message' => $message,
                'sendername' => $from,
            ]);
        } catch (\Throwable $e) {
            Log::warning('Status SMS notification failed', [
                'phone' => $normalizedPhone,
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function normalizePhone(string $phone): ?string
    {
        $digits = preg_replace('/\D+/', '', $phone);
        if ($digits === null || $digits === '') {
            return null;
        }

        if (str_starts_with($digits, '09') && strlen($digits) === 11) {
            return '63'.substr($digits, 1);
        }

        if (str_starts_with($digits, '639') && strlen($digits) === 12) {
            return $digits;
        }

        return null;
    }
}
