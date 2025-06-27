<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Leverancier>
 */
class LeverancierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'bedrijfsnaam' => $this->faker->company(),
            'adres' => $this->faker->streetAddress() . ', ' . $this->faker->postcode() . ' ' . $this->faker->city(),
            'contactpersoon_naam' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'telefoonnummer' => $this->faker->phoneNumber(),
            'eerstvolgende_levering' => $this->faker->dateTimeBetween('now', '+2 weeks'),
            'actief' => $this->faker->boolean(80), // 80% kans op actief
        ];
    }
    
    /**
     * Indicate that the leverancier is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'actief' => true,
        ]);
    }
    
    /**
     * Indicate that the leverancier is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'actief' => false,
        ]);
    }
}
