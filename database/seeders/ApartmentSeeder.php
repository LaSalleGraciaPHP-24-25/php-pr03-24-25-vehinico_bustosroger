<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\User;
use Illuminate\Database\Seeder;

class ApartmentSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        if ($users->count() == 0) {
            $users = User::factory(5)->create();
        }

        Apartment::factory(20)->create([
            'user_id' => $users->random()->id,
        ]);
    }
}
