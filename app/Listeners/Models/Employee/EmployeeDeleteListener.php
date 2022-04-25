<?php

namespace App\Listeners\Models\Employee;

use App\Events\Models\Employee\EmployeeDeleteEvent;
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
     * @param  \App\Events\Models\Employee\EmployeeDeleteEvent $event
     * @return void
     */
    public function handle(EmployeeDeleteEvent $event)
    {
        \App\Events\Common\UpdateCachesDataEvent::dispatch('company');
    }

    /**
     * Determine whether the listener should be queued.
     *
     * @param  \App\Events\Models\Employee\EmployeeDeleteEvent  $event
     * @return bool
     */
    public function shouldQueue(EmployeeDeleteEvent $event)
    {
        return true;
    }
}
