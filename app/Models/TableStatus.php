<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
