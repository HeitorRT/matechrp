<?php

namespace App\Models;

use App\Enums\ChapterPlayerEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

/**
 * @property int|null $id
 * @property string $name
 * @property string $description
 * @property integer $number
 * @property Carbon $duration
 * @property string $image
 * @property string $cast
 * @property string $direction
 * @property string $main_player
 * @property string $vimeo_link
 * @property string $vimeo_embed
 * @property string $sambatech_link
 * @property string $sambatech_embed
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method Builder filterLikeName(string|null $name)
 */
class Chapter extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'number',
        'duration',
        'cast',
        'direction',
        'image',
        'main_player',
        'vimeo_link',
        'vimeo_embed',
        'sambatech_link',
        'sambatech_embed',
        'embed',
        'chapterable_id',
        'chapterable_type',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'duration' => 'datetime:H:i',
        'main_player' => ChapterPlayerEnum::class
    ];

     /**
     * @return MorphTo
     */
    public function chapterable(): MorphTo
    {
        return $this->morphTo();
    }
}
