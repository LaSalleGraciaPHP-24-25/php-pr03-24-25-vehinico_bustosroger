<?php

namespace Database\Factories;

use App\Models\Apartment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApartmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'postal_code' => $this->faker->postcode(),
            'rented_price' => $this->faker->randomFloat(2, 500, 2000),
            'rented' => $this->faker->boolean(),

            'user_id' => User::factory(),
        ];
    }
}
