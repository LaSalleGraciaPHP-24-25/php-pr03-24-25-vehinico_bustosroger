<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Apartment;
use App\Models\Platform;

class PlatformApartmentFactory extends Factory
{

    public function definition(): array
    {
        return [
            'apartment_id' => Apartment::inRandomOrder()->first()->id ?? Apartment::factory(),
            'platform_id' => Platform::inRandomOrder()->first()->id ?? Platform::factory(),
            'register_date' => now(),
            'premium' => $this->faker->boolean,
        ];
    }
}
