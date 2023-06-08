<?php

namespace App\Models;

use App\Enums\ExtraPlayerEnum;
use App\Enums\ExtraTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
use Illuminate\Support\Arr;

/**
 * @property int|null $id
 * @property string $name
 * @property string|ExtraTypeEnum $type
 * @property string|ExtraPlayerEnum $player
 * @property string $embed
 * @property string $file
 * @property-read bool $is_image
 * @property Content $content
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Extra extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type',
        'player',
        'embed',
        'file'
    ];

     /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'type' => ExtraTypeEnum::class.':nullable',
        'player' => ExtraPlayerEnum::class.':nullable',
    ];


    /**
     * @return Content
     */
    public function content(): BelongsTo
    {
        return $this->belongsTo(Content::class);
    }

    /**
     * Attributes
     */

     /**
      * @return boolean
      */
    public function getIsImageAttribute(): bool
    {
        return in_array(Arr::last(explode('.', $this->file)), ['png', 'jpg', 'jpeg']);
    }
}
