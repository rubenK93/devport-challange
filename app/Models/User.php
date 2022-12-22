<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'mobile',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * @return HasMany
     */
    public function links(): HasMany
    {
        return $this->hasMany(UserLink::class);
    }

    /**
     * @return HasMany
     */
    public function manual_links(): HasMany
    {
        return $this->links()
            ->where('is_manual', true);
    }

    /**
     * @return HasMany
     */
    public function scores(): HasMany
    {
        return $this->hasMany(UserScore::class);
    }

    /**
     * @return HasMany
     */
    public function last_three_scores(): HasMany
    {
        return $this->scores()
            ->orderBy('id', 'DESC')
            ->take(3);
    }
}
