<?php

namespace App\Providers;

use App\Services\AuthService;
use App\Services\ErrorService;
use App\Services\BuilderService;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Auth\Middleware\Authenticate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ErrorService::class, function ($app) {
            return new ErrorService();
        });
        $this->app->singleton(BuilderService::class, function ($app) {
            return new BuilderService();
        });
        $this->app->singleton(AuthService::class, function ($app) {
            return new AuthService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('formatToComaDecimalSeparator', function ($number) {
            return "<?php echo \App\Helpers\NumberFormatHelper::formatToComaDecimalSeparator($number); ?>";
        });

        Authenticate::redirectUsing(function ($request) {
            $currentUrl = url()->current();
            $redirectTo = parse_url($currentUrl, PHP_URL_PATH);
    
            return route('login') . '?redirect-to='.urlencode($redirectTo);
        });

        RateLimiter::for('global', function ($request) {
            return [
                Limit::perMinute(50)->by($request->ip()),
                Limit::perHour(800)->by($request->ip()),
                Limit::perHour(3000, 6)->by($request->ip()),
            ];
        });

        RateLimiter::for('sensitive-actions', function ($request) {
            return [
                Limit::perMinute(10)->by($request->ip())->response(function () {
                    return response()->json(['errors' => [
                        'error' => [__('errors.sensitive_actions.too_many_attempts')]
                    ]], 429);
                }),
                Limit::perHour(25)->by($request->ip())->response(function () {
                    return response()->json(['errors' => [
                        'error' => [__('errors.sensitive_actions.too_many_attempts')]
                    ]], 429);
                }),
                Limit::perHour(40, 6)->by($request->ip())->response(function () {
                    return response()->json(['errors' => [
                        'error' => [__('errors.sensitive_actions.too_many_attempts')]
                    ]], 429);
                }),
            ];
        });

        if(env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }
    }
}
