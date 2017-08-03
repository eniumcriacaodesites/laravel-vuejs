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
        $this->app->bind(\CodeBills\Repositories\BankAccountRepository::class, \CodeBills\Repositories\BankAccountRepositoryEloquent::class);
        $this->app->bind(\CodeBills\Repositories\BillPayRepository::class, \CodeBills\Repositories\BillPayRepositoryEloquent::class);
        $this->app->bind(\CodeBills\Repositories\BillReceiveRepository::class, \CodeBills\Repositories\BillReceiveRepositoryEloquent::class);
        $this->app->bind(\CodeBills\Repositories\ClientRepository::class, \CodeBills\Repositories\ClientRepositoryEloquent::class);
        $this->app->bind(\CodeBills\Repositories\CategoryRepository::class, \CodeBills\Repositories\CategoryRepositoryEloquent::class);
        $this->app->bind(\CodeBills\Repositories\CategoryExpenseRepository::class, \CodeBills\Repositories\CategoryExpenseRepositoryEloquent::class);
        $this->app->bind(\CodeBills\Repositories\CategoryRevenueRepository::class, \CodeBills\Repositories\CategoryRevenueRepositoryEloquent::class);
        $this->app->bind(\CodeBills\Repositories\StatementRepository::class, \CodeBills\Repositories\StatementRepositoryEloquent::class);
        $this->app->bind(\CodeBills\Repositories\PlanRepository::class, \CodeBills\Repositories\PlanRepositoryEloquent::class);
        $this->app->bind(\CodeBills\Repositories\UserRepository::class, \CodeBills\Repositories\UserRepositoryEloquent::class);
        $this->app->bind(\CodeBills\Repositories\SubscriptionRepository::class, \CodeBills\Repositories\SubscriptionRepositoryEloquent::class);
        $this->app->bind(\CodeBills\Repositories\OrderRepository::class, \CodeBills\Repositories\OrderRepositoryEloquent::class);
        //:end-bindings:
    }
}
