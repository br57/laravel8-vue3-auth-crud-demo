<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        \App\Events\Common\UpdateCachesDataEvent::class => [
            \App\Listeners\Common\UpdateCachesDataListener::class
        ],

        /* Company Model Listener */
        \App\Events\Modules\Company\CompanyCreatedEvent::class => [
            \App\Listeners\Modules\Company\CompanyCreatedListener::class,
        ],
        \App\Events\Modules\Company\CompanyUpdatedEvent::class => [
            \App\Listeners\Modules\Company\CompanyUpdatedListener::class,
        ],
        \App\Events\Modules\Company\CompanyDeleteEvent::class => [
            \App\Listeners\Modules\Company\CompanyDeleteListener::class,
        ],


        /* Employee Model Listener */
        \App\Events\Modules\Employee\EmployeeCreatedEvent::class => [
            \App\Listeners\Modules\Employee\EmployeeCreatedListener::class,
        ],
        \App\Events\Modules\Employee\EmployeeUpdatedEvent::class => [
            \App\Listeners\Modules\Employee\EmployeeUpdatedListener::class,
        ],
        \App\Events\Modules\Employee\EmployeeDeleteEvent::class => [
            \App\Listeners\Modules\Employee\EmployeeDeleteListener::class,
        ],


    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
