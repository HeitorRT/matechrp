<?php

namespace App\Services\Admin;

use App\Models\Content;
use App\Models\Section;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

class SectionService
{
    /**
     * @param array $filters
     * @param null|integer $rowsPerPage
     * @param null|string $orderBy
     * @param null|string $sort
     * @return Section[]|Collection|LengthAwarePaginator
     */
    public function index(
        array $filters = [],
        null|int $rowsPerPage = 10,
        null|string $orderBy = 'id',
        null|string $sort = 'asc'
    ): LengthAwarePaginator|Collection
    {
        return Section::when(Arr::get($filters, 'name'), function (Builder $builder, $name) {
            return $builder->where('name', 'like', "%{$name}%");
        })->when($orderBy, function(Builder $query) use ($orderBy, $sort){
            return $query->orderBy($orderBy, $sort);
        })->paginate($rowsPerPage);
    }

    /**
     * @param array $requestData
     * @return Section
     */
    public function store(array $requestData = []): Section
    {
        $transformData = array_merge($this->transformData($requestData), [
            'sort_number' => Section::max('sort_number') + 1
        ]);

        $section = Section::create($transformData);

        return $section;
    }

    /**
     * @param Section $section
     * @param array $requestData
     * @return Section
     */
    public function update(Section $section, array $requestData = []): Section
    {
        $section->update($this->transformData($requestData));

        $this->reorderContents($section, Arr::get($requestData, 'contents'));

        return $section;
    }

    /**
     * @param Section $section
     * @return boolean|null
     */
    public function delete(Section $section): ?bool
    {
        if (! $section->can_delete) {
            return false;
        }

        $section->contents()->detach();

        return $section->delete();
    }

    /**
     * @param array $ids
     * @return void
     */
    public function deleteMultiple(array $ids = []): void
    {
        foreach ($ids as $id) {
            if ($section = Section::find($id)) {
                $this->delete($section);
            }
        }
    }

    /**
     * @param array $requestData
     * @return array
     */
    public function transformData(array $requestData = []): array
    {
        return [
            'name' => Arr::get($requestData, 'name'),
        ];
    }

    /**
     * @param array $newPositions
     * @return void
     */
    public function reorder(array $newPositions = []): void
    {
        foreach ($newPositions as $key => $dataPosition) {
            if ($id = Arr::get($dataPosition, 'id')) {
                $section = Section::find($id);

                if ($section) {
                    $section->update(['sort_number' => $key + 1]);
                }
            }
        }
    }

    /**
     * @param Section $section
     * @param array $newPositions
     * @return void
     */
    public function reorderContents(Section $section, array $newPositions = []): void
    {
        foreach ($newPositions as $key => $dataPosition) {
            if ($id = Arr::get($dataPosition, 'id')) {
                $section->contents()->updateExistingPivot($id, ['sort_number' => $key + 1]);
            }
        }
    }
}
