<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'full_name' => $this->faker->name,
            'specialization' => $this->faker->randomElement(['Cardiology', 'Neurology', 'Pediatrics', 'Orthopedics', 'General Medicine']),
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'tarif' => $this->faker->numberBetween(100, 1000),
        ];
    }
}
