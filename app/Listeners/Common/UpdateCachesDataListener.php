<?php

namespace App\Listeners\Common;

use App\Events\Common\UpdateCachesDataEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\Cache;

class UpdateCachesDataListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\Common\UpdateCachesDataEvent  $event
     * @return void
     */
    public function handle(UpdateCachesDataEvent $event)
    {
        refreshCacheData($event->model, $event->cache_name);
    }
    
    /**
     * Determine whether the listener should be queued.
     *
     * @param  \App\Events\Common\UpdateCachesDataEvent  $event
     * @return bool
     */
    public function shouldQueue(UpdateCachesDataEvent $event)
    {
        return !is_null($event->model);
    }
}
