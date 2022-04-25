<?php

namespace App\Listeners\Modules\Employee;

use App\Events\Modules\Employee\EmployeeDeleteEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EmployeeDeleteListener implements ShouldQueue
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
     * @param  \App\Events\Modules\Employee\EmployeeDeleteEvent $event
     * @return void
     */
    public function handle(EmployeeDeleteEvent $event)
    {
        \App\Events\Common\UpdateCachesDataEvent::dispatch('company');
    }

    /**
     * Determine whether the listener should be queued.
     *
     * @param  \App\Events\Modules\Employee\EmployeeDeleteEvent  $event
     * @return bool
     */
    public function shouldQueue(EmployeeDeleteEvent $event)
    {
        return true;
    }
}
