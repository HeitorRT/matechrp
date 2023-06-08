<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\Student\HighlightService;
use App\Http\Resources\Student\LiveEventResource;
use App\Models\LiveEvent;
use App\Services\Student\LiveEventService;
use Inertia\Response;

class LiveEventController extends Controller
{
     /**
     * @var LiveEventService
     */
    protected LiveEventService $liveEventService;

    /**
     * @param HighlightService $liveEventService
     */
    public function __construct(LiveEventService $liveEventService)
    {
        $this->liveEventService = $liveEventService;
    }

    /**
     * @return Response
     */
    public function index(): Response
    {
        $highlightItems = $this->liveEventService->getNext(6);

        return inertia('Student/Live/Index', [
            'highlightItems' => LiveEventResource::collection($highlightItems),
            'sections' => collect()->push([
                'name' => 'Lives futuras',
                'lives' => LiveEventResource::collection($this->liveEventService->getNext())
            ])->push([
                'name' => 'Lives anteriores',
                'lives' => LiveEventResource::collection($this->liveEventService->getPrevious())
            ])->push([
                'name' => 'Continue assistindo',
                'lives' => LiveEventResource::collection($this->liveEventService->getKeepWatching())
            ])
        ]);
    }

    /**
     * @param LiveEvent $liveEvent
     * @return Response
     */
    public function show(LiveEvent $liveEvent): Response
    {
        return inertia('Student/LiveEvent/Show', [
            'liveEvent' => new LiveEventResource($liveEvent)
        ]);
    }
}
