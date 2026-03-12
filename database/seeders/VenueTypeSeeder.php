<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VenueType;

class VenueTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $venueTypes = [
            [
                'name' => 'Indoor Hall',
                'description' => 'Spacious indoor hall perfect for formal events, weddings, and corporate gatherings',
                'capacity' => 100,
                'is_active' => true
            ],
            [
                'name' => 'Outdoor Garden',
                'description' => 'Beautiful outdoor garden setting for nature-themed events and outdoor celebrations',
                'capacity' => 150,
                'is_active' => true
            ],
            [
                'name' => 'Rooftop Terrace',
                'description' => 'Elegant rooftop with stunning city views, perfect for intimate gatherings',
                'capacity' => 80,
                'is_active' => true
            ],
            [
                'name' => 'Private Dining Room',
                'description' => 'Intimate private dining space for small groups and business meetings',
                'capacity' => 30,
                'is_active' => true
            ],
            [
                'name' => 'Conference Room',
                'description' => 'Professional conference room equipped with modern amenities for business events',
                'capacity' => 50,
                'is_active' => true
            ],
            [
                'name' => 'Poolside Area',
                'description' => 'Relaxing poolside venue perfect for casual events and summer parties',
                'capacity' => 60,
                'is_active' => false
            ]
        ];

        foreach ($venueTypes as $venueType) {
            VenueType::create($venueType);
        }
    }
}
