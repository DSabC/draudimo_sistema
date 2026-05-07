<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\Owner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OwnershipPoliciesTest extends TestCase
{
    use RefreshDatabase;

    public function test_regular_user_only_sees_their_own_owners_and_cars(): void
    {
        $regular = User::factory()->create(['role' => User::ROLE_REGULAR]);
        $otherUser = User::factory()->create(['role' => User::ROLE_REGULAR]);

        $ownOwner = Owner::factory()->create(['user_id' => $regular->id, 'name' => 'OwnName']);
        $otherOwner = Owner::factory()->create(['user_id' => $otherUser->id, 'name' => 'OtherName']);

        $ownCar = Car::factory()->create(['owner_id' => $ownOwner->id, 'reg_number' => 'AAA111']);
        $otherCar = Car::factory()->create(['owner_id' => $otherOwner->id, 'reg_number' => 'BBB222']);

        $this->actingAs($regular)
            ->get(route('owners.index'))
            ->assertOk()
            ->assertSee('OwnName')
            ->assertDontSee('OtherName');

        $this->actingAs($regular)
            ->get(route('cars.index'))
            ->assertOk()
            ->assertSee('AAA111')
            ->assertDontSee('BBB222');
    }

    public function test_reader_user_can_view_all_but_cannot_edit_foreign_records(): void
    {
        $reader = User::factory()->create(['role' => User::ROLE_READER]);
        $ownerUser = User::factory()->create(['role' => User::ROLE_REGULAR]);

        $foreignOwner = Owner::factory()->create(['user_id' => $ownerUser->id, 'name' => 'ForeignOwner']);
        $foreignCar = Car::factory()->create(['owner_id' => $foreignOwner->id, 'reg_number' => 'CCC333']);

        $this->actingAs($reader)
            ->get(route('owners.index'))
            ->assertOk()
            ->assertSee('ForeignOwner');

        $this->actingAs($reader)
            ->get(route('cars.index'))
            ->assertOk()
            ->assertSee('CCC333');

        $this->actingAs($reader)
            ->get(route('owners.edit', $foreignOwner))
            ->assertForbidden();

        $this->actingAs($reader)
            ->get(route('cars.edit', $foreignCar))
            ->assertForbidden();
    }

    public function test_admin_can_edit_foreign_records(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $ownerUser = User::factory()->create(['role' => User::ROLE_REGULAR]);

        $foreignOwner = Owner::factory()->create(['user_id' => $ownerUser->id]);
        $foreignCar = Car::factory()->create(['owner_id' => $foreignOwner->id]);

        $this->actingAs($admin)
            ->get(route('owners.edit', $foreignOwner))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('cars.edit', $foreignCar))
            ->assertOk();
    }
}
