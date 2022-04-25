<?php

namespace App\Listeners\Modules\Company;

use App\Events\Modules\Company\CompanyDeleteEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CompanyDeleteListener implements ShouldQueue
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
     * @param  \App\Events\Modules\Company\CompanyDeleteEvent  $event
     * @return void
     */
    public function handle(CompanyDeleteEvent $event)
    {
        \App\Events\Common\UpdateCachesDataEvent::dispatch('company');
    }

    /**
     * Determine whether the listener should be queued.
     *
     * @param  \App\Events\Modules\Company\CompanyDeleteEvent  $event
     * @return bool
     */
    public function shouldQueue(CompanyDeleteEvent $event)
    {
        return true;
    }
}
