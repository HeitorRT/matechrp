<?php

namespace Database\Seeders;

use App\Enums\ContentAuthorEnum;
use App\Models\Category;
use App\Models\Chapter;
use App\Models\Content;
use App\Models\Extra;
use App\Models\Genre;
use App\Models\Season;
use App\Models\Section;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Content::factory(30)
            ->hasAttached(Student::all()->random(), [], 'studentList')
            ->for(Category::where('name', 'not like', "%Filme%")->get()->random())
            ->has(Extra::factory(random_int(5, 6)))
            ->state([
                'has_seasons' => true,
                'number_of_seasons' => random_int(1, 5)
            ])
            ->create()
            ->each(function(Content $content) {
                $content->genres()->sync(Genre::all()->random(2));

                foreach (range(1, $content->number_of_seasons) as $number) {
                    /** @var Season */
                    $season = $content->seasons()->create(Season::factory()->make([
                        'number' => $number,
                        'number_of_chapters' => random_int(1, 5)
                    ])->toArray());

                    foreach (range(1, $season->number_of_chapters) as $chapterNumber) {
                        $season->chapters()->create(Chapter::factory()->make(['number' => $chapterNumber])->toArray());
                    }
                }
            });

        Content::factory(30)
            ->for(Category::where('name', 'like', "%Filme%")->first())
            ->has(Extra::factory(random_int(5, 6)))
            ->create()
            ->each(function(Content $content) {
                $content->chapter()->create(Chapter::factory()->make()->toArray());
                $content->genres()->sync(Genre::all()->random(2));
            });

        Content::get()->each(function(Content $content) {
            $content->similarContents()->sync(Content::all()->random(random_int(5, 6)));
            $content->contentsOfTheSameCollection()->sync(Content::all()->random(random_int(5, 6)));

            if ($content->author === ContentAuthorEnum::outro()) {
                $content->responsible()->associate(User::arePartners()->get()->random())->save();
            }

            Section::get()->random(random_int(1, 3))->each(function (Section $section, int $key) use ($content) {
                $content->sections()->attach($section, ['sort_number' => $key + 1]);
            });
        });
    }
}
