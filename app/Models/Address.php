<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int|null $id
 * @property string $cep
 * @property string $street
 * @property string $number
 * @property string $district
 * @property string $complement
 * @property string $city
 * @property string $state
 * @property string $country
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Student|BelongsTo $student
 */
class Address extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cep',
        'street',
        'number',
        'district',
        'complement',
        'city',
        'state',
        'country'
    ];

    /**
     * @return MorphTo
     */
    public function addresseable(): MorphTo
    {
        return $this->morphTo();
    }
}
