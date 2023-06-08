<?php

namespace Database\Factories;

use App\Enums\ExtraPlayerEnum;
use App\Enums\ExtraTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExtraFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $type = fake()->randomElement(ExtraTypeEnum::toValues());

        return [
            'name' => fake()->name,
            'type' => $type,
            'player' => fake()->randomElement(ExtraPlayerEnum::toValues()),
            'embed' => fake()->url(),
            'file' => $type === ExtraTypeEnum::arquivo()->value ? \App\Helpers\Seeder\Random::image() : null
        ];
    }
}
