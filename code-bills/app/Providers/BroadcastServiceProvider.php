<?php

namespace CodeBills\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes(['middleware' => ['web', 'cors', 'auth:api']]);

        /*
         * Authenticate the user's personal channel...
         */
        Broadcast::channel('client.*', function ($user, $clientId) {
            return $user->client_id == $clientId;
        });
    }
}
