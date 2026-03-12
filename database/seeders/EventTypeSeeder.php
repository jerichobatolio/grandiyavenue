<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EventType;

class EventTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $eventTypes = [
            [
                'name' => 'Birthday Party',
                'description' => 'Celebrate your special day with our birthday party package. Perfect for all ages with themed decorations, delicious food, and entertainment.',
                'down_payment' => 1500.00,
                'price' => 3000.00,
                'is_active' => true
            ],
            [
                'name' => 'Wedding Reception',
                'description' => 'Make your wedding day unforgettable with our elegant wedding reception package. Includes premium catering, decorations, and professional services.',
                'down_payment' => 5000.00,
                'price' => 10000.00,
                'is_active' => true
            ],
            [
                'name' => 'Anniversary Celebration',
                'description' => 'Celebrate your love story with our romantic anniversary package. Perfect for couples celebrating their special milestone.',
                'down_payment' => 2000.00,
                'price' => 4000.00,
                'is_active' => true
            ],
            [
                'name' => 'Corporate Event',
                'description' => 'Professional corporate event package for conferences, seminars, product launches, and company celebrations.',
                'down_payment' => 3000.00,
                'price' => 6000.00,
                'is_active' => true
            ],
            [
                'name' => 'Custom Event',
                'description' => 'Create your perfect event with our customizable package. We work with you to design the ideal celebration for any occasion.',
                'down_payment' => 1500.00,
                'price' => 3000.00,
                'is_active' => true
            ]
        ];

        foreach ($eventTypes as $eventTypeData) {
            EventType::create($eventTypeData);
        }
    }
}
