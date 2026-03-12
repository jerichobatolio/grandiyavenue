<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnRefundButtonSetting extends Model
{
    protected $fillable = [
        'is_enabled',
        'button_text',
        'button_link',
        'button_icon',
        'description',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
    ];

    /**
     * Get the current button settings (singleton pattern)
     */
    public static function getSettings()
    {
        try {
            // Check if table exists
            if (!\Illuminate\Support\Facades\Schema::hasTable('return_refund_button_settings')) {
                return null;
            }
            
            $settings = self::first();
            
            // If no settings exist, create default ones
            if (!$settings) {
                try {
                    $settings = self::create([
                        'is_enabled' => true,
                        'button_text' => 'Return/Refund',
                        'button_link' => '/return-refunds',
                        'button_icon' => '🔄',
                        'description' => 'Return or refund your orders',
                    ]);
                } catch (\Exception $e) {
                    // If creation fails, return null
                    \Log::error('Error creating return refund button settings: ' . $e->getMessage());
                    return null;
                }
            }
            
            return $settings;
        } catch (\Exception $e) {
            \Log::error('Error getting return refund button settings: ' . $e->getMessage());
            return null;
        }
    }
}
