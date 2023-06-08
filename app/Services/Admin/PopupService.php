<?php

namespace App\Services\Admin;

use App\Models\Popup;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Carbon\carbon;

class PopupService
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
     * @return Popup[]|Collection|LengthAwarePaginator
     */
    public function index(
        array $filters = [],
        null|int $rowsPerPage = 10,
        null|string $orderBy = 'id',
        null|string $sort = 'asc'
    ): LengthAwarePaginator|Collection
    {
        /** @var Popup|Builder */
        $query = Popup::query()->select(['popups.*']);

        if ($description = Arr::get($filters, 'description')) {
            $query->where('description', 'like', "%{$description}%");
        }

        if ($StartAt = Arr::get($filters, 'start_at')) {
            $query->whereDate('start_at', Carbon::createFromFormat('d/m/Y H:i', $StartAt));
        }

        if ($EndAt = Arr::get($filters, 'end_at')) {
            $query->whereDate('end_at', Carbon::createFromFormat('d/m/Y H:i', $EndAt));
        }

        $active = Arr::get($filters, 'active');

        if (isset($active) && $active=='ativo') {
            $query->where('start_at', '<=', Carbon::now()->format('Y-m-d H:i'));
            $query->where('end_at', '>=', Carbon::now()->format('Y-m-d H:i'));

        } elseif (isset($active) && $active=='inativo') {
            $query->where('end_at', '<', Carbon::now()->format('Y-m-d H:i'));

        } elseif (isset($active) && $active=='a_exibir') {
            $query->where('start_at', '>', Carbon::now()->format('Y-m-d H:i'));

        } else {
            $query->where('end_at', '>', Carbon::now()->format('Y-m-d H:i'));
        }

        if ($contentId = Arr::get($filters, 'content_id')) {
            $query->join('content_popup', 'content_popup.popup_id', '=', 'popups.id')
                ->where('content_popup.content_id', '=', $contentId);
        }

        if (in_array($orderBy, (new Popup)->getFillable())) {
            $query->orderBy("popups.{$orderBy}", $sort);
        }

        return $rowsPerPage ? $query->paginate($rowsPerPage) : $query->get();
    }

    /**
     * @param array $requestData
     * @return Popup
     */
    public function store(array $requestData = []): Popup
    {
        $popup = Popup::create($this->transformData($requestData));

        $popup->contents()->sync(Arr::get($requestData, 'content_ids'));

        $this->uploadImageService->upload($popup, 'image', Arr::get($requestData, 'image'));

        return $popup;
    }

    /**
     * @param Popup $popup
     * @param array $requestData
     * @return Popup
     */
    public function update(Popup $popup, array $requestData = []): Popup
    {
        $popup->update($this->transformData($requestData));

        $popup->contents()->sync(Arr::get($requestData, 'content_ids'));

        $this->uploadImageService->upload($popup, 'image', Arr::get($requestData, 'image'));

        return $popup;
    }

    /**
     * @param Popup $popup
     * @return boolean|null
     */
    public function delete(Popup $popup): ?bool
    {
        $popup->contents()->detach();

        $this->uploadImageService->delete($popup, 'image');

        return $popup->delete();
    }

    /**
     * @param array $ids
     * @return void
     */
    public function deleteMultiple(array $ids = []): void
    {
        foreach ($ids as $id) {
            if ($popup = Popup::find($id)) {
                $this->delete($popup);
            }
        }
    }

    /**
     * @param array $requestData
     * @return array
     */
    private function transformData(array $requestData): array
    {
        $startAt = Arr::get($requestData, 'start_at') ? Carbon::createFromFormat('d/m/Y H:i', Arr::get($requestData, 'start_at')) : null;
        $endAt = Arr::get($requestData, 'end_at') ? Carbon::createFromFormat('d/m/Y H:i', Arr::get($requestData, 'end_at')) : null;

        return [
            'description' => Arr::get($requestData, 'description'),
            'start_at' => $startAt,
            'end_at' => $endAt,
        ];
    }
}
