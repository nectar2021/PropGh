<?php

namespace App\Providers;

use App\Models\Property;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer('partials.footer', function ($view): void {
            $keys = [
                'contact_email',
                'contact_phone',
                'brand_description',
                'social_instagram',
                'social_facebook',
                'social_twitter',
                'social_youtube',
                'stat_rating',
                'stat_rating_label',
                'stat_support',
                'stat_support_label',
                'stat_satisfaction',
                'stat_satisfaction_label',
            ];

            try {
                $settings = Schema::hasTable('site_settings')
                    ? SiteSetting::getMany($keys)
                    : array_fill_keys($keys, null);

                $livePropertyCount = Schema::hasTable('properties')
                    ? Property::where('status', 'live')->count()
                    : 0;
            } catch (\Throwable) {
                $settings = array_fill_keys($keys, null);
                $livePropertyCount = 0;
            }

            $view->with('footerSettings', $settings)
                ->with('livePropertyCount', $livePropertyCount);
        });
    }
}
