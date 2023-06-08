<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'cpf' => fake()->numerify('###.###.###-##'),
            'phone' => fake()->phoneNumber(),
            'customer_cpf' => fake()->numerify('###.###.###-##'),
            'customer_phone' => fake()->phoneNumber(),
            'created_at' => fake()->dateTimeBetween('-2 months', 'now')
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function forTest()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Aluno',
                'email' => 'aluno@aluno.com',
                'password' => bcrypt('aluno'),
                'active' => true
            ];
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function equalData()
    {
        return $this->state(function (array $attributes) {
            return [
                'customer_cpf' => $attributes['cpf'],
                'customer_phone' => $attributes['phone'],
                'equal_data' => true
            ];
        });
    }
}