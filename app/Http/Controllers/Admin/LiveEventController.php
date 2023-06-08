<?php

namespace App\Http\Controllers\Admin;

use App\Enums\LinkableTypeEnum;
use App\Helpers\Acess\Authorize;
use App\Helpers\Http\DataQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LiveEvent\LiveEventIndexRequest;
use App\Models\LiveEvent;
use App\Http\Requests\Admin\LiveEvent\LiveEventStoreRequest;
use App\Http\Requests\Admin\LiveEvent\LiveEventUpdateRequest;
use App\Http\Resources\Admin\LiveEventResource;
use App\Models\Campaign;
use App\Models\Content;
use App\Models\User;
use App\Services\Admin\LinkableService;
use App\Services\Admin\LiveEventService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class LiveEventController extends Controller
{
     /**
     * @var LiveEventService
     */
    protected LiveEventService $liveEventService;

    /**
     * @param LiveEventService $liveEventService
     */
    public function __construct(LiveEventService $liveEventService)
    {
        $this->liveEventService = $liveEventService;
    }

    /**
     * @param LiveEventIndexRequest $request
     * @return Response
     */
    public function index(LiveEventIndexRequest $request): Response
    {
        Authorize::abortIfNot('live_event_index');

        $dataQuery = new DataQuery($request);

        $liveEvents = $this->liveEventService->index(
            $dataQuery->filters(),
            $dataQuery->rowsPerPage(),
            $dataQuery->orderBy('start_at'),
            $dataQuery->sort('asc')
        );

        return inertia('Admin/LiveEvent/Index', [
            'liveEvents' => LiveEventResource::collection($liveEvents),
            'query' => $dataQuery->query(),
            'responsible' => User::areTeachers()->select('id', 'name')->orderBy('name')->get(),
            'canLiveEventStore' => Authorize::any('live_event_store'),
            'canLiveEventEdit' => Authorize::any('live_event_update'),
            'canLiveEventDestroy' => Authorize::any('live_event_destroy'),
        ]);
    }

    /**
     * @return Response
     */
    public function create(): Response
    {
        Authorize::abortIfNot('live_event_store');

        $responsible = User::areTeachers()->select('id', 'name')->orderBy('name')->get();
        $campaigns = Campaign::select('id', 'name')->orderBy('name')->get();
        $contents = Content::select('id', 'name')->orderBy('name')->get();

        return inertia('Admin/LiveEvent/Create', [
            'linkableTypes' => LinkableTypeEnum::toArray(),
            'responsible' => $responsible,
            'campaigns' => $campaigns,
            'contents' => $contents,
            'seasonsOrChapters' => [],
        ]);
    }

    /**
     * @param LiveEventStoreRequest $liveEventStoreRequest
     * @return RedirectResponse
     */
    public function store(LiveEventStoreRequest $liveEventStoreRequest): RedirectResponse
    {
        Authorize::abortIfNot('live_event_store');

        $liveEvent = $this->liveEventService->store($liveEventStoreRequest->validated());

        return redirect()->route('admin.live-event.edit', $liveEvent);
    }

    /**
     * @param LiveEvent $liveEvent
     * @return Response
     */
    public function edit(LiveEvent $liveEvent): Response
    {
        Authorize::abortIfNot('live_event_update');

        $responsible = User::areTeachers()->select('id', 'name')->orderBy('name')->get();
        $campaigns = Campaign::select('id', 'name')->orderBy('name')->get();
        $contents = Content::select('id', 'name')->orderBy('name')->get();

        return inertia('Admin/LiveEvent/Edit', [
            'liveEvent' => new LiveEventResource($liveEvent),
            'linkableTypes' => LinkableTypeEnum::toArray(),
            'responsible' => $responsible,
            'campaigns' => $campaigns,
            'contents' => $contents,
            'seasonsOrChapters' => LinkableService::getSeasonsOrChapters($liveEvent->content, $liveEvent->getLinkableTypeParse()),
            'canLiveEventDestroy' => Authorize::any('live_event_destroy'),
        ]);
    }

     /**
     * @param LiveEvent $liveEvent
     * @return Response
     */
    public function show(LiveEvent $liveEvent): Response
    {
        $responsible = User::select('id', 'name')->orderBy('name')->get();
        $campaigns = Campaign::select('id', 'name')->orderBy('name')->get();
        $contents = Content::select('id', 'name')->orderBy('name')->get();

        return inertia('Admin/LiveEvent/Show', [
            'liveEvent' => new LiveEventResource($liveEvent),
            'linkableTypes' => LinkableTypeEnum::toArray(),
            'responsible' => $responsible,
            'campaigns' => $campaigns,
            'contents' => $contents,
            'seasonsOrChapters' => LinkableService::getSeasonsOrChapters($liveEvent->content, $liveEvent->getLinkableTypeParse()),
        ]);
    }

    /**
     * @param LiveEventUpdateRequest $liveEventUpdateRequest
     * @param LiveEvent $liveEvent
     * @return RedirectResponse
     */
    public function update(LiveEventUpdateRequest $liveEventUpdateRequest, LiveEvent $liveEvent): RedirectResponse
    {
        Authorize::abortIfNot('live_event_update');

        $this->liveEventService->update($liveEvent, $liveEventUpdateRequest->validated());

        return redirect()->route('admin.live-event.index');
    }

    /**
     * @param LiveEvent $liveEvent
     * @return RedirectResponse
     */
    public function destroy(LiveEvent $liveEvent): RedirectResponse
    {
        Authorize::abortIfNot('live_event_destroy');

        $this->liveEventService->delete($liveEvent);

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroyMultiples(Request $request): RedirectResponse
    {
        Authorize::abortIfNot('live_event_destroy');

        $request->validate(['ids' => 'required|array|in:' . LiveEvent::get()->pluck('id')->join(',')]);

        $this->liveEventService->deleteMultiple($request->get('ids', []));

        return redirect()->route('admin.live-event.index');
    }

    /**
     * @param LiveEvent $liveEvent
     * @return Response
     */
    public function follow(LiveEvent $liveEvent): Response
    {
        return inertia('Admin/LiveEvent/Follow', [
            'liveEvent' => new LiveEventResource($liveEvent),
        ]);
    }

     /**
     * @param LiveEvent $liveEvent
     * @return RedirectResponse
     */
    public function toggleOfferAvailability(LiveEvent $liveEvent): RedirectResponse
    {
        $this->liveEventService->toggleOfferAvailability($liveEvent);

        return redirect()->route('admin.live-event.follow', $liveEvent);
    }
}
