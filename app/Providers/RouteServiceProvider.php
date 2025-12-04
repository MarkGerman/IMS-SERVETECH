<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Livewire;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {

        // Livewire::setUpdateRoute(function ($handle) {
        //     return Route::post('/livewire/update', $handle);
        //     // return Route::post('/livewire/update', $handle)
        //     //     ->middleware('web')
        //     //     ->prefix(LaravelLocalization::setLocale());
        //     // return Route::post('/ims/livewire/update', $handle);
        // });

        // Livewire::setUpdateRoute(function ($handle) {
        //     return Route::post('/livewire/update', $handle)
        //         ->middleware('web');
        //         // ->prefix(LaravelLocalization::setLocale());
        // });
        // Livewire::setScriptRoute(function ($handle) {
        //     return Route::get('/livewire/livewire.js', $handle);
        //     // return Route::get('/academia/livewire/livewire.js', $handle);
        // });


        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
