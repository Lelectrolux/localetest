<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            // You probably don't need to localise any json api, but you could do the same if needed
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(static function (): void {
                    // Register routes with a locale segment first
                    foreach (config()->get('app.other_locales') as $locale) {
                        Route::middleware("setLocale:$locale")
                            ->prefix($locale)
                            ->name("$locale:") // Don't use other colons in your route name
                            ->group(function () use ($locale) { // That use($locale) is important
                                // We are doing the equivalent to Illuminate\Routing\RouteFileRegistrar:31
                                require base_path('routes/web.php');
                            });
                    }

                    // Then add the hidden locale routes
                    $locale = config()->get('app.default_locale');
                    Route::middleware("setLocale:$locale")
                        ->name("$locale:")
                        ->name("$locale:")
                        ->group(function () use ($locale) { // That use($locale) is important
                            require base_path('routes/web.php');
                        });
                });
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
