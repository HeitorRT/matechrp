<?php

namespace App\Services\Admin;

use App\Http\Resources\Admin\EventsTeacher\LiveEventResource;
use App\Http\Resources\Admin\EventsTeacher\MeetingResource;
use App\Models\LiveEvent;
use App\Models\Meeting;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class EventsTeacherService
{
    /**
     * @return array|null
     */
    public function nextEventsTeacher(int $limit = 1): array|null
    {
        $meetings = $this->nextMeetings($limit);
        $liveEvents = $this->nextLiveEvents($limit);

        return $meetings->merge($liveEvents)->sortBy('start_at')->values()->take($limit)->map(function(Meeting|LiveEvent $event){
            return $event instanceof Meeting ? new MeetingResource($event) : new LiveEventResource($event);
        })->toArray();
    }

    /**
     * @return Meeting[]|Collection
     */
    public function nextMeetings(int $limit = 1): Collection
    {
        return Meeting::where('start_at', '>=', now())
            ->where('teacher_id', Auth::user()->id)
            ->where('status', 'aberto')
            ->orderBy('start_at')
            ->take($limit)
            ->get();
    }

    /**
     * @return LiveEvent[]|Collection
     */
    public function nextLiveEvents(int $limit = 1): Collection
    {
        return LiveEvent::where('start_at', '>=', now())
            ->where('responsible_id', Auth::user()->id)
            ->orderBy('start_at')
            ->take($limit)
            ->get();
    }

}


