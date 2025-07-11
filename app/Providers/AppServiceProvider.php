<?php

namespace App\Providers;

use App\Models\Penumpang;
use App\Policies\PenumpangPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use App\Observers\UserObserver;
use App\Observers\PenumpangObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Penumpang::class => PenumpangPolicy::class,
    ];

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
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // Register observers
        User::observe(UserObserver::class);
        Penumpang::observe(PenumpangObserver::class);

        Gate::define('admin', function (User $user) {
            return $user->role === 'admin';
        });
    }
}
