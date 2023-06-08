<?php

namespace Database\Factories;

use App\Enums\MeetingStatusEnum;
use App\Enums\MeetingTypeEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class MeetingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $dateStart =  new Carbon(fake()->dateTimeBetween('-3 months', '+3 months'));

        return [
            'name' => fake()->words(3, true),
            'description' => fake()->realText(rand(20, 100)),
            'start_at' => $dateStart,
            'end_at' => $dateStart->addHours(2),
            'has_live_offer' => fake()->boolean(),
            'name_offer' => fake()->jobTitle(),
            'description_offer'=> fake()->realText(100),
            'embed_offer'=> fake()->url(),
            'type' => fake()->randomElement(MeetingTypeEnum::toValues()),
            'status' => $dateStart->greaterThan(now()) ? MeetingStatusEnum::aberto() : MeetingStatusEnum::finalizado(),
            'image' => \App\Helpers\Seeder\Random::image(),
            'tags' => \App\Helpers\Seeder\Random::tag(2),
        ];
    }
}
