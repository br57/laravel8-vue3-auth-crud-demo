<?php

namespace App\Listeners\Modules\Employee;

use App\Events\Modules\Employee\EmployeeCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EmployeeCreatedListener implements ShouldQueue
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
     * @param  \App\Events\Modules\Employee\EmployeeCreatedEvent  $event
     * @return void
     */
    public function handle(EmployeeCreatedEvent $event)
    {
        \App\Events\Common\UpdateCachesDataEvent::dispatch('company');
    }

    /**
     * Determine whether the listener should be queued.
     *
     * @param  \App\Events\Modules\Employee\EmployeeCreatedEvent  $event
     * @return bool
     */
    public function shouldQueue(EmployeeCreatedEvent $event)
    {
        return true;
    }
}
