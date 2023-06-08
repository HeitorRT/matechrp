<?php

namespace App\Models;

use App\Enums\InstallmentPaymentMethodEnum;
use App\Enums\InstallmentStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int|null $id
 * @property int $order_id
 * @property int $payment_method
 * @property string $status
 * @property int $installment
 * @property string $payment_value
 * @property string $expiration_date
 * @property string $expiration_date_original
 * @property string $payday

 * @property Product $product
 */
class Installment extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'payment_method',
        'status',
        'installment_number',
        'payment_value',
        'expiration_at',
        'expiration_original_at',
        'payday_at'
    ];

     /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'payment_method' => InstallmentPaymentMethodEnum::class,
        'status' => InstallmentStatusEnum::class,
        'intstallment_number' => 'integer',
        'payment_value' => 'float',
        'expiration_at' => 'datetime',
        'expiration_original_at' => 'datetime',
        'payday_at' => 'datetime'
    ];

    /**
     * Relationships
     */
    /**
     * @return Product|BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class)->withDefault();
    }
}
