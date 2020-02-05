<?php

namespace App\Repositories;

use App\Models\User;

class UserRepo
{
    public function create(array $data)
    {
        return User::create($data);
    }
}
