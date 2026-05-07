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
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password',
            'role' => User::ROLE_ADMIN,
        ]);

        $reader = User::factory()->create([
            'name' => 'Reader User',
            'email' => 'reader@example.com',
            'password' => 'password',
            'role' => User::ROLE_READER,
        ]);

        $regular = User::factory()->create([
            'name' => 'Regular User',
            'email' => 'regular@example.com',
            'password' => 'password',
            'role' => User::ROLE_REGULAR,
        ]);

        collect([$admin, $reader, $regular])->each(function (User $user) {
            Owner::factory(rand(3, 4))->create([
                'user_id' => $user->id,
            ])->each(function ($owner) {
                Car::factory(rand(1, 3))->create([
                    'owner_id' => $owner->id,
                ]);
            });
        });

        $legacyOwner = Owner::factory()->create([
            'name' => 'Legacy',
            'surname' => 'Owner',
            'phone' => '+37060000000',
            'email' => 'legacy.owner@example.com',
            'address' => 'Kaunas',
            'user_id' => $admin->id,
        ]);

        Car::factory(rand(1, 3))->create([
            'owner_id' => $legacyOwner->id,
        ]);
    }
}
