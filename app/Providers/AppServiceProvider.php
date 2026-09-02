<?php

namespace App\Providers;

use App\Policies\NotificationPolicy;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('auth', fn(Request $request) => Limit::perMinute(5)->by($request->user()->id ?? $request->ip()));

        RateLimiter::for('api', fn(Request $request) => Limit::perMinute(20)->by($request->user()->id ?? $request->ip()));

        /**
         * connecting the notification policy class to database notification class because
         * notification isnt a model that lets laravel find the policy automatically
         */
        Gate::policy(DatabaseNotification::class, NotificationPolicy::class);

        /**
         * custom route bind for notification because notification isnt a model
         */
        Route::bind(
            'notification',
            fn(string $id) => request()->user()
                ->notifications()
                ->where('id', $id)
                ->firstOrFail()
        );
    }
}
