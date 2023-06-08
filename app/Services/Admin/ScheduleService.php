<?php

namespace App\Services\Admin;

use App\Models\LiveEvent;
use App\Models\Meeting;
use Illuminate\Support\Carbon;

class ScheduleService
{
    /**
     * @return Meeting|null
     */
    public function nextMeeting(): Meeting|null
    {
        return Meeting::where('start_at', '>=', now())
            ->where('status', 'aberto')
            ->orderBy('start_at')
            ->first();
    }

    /**
     * @return LiveEvent|null
     */
    public function nextLiveEvent(): LiveEvent|null
    {
        return LiveEvent::where('start_at', '>=', now())
            ->orderBy('start_at')
            ->first();
    }

    /**
     * @return LiveEvent|Meeting|null
     */
    public function nextEvent(): LiveEvent|Meeting|null
    {
        $liveEvent = $this->nextLiveEvent();

        $meeting = $this->nextMeeting();

        if ($liveEvent?->start_at && $meeting?->start_at) {
            return $liveEvent->start_at->lte($meeting->start_at) ? $liveEvent : $meeting;
        }  elseif($liveEvent?->start_at){
            return $liveEvent;
        } elseif($meeting?->start_at){
            return $meeting;
        }

        return null;
    }

    /**
     * @return Carbon|null
     */
    public function nextEventDate(): Carbon|null
    {
        $event = $this->nextEvent();

        return $event && $event->start_at ? $event->start_at : null;
    }

    /**
     * @return string|null
     */
    public function nextEventDateFormat(string $format = 'Y-m-d H:i'): string|null
    {
        $eventDate = $this->nextEventDate();

        return $eventDate ? $eventDate->format($format) : null;
    }

}


