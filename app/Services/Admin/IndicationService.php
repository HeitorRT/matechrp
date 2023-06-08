<?php

namespace App\Services\Admin;

use App\Models\Indication;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class IndicationService
{
   /**
     * @param array $filters
     * @param null|integer $rowsPerPage
     * @param null|string $orderBy
     * @param null|string $sort
     * @return Indication[]|Collection|LengthAwarePaginator
     */
    public function index(
        array $filters = [],
        null|int $rowsPerPage = 10,
        null|string $orderBy = 'id',
        null|string $sort = 'asc'
    ): LengthAwarePaginator|Collection
    {
        /** @var Indication|Builder */
        $query = Indication::query();

        if ($name = Arr::get($filters, 'name')) {
            $query->where('name', 'like', "%{$name}%");
        }

        if ($email = Arr::get($filters, 'email')) {
            $query->where('email', $email);
        }

        if (in_array($orderBy, (new Indication)->getFillable())) {
            $query->orderBy($orderBy, $sort);
        }

        return $query->paginate($rowsPerPage);
    }

    /**
     * @param array $requestData
     * @return Indication
     */
    public function store(array $requestData = []): Indication
    {
        $indication = Indication::create($this->transformData($requestData));

        $this->uploadImage($indication, Arr::get($requestData, 'image'));

        return $indication;
    }

   /**
     * @param Indication $indication
     * @param array $requestData
     * @return Indication
     */
    public function update(Indication $indication, array $requestData = []): Indication
    {
        $indication->update($this->transformData($requestData));

        $this->uploadImage($indication, Arr::get($requestData, 'image'));

        return $indication;
    }

    /**
     * @param array $requestData
     * @return array
     */
    private function transformData(array $requestData): array
    {
        $startAt = Arr::get($requestData, 'start_at') ? Carbon::createFromFormat('d/m/Y', Arr::get($requestData, 'start_at')) : null;
        $endAt = Arr::get($requestData, 'end_at') ? Carbon::createFromFormat('d/m/Y', Arr::get($requestData, 'end_at')) : null;

        return [
            'name' => Arr::get($requestData, 'name'),
            'company_name'=> Arr::get($requestData, 'company_name'),
            'phone'=> Arr::get($requestData, 'phone'),
            'email'=> Arr::get($requestData, 'email'),
            'link'=> Arr::get($requestData, 'link'),
            'start_at'=> $startAt,
            'end_at'=> $endAt,
        ];
    }

    /**
     * @param Indication $indication
     * @return boolean|null
     */
    public function delete(Indication $indication): ?bool
    {
        return $indication->delete();
    }

     /**
     * @param array $ids
     * @return void
     */
    public function deleteMultiple(array $ids = []): void
    {
        foreach ($ids as $id) {
            if ($indication = Indication::find($id)) {
                $this->delete($indication);
            }
        }
    }

    /**
     * @param Indication $indication
     * @param UploadedFile|null $image
     * @return bool
     */
    public function uploadImage(Indication $indication, ?UploadedFile $image): bool
    {
        if (! $image) {
            return false;
        }

        if ($indication->image) {
            Storage::disk('public')->delete($indication->image);
        }

        return $indication->update([
            'image' => Storage::url(Storage::disk('public')->put('indications', $image))
        ]);
    }
}
