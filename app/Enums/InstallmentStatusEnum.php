<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self pago()
 * @method static self aberto()
 * @method static self vencido()
 * @method static self inadimplente()
 * @method static self reembolsado()
 * @method static self cancelado()
 */
class InstallmentStatusEnum extends Enum
{
    /**
     * @return array
     */
    protected static function labels(): array
    {
        return [
            'pago' => 'Pago',
            'aberto' => 'Aberto',
            'vencido' => 'Vencido',
            'inadimplente' => 'Inadimplente',
            'reembolsado' => 'Reembolsado',
            'cancelado' => 'Cancelado'
        ];
    }
}
