<?php

namespace App\Services\Student;

use App\Models\LiveEvent;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

class LiveEventService
{
    /**
     * @return Collection<LiveEvent>
     */
    public function getNext(null|int $limit = null): Collection
    {
        return LiveEvent::where('start_at', '>=', now())
            ->when($limit, fn(Builder $query) => $query->limit($limit))
            ->orderBy('start_at')
            ->get();
    }

    /**
     * @return Collection<LiveEvent>
     */
    public function getPrevious(null|int $limit = null): Collection
    {
        return LiveEvent::where('start_at', '<', now())
            ->when($limit, fn(Builder $query) => $query->limit($limit))
            ->orderBy('start_at')
            ->get();
    }

    /**
     * @return Collection<LiveEvent>
     */
    public function getKeepWatching(null|int $limit = null): Collection
    {
        return LiveEvent::when($limit, fn(Builder $query) => $query->limit($limit))
            ->get()
            ->shuffle();
    }
}


