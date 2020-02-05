<?php

namespace App\Repositories;

use App\Models\Media;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MediaRepo
{
    public function store($meta, $file, $owningModel)
    {
        $staticFilename = request('staticFilename') && request('staticFilename') == true;

        if ($staticFilename) {
            $newFilename = $file->storeAs(
                'user-uploads',
                $file->getClientOriginalName()
            );
        } else {
            $newFilename = $file->store('user-uploads');
        }

        $meta['meta_filename'] = $newFilename;
        $meta['commentable_id'] = $owningModel->id;
        $meta['commentable_type'] = get_class($owningModel);

        $newMedia = Media::create($meta);

        $newMedia->sorting_order = $newMedia->id;
        $newMedia->save();

        return $newMedia;
    }

    public function storeMany($meta, $files, $owningModel)
    {
        $meta['commentable_type'] = get_class($owningModel);
        $meta['commentable_id'] = $owningModel->id;

        $media = [];

        foreach ($files as $file) {
            $meta['meta_filename'] = $file->store('user-uploads');
            $media[] = Media::create($meta);
        }

        return $media;
    }

    public function destroy($mediaId)
    {
        $media = Media::whereId($mediaId)->firstOrFail();
        Storage::delete($media->meta_filename);

        return $media->delete();
    }

    public function updateSortingOrder($data)
    {
        if ($data) {
            foreach ($data as $item) {
                $media = Media::whereId($item->itemId)->first(['id', 'sorting_order']);
                if ($media) {
                    $media->sorting_order = $item->order;
                    $media->save();
                }
            }
        }
    }

    public function updateCaption($data)
    {
        if ($data) {
            foreach ($data as $item) {
                $media = Media::whereId($item->itemId)->first(['id', 'caption']);
                if ($media) {
                    $media->caption = $item->caption;
                    $media->save();
                }
            }
        }
    }

    public function updatePosition($data)
    {
        if ($data) {
            foreach ($data as $item) {
                $media = Media::whereId($item->itemId)->first(['id', 'background_position']);
                if ($media) {
                    $media->background_position = $item->background_position;
                    $media->save();
                }
            }
        }
    }
}
