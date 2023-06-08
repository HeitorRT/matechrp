<?php

namespace App\Services\Admin;

use App\Models\SystemSetting;
use Illuminate\Support\Arr;

class SystemSettingService
{
   /**
     * @param array $requestData
     * @return void
     */
    public function updateOrCreateKeys(array $requestData = []): void
    {
        collect($this->transformData($requestData))->each(fn($value, $key) => SystemSetting::updateOrCreate(['key' => $key], ['key' => $key, 'value' => $value]));
    }

    /**
     * @param array $requestData
     * @return array
     */
    private function transformData(array $requestData): array
    {
        return [
            'script' => Arr::get($requestData, 'script'),
        ];
    }
}
