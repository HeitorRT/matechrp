<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self arquivo()
 * @method static self bastidor()
 * @method static self debate()
 * @method static self trailer()
 */
class ExtraTypeEnum extends Enum
{
    protected static function labels(): array
    {
        return [
            'arquivo' => 'Arquivo',
            'bastidor' => 'Bastidores',
            'debate' => 'Debates',
            'trailer' => 'Trailers',
        ];
    }
}
