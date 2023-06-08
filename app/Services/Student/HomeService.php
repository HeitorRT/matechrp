<?php

namespace App\Services\Student;

use App\Models\Content;
use App\Models\LiveEvent;
use App\Models\Meeting;
use Illuminate\Support\Collection;

class HomeService
{
    /**
     * @var HighlightService
     */
    protected HighlightService $highlightService;

    /**
     * @var LiveEventService
     */
    protected LiveEventService $liveEventService;

    /**
     * @param HighlightService $highlightService
     * @param LiveEventService $liveEventService
     */
    public function __construct(HighlightService $highlightService, LiveEventService $liveEventService)
    {
        $this->highlightService = $highlightService;
        $this->liveEventService = $liveEventService;
    }

    /**
     * @return Collection<Content|LiveEvent|Meeting>
     */
    public function index(): Collection
    {
        $highLights = new Collection();

        foreach ($this->highlightService->getContents(6) as $content) {
            $highLights->push($content);
        }

        foreach ($this->liveEventService->getNext(1) as $liveEvent) {
            $highLights->push($liveEvent);
        }

        foreach ($this->highlightService->getNextMeetings(1) as $meeting) {
            $highLights->push($meeting);
        }

        return $highLights;
    }
}
