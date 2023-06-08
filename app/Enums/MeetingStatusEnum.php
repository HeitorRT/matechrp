<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self aberto()
 * @method static self iniciado()
 * @method static self finalizado()
 */
class MeetingStatusEnum extends Enum
{
    protected static function labels(): array
    {
        return [
            'aberto' => 'Aberto',
            'iniciado' => 'Iniciado',
            'finalizado' => 'Finalizado',
        ];
    }
}
