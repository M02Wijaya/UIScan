<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// 1. Tambahkan baris ini di atas
use Illuminate\Pagination\Paginator;

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
        // 2. Tambahkan baris ini untuk memaksa pagination menggunakan gaya Bootstrap 5
        Paginator::useBootstrapFive();
    }
}