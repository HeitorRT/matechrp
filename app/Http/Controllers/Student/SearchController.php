<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\Student\HighLight\ContentResource;
use App\Services\Student\SearchService;
use Illuminate\Http\Request;
use Inertia\Response;

class SearchController extends Controller
{
    /**
     * @var SearchService
     */
    private $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    /**
     * @return Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $request->validate([
            'genre_id' => 'nullable|exists:genres,id',
            'filter_content' => 'nullable',
        ]);

        $content = $this->searchService->getMatchContent($request->get('filter_content',null));
        $contents = $this->searchService->getContentsFilter($request->get('filter_content',null),$request->get('genre_id', null));

        return inertia('Student/Search/Index', [
            'content' => $content,
            'contents' => ContentResource::collection($contents),
            'genres' => $content ? null : $this->searchService->getGenres($request->get('filter_content',null)),
        ]);
    }
}
