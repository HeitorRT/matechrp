<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self cartao()
 * @method static self boleto()
 * @method static self pix()
 * @method static self deposito()
 */
class InstallmentPaymentMethodEnum extends Enum
{
    /**
     * @return array
     */
    protected static function labels(): array
    {
        return [
            'cartao' => 'Cartão',
            'boleto' => 'Boleto',
            'pix' => 'Pix',
            'deposito' => 'Depósito',
        ];
    }
}
