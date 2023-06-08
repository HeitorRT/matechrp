<?php

namespace Database\Factories;

use App\Enums\ContentAuthorEnum;
use App\Enums\ContentProductionTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class ContentFactory extends Factory
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
            'name' => fake()->streetName(),
            'launch_start_at' => now()->addDays(random_int(10, 20)),
            'launch_end_at' => now()->addDays(random_int(30, 40)),
            'author' => $author,
            'production_type' => fake()->randomElement(ContentProductionTypeEnum::toValues()),
            'end_at' => now()->addDays(random_int(50, 55)),
            'highlight' => fake()->boolean(),
            'access_count' => fake()->numberBetween(0, 500),
            'image' => \App\Helpers\Seeder\Random::image(),
            'secondary_image' => \App\Helpers\Seeder\Random::image(),
            'description_image' => \App\Helpers\Seeder\Random::image(),
            'screensaver_image' => \App\Helpers\Seeder\Random::image(),
            'active' => fake()->boolean(),
            'description' => fake()->realText(300),
            'tags' => \App\Helpers\Seeder\Random::tag(3),
        ];
    }
}
