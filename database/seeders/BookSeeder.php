<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('books')->insert([
            [
                'phone' => '123-456-7890',
                'guest' => '4',
                'date' => '2025-10-23',
                'time' => '19:00',
                'status' => 'pending',
                'table_number' => 'T1',
                'time_in' => '19:00',
                'time_out' => '21:00',
                'duration_hours' => '2',
                'occasion' => 'birthday',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'phone' => '987-654-3210',
                'guest' => '6',
                'date' => '2025-10-23',
                'time' => '20:30',
                'status' => 'pending',
                'table_number' => 'T3',
                'time_in' => '20:30',
                'time_out' => '22:30',
                'duration_hours' => '2',
                'occasion' => 'anniversary',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'phone' => '555-123-4567',
                'guest' => '8',
                'date' => '2025-10-24',
                'time' => '18:00',
                'status' => 'approved',
                'table_number' => 'H9',
                'time_in' => '18:00',
                'time_out' => '20:00',
                'duration_hours' => '2',
                'occasion' => 'business',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'phone' => '444-555-6666',
                'guest' => '2',
                'date' => '2025-10-24',
                'time' => '19:30',
                'status' => 'pending',
                'table_number' => 'V11',
                'time_in' => '19:30',
                'time_out' => '21:30',
                'duration_hours' => '2',
                'occasion' => 'date',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'phone' => '777-888-9999',
                'guest' => '10',
                'date' => '2025-10-25',
                'time' => '17:00',
                'status' => 'cancelled',
                'table_number' => 'T5',
                'time_in' => '17:00',
                'time_out' => '19:00',
                'duration_hours' => '2',
                'occasion' => 'family',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
