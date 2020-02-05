<?php

namespace App\Policies;

class User
{
    public function update($loggedInUser, $user)
    {
        return (int) $loggedInUser->id === (int) $user->id;
    }
}
