<?php

namespace App\Providers;

use App\Interfaces\AdminUsersRepositoryInterface;
use App\Interfaces\ProductRepositroryInterface;
use App\Interfaces\RoleRepositoryInterface;
use App\Repositories\AdminUsersRepository;
use App\Repositories\ProductRepository;
use App\Repositories\RoleRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepositroryInterface::class, ProductRepository::class);
        $this->app->bind(AdminUsersRepositoryInterface::class, AdminUsersRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
