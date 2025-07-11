<?php

namespace App\Providers;

use App\Models\Karyawan;
use App\Policies\KaryawanPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use App\Observers\UserObserver;
use App\Observers\KaryawanObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Karyawan::class => KaryawanPolicy::class,
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
        Karyawan::observe(KaryawanObserver::class);

        Gate::define('admin', function (User $user) {
            return $user->role === 'admin';
        });
    }
}
