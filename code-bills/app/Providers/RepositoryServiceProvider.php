<?php

namespace CodeBills\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\CodeBills\Repositories\BankRepository::class, \CodeBills\Repositories\BankRepositoryEloquent::class);
        //:end-bindings:
    }
}
