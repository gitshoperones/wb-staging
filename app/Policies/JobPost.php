<?php

namespace App\Policies;

class JobPost
{
    public function create($user)
    {
        return $user->account === 'couple';
    }

    public function store($user)
    {
        return $user->account === 'couple';
    }

    public function edit($user, $jobPost)
    {
        return (int) $user->id === (int) $jobPost->user_id && $jobPost->status !== 2;
    }

    public function update($user, $jobPost)
    {
        return (int) $user->id === (int) $jobPost->user_id;
    }
}
