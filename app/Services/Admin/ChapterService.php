<?php

namespace App\Services\Admin;

use App\Models\Chapter;
use App\Models\Content;
use App\Models\Season;
use Illuminate\Support\Arr;

class ChapterService
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
     * @param array $requestData
     * @return array
     */
    public function transformData(array $requestData = []): array
    {
        return [
            'name' => Arr::get($requestData, 'name'),
            'description' => Arr::get($requestData, 'description'),
            'number' => Arr::get($requestData, 'number'),
            'duration' => Arr::get($requestData, 'duration'),
            'cast' => Arr::get($requestData, 'cast'),
            'direction' => Arr::get($requestData, 'direction'),
            'main_player' => Arr::get($requestData, 'main_player'),
            'vimeo_link' => Arr::get($requestData, 'vimeo_link'),
            'vimeo_embed' => Arr::get($requestData, 'vimeo_embed'),
            'sambatech_link' => Arr::get($requestData, 'sambatech_link'),
            'sambatech_embed' => Arr::get($requestData, 'sambatech_embed'),
            'embed' => Arr::get($requestData, 'embed'),
        ];
    }

    /**
     * @param Content $content
     * @param array $requestData
     * @return Chapter
     */
    public function storeForContent(Content $content, array $requestData = []): Chapter
    {
        $chapter = $content->chapter()->create($this->transformData($requestData));

        $this->uploadImageService->upload($chapter, 'image', Arr::get($requestData, 'image'));

        return $chapter;
    }

    /**
     * @param Content $content
     * @param Chapter $chapter
     * @param array $requestData
     * @return Chapter
     */
    public function updateForContent(Content $content, array $requestData = []): Chapter
    {
        $content->chapter->update($this->transformData($requestData));

        $this->uploadImageService->upload($content->chapter, 'image', Arr::get($requestData, 'image'));

        return $content->chapter;
    }

    /**
     * @param Content $content
     * @param Chapter $chapter
     * @return boolean|null
     */
    public function deleteForContent(Content $content): ?bool
    {
        if ($content->chapter) {
            $this->uploadImageService->delete($content->chapter, 'image');

            return $content->chapter->delete();
        }

        return false;
    }

    /**
     * @param Season $season
     * @param array $requestData
     * @return Chapter
     */
    public function storeForSeason(Season $season, array $requestData = []): Chapter
    {
        /** @var Chapter */
        $chapter = $season->chapters()->create($this->transformData($requestData));

        $this->uploadImageService->upload($chapter, 'image', Arr::get($requestData, 'image'));

        return $chapter;
    }

     /**
     * @param Season $season
     * @param Chapter $chapter
     * @param array $requestData
     * @return Chapter
     */
    public function updateForSeason(Season $season, Chapter $chapter, array $requestData = []): Chapter
    {
        /** @var Chapter|null */
        $chapter = $season->chapters()->find($chapter->id);

        if ($chapter) {
            $chapter->update($this->transformData($requestData));

            $this->uploadImageService->upload($chapter, 'image', Arr::get($requestData, 'image'));
        }

        return $chapter;
    }

    /**
     * @param Season $season
     * @param Chapter $chapter
     * @return boolean|null
     */
    public function deleteForSeason(Season $season, Chapter $chapter): ?bool
    {
        /** @var Chapter|null */
        $chapter = $season->chapters()->find($chapter->id);

        if ($chapter) {
            $this->uploadImageService->delete($chapter, 'image');

            return $chapter->delete();
        }

        return false;
    }

    /**
     * @param Season $season
     * @param array $chaptersWithNewPosition
     * @return void
     */
    public function reorderForSeason(Season $season, array $chaptersWithNewPosition = []): void
    {
        foreach ($chaptersWithNewPosition as $key => $dataPosition) {
            if ($id = Arr::get($dataPosition,'id')) {
                /** @var Chapter */
                $chapter = $season->chapters()->find($id);
                $chapter->update(['number' => $key + 1]);
            }
        }
    }
}
