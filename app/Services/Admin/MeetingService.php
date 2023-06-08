<?php

namespace App\Services\Admin;

use App\Enums\MeetingStatusEnum;
use App\Helpers\Acess\Authorize;
use App\Models\Chapter;
use App\Models\Content;
use App\Models\Material;
use App\Models\Meeting;
use App\Models\Season;
use App\Models\Student;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class MeetingService
{
    /**
     * @var UploadImageService
     */
    protected UploadImageService $uploadImageService;

    /**
     * @param UploadImageService $uploadImageService
     */
    public function __construct(UploadImageService $uploadImageService)
    {
        $this->uploadImageService = $uploadImageService;
    }

    /**
     * @param array $filters
     * @param null|integer $rowsPerPage
     * @param null|string $orderBy
     * @param null|string $sort
     * @return Meeting[]|Collection|LengthAwarePaginator
     */
    public function index(
        array $filters = [],
        null|int $rowsPerPage = 10,
        null|string $orderBy = 'id',
        null|string $sort = 'asc'
    ): LengthAwarePaginator|Collection
    {
        /** @var Meeting|Builder */
        $queryMeeting = Meeting::query();

        $queryMeeting->select(['meetings.*']);

        if ($name = Arr::get($filters, 'name')) {
            $queryMeeting->where('name', 'like', "%{$name}%");
        }

        if ($type = Arr::get($filters, 'type')) {
            $queryMeeting->where('type', $type);
        }

        if ($startAt = Arr::get($filters, 'start_at')) {
            $queryMeeting->whereDate('start_at', Carbon::createFromFormat('d/m/Y H:i', $startAt));
        }

        if ($endAt = Arr::get($filters, 'end_at')) {
            $queryMeeting->whereDate('end_at', Carbon::createFromFormat('d/m/Y H:i', $endAt));
        }

        if ($status = Arr::get($filters, 'status')) {
            $queryMeeting->whereIn('status', is_array($status) ? $status : [$status]);
        }

        if (Authorize::any('meeting_individual_view')) {
             /** @var User */
            $authUser = auth('admin')->user();
            $queryMeeting->where('teacher_id', $authUser->id);
        } else if ($teacherId = Arr::get($filters, 'teacher_id')) {
            $queryMeeting->where('teacher_id', $teacherId);
        }

        if ($orderBy === 'teacher_name') {
            $queryMeeting->join('users', 'meetings.teacher_id', '=', 'users.id')->orderBy('users.name', $sort);
        } else if (in_array($orderBy, (new Meeting)->getFillable())) {
            $queryMeeting->orderBy("meetings.{$orderBy}", $sort);
        }

        return $queryMeeting->paginate($rowsPerPage);
    }

    /**
     * @param array $requestData
     * @return Meeting
     */
    public function store(array $requestData = []): Meeting
    {
        $meeting = Meeting::create($this->transformData($requestData));

        $this->uploadImageService->upload($meeting, 'image', Arr::get($requestData, 'image'));

        $this->updateOrCreateMaterials($meeting, Arr::get($requestData, 'materials', []));

        return $meeting;
    }

    /**
     * @param Meeting $meeting
     * @param array $requestData
     * @return Meeting
     */
    public function update(Meeting $meeting, array $requestData = []): Meeting
    {
        $meeting->update($this->transformData($requestData));

        $this->uploadImageService->upload($meeting, 'image', Arr::get($requestData, 'image'));

        $this->updateOrCreateMaterials($meeting, Arr::get($requestData, 'materials', []));

        return $meeting;
    }

    /**
     * @param array $requestData
     * @return array
     */
    private function transformData(array $requestData): array
    {
        $startAt = Arr::get($requestData, 'start_at') ? Carbon::createFromFormat('d/m/Y H:i', Arr::get($requestData, 'start_at')) : null;
        $endAt = Arr::get($requestData, 'end_at') ? Carbon::createFromFormat('d/m/Y H:i', Arr::get($requestData, 'end_at')) : null;
        $hasLinkWithContent = Arr::get($requestData, 'has_link_with_content', false);

        $transform = [
            'name' => Arr::get($requestData, 'name'),
            'type' => Arr::get($requestData, 'type'),
            'number_of_students' => Arr::get($requestData, 'number_of_students'),
            'teacher_id' => Arr::get($requestData, 'teacher_id'),
            'has_live_offer' => Arr::get($requestData, 'has_live_offer'),
            'name_offer' => Arr::get($requestData, 'name_offer'),
            'description_offer' => Arr::get($requestData, 'description_offer'),
            'embed_offer' => Arr::get($requestData, 'embed_offer'),
            'tags' => Arr::get($requestData, 'tags'),
            'start_at' => $startAt,
            'end_at' => $endAt,
            'has_link_with_content' => $hasLinkWithContent,
            'content_id' => Arr::get($requestData, 'content_id')
        ];

        if (Arr::get($requestData, 'content_id') && $hasLinkWithContent) {
            $transform['linkable_type'] = match (Arr::get($requestData, 'linkable_type')) {
                'season' => Season::class,
                'chapter' => Chapter::class,
                default => Content::class
             };

             $transform['linkable_id'] = match (Arr::get($requestData, 'linkable_type')) {
                'season' => Arr::get($requestData, 'linkable_id'),
                'chapter' => Arr::get($requestData, 'linkable_id'),
                default => Arr::get($requestData, 'content_id')
             };
         } else {
             $transform['linkable_type'] = null;
             $transform['linkable_id'] = null;
         }

        return $transform;
    }

    /**
     * @param Meeting $meeting
     * @return boolean|null
     */
    public function delete(Meeting $meeting): ?bool
    {
        $meeting->materials()->each(function(Material $material) use ($meeting){
            $this->deleteMaterial($meeting, $material);
        });

        $this->uploadImageService->delete($meeting, 'image');

        $meeting->groups()->detach();
        $meeting->students()->detach();

        return $meeting->delete();
    }


    /**
     * @param array $ids
     * @return void
     */
    public function deleteMultiple(array $ids = []): void
    {
        foreach ($ids as $id) {
            if ($meeting = Meeting::find($id)) {
                $this->delete($meeting);
            }
        }
    }

     /**
     * @param Meeting $meeting
     * @param array $materials
     * @return void
     */
    public function updateOrCreateMaterials(Meeting $meeting, array $materials = []): void
    {
        /**
         * Filtra apenas materiais do tipo UploadedFile, ou seja, materiais que vieram como arquivos temporários
         * do navegador. Após realizar o upload desses materiais, criando registro no banco para cada um deles.
         */
        collect($materials)->filter(function ($material) {
            return Arr::get($material, 'uploadedFile') instanceof UploadedFile;
        })->each(function($material) use ($meeting) {
            /** @var UploadedFile */
            $uploadedFile = Arr::get($material, 'uploadedFile');

            $meeting->materials()->create([
                'name' => $uploadedFile->getClientOriginalName(),
                'path' => Storage::url(Storage::disk('public')->put('meetings', $uploadedFile)),
                'size' => $uploadedFile->getSize()
            ]);
        });

        /**
         * Verifica os arquivos que não vieram na requisição e deleta do registro
         * no banco de dados e os arquivo
         *
         * Por exemplo: No Evento há 3 materiais com ID's 1, 2 e 3.
         * Caso venha na requisição apenas os materiais de ID 1 e 3, o material de ID numero 2
         * será deletedo do storage e o registro de banco deletedo.
         */
        $meeting->materials()
            ->whereNotIn('id', data_get($materials, '*.id'))
            ->each(fn(Material $material) => $this->deleteMaterial($meeting, $material));
    }

    /**
     * @param Meeting $meeting
     * @param Material $material
     * @return bool|null
     */
    public function deleteMaterial(Meeting $meeting, Material $material): ?bool
    {
        Storage::disk('public')->delete(Str::replaceFirst('storage', '', $material->path));

        return $meeting->materials()->find($material->id)->delete();
    }

    /**
     * @param Meeting $meeting
     * @return void
     */
    public function start(Meeting $meeting): void
    {
        $meeting->update([
            'status' => MeetingStatusEnum::iniciado(),
            'started_at' => now()
        ]);
    }

    /**
     * @param Meeting $meeting
     * @return void
     */
    public function finish(Meeting $meeting): void
    {
        $meeting->update([
            'status' => MeetingStatusEnum::finalizado(),
            'ended_at' => now()
        ]);
    }

    /**
     * @param Meeting $meeting
     * @param Student $student
     * @return void
     */
    public function detachStudent(Meeting $meeting, Student $student): void
    {
        $meeting->students()->detach($student);
    }

    /**
     * @param Meeting $meeting
     * @return void
     */
    public function toggleOfferAvailability(Meeting $meeting): void
    {
        /** @todo Precisa fazer o envio para o aluno, possivelmente fazer com websocket */
        $meeting->update(['offer_available' => !$meeting->offer_available]);
    }
}
