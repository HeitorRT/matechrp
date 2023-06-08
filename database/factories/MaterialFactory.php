<?php

namespace Database\Factories;

use App\Enums\ExtraPlayerEnum;
use App\Enums\ExtraTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => fake()->name,
            'path' => fake()->imageUrl(640, 480, 'material para teste', true),
            'size' => fake()->numberBetween(50, 5000),
        ];
    }
}
