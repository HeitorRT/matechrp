<?php

namespace Database\Factories;

use App\Enums\ChapterPlayerEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class ChapterFactory extends Factory
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
            'description' => fake()->realText(100),
            'duration' => fake()->time(),
            'cast' => Arr::join([
                fake()->name(),
                fake()->name(),
                fake()->name()
            ], ', ', ' e '),
            'direction' => fake()->name(),
            'main_player' => fake()->randomElement([ChapterPlayerEnum::vimeo(), ChapterPlayerEnum::outros()]),
            'vimeo_link' => 'https://player.vimeo.com/video/76979871?h=8272103f6e',
            'vimeo_embed' => '<iframe src="https://player.vimeo.com/video/76979871?h=8272103f6e" width="1920" height="1080" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen frameborder="0"></iframe>',
            'sambatech_link' => fake()->url(),
            'sambatech_embed' => fake()->unique()->slug(2),
            'embed' => '<iframe width="1280" height="720" src="https://www.youtube.com/embed/jdrNjHPYKz4?list=PLJicmE8fK0EhjQU9p9XUcJslo_hs5oBKk" title="Why do cats have vertical pupils? - Emma Bryce" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>',
            'image' => \App\Helpers\Seeder\Random::image()
        ];
    }
}
