<?php

namespace CodeBills\Providers;

use CodeBills\Events\BankStoredEvent;
use CodeBills\Listeners\BankAccountSetDefaultListener;
use CodeBills\Listeners\BankLogoUploadListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Prettus\Repository\Events\RepositoryEntityCreated;
use Prettus\Repository\Events\RepositoryEntityUpdated;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        BankStoredEvent::class => [
            BankLogoUploadListener::class,
        ],
        RepositoryEntityCreated::class => [
            BankAccountSetDefaultListener::class,
        ],
        RepositoryEntityUpdated::class => [
            BankAccountSetDefaultListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        //
    }
}
