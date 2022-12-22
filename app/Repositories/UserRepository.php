<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * @param array $data
     * @return User
     */
    public function storeOrGetUser(array $data): User
    {
        return User::firstOrCreate(\Arr::only($data, ['mobile']), $data);
    }
}
