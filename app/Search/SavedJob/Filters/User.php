<?php

namespace App\Search\SavedJob\Filters;

use App\Models\Couple;
use App\Contracts\Search;
use App\Models\User as UserModel;
use Illuminate\Database\Eloquent\Builder;

class User implements Search
{
    public static function apply(Builder $builder, $value)
    {
        $user = UserModel::whereId($value)->first(['id', 'account']);

        if ($user->account === 'couple') {
            $couple = Couple::where('userA_id', $user->id)
                ->orWhere('userB_id', $user->id)->first();

            return $builder->where(function ($q) use ($couple) {
                $q->where('user_id', $couple->userA_id)
                ->orWhere('user_id', $couple->userB_id);
            });
        }

        return $builder->where('user_id', $value);
    }
}
