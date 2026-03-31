<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Models\Setting;

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
        // View Composer를 활용한 전역 세팅 캐싱 및 주입
        View::composer('*', function ($view) {
            $settings = Cache::rememberForever('global_site_settings', function () {
                try {
                    return Setting::pluck('value', 'key')->all();
                } catch (\Exception $e) {
                    return [];
                }
            });

            $view->with('siteSettings', $settings);
        });
    }
}
