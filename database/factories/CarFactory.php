<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $brands = [
            'Audi' => ['A4', 'A6', 'Q5'],
            'BMW' => ['320', '520', 'X5'],
            'Toyota' => ['Corolla', 'Avensis', 'RAV4'],
            'Volkswagen' => ['Golf', 'Passat', 'Tiguan'],
            'Mercedes' => ['C200', 'E220', 'GLC'],
        ];

        $brand = fake()->randomElement(array_keys($brands));
        $model = fake()->randomElement($brands[$brand]);

        return [
            'reg_number' => strtoupper(fake()->bothify('???###')),
            'brand' => $brand,
            'model' => $model,
        ];
    }
}
