<?php

namespace App\Services\Admin;

use App\Models\Chapter;
use App\Models\Content;
use App\Models\Season;
use Illuminate\Support\Arr;


class SeasonService
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
     * @param Content $content
     * @param array $requestData
     * @return Season
     */
    public function store(Content $content, array $requestData = []): Season
    {
        $season = $content->seasons()->create($this->transform($requestData));

        $this->uploadImageService->upload($season, 'image', Arr::get($requestData, 'image'));

        return $season;
    }

     /**
     * @param Content $content
     * @param Season $season
     * @param array $requestData
     * @return Extra
     */
    public function update(Content $content, Season $season, array $requestData = []): Season
    {
        $content->seasons()->find($season->id)->update($this->transform($requestData));

        $this->uploadImageService->upload($season, 'image', Arr::get($requestData, 'image'));

        return $season;
    }

    /**
     * @param Content $content
     * @param Season $season
     * @return bool|null
     */
    public function delete(Content $content, Season $season): bool|null
    {
        $season = $content->seasons()->find($season->id);

        if ($season) {
            /** @var ChapterService $chapterService */
            $chapterService= app(ChapterService::class);

            $season->chapters->map(function(Chapter $chapter) use ($season, $chapterService) {
                $chapterService->deleteForSeason($season, $chapter);
            });

            $this->uploadImageService->delete($season, 'image');

            return $season->delete();
        }

        return false;
    }

    /**
     * @param array $requestData
     * @return array
     */
    private function transform(array $requestData): array
    {
        return [
            'name' => Arr::get($requestData, 'name'),
            'number' => Arr::get($requestData, 'number'),
            'number_of_chapters' => Arr::get($requestData, 'number_of_chapters'),
        ];
    }
}
