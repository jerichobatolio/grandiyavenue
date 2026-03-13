<?php

namespace App\Models;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class TableLayoutSetting extends Model
{
    protected $fillable = [
        'sections_json',
        'section_order_json',
    ];

    protected $casts = [
        'sections_json' => 'array',
        'section_order_json' => 'array',
    ];

    public static function defaultSections(): array
    {
        return [
            'hallway' => [
                'name' => 'Section A',
                'icon' => '🪑',
                'value' => 'hallway',
                'image' => '',
                'capacity' => '4 – 10 pax',
                'inclusions' => 'Standard setup with comfortable seating and full dining service.',
            ],
            'top' => [
                'name' => 'Section B',
                'icon' => '🪑',
                'value' => 'top',
                'image' => '',
                'capacity' => '',
                'inclusions' => '',
            ],
            'garden' => [
                'name' => 'Garden',
                'icon' => '🌿',
                'value' => 'garden',
                'image' => '',
                'capacity' => '',
                'inclusions' => '',
            ],
            'vip' => [
                'name' => 'VIP Cabin Room',
                'icon' => '👑',
                'value' => 'vip',
                'image' => '',
                'capacity' => '',
                'inclusions' => '',
            ],
        ];
    }

    public static function getSettings(): ?self
    {
        if (!Schema::hasTable('table_layout_settings')) {
            return null;
        }

        return self::first();
    }

    public static function ensureTableExists(): void
    {
        if (Schema::hasTable('table_layout_settings')) {
            return;
        }

        Schema::create('table_layout_settings', function (Blueprint $table) {
            $table->id();
            $table->longText('sections_json')->nullable();
            $table->longText('section_order_json')->nullable();
            $table->timestamps();
        });
    }

    public static function resolvedSections(): array
    {
        $defaults = self::defaultSections();
        $settings = self::getSettings();
        $stored = $settings?->sections_json;

        if (!is_array($stored) || !$stored) {
            return $defaults;
        }

        $resolved = [];
        foreach ($stored as $key => $section) {
            $resolved[$key] = array_merge(
                $defaults[$key] ?? [],
                is_array($section) ? $section : []
            );
        }

        return $resolved;
    }

    public static function resolvedSectionOrder(): array
    {
        $sections = self::resolvedSections();
        $settings = self::getSettings();
        $order = $settings?->section_order_json;
        $keys = array_keys($sections);

        if (!is_array($order) || !$order) {
            return $keys;
        }

        $filtered = array_values(array_filter($order, fn ($key) => in_array($key, $keys, true)));
        foreach ($keys as $key) {
            if (!in_array($key, $filtered, true)) {
                $filtered[] = $key;
            }
        }

        return $filtered;
    }
}
