<?php

namespace App\Providers;

use App\Services\ErrorService;
use App\Services\BuilderService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('formatToComaDecimalSeparator', function($number) {
            return "<?php echo \App\Helpers\NumberFormatHelper::formatToComaDecimalSeparator($number); ?>";
        });
    }
}
