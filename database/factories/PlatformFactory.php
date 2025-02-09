<?php
namespace Database\Factories;

use App\Models\Platform;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlatformFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'owner' => $this->faker->name(),
        ];
    }
}
