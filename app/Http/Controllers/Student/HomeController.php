<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Section;
use App\Models\LiveEvent;
use App\Models\Meeting;
use App\Services\Student\CourseApiService;
use App\Http\Resources\Student\HighLight\ContentResource;
use App\Http\Resources\Student\LiveEventResource;
use App\Http\Resources\Student\HighLight\MeetingResource;
use App\Http\Resources\Student\Section\SectionResource;
use App\Services\Student\HomeService;
use Inertia\Response;

class HomeController extends Controller
{
    /**
     * @var CourseApiService
     */
    protected CourseApiService $courseApiService;

     /**
     * @var HomeService
     */
    protected HomeService $homeService;

    /**
     * @param CourseApiService $courseApiService
     * @param HomeService $homeService
     */
    public function __construct(CourseApiService $courseApiService, HomeService $homeService)
    {
        $this->courseApiService = $courseApiService;
        $this->homeService = $homeService;
    }

    /**
     * @return Response
     */
    public function index(): Response
    {
        $highlightItems = $this->homeService->index()->map(fn(Content|Meeting|LiveEvent $item) => match(true) {
            $item instanceof Content    => new ContentResource($item),
            $item instanceof Meeting    => new MeetingResource($item),
            $item instanceof LiveEvent  => new LiveEventResource($item),
        });

        $sections = Section::orderBy('sort_number')->get();

        return inertia('Student/Home/Index', [
            'highlightItems' => $highlightItems,
            'sections' => SectionResource::collection($sections),
            'courses' => $this->courseApiService->get(),
        ]);
    }
}
