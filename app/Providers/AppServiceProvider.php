<?php

namespace App\Providers;

use App\Services\AuthService;
use App\Services\ErrorService;
use App\Services\BuilderService;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
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
        Blade::directive('formatToComaDecimalSeparator', function($number) {
            return "<?php echo \App\Helpers\NumberFormatHelper::formatToComaDecimalSeparator($number); ?>";
        });

        Authenticate::redirectUsing(function ($request) {
            $currentUrl = url()->current();
            $redirectTo = parse_url($currentUrl, PHP_URL_PATH);
    
            return route('login') . '?redirect-to='.urlencode($redirectTo);
        });

        if(env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }
    }
}
