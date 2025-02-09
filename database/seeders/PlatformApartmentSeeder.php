<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlatformApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $apartments = Apartment::all();
        $platforms = Platform::all();

        foreach ($apartments as $apartment) {
            $platformIds = $platforms->random(rand(1, 3))->pluck('id')->toArray();
            
            foreach ($platformIds as $platformId) {
                $apartment->platforms()->attach($platformId, [
                    'register_date' => now(),
                    'premium' => rand(0, 1),
                ]);
            }
        }
    }
}
