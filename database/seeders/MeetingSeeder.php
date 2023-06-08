<?php

namespace Database\Seeders;

use App\Enums\MeetingTypeEnum;
use App\Models\Chapter;
use App\Models\Content;
use App\Models\Group;
use App\Models\Material;
use App\Models\Meeting;
use App\Models\Season;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class MeetingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Meeting::factory(20)
            ->hasAttached(Student::all()->random())
            ->has(Material::factory()->count(random_int(1, 4)))
            ->state(function() {
                $content = Content::where('has_seasons', true)->get()->random();

                if (! $content)
                    return [];

                $season = $content->seasons()->get()->random();

                return [
                    'type' => MeetingTypeEnum::individual()->value,
                    'teacher_id' => User::areTeachers()->get()->random()->id,
                    'number_of_students' =>  1,
                    'linkable_type' => Season::class,
                    'linkable_id' => $season->id,
                    'content_id' => $content->id,
                    'has_link_with_content' => true
                ];
            })
            ->create();

        Meeting::factory(20)
            ->has(Material::factory()->count(random_int(1, 4)))
            ->hasAttached(Group::inRandomOrder()->take(rand(1, 3))->get())
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
                    'type' => MeetingTypeEnum::grupo()->value,
                    'teacher_id' => User::areTeachers()->get()->random()->id,
                    'number_of_students' => rand(1, 10),
                    'linkable_type' => Chapter::class,
                    'linkable_id' => $chapter->id,
                    'content_id' => $content->id,
                    'has_link_with_content' => true
                ];
            })
            ->create()
            ->each(function(Meeting $meeting) {
                $meeting->students()->sync(Student::all()->random(rand(1, $meeting->number_of_students)));
            });
    }
}
