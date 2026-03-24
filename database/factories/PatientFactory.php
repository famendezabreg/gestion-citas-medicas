<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'      => fake('es_ES')->name(),
            'email'     => fake()->unique()->safeEmail(),
            'phone'     => fake('es_ES')->phoneNumber(),
            'birthdate' => fake()->dateTimeBetween('-80 years', '-18 years')->format('Y-m-d'),
            'address'   => fake('es_ES')->address(),
            'gender'    => fake()->randomElement(['M', 'F']),
        ];
    }
}