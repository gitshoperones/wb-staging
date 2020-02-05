<?php

namespace App\Policies;

use App\Models\User;
use App\Models\JobPost;

class JobQuote
{
    public function create($user)
    {
        return $user->account === 'vendor';
    }

    public function store($user)
    {
        return $user->account === 'vendor';
    }

    public function show($user, $jobQuote)
    {
        if ($user->account === 'couple') {
            $jobPost = JobPost::whereId($jobQuote->job_post_id)->firstOrFail([
                'id', 'user_id'
            ]);

            return (int) $user->id === (int) $jobPost->user_id;
        }

        return (int) $user->id === (int) $jobQuote->user_id;
    }

    public function edit($user, $jobQuote)
    {
        return (int) $user->id === (int) $jobQuote->user_id && $jobQuote->locked !== 1;
    }

    public function update($user, $jobQuote)
    {
        return (int) $user->id === (int) $jobQuote->user_id && $jobQuote->locked !== 1;
    }

    public function respond($user, $jobQuote)
    {
        if ($user->account !== 'couple') {
            return false;
        }

        if ($jobQuote->user_id === $user->id) {
            return false;
        }

        if (!in_array($jobQuote->status, [1, 2])) {
            return false;
        }

        if ($jobQuote->locked) {
            return false;
        }

        $jobPost = JobPost::whereId($jobQuote->job_post_id)->firstOrFail([
            'id', 'user_id'
        ]);

        return $user->id === $jobPost->user_id && $jobPost->status !== 2;
    }
}
