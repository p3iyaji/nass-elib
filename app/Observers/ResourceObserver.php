<?php

namespace App\Observers;

use App\Models\Resource;
use Illuminate\Support\Str;

class ResourceObserver
{
    /**
     * Handle the Resource "created" event.
     */
    public function created(Resource $resource): void
    {
        //
    }

    /**
     * Handle the Resource "updated" event.
     */
    public function updated(Resource $resource): void
    {
        //
    }

    public function updating(Resource $resource): void
    {
        if (!$resource->isDirty('title')) {
            $resource->slug = Str::slug($resource->title);
        }
    }

    /**
     * Handle the Resource "deleted" event.
     */
    public function deleted(Resource $resource): void
    {
        //
    }

    /**
     * Handle the Resource "restored" event.
     */
    public function restored(Resource $resource): void
    {
        //
    }

    /**
     * Handle the Resource "force deleted" event.
     */
    public function forceDeleted(Resource $resource): void
    {
        //
    }
}
