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
        \App\Events\Models\Company\CompanyCreatedEvent::class => [
            \App\Listeners\Models\Company\CompanyCreatedListener::class,
        ],
        \App\Events\Models\Company\CompanyUpdatedEvent::class => [
            \App\Listeners\Models\Company\CompanyUpdatedListener::class,
        ],
        \App\Events\Models\Company\CompanyDeleteEvent::class => [
            \App\Listeners\Models\Company\CompanyDeleteListener::class,
        ],


        /* Employee Model Listener */
        \App\Events\Models\Employee\EmployeeCreatedEvent::class => [
            \App\Listeners\Models\Employee\EmployeeCreatedListener::class,
        ],
        \App\Events\Models\Employee\EmployeeUpdatedEvent::class => [
            \App\Listeners\Models\Employee\EmployeeUpdatedListener::class,
        ],
        \App\Events\Models\Employee\EmployeeDeleteEvent::class => [
            \App\Listeners\Models\Employee\EmployeeDeleteListener::class,
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
