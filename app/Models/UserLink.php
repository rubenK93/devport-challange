<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserLink extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string, date, boolean>
     */
    protected $fillable = [
        'user_id',
        'link',
        'status',
        'due_date',
        'is_manual',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, boolean>
     */
    protected $casts = [
        'status' => 'boolean',
        'is_manual' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'linkUrl'
    ];

    /**
     * @return string
     */
    protected function getLinkUrlAttribute()
    {
        return route('links.show', $this->link);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param Builder $query
     * @param string $link
     * @return Builder
     */
    public function scopeIsActive(Builder $query, string $link): Builder
    {
        return $query->where([
            ['status', true],
            ['link', $link],
            ['due_date', '>', now()],
        ]);
    }

    /**
     * @param int $chars
     * @return string
     * @throws Exception
     */
    public static function generateUniqueLink(int $chars = 10): string
    {
        do {
            $link = bin2hex(random_bytes($chars));
        } while (self::query()->where('link', $link)->exists());

        return $link;
    }
}
