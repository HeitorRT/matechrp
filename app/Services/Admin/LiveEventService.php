<?php

namespace App\Services\Admin;

use App\Models\Chapter;
use App\Models\Content;
use App\Models\LiveEvent;
use App\Models\Material;
use App\Models\Season;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class LiveEventService
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
     * @return LiveEvent[]|Collection|LengthAwarePaginator
     */
    public function index(
        array $filters = [],
        null|int $rowsPerPage = 10,
        null|string $orderBy = 'id',
        null|string $sort = 'asc'
    ): LengthAwarePaginator|Collection
    {
        /** @var LiveEvent|Builder */
        $query  = LiveEvent::query()->select(['live_events.*']);

        if ($name = Arr::get($filters, 'name')) {
            $query->where('name', 'like', "%{$name}%");
        }

        if ($startAt = Arr::get($filters, 'start_at')) {
            $query->whereDate('start_at', Carbon::createFromFormat('d/m/Y H:i', $startAt));
        }

        if ($endAt = Arr::get($filters, 'end_at')) {
            $query->whereDate('end_at', Carbon::createFromFormat('d/m/Y H:i', $endAt));
        }

        if ($responsibleId = Arr::get($filters, 'responsible_id')) {
            $query->where('responsible_id', $responsibleId);
        }

        $active = Arr::get($filters, 'active');
        if (isset($active) && !$active) {
            $query->where('end_at', '<', Carbon::now()->format('Y-m-d H:i'));
        } else {
            $query->where('end_at', '>=', Carbon::now()->format('Y-m-d H:i'));
        }

        if ($orderBy === 'responsible_name') {
            $query->join('users', 'live_events.responsible_id', '=', 'users.id')->orderBy('users.name', $sort);
        } else if (in_array($orderBy, (new LiveEvent)->getFillable())) {
            $query->orderBy("live_events.{$orderBy}", $sort);
        }

        return $rowsPerPage ? $query->paginate($rowsPerPage) : $query->get();
    }

    /**
     * @param array $requestData
     * @return LiveEvent
     */
    public function store(array $requestData = []): LiveEvent
    {
        $liveEvent = LiveEvent::create($this->transformData($requestData));

        $liveEvent->campaigns()->sync(Arr::get($requestData, 'campaign_ids'));

        $this->uploadImageService->upload($liveEvent, 'image', Arr::get($requestData, 'image'));

        $this->updateOrCreateMaterials($liveEvent, Arr::get($requestData, 'materials', []));

        return $liveEvent;
    }

    /**
     * @param LiveEvent $liveEvent
     * @param array $requestData
     * @return LiveEvent
     */
    public function update(LiveEvent $liveEvent, array $requestData = []): LiveEvent
    {
        $liveEvent->update($this->transformData($requestData));

        $liveEvent->campaigns()->sync(Arr::get($requestData, 'campaign_ids'));

        $this->uploadImageService->upload($liveEvent, 'image', Arr::get($requestData, 'image'));

        $this->updateOrCreateMaterials($liveEvent, Arr::get($requestData, 'materials', []));

        return $liveEvent;
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
            'description' => Arr::get($requestData, 'description'),
            'event_type' => Arr::get($requestData, 'event_type', 'live'),
            'embed' => Arr::get($requestData, 'embed'),
            'has_live_offer' => Arr::get($requestData, 'has_live_offer'),
            'name_offer' => Arr::get($requestData, 'name_offer'),
            'description_offer' => Arr::get($requestData, 'description_offer'),
            'embed_offer' => Arr::get($requestData, 'embed_offer'),
            'responsible_id' => Arr::get($requestData, 'responsible_id'),
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
     * @param LiveEvent $liveEvent
     * @return boolean|null
     */
    public function delete(LiveEvent $liveEvent): ?bool
    {
        $liveEvent->materials()->each(fn(Material $material) => $this->deleteMaterial($liveEvent, $material));

        $this->uploadImageService->delete($liveEvent, 'image');

        $liveEvent->campaigns()->detach();

        return $liveEvent->delete();
    }

    /**
     * @param array $ids
     * @return void
     */
    public function deleteMultiple(array $ids = []): void
    {
        foreach ($ids as $id) {
            if ($liveEvent = LiveEvent::find($id)) {
                $this->delete($liveEvent);
            }
        }
    }

     /**
     * @param LiveEvent $liveEvent
     * @param array $materials
     * @return void
     */
    public function updateOrCreateMaterials(LiveEvent $liveEvent, array $materials = []): void
    {
        /**
         * Filtra apenas materiais do tipo UploadedFile, ou seja, materiais que vieram como arquivos temporários
         * do navegador. Após realizar o upload desses materiais, criando registro no banco para cada um deles.
         */
        collect($materials)->filter(function ($material) {
            return Arr::get($material, 'uploadedFile') instanceof UploadedFile;
        })->each(function($material) use ($liveEvent) {
            /** @var UploadedFile */
            $uploadedFile = Arr::get($material, 'uploadedFile');

            $liveEvent->materials()->create([
                'name' => $uploadedFile->getClientOriginalName(),
                'path' => Storage::url(Storage::disk('public')->put('liveEvents', $uploadedFile)),
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
        $liveEvent->materials()
            ->whereNotIn('id', data_get($materials, '*.id'))
            ->each(fn(Material $material) => $this->deleteMaterial($liveEvent, $material));
    }

     /**
     * @param LiveEvent $liveEvent
     * @param Material $material
     * @return bool|null
     */
    public function deleteMaterial(LiveEvent $liveEvent, Material $material): bool|null
    {
        Storage::disk('public')->delete(Str::replaceFirst('storage', '', $material->path));

        return $liveEvent->materials()->find($material->id)->delete();
    }

     /**
     * @param LiveEvent $liveEvent
     * @return void
     */
    public function toggleOfferAvailability(LiveEvent $liveEvent): void
    {
        /** @todo Precisa fazer o envio para o aluno, possivelmente fazer com websocket */
        $liveEvent->update(['offer_available' => !$liveEvent->offer_available]);
    }
}
