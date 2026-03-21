<?php

namespace App\Providers;

use App\Models\Property;
use App\Models\SiteSetting;
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
            $settings = SiteSetting::getMany([
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
            ]);

            $livePropertyCount = Property::where('status', 'live')->count();

            $view->with('footerSettings', $settings)
                ->with('livePropertyCount', $livePropertyCount);
        });
    }
}
