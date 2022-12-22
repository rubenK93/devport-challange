<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ScoreRepository
{
    /**
     * @param User $user
     * @param int|float $score
     * @param int $number
     * @return Model
     */
    public function storeScore(User $user, int|float $score, int $number): Model
    {
        return $user->scores()->create([
            'number' => $number,
            'score' => $score,
            'is_win' => (bool) $score,
        ]);
    }
}
