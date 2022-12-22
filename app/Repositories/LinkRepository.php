<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserLink;
use Exception;
use Illuminate\Database\Eloquent\Model;

class LinkRepository
{
    /**
     * @param User $user
     * @param bool $is_manual
     * @return Model
     * @throws Exception
     */
    public function createUserLink(User $user, bool $is_manual = false): Model
    {
        return $user->links()->create([
            'link' => UserLink::generateUniqueLink(),
            'due_date' => now()->addDays(7),
            'is_manual' => $is_manual,
        ]);
    }

    /**
     * @param UserLink $link
     */
    public function deactivateUserLink(UserLink $link)
    {
        $link->update(['status' => false]);
    }
}
