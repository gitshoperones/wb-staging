<?php

namespace App\Repositories;

use Bouncer;
use App\Models\User;
use App\Models\Couple;
use Illuminate\Support\Facades\Storage;

class CoupleRepo
{
    public function create(array $data)
    {
        return Couple::create(['userA_id' => $data['user_id']]);
    }

    public function updateOrCreate(array $data)
    {
        if (isset($data['coupleId'])) {
            $couple = Couple::whereId($data['coupleId'])
                ->firstOrFail(['id', 'userB_id']);

            return $couple->update(['userB_id' => $data['user_id']]);
        }

        return Couple::create(['userA_id' => $data['user_id']]);
    }

    public function update(array $data)
    {
        return Couple::whereId($data['coupleId'])->firstOrFail()->update($data);
    }

    public function updateProfileAvatar($file, Couple $couple)
    {
        if ($file) {
            $oldFile = $couple->getRawProfileAvatarFilename();
            if ($couple->profile_avatar && $oldFile) {
                Storage::delete(sprintf('user-uploads/%s', $oldFile));
            }

            return $couple->update(['profile_avatar' => $this->upload($file)]);
        }
    }

    public function updateProfileCover($file, Couple $couple)
    {
        if ($file) {
            $oldFile = $couple->getRawProfileCoverFilename();
            if ($couple->profile_cover && $oldFile) {
                Storage::delete(sprintf('user-uploads/%s', $oldFile));
            }

            return $couple->update(['profile_cover' => $this->upload($file)]);
        }
    }

    public function upload($file)
    {
        $staticFilename = request('staticFilename') && request('staticFilename') == true;

        if ($staticFilename) {
            return $file->storeAs(
                'user-uploads',
                $file->getClientOriginalName()
            );
        }

        return $file->store('user-uploads');
    }
}
