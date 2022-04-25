<?php

namespace App\Listeners\Models\Company;

use App\Events\Models\Company\CompanyUpdatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CompanyUpdatedListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }
    
    /**
     * Handle the event.
     *
     * @param  \App\Events\Models\Company\CompanyUpdatedEvent  $event
     * @return void
     */
    public function handle(CompanyUpdatedEvent $event)
    {
        \App\Events\Common\UpdateCachesDataEvent::dispatch('company');
    }

    /**
     * Determine whether the listener should be queued.
     *
     * @param  \App\Events\Models\Company\CompanyUpdatedEvent  $event
     * @return bool
     */
    public function shouldQueue(CompanyUpdatedEvent $event)
    {
        return true;
    }
}
