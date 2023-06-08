<?php

namespace Database\Factories;

use App\Enums\ContentAuthorEnum;
use App\Enums\ContentProductionTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class PopupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $author = fake()->randomElement(ContentAuthorEnum::toValues());

        return [
            'description' => fake()->name(),
            'start_at' => now(),
            'end_at' => now()->addDays(1),
            'image' => \App\Helpers\Seeder\Random::image(),
        ];
    }
}
