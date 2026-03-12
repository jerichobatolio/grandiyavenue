<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'name' => 'Royal Wedding Package',
                'description' => 'A luxurious wedding celebration with elegant decorations, premium catering, and professional photography. Perfect for couples who want their special day to be truly memorable.',
                'type' => 'wedding',
                'base_price' => 150000.00,
                'min_guests' => 50,
                'max_guests' => 200,
                'duration_hours' => 8,
                'included_services' => [
                    'Elegant venue decoration',
                    'Premium 5-course dinner',
                    'Professional photography (8 hours)',
                    'Live band entertainment',
                    'Wedding cake (3-tier)',
                    'Bridal suite preparation',
                    'Event coordinator',
                    'Sound system and lighting',
                    'Table linens and centerpieces',
                    'Parking for 50 vehicles'
                ],
                'addon_services' => [
                    'videography' => [
                        'name' => 'Professional Videography',
                        'description' => 'Full wedding video with highlights reel',
                        'price' => 25000.00
                    ],
                    'dj' => [
                        'name' => 'DJ Services',
                        'description' => 'Professional DJ with music library',
                        'price' => 15000.00
                    ],
                    'flowers' => [
                        'name' => 'Premium Floral Arrangements',
                        'description' => 'Custom floral decorations and bouquets',
                        'price' => 30000.00
                    ],
                    'bar' => [
                        'name' => 'Open Bar Service',
                        'description' => 'Unlimited drinks for 4 hours',
                        'price' => 20000.00
                    ]
                ],
                'terms_conditions' => 'Wedding bookings require 50% deposit. Final payment due 2 weeks before event. Cancellation policy: 30 days notice for full refund, 14 days for 50% refund.',
                'is_active' => true
            ],
            [
                'name' => 'Birthday Celebration Package',
                'description' => 'Make your birthday unforgettable with our special celebration package. Includes themed decorations, delicious food, and entertainment for all ages.',
                'type' => 'birthday',
                'base_price' => 25000.00,
                'min_guests' => 10,
                'max_guests' => 50,
                'duration_hours' => 4,
                'included_services' => [
                    'Themed decorations',
                    'Birthday cake',
                    'Buffet-style meal',
                    'Party games and activities',
                    'Sound system',
                    'Party coordinator',
                    'Clean-up service',
                    'Birthday banner',
                    'Party favors for guests',
                    'Photo booth (2 hours)'
                ],
                'addon_services' => [
                    'magician' => [
                        'name' => 'Magician Performance',
                        'description' => 'Professional magician show (1 hour)',
                        'price' => 8000.00
                    ],
                    'face_painting' => [
                        'name' => 'Face Painting Service',
                        'description' => 'Face painting for children',
                        'price' => 5000.00
                    ],
                    'balloon_artist' => [
                        'name' => 'Balloon Artist',
                        'description' => 'Balloon animals and decorations',
                        'price' => 3000.00
                    ],
                    'catering_upgrade' => [
                        'name' => 'Premium Catering',
                        'description' => 'Upgraded menu with premium dishes',
                        'price' => 10000.00
                    ]
                ],
                'terms_conditions' => 'Birthday packages require full payment upon booking. Cancellation policy: 7 days notice for full refund.',
                'is_active' => true
            ],
            [
                'name' => 'Corporate Event Package',
                'description' => 'Professional corporate event package perfect for conferences, seminars, product launches, and company celebrations. Includes modern facilities and professional services.',
                'type' => 'corporate',
                'base_price' => 75000.00,
                'min_guests' => 20,
                'max_guests' => 100,
                'duration_hours' => 6,
                'included_services' => [
                    'Conference room setup',
                    'Professional AV equipment',
                    'High-speed WiFi',
                    'Coffee break service',
                    'Lunch buffet',
                    'Event coordinator',
                    'Registration desk',
                    'Name tags and materials',
                    'Parking for attendees',
                    'Clean-up service'
                ],
                'addon_services' => [
                    'projector' => [
                        'name' => 'High-Resolution Projector',
                        'description' => '4K projector with large screen',
                        'price' => 5000.00
                    ],
                    'catering_upgrade' => [
                        'name' => 'Premium Catering',
                        'description' => 'Gourmet lunch and refreshments',
                        'price' => 15000.00
                    ],
                    'photography' => [
                        'name' => 'Event Photography',
                        'description' => 'Professional event documentation',
                        'price' => 12000.00
                    ],
                    'networking' => [
                        'name' => 'Networking Session',
                        'description' => 'Extended networking with refreshments',
                        'price' => 8000.00
                    ]
                ],
                'terms_conditions' => 'Corporate events require 30% deposit. Final payment due 1 week before event. Cancellation policy: 14 days notice for full refund.',
                'is_active' => true
            ],
            [
                'name' => 'Anniversary Celebration Package',
                'description' => 'Celebrate your special milestone with our romantic anniversary package. Perfect for couples celebrating their years together with an intimate and elegant setting.',
                'type' => 'anniversary',
                'base_price' => 35000.00,
                'min_guests' => 2,
                'max_guests' => 30,
                'duration_hours' => 3,
                'included_services' => [
                    'Romantic table setup',
                    'Candlelight dinner',
                    'Anniversary cake',
                    'Flower arrangements',
                    'Soft background music',
                    'Photography session (1 hour)',
                    'Champagne toast',
                    'Personalized menu',
                    'Romantic lighting',
                    'Memory book creation'
                ],
                'addon_services' => [
                    'photographer' => [
                        'name' => 'Professional Photographer',
                        'description' => 'Extended photography session (2 hours)',
                        'price' => 10000.00
                    ],
                    'live_music' => [
                        'name' => 'Live Music Performance',
                        'description' => 'Acoustic guitar or piano performance',
                        'price' => 8000.00
                    ],
                    'spa_treatment' => [
                        'name' => 'Couple Spa Treatment',
                        'description' => 'Relaxing spa session for two',
                        'price' => 12000.00
                    ],
                    'wine_tasting' => [
                        'name' => 'Wine Tasting Experience',
                        'description' => 'Curated wine selection with sommelier',
                        'price' => 6000.00
                    ]
                ],
                'terms_conditions' => 'Anniversary packages require full payment upon booking. Cancellation policy: 3 days notice for full refund.',
                'is_active' => true
            ],
            [
                'name' => 'Custom Event Package',
                'description' => 'Create your perfect event with our customizable package. We work with you to design the ideal celebration for any occasion with flexible options and personalized service.',
                'type' => 'other',
                'base_price' => 50000.00,
                'min_guests' => 15,
                'max_guests' => 150,
                'duration_hours' => 5,
                'included_services' => [
                    'Custom venue setup',
                    'Flexible catering options',
                    'Basic sound system',
                    'Event planning consultation',
                    'Day-of coordination',
                    'Basic decorations',
                    'Clean-up service',
                    'Parking assistance',
                    'Flexible timing',
                    'Custom menu options'
                ],
                'addon_services' => [
                    'custom_decor' => [
                        'name' => 'Custom Decorations',
                        'description' => 'Personalized theme and decorations',
                        'price' => 15000.00
                    ],
                    'entertainment' => [
                        'name' => 'Entertainment Package',
                        'description' => 'Live music, DJ, or performance',
                        'price' => 20000.00
                    ],
                    'catering_custom' => [
                        'name' => 'Custom Catering Menu',
                        'description' => 'Fully customized food and beverage',
                        'price' => 25000.00
                    ],
                    'photography_custom' => [
                        'name' => 'Custom Photography',
                        'description' => 'Extended photography with editing',
                        'price' => 18000.00
                    ]
                ],
                'terms_conditions' => 'Custom events require consultation and 40% deposit. Final payment due 2 weeks before event. Cancellation policy: 21 days notice for full refund.',
                'is_active' => true
            ]
        ];

        foreach ($events as $eventData) {
            Event::create($eventData);
        }
    }
}