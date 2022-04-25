<?php

namespace App\Listeners\Modules\Employee;

use App\Events\Modules\Employee\EmployeeUpdatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EmployeeUpdatedListener implements ShouldQueue
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
     * @param  \App\Events\Modules\Employee\EmployeeUpdatedEvent  $event
     * @return void
     */
    public function handle(EmployeeUpdatedEvent $event)
    {
        \App\Events\Common\UpdateCachesDataEvent::dispatch('company');
    }

    /**
     * Determine whether the listener should be queued.
     *
     * @param  \App\Events\Modules\Employee\EmployeeUpdatedEvent  $event
     * @return bool
     */
    public function shouldQueue(EmployeeUpdatedEvent $event)
    {
        return true;
    }
}
