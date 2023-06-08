<?php

namespace App\Services\Student;

use App\Models\Content;
use App\Models\Genre;
use Illuminate\Support\Collection;

class SearchService
{

    /**
     * @param string $filter_content
     * @param string $genre_id
     * @return Collection|Content[]
     */
    public function getContentsFilter(null|string $filter_content, null|string $genre_id): Collection
    {
        $contentMatch = $this->getMatchContent($filter_content);

        if ($contentMatch) {
            $contents = $contentMatch->contentsOfTheSameCollection;
        } else {
            $contents = $this->getContents($filter_content, $genre_id);
        }

        if ($genre_id && !$filter_content) {
            $genre = Genre::with(['contents'])->find($genre_id);
            $contents = $genre->contents;
        }

        return $contents;
    }

    /**
     * @param string $filter_content
     * @return Content
     */
    public function getMatchContent(null|string $filter_content): Content|null
    {
        return Content::with(['genres', 'contentsOfTheSameCollection', 'category', 'seasons'])->where('name', $filter_content)->first();
    }

    /**
     * @param string $filter_content
     * @param string $genre_id
     * @return Collection|Content[]
     */
    public function getContents(null|string $filter_content, null|string $genre_id): Collection
    {
        return Content::where('name', 'like', '%' . $filter_content . '%')
                ->when($genre_id, function($query, $genre_id){
                    return $query->whereHas('genres', function($query) use ($genre_id) {
                        $query->where('genres.id', $genre_id);
                    });
                })
                ->get();
    }

    /**
     * @param string $filter_content
     * @return Collection|Genre[]
     */
    public function getGenres(null|string $filter_content): Collection
    {
        return $genres = Genre::with('contents')
            ->when($filter_content, function($query, $filter_content){
                return $query->whereHas('contents', function($query) use ($filter_content) {
                    $query->where('contents.name', 'like', '%'.$filter_content.'%');
                });
            })
            ->orderBy('name')
            ->get();
    }

}
