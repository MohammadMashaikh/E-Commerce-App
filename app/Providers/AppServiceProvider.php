<?php

namespace App\Providers;

use App\Models\Admin;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

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

        if (app()->environment('production')) {
            URL::forceScheme('https');
         }


        Gate::define('manage-products', function (Admin $admin) {
            return $admin->hasPermission('manage-products');
        });

         Gate::define('view-products', function (Admin $admin) {
            return $admin->hasPermission('view-products');
        });

        Gate::define('manage-users', function (Admin $admin) {
            return $admin->hasPermission('manage-users');
        });

        Gate::define('view-users', function (Admin $admin) {
            return $admin->hasPermission('view-users');
        });

        Gate::define('view-orders', function (Admin $admin) {
            return $admin->hasPermission('view-orders');
        });

        Gate::define('manage-orders', function (Admin $admin) {
            return $admin->hasPermission('manage-orders');
        });

        Gate::define('manage-roles', function (Admin $admin) {
            return $admin->hasPermission('manage-roles');
        });

        Gate::define('view-roles', function (Admin $admin) {
            return $admin->hasPermission('view-roles');
        });

       
    }
}
