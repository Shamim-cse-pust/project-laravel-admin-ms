<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::define('view', function ($user, $model) {
            return $user->hasAccessView($model) || $user->hasAccessEdit($model);
        });
        Gate::define('edit', function ($user, $model) {
            return $user->hasAccessEdit($model);
        });
    }
}