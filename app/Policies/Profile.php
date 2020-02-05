<?php

namespace App\Policies;

class Profile
{
    public function edit($user, $profile)
    {
        if (get_class($profile) === 'App\Models\Couple') {
            return (int) $user->id === (int) $profile->userA_id || (int) $user->id === (int) $profile->userB_id;
        }

        return (int) $user->id === (int) $profile->user_id;
    }

    public function update($user, $profile)
    {
        if (get_class($profile) === 'App\Models\Couple') {
            return (int) $user->id === (int) $profile->userA_id || (int) $user->id === (int) $profile->userB_id;
        }

        return (int) $user->id === (int) $profile->user_id;
    }
}
