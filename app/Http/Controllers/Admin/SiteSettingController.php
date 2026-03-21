<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteSettingController extends Controller
{
    private const SETTING_KEYS = [
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

    public function edit(): View
    {
        $settings = SiteSetting::getMany(self::SETTING_KEYS);

        return view('admin.settings.edit', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'brand_description' => ['nullable', 'string', 'max:500'],
            'social_instagram' => ['nullable', 'url', 'max:255'],
            'social_facebook' => ['nullable', 'url', 'max:255'],
            'social_twitter' => ['nullable', 'url', 'max:255'],
            'social_youtube' => ['nullable', 'url', 'max:255'],
            'stat_rating' => ['nullable', 'string', 'max:20'],
            'stat_rating_label' => ['nullable', 'string', 'max:50'],
            'stat_support' => ['nullable', 'string', 'max:20'],
            'stat_support_label' => ['nullable', 'string', 'max:50'],
            'stat_satisfaction' => ['nullable', 'string', 'max:20'],
            'stat_satisfaction_label' => ['nullable', 'string', 'max:50'],
        ]);

        foreach (self::SETTING_KEYS as $key) {
            SiteSetting::set($key, $data[$key] ?? null);
        }

        return back()->with('status', 'Settings updated.');
    }
}
