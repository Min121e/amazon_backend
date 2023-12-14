<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */

    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Sanctum::usePersonalAccessTokenModel(SanctumPersonalAccessToken::class);
    }
}
