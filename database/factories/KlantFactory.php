<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Klant>
 */
class KlantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $achternaam = $this->faker->lastName();
        
        return [
            'voornaam' => $this->faker->firstName(),
            'achternaam' => $achternaam,
            'gezinsnaam' => 'Familie ' . $achternaam,
            'straat' => $this->faker->streetName(),
            'huisnummer' => $this->faker->buildingNumber(),
            'postcode' => $this->faker->postcode(),
            'plaats' => $this->faker->city(),
            'telefoonnummer' => $this->faker->phoneNumber(),
            'email' => $this->faker->optional(0.8)->safeEmail(), // 80% heeft email
            'aantal_volwassenen' => $this->faker->numberBetween(1, 3),
            'aantal_kinderen' => $this->faker->numberBetween(0, 4),
            'aantal_babies' => $this->faker->numberBetween(0, 2),
            'actief' => $this->faker->boolean(85), // 85% kans op actief
            'aanmelddatum' => $this->faker->dateTimeBetween('-2 years', 'now'),
        ];
    }
    
    /**
     * Indicate that the klant is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'actief' => true,
        ]);
    }
    
    /**
     * Indicate that the klant is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'actief' => false,
        ]);
    }
    
    /**
     * Create a large family.
     */
    public function largeFamily(): static
    {
        return $this->state(fn (array $attributes) => [
            'aantal_volwassenen' => $this->faker->numberBetween(2, 4),
            'aantal_kinderen' => $this->faker->numberBetween(3, 6),
            'aantal_babies' => $this->faker->numberBetween(0, 2),
        ]);
    }
    
    /**
     * Create a single person household.
     */
    public function single(): static
    {
        return $this->state(fn (array $attributes) => [
            'aantal_volwassenen' => 1,
            'aantal_kinderen' => 0,
            'aantal_babies' => 0,
        ]);
    }
    
    /**
     * Create without email.
     */
    public function withoutEmail(): static
    {
        return $this->state(fn (array $attributes) => [
            'email' => null,
        ]);
    }
}
