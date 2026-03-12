<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Subcategory;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories
        $categories = [
            ['name' => 'Chicken', 'emoji' => '🍗'],
            ['name' => 'Noodles & Pasta', 'emoji' => '🍝'],
            ['name' => 'Sizzling', 'emoji' => '🔥'],
            ['name' => 'Dessert', 'emoji' => '🍰'],
            ['name' => 'Drinks', 'emoji' => '🥤'],
            ['name' => 'Beef', 'emoji' => '🥩'],
            ['name' => 'Bundle Package', 'emoji' => '📦'],
            ['name' => 'Party Tray', 'emoji' => '🎉'],
            ['name' => 'House Specialty', 'emoji' => '⭐']
        ];

        foreach ($categories as $categoryData) {
            $category = Category::create($categoryData);
            
            // Add subcategories for Drinks
            if ($category->name === 'Drinks') {
                $drinkSubcategories = [
                    ['name' => 'Cold', 'emoji' => '❄️'],
                    ['name' => 'Hot', 'emoji' => '☕'],
                    ['name' => 'Shake', 'emoji' => '🥤']
                ];
                
                foreach ($drinkSubcategories as $subcategoryData) {
                    Subcategory::create([
                        'name' => $subcategoryData['name'],
                        'emoji' => $subcategoryData['emoji'],
                        'category_id' => $category->id
                    ]);
                }
            }
        }
    }
}
