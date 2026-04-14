<?php

namespace Database\Seeders;

use App\Models\Tour;
use Illuminate\Database\Seeder;

class TourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tour::create([
            'name' => 'Paris City Tour',
            'description' => 'Explore the beautiful city of Paris with visits to Eiffel Tower, Louvre, and Notre-Dame.',
            'price' => 150.00,
            'total_slots' => 50,
            'available_slots' => 50,
        ]);

        Tour::create([
            'name' => 'Italian Adventure',
            'description' => 'Experience Italy - Vatican City, Rome, Florence, and Venice in one amazing tour.',
            'price' => 250.00,
            'total_slots' => 40,
            'available_slots' => 40,
        ]);

        Tour::create([
            'name' => 'London Historical Tour',
            'description' => 'Discover London\'s rich history with tours of Big Ben, Tower of London, and Buckingham Palace.',
            'price' => 120.00,
            'total_slots' => 60,
            'available_slots' => 60,
        ]);

        Tour::create([
            'name' => 'Alps Mountain Trek',
            'description' => 'Hiking adventure in the Swiss Alps with breathtaking mountain views.',
            'price' => 200.00,
            'total_slots' => 25,
            'available_slots' => 25,
        ]);

        Tour::create([
            'name' => 'Spanish Fiesta Experience',
            'description' => 'Experience authentic Spanish culture, flamenco, and delicious cuisine in Barcelona and Madrid.',
            'price' => 180.00,
            'total_slots' => 35,
            'available_slots' => 35,
        ]);
    }
}
