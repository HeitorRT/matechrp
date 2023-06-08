<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Content;
use App\Models\LiveEvent;
use App\Models\Material;
use App\Models\Season;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class LiveEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LiveEvent::factory(20)
            ->hasAttached(Student::all()->random())
            ->has(Material::factory()->count(random_int(1, 4)))
            ->state(function() {
                $content = Content::where('has_seasons', true)->get()->random();

                if (! $content)
                    return [];

                $season = $content->seasons()->get()->random();

                return [
                    'responsible_id' => User::areTeachers()->get()->random()->id,
                    'linkable_type' => Season::class,
                    'linkable_id' => $season->id,
                    'content_id' => $content->id,
                    'has_link_with_content' => true
                ];
            })
            ->create();

        LiveEvent::factory(20)
            ->has(Material::factory()->count(random_int(1, 4)))
            ->state(function() {
                $content = Content::where('has_seasons', true)->get()->random();

                if (! $content)
                    return [];

                $season = $content->seasons()->get()->random();

                if (! $season)
                    return [];

                $chapter = $season->chapters()->get()->random();

                if (! $chapter)
                    return [];

                return [
                    'responsible_id' => User::areTeachers()->get()->random()->id,
                    'linkable_type' => Chapter::class,
                    'linkable_id' => $chapter->id,
                    'content_id' => $content->id,
                    'has_link_with_content' => true
                ];
            })
            ->create();
    }
}
