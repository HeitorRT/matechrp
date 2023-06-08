<?php

namespace App\Services\Admin;

use App\Models\Content;
use App\Models\ContentTag;
use App\Models\LiveEvent;
use App\Models\Meeting;
use App\Models\Season;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;

class ContentService
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
     * @return Content[]|Collection|LengthAwarePaginator
     */
    public function index(
        array $filters = [],
        null|int $rowsPerPage = 10,
        null|string $orderBy = 'id',
        null|string $sort = 'asc'
    ): LengthAwarePaginator|Collection
    {
        /** @var Content|Builder */
        $query = Content::query()->select(['contents.*']);

        if ($name = Arr::get($filters, 'name')) {
            $query->where('contents.name', 'like', "%{$name}%");
        }

        if ($launchStartAt = Arr::get($filters, 'launch_start_at')) {
            $query->whereDate('launch_start_at', Carbon::createFromFormat('d/m/Y H:i', $launchStartAt));
        }

        if ($launchEndAt = Arr::get($filters, 'launch_end_at')) {
            $query->whereDate('launch_end_at', Carbon::createFromFormat('d/m/Y H:i', $launchEndAt));
        }

        if (Arr::has($filters, 'active')) {
            $query->where('active', (bool)  Arr::get($filters, 'active'));
        }

        if ($orderBy === 'category_name') {
            $query->join('categories', 'contents.category_id', '=', 'categories.id')->orderBy('categories.name', $sort);
        } else if ($orderBy === 'sections_name') {
            $query->join('content_section', 'contents.id', '=', 'content_section.content_id')
                ->join('sections', 'sections.id', '=', 'content_section.section_id')
                ->orderBy('sections.name', $sort);
        } else if (in_array($orderBy, (new Content)->getFillable())) {
            $query->orderBy("contents.{$orderBy}", $sort);
        }

        return $rowsPerPage ? $query->paginate($rowsPerPage) : $query->get();
    }

    /**
     * @param array $requestData
     * @return Content
     */
    public function store(array $requestData = []): Content
    {
        $content = Content::create($this->transformData($requestData));

        $content->sections()->sync(Arr::get($requestData, 'sections'));

        $content->genres()->sync(Arr::get($requestData, 'genres'));

        $content->contentsOfTheSameCollection()->sync(Arr::get($requestData, 'contents_of_the_same_collection'));

        $content->similarContents()->sync(Arr::get($requestData, 'similar_contents'));

        $this->uploadImageService->upload($content, 'image', Arr::get($requestData, 'image'));
        $this->uploadImageService->upload($content, 'secondary_image', Arr::get($requestData, 'secondary_image'));
        $this->uploadImageService->upload($content, 'description_image', Arr::get($requestData, 'description_image'));
        $this->uploadImageService->upload($content, 'screensaver_image', Arr::get($requestData, 'screensaver_image'));

        return $content;
    }

   /**
     * @param Content $content
     * @param array $requestData
     * @return Content
     */
    public function update(Content $content, array $requestData = []): Content
    {
        if ($content->number_of_seasons < $content->seasons->count()) {
            throw new \Exception("Limite de temporadas", 1);
        }

        $content->update($this->transformData($requestData));

        $content->sections()->sync(Arr::get($requestData, 'sections'));

        $content->genres()->sync(Arr::get($requestData, 'genres'));

        $content->contentsOfTheSameCollection()->sync(Arr::get($requestData, 'contents_of_the_same_collection'));

        $content->similarContents()->sync(Arr::get($requestData, 'similar_contents'));

        $this->uploadImageService->upload($content, 'image', Arr::get($requestData, 'image'));
        $this->uploadImageService->upload($content, 'secondary_image', Arr::get($requestData, 'secondary_image'));
        $this->uploadImageService->upload($content, 'description_image', Arr::get($requestData, 'description_image'));
        $this->uploadImageService->upload($content, 'screensaver_image', Arr::get($requestData, 'screensaver_image'));

        return $content;
    }

    /**
     * @param array $requestData
     * @return array
     */
    private function transformData(array $requestData): array
    {
        $launchStartAt = Arr::get($requestData, 'launch_start_at') ? Carbon::createFromFormat('d/m/Y H:i', Arr::get($requestData, 'launch_start_at')) : null;
        $launchEndAt = Arr::get($requestData, 'launch_end_at') ? Carbon::createFromFormat('d/m/Y H:i', Arr::get($requestData, 'launch_end_at')) : null;
        $endAt = Arr::get($requestData, 'end_at') ? Carbon::createFromFormat('d/m/Y H:i', Arr::get($requestData, 'end_at')) : null;

        return [
            'launch_start_at' => $launchStartAt,
            'launch_end_at' => $launchEndAt,
            'end_at' => $endAt,
            'name' => Arr::get($requestData, 'name'),
            'tags' => Arr::get($requestData, 'tags'),
            'author' => Arr::get($requestData, 'author'),
            'responsible_id' => Arr::get($requestData, 'responsible_id'),
            'production_type' => Arr::get($requestData, 'production_type'),
            'has_seasons' => Arr::get($requestData, 'has_seasons'),
            'number_of_seasons' => Arr::get($requestData, 'number_of_seasons'),
            'highlight' => Arr::get($requestData, 'highlight'),
            'top_position' => Arr::get($requestData, 'top_position'),
            'category_id' => Arr::get($requestData, 'category_id'),
            'description' => Arr::get($requestData, 'description'),
            'active' => Arr::get($requestData, 'active'),
        ];
    }

    /**
     * @param Content $content
     * @return boolean|null
     */
    public function delete(Content $content): ?bool
    {
        ContentTag::where('content_tag_id', $content->id)->delete();
        ContentTag::where('content_id', $content->id)->delete();

        $content->sections()->detach();
        $content->genres()->detach();
        $content->chapter()->delete();
        $content->extras()->delete();

        $content->liveEvents()->each(fn(LiveEvent $liveEvent) => $liveEvent->content()->dissociate($liveEvent)->save());
        $content->meetings()->each(fn(Meeting $meeting) => $meeting->content()->dissociate($meeting)->save());

        /** @var SeasonService $seasonService */
        $seasonService= app(SeasonService::class);

        $content->seasons->each(function(Season $season) use ($content, $seasonService) {
            $seasonService->delete($content, $season);
        });

        $this->uploadImageService->delete($content, 'image');
        $this->uploadImageService->delete($content, 'secondary_image');
        $this->uploadImageService->delete($content, 'description_image');
        $this->uploadImageService->delete($content, 'screensaver_image');

        return $content->delete();
    }

    /**
     * @param array $ids
     * @return void
     */
    public function deleteMultiple(array $ids = []): void
    {
        foreach ($ids as $id) {
            if ($content = Content::find($id)) {
                $this->delete($content);
            }
        }
    }

    /**
     * @param int $limit
     * @return Collection|Content[]
     */
    public function launchesOfThisMonth(int $limit = 5): Collection
    {
        /** @var User **/
        $user = auth('admin')->user();

        return Content::whereMonth('launch_start_at', now())->orderBy('launch_start_at')->take($limit)
            ->when($user->is_partner, function ($query) use ($user) {
                $query->where('responsible_id', $user->id);
            })
            ->get();
    }

    /**
     * @param int $limit
     * @return Collection|Content[]
     */
    public function mostViewed(int $limit = 5): Collection
    {
        /** @var User **/
        $user = auth('admin')->user();

        return Content::orderBy('access_count', 'desc')->take($limit)
            ->when($user->is_partner, function ($query) use ($user) {
                $query->where('responsible_id', $user->id);
            })
            ->get();
    }

    /**
     * @param int $limit
     * @return Collection|Content[]
     */
    public function expiresIn60Days(int $limit = 5): Collection
    {
        /** @var User **/
        $user = auth('admin')->user();

        return Content::orderBy('end_at')->take($limit)
            ->when($user->is_partner, function ($query) use ($user) {
                $query->where('responsible_id', $user->id);
            })
            ->get();
    }
}
