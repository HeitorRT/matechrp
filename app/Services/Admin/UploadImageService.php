<?php

namespace App\Services\Admin;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class UploadImageService
{
    /**
     * @param Model $model
     * @param string $attributeName
     * @return void
     */
    public function delete(Model $model, string $attributeName): void
    {
        if ($attribute = $model->getAttribute($attributeName)) {
            Storage::disk('public')->delete(Str::replaceFirst('storage', '', $attribute));

            $model->update([$attributeName => null]);
        }
    }

    /**
     * @param Model $model
     * @param string $attributeName
     * @param UploadedFile $image
     * @return void
     */
    public function update(Model $model, string $attributeName, UploadedFile $image): void
    {
        $this->delete($model, $attributeName);

        $model->update([
            $attributeName => Storage::url(Storage::disk('public')->put($model->getTable(), $image))
        ]);
    }

    /**
     * @param Model $model
     * @param string $attributeName
     * @param null|string|UploadedFile $image
     * @return void
     */
    public function upload(Model $model, string $attributeName, null|string|UploadedFile $image): void
    {
        if (! $image) {
            $this->delete($model, $attributeName);
        } else if ($image instanceof UploadedFile) {
            $this->update($model, $attributeName, $image);
        }
    }
}
