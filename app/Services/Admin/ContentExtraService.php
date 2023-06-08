<?php

namespace App\Services\Admin;

use App\Enums\ExtraTypeEnum;
use App\Models\Content;
use App\Models\Extra;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;

class ContentExtraService
{
    /**
     * @param Content $content
     * @return Extra[]|Collection|array
     */
    public function index(Content $content): Collection
    {
        return $content->extras;
    }

    /**
     * @param array $requestData
     * @return array
     */
    private function transformData(array $requestData): array
    {
        $type = Arr::get($requestData, 'type');

        return [
            'name' => Arr::get($requestData, 'name'),
            'type' => $type,
            'player' => $type !== ExtraTypeEnum::arquivo()->value ? Arr::get($requestData, 'player') : null,
            'embed' => $type !== ExtraTypeEnum::arquivo()->value ? Arr::get($requestData, 'embed') : null,
        ];
    }

    /**
     * @param Content $content
     * @param array $requestData
     * @return Extra
     */
    public function store(Content $content, array $requestData = []): Extra
    {
        $extra = $content->extras()->create($this->transformData($requestData));

        $this->uploadFile($extra, Arr::get($requestData, 'file'));

        return $extra;
    }

    /**
     * @param Content $content
     * @param Extra $extra
     * @param array $requestData
     * @return Extra
     */
    public function update(Content $content, Extra $extra, array $requestData = []): Extra
    {
        $content->extras()->find($extra->id)->update($this->transformData($requestData));

        if (Arr::get($requestData, 'type') !== ExtraTypeEnum::arquivo()->value) {
            $this->deleteFile($extra);
        } else {
            $this->uploadFile($extra, Arr::get($requestData, 'file'));
        }

        return $extra;
    }

    /**
     * @param Content $content
     * @param Extra $extra
     * @return bool|null
     */
    public function delete(Content $content, Extra $extra): bool|null
    {
        /** @var Extra|null */
        $extra = $content->extras()->find($extra->id);

        if ($extra) {
            $this->deleteFile($extra);

            return $extra->delete();
        }

        return false;
    }

    /**
     * @param Extra $extra
     * @return void
     */
    public function deleteFile(Extra $extra): void
    {
        if ($extra->file) {
            Storage::disk('public')->delete(Str::replaceFirst('storage', '', $extra->file));

            $extra->update(['file' => null]);
        }
    }

    /**
     * @param Extra $extra
     * @param UploadedFile $file
     * @return void
     */
    public function updateFile(Extra $extra, UploadedFile $file): void
    {
        $this->deleteFile($extra);

        $extra->update([
            'file' => Storage::url(Storage::disk('public')->put('extras', $file))
        ]);
    }

    /**
     * @param Extra $extra
     * @param null|string|UploadedFile $file
     * @return void
     */
    public function uploadFile(Extra $extra, null|string|UploadedFile $file): void
    {
        if (! $file) {
            $this->deleteFile($extra);
        } else if ($file instanceof UploadedFile) {
            $this->updateFile($extra, $file);
        }
    }
}
