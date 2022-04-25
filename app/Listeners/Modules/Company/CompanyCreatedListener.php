<?php

namespace App\Listeners\Modules\Company;

use App\Events\Modules\Company\CompanyCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CompanyCreatedListener implements ShouldQueue
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
     * @param  \App\Events\Modules\Company\CompanyCreatedEvent  $event
     * @return void
     */
    public function handle(CompanyCreatedEvent $event)
    {
        \App\Events\Common\UpdateCachesDataEvent::dispatch('company');
    }

    /**
     * Determine whether the listener should be queued.
     *
     * @param  \App\Events\Modules\Company\CompanyCreatedEvent  $event
     * @return bool
     */
    public function shouldQueue(CompanyCreatedEvent $event)
    {
        return true;
    }
}
