<?php

namespace App\Services\Student;

use App\Models\Category;
use App\Models\Content;
use App\Models\Genre;
use App\Models\Meeting;
use App\Models\Section;
use Illuminate\Support\Collection;

class HighlightService
{
    /**
     * @param Category $category
     * @param Genre|null $genre
     * @param integer $limit
     * @return Collection|Content[]
     */
    public function getContentsByCategoryAndGenre(Category $category, null|Genre $genre = null, int $limit = 6): Collection
    {
        /** @var Section */
        $highlightSection = Section::where('identifier', 'Destaques')->first();

        return $highlightSection->contents()
            ->where('category_id', $category->id)
            ->when($genre, function($query, $genre){
                return $query->whereHas('genres', function($query) use ($genre) {
                    $query->where('genres.id', $genre->id);
                });
            })
            ->limit($limit)
            ->get();
    }

    /**
     * @param array $categoryIds
     * @param Genre|null $genre
     * @param integer $limit
     * @return Collection|Content[]
     */
    public function getContentsByCategoriesAndGenre(array $categoryIds, null|Genre $genre = null, int $limit = 6): Collection
    {
        /** @var Section */
        $highlightSection = Section::where('identifier', 'Destaques')->first();

        return $highlightSection->contents()
            ->whereIn('category_id', $categoryIds)
            ->when($genre, function($query, $genre){
                return $query->whereHas('genres', function($query) use ($genre) {
                    $query->where('genres.id', $genre->id);
                });
            })
            ->limit($limit)
            ->get();
    }

    /**
     * @param int $limit
     * @return Collection|Content[]
     */
    public function getContents(int $limit = 6): Collection
    {
        /** @var Section */
        $highlightSection = Section::where('identifier', 'Destaques')->first();

        return $highlightSection->contents()->limit($limit)->get();
    }

    /**
     * @return Collection<Meeting>
     */
    public function getNextMeetings(int $limit = 6): Collection
    {
        return Meeting::where('start_at', '>=', now())->where('status', 'aberto')->orderBy('start_at')->limit($limit)->get();
    }
}
