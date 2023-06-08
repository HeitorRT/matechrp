<?php

namespace App\DTO;

use App\Models\SystemSetting;

class SystemSettingDTO
{
    /**
     * @var string|null $script
     */
    public null|string $script = null;

    public function __construct()
    {
        $this->handleAttributes();
    }

    /**
     * @return void
     */
    private function handleAttributes(): void
    {
        foreach (SystemSetting::get() as $setting) {
            $this->setAttribute($setting->key, $setting->value);
        }
    }

    /**
     * @param string $attribute
     * @param mixed $value
     * @return void
     */
    private function setAttribute(string $attribute, mixed $value): void
    {
        if ($this->attributeExists($attribute)) {
            $this->{$attribute} = $value;
        }
    }

    /**
     * @param string $attribute
     * @return mixed
     */
    public function getAttribute(string $attribute): mixed
    {
        if ($this->attributeExists($attribute)) {
            return $this->{$attribute};
        }

        return false;
    }

    /**
     * @param string $attribute
     * @return bool
     */
    public function attributeExists(string $attribute): bool
    {
        return property_exists($this, $attribute);
    }


    /**
     * @return array
     */
    public function getAllAttributes(): array
    {
        return get_object_vars($this);
    }
}
