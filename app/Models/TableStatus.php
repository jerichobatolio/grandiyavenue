<?php

namespace App\Models;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class TableStatus extends Model
{
    protected $fillable = [
        'table_number',
        'section',
        'room',
        'status',
        'seat_capacity',
        'description'
    ];

    protected $casts = [
        'room' => 'integer',
        'seat_capacity' => 'integer',
    ];

    public static function defaultDefinitions(): array
    {
        return [
            'A1' => ['number' => 'A1', 'section' => 'hallway', 'seats' => 8, 'status' => 'available', 'description' => 'Section A table'],
            'A2' => ['number' => 'A2', 'section' => 'hallway', 'seats' => 8, 'status' => 'available', 'description' => 'Section A table'],
            'A3' => ['number' => 'A3', 'section' => 'hallway', 'seats' => 8, 'status' => 'available', 'description' => 'Section A table'],
            'A4' => ['number' => 'A4', 'section' => 'hallway', 'seats' => 8, 'status' => 'available', 'description' => 'Section A table'],
            'B1' => ['number' => 'B1', 'section' => 'top', 'seats' => 8, 'status' => 'available', 'description' => 'Section B table'],
            'B2' => ['number' => 'B2', 'section' => 'top', 'seats' => 8, 'status' => 'available', 'description' => 'Section B table'],
            'B3' => ['number' => 'B3', 'section' => 'top', 'seats' => 8, 'status' => 'available', 'description' => 'Section B table'],
            'B4' => ['number' => 'B4', 'section' => 'top', 'seats' => 8, 'status' => 'available', 'description' => 'Section B table'],
            'G1' => ['number' => 'G1', 'section' => 'garden', 'seats' => 6, 'status' => 'available', 'description' => 'Garden table'],
            'G2' => ['number' => 'G2', 'section' => 'garden', 'seats' => 6, 'status' => 'available', 'description' => 'Garden table'],
            'G3' => ['number' => 'G3', 'section' => 'garden', 'seats' => 8, 'status' => 'available', 'description' => 'Garden table'],
            'G4' => ['number' => 'G4', 'section' => 'garden', 'seats' => 8, 'status' => 'available', 'description' => 'Garden table'],
            'V11' => ['number' => 'V11', 'section' => 'vip', 'seats' => 8, 'status' => 'available', 'room' => 1, 'description' => 'VIP Cabin Room 1'],
            'V12' => ['number' => 'V12', 'section' => 'vip', 'seats' => 8, 'status' => 'available', 'room' => 1, 'description' => 'VIP Cabin Room 1'],
            'V13' => ['number' => 'V13', 'section' => 'vip', 'seats' => 8, 'status' => 'available', 'room' => 1, 'description' => 'VIP Cabin Room 1'],
            'V21' => ['number' => 'V21', 'section' => 'vip', 'seats' => 8, 'status' => 'available', 'room' => 2, 'description' => 'VIP Cabin Room 2'],
            'V22' => ['number' => 'V22', 'section' => 'vip', 'seats' => 8, 'status' => 'available', 'room' => 2, 'description' => 'VIP Cabin Room 2'],
            'V23' => ['number' => 'V23', 'section' => 'vip', 'seats' => 8, 'status' => 'available', 'room' => 2, 'description' => 'VIP Cabin Room 2'],
            'V31' => ['number' => 'V31', 'section' => 'vip', 'seats' => 8, 'status' => 'available', 'room' => 3, 'description' => 'VIP Cabin Room 3'],
            'V32' => ['number' => 'V32', 'section' => 'vip', 'seats' => 8, 'status' => 'available', 'room' => 3, 'description' => 'VIP Cabin Room 3'],
            'V33' => ['number' => 'V33', 'section' => 'vip', 'seats' => 8, 'status' => 'available', 'room' => 3, 'description' => 'VIP Cabin Room 3'],
        ];
    }

    public static function inferSectionFromTableNumber(?string $tableNumber): ?string
    {
        $tableNumber = strtoupper(trim((string) $tableNumber));
        if ($tableNumber === '') {
            return null;
        }

        if ($tableNumber === 'GARDEN' || str_starts_with($tableNumber, 'G')) {
            return 'garden';
        }

        if (str_starts_with($tableNumber, 'VIP') || str_starts_with($tableNumber, 'V')) {
            return 'vip';
        }

        if (str_starts_with($tableNumber, 'A')) {
            return 'hallway';
        }

        if (
            str_starts_with($tableNumber, 'B') ||
            str_starts_with($tableNumber, 'T') ||
            str_starts_with($tableNumber, 'FH')
        ) {
            return 'top';
        }

        return null;
    }

    public static function inferRoomFromTableNumber(?string $tableNumber, ?string $section = null): ?int
    {
        $tableNumber = strtoupper(trim((string) $tableNumber));
        $section = $section ?: self::inferSectionFromTableNumber($tableNumber);

        if ($section !== 'vip' || $tableNumber === '') {
            return null;
        }

        if (preg_match('/^VIP\s*C\s*(\d+)$/', $tableNumber, $matches)) {
            return (int) $matches[1];
        }

        if (preg_match('/^V(\d)/', $tableNumber, $matches)) {
            return (int) $matches[1];
        }

        return null;
    }

    public static function removeLegacyRows(array $definitions): array
    {
        foreach (['T1', 'T2', 'T3'] as $legacyTableNumber) {
            unset($definitions[$legacyTableNumber]);
        }

        if (isset($definitions['Garden'])) {
            unset($definitions['G1']);
        }

        return $definitions;
    }

    public static function ensureLayoutColumnsExist(): void
    {
        if (!Schema::hasTable('table_statuses')) {
            return;
        }

        if (!Schema::hasColumn('table_statuses', 'section')) {
            Schema::table('table_statuses', function (Blueprint $table) {
                $table->string('section')->nullable()->after('table_number');
            });
        }

        if (!Schema::hasColumn('table_statuses', 'room')) {
            Schema::table('table_statuses', function (Blueprint $table) {
                $table->unsignedInteger('room')->nullable()->after('section');
            });
        }
    }
}
