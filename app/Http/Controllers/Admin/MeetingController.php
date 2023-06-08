<?php

namespace App\Http\Controllers\Admin;

use App\Enums\LinkableTypeEnum;
use App\Enums\MeetingStatusEnum;
use App\Enums\MeetingTypeEnum;
use App\Helpers\Acess\Authorize;
use App\Helpers\Http\DataQuery;
use App\Http\Controllers\Controller;
use App\Http\Middleware\Admin\MeetingIndividualViewMiddleware;
use App\Http\Requests\Admin\Meeting\MeetingIndexRequest;
use App\Models\Meeting;
use App\Http\Requests\Admin\Meeting\MeetingStoreRequest;
use App\Http\Requests\Admin\Meeting\MeetingUpdateRequest;
use App\Http\Resources\Admin\MeetingResource;
use App\Models\Content;
use App\Models\Student;
use App\Models\User;
use App\Services\Admin\LinkableService;
use App\Services\Admin\MeetingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class MeetingController extends Controller
{
     /**
     * @var MeetingService
     */
    protected MeetingService $meetingService;

    /**
     * @param MeetingService $meetingService
     */
    public function __construct(MeetingService $meetingService)
    {
        /**
         * Middleware criado para verificação de permissionamento de visualização individual.
         * Caso o grupo do usuário logado tenha a permissão flegada, usuário poderá realizar funções como editar ou atualizar (todas as permissões se encontram no metodo only())
         * apenas se professor (campo teacher_id na model Meeting) for igual a do usuário logado.
         */
        $this->middleware(MeetingIndividualViewMiddleware::class)->only(['edit', 'show', 'update', 'destroy', 'start', 'finish', 'detachStudent', 'follow']);

        $this->meetingService = $meetingService;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function index(MeetingIndexRequest $request): Response
    {
        Authorize::abortIfNot('meeting_index');

        $dataQuery = new DataQuery($request);

        $meetings = $this->meetingService->index(
            $dataQuery->filters([
                'status' => [
                    MeetingStatusEnum::aberto(),
                    MeetingStatusEnum::iniciado()
                ]
            ]),
            $dataQuery->rowsPerPage(),
            $dataQuery->orderBy('start_at'),
            $dataQuery->sort('asc')
        );

        return inertia('Admin/Meeting/Index', [
            'meetings' => MeetingResource::collection($meetings),
            'teachers' => User::select('id', 'name')->orderBy('name')->get(),
            'types' => MeetingTypeEnum::toArray(),
            'status' => MeetingStatusEnum::toArray(),
            'query' => $dataQuery->query(),

            'canMeetingStore' => Authorize::any('meeting_store'),
            'canMeetingEdit' => Authorize::any('meeting_update'),
            'canMeetingDestroy' => Authorize::any('meeting_destroy'),
            'canMeetingDetachStudent' => Authorize::any('meeting_detach_student'),
            'canMeetingIndividualView' => Authorize::any('meeting_individual_view'),
        ]);
    }

    /**
     * @return Response
     */
    public function create(): Response
    {
        Authorize::abortIfNot('meeting_store');

        $teachers = User::areTeachers()->select('id', 'name')->orderBy('name')->get();
        $contents = Content::select('id', 'name')->orderBy('name')->get();

        return inertia('Admin/Meeting/Create', [
            'types' => MeetingTypeEnum::toArray(),
            'linkableTypes' => LinkableTypeEnum::toArray(),
            'teachers' => $teachers,
            'contents' => $contents,
            'seasonsOrChapters' => [],
        ]);
    }

    /**
     * @param MeetingStoreRequest $meetingStoreRequest
     * @return RedirectResponse
     */
    public function store(MeetingStoreRequest $meetingStoreRequest): RedirectResponse
    {
        Authorize::abortIfNot('meeting_store');

        $meeting = $this->meetingService->store($meetingStoreRequest->validated());

        return redirect()->route('admin.meeting.edit', $meeting);
    }

    /**
     * @param Meeting $meeting
     * @return Response
     */
    public function edit(Meeting $meeting): Response
    {
        Authorize::abortIfNot('meeting_update');

        $teachers = User::areTeachers()->select('id', 'name')->orderBy('name')->get();
        $contents = Content::select('id', 'name')->orderBy('name')->get();

        return inertia('Admin/Meeting/Edit', [
            'meeting' => new MeetingResource($meeting),
            'types' => MeetingTypeEnum::toArray(),
            'linkableTypes' => LinkableTypeEnum::toArray(),
            'teachers' => $teachers,
            'contents' => $contents,
            'seasonsOrChapters' => LinkableService::getSeasonsOrChapters($meeting->content, $meeting->getLinkableTypeParse()),

            'canMeetingDestroy' => Authorize::any('meeting_destroy'),
        ]);
    }

    /**
     * @param Meeting $meeting
     * @return Response
     */
    public function show(Meeting $meeting): Response
    {
        $teachers = User::areTeachers()->select('id', 'name')->orderBy('name')->get();
        $contents = Content::select('id', 'name')->orderBy('name')->get();

        return inertia('Admin/Meeting/Show', [
            'meeting' => new MeetingResource($meeting),
            'types' => MeetingTypeEnum::toArray(),
            'linkableTypes' => LinkableTypeEnum::toArray(),
            'teachers' => $teachers,
            'contents' => $contents,
            'seasonsOrChapters' => LinkableService::getSeasonsOrChapters($meeting->content, $meeting->getLinkableTypeParse()),
        ]);
    }

    /**
     * @param MeetingUpdateRequest $meetingUpdateRequest
     * @param Meeting $meeting
     * @return RedirectResponse
     */
    public function update(MeetingUpdateRequest $meetingUpdateRequest, Meeting $meeting): RedirectResponse
    {
        Authorize::abortIfNot('meeting_update');

        $meeting = $this->meetingService->update($meeting, $meetingUpdateRequest->validated());

        return redirect()->route('admin.meeting.index');
    }

    /**
     * @param Meeting $meeting
     * @return RedirectResponse
     */
    public function destroy(Meeting $meeting): RedirectResponse
    {
        Authorize::abortIfNot('meeting_destroy');

        $this->meetingService->delete($meeting);

        return redirect()->route('admin.meeting.index');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroyMultiples(Request $request): RedirectResponse
    {
        Authorize::abortIfNot('meeting_destroy');

        $request->validate(['ids' => 'required|array|in:' . Meeting::get()->pluck('id')->join(',')]);

        $this->meetingService->deleteMultiple($request->get('ids', []));

        return redirect()->route('admin.meeting.index');
    }

    /**
     * @param Meeting $meeting
     * @return RedirectResponse
     */
    public function start(Meeting $meeting): RedirectResponse
    {
        Authorize::abortIfNot('meeting_start_finish');

        $this->meetingService->start($meeting);

        return redirect()->route('admin.meeting.follow', $meeting);
    }

    /**
     * @param Meeting $meeting
     * @return RedirectResponse
     */
    public function finish(Meeting $meeting): RedirectResponse
    {
        Authorize::abortIfNot('meeting_start_finish');

        $this->meetingService->finish($meeting);

        return redirect()->route('admin.meeting.follow', $meeting);
    }

    /**
     * @param Meeting $meeting
     * @return void
     */
    public function detachStudent(Meeting $meeting, Student $student): void
    {
        Authorize::abortIfNot('meeting_detach_student');

        $this->meetingService->detachStudent($meeting, $student);
    }

    /**
     * @param Meeting $meeting
     * @return Response
     */
    public function follow(Meeting $meeting): Response
    {
        return inertia('Admin/Meeting/Follow', [
            'meeting' => new MeetingResource($meeting),
            'canMeetingStartFinish' => Authorize::any('meeting_start_finish'),
            'canMeetingDetachStudent' => Authorize::any('meeting_detach_student'),
        ]);
    }

     /**
     * @param Meeting $meeting
     * @return RedirectResponse
     */
    public function toggleOfferAvailability(Meeting $meeting): RedirectResponse
    {
        $this->meetingService->toggleOfferAvailability($meeting);

        return redirect()->route('admin.meeting.follow', $meeting);
    }
}
