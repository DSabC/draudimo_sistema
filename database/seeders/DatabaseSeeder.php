<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Owner;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Owner::factory(10)->create()->each(function ($owner) {
            Car::factory(rand(1, 3))->create([
                'owner_id' => $owner->id,
            ]);
        });
    }
}
