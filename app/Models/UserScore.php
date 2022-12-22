<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserScore extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, double>
     */
    protected $fillable = [
        'user_id',
        'score',
        'is_win',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string>
     */
    protected $casts = [
        'score' => 'float',
    ];

    /**
     * @param int $number
     * @return float|int
     */
    public static function calculateScore(int $number): float|int
    {
        if ($number % 2 === 0) {
            return match (true) {
                $number > 900 => $number * 70 / 100,
                $number > 600 => $number * 60 / 100,
                $number > 300 => $number * 30 / 100,
                default => $number * 10 / 100,
            };
        }

        return 0;
    }
}
