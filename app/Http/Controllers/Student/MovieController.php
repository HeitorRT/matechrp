<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Services\Student\CourseApiService;
use App\Services\Student\HighlightService;
use App\Http\Resources\Student\HighLight\ContentResource;
use App\Http\Resources\Student\Section\SectionResource;
use App\Models\Category;
use App\Models\Genre;
use Illuminate\Http\Request;
use Inertia\Response;

class MovieController extends Controller
{
    /**
     * @var CourseApiService
     */
    protected CourseApiService $courseApiService;

     /**
     * @var HighlightService
     */
    protected HighlightService $highlightService;

    /**
     * @param CourseApiService $courseApiService
     * @param HighlightService $highlightService
     */
    public function __construct(CourseApiService $courseApiService, HighlightService $highlightService)
    {
        $this->courseApiService = $courseApiService;
        $this->highlightService = $highlightService;
    }

    /**
     * @return Response
     */
    public function index(Request $request): Response
    {
        $genre = $request->has('genre') ? Genre::find($request->get('genre')) : null;

        $category = Category::where('name', 'Filme')->firstOrfail();

        $highlightItems = $this->highlightService->getContentsByCategoryAndGenre($category, $genre);

        $sections = Section::with(['contents' => function($query) use ($category, $genre) {
            return $query->where('category_id', $category->id)->when($genre, function($query, $genre){
                return $query->whereHas('genres', function($query) use ($genre) {
                    $query->where('genres.id', $genre->id);
                });
            });
        }])->orderBy('sort_number')->get()->filter(fn(Section $section) => $section->contents->count());

        return inertia('Student/Movie/Index', [
            'highlightItems' => ContentResource::collection($highlightItems),
            'sections' => SectionResource::collection($sections),
            'genres' => Genre::orderBy('name')->get(),
            'courses' => $this->courseApiService->get(),
            'genreId' => $genre?->id
        ]);
    }
}
