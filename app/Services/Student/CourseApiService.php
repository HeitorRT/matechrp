<?php

namespace App\Services\Student;

use App\Helpers\Seeder\Random;
use Illuminate\Support\Collection;

class CourseApiService
{
    /**
     * @return Collection
     */
    public function get(): Collection
    {
        /** @todo Alterar para API de cursos do Frances EAD */

        return collect([
            [
               'name' => fake()->name(),
               'image' => Random::image()
            ], [
                'name' => fake()->name(),
                'image' => Random::image()
            ],  [
                'name' => fake()->name(),
                'image' => Random::image()
            ]
        ]);
    }
}
