<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PlatformApartment;

class PlatformApartmentSeeder extends Seeder
{
    public function run(): void
    {
        PlatformApartment::factory()->count(50)->create();
    }
}
