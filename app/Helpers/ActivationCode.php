<?php

namespace App\Helpers;

use App\Models\User;

class ActivationCode
{
    public $code;

    public function create()
    {
        $this->code = str_random(40);

        return $this;
    }

    public function assignTo(User $user)
    {
        return $user->activationCode()->create(['code' => $this->code]);
    }
}
