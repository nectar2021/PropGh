<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SiteSettingController extends Controller
{
    private const HEADER_LOGO_KEY = 'header_logo_path';

    private const IMAGE_SETTING_INPUTS = [
        'header_logo' => [
            'key' => self::HEADER_LOGO_KEY,
            'folder' => 'branding',
        ],
    ];

    private const TEXT_SETTING_KEYS = [
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
        $settings = SiteSetting::getMany($this->allSettingKeys());

        return view('admin.settings.edit', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate($this->validationRules());

        foreach (array_keys(self::IMAGE_SETTING_INPUTS) as $inputName) {
            $this->syncImageSetting($request, $inputName);
        }

        foreach (self::TEXT_SETTING_KEYS as $key) {
            SiteSetting::set($key, $data[$key] ?? null);
        }

        return back()->with('status', 'Settings updated.');
    }

    /**
     * @return array<string, array<int, string>|string>
     */
    private function validationRules(): array
    {
        $rules = [
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
            'home_meta_title' => ['nullable', 'string', 'max:255'],
            'home_meta_description' => ['nullable', 'string', 'max:255'],
            'home_hero_title' => ['nullable', 'string', 'max:255'],
            'home_hero_subtitle' => ['nullable', 'string', 'max:500'],
            'home_hero_primary_label' => ['nullable', 'string', 'max:50'],
            'home_hero_secondary_label' => ['nullable', 'string', 'max:50'],
            'home_hero_tertiary_label' => ['nullable', 'string', 'max:50'],
            'home_top_offers_heading' => ['nullable', 'string', 'max:100'],
            'home_city_heading' => ['nullable', 'string', 'max:100'],
            'home_action_buy_title' => ['nullable', 'string', 'max:100'],
            'home_action_buy_button_label' => ['nullable', 'string', 'max:100'],
            'home_action_buy_button_url' => ['nullable', 'string', 'max:255'],
            'home_action_sell_title' => ['nullable', 'string', 'max:100'],
            'home_action_sell_button_label' => ['nullable', 'string', 'max:100'],
            'home_action_sell_button_url' => ['nullable', 'string', 'max:255'],
            'home_action_rent_title' => ['nullable', 'string', 'max:100'],
            'home_action_rent_button_label' => ['nullable', 'string', 'max:100'],
            'home_action_rent_button_url' => ['nullable', 'string', 'max:255'],
        ];

        foreach (array_keys(self::IMAGE_SETTING_INPUTS) as $inputName) {
            $rules[$inputName] = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:4096'];
            $rules[$this->removeInputName($inputName)] = ['nullable', 'boolean'];
        }

        return $rules;
    }

    private function syncImageSetting(Request $request, string $inputName): void
    {
        $settingKey = self::IMAGE_SETTING_INPUTS[$inputName]['key'];
        $folder = self::IMAGE_SETTING_INPUTS[$inputName]['folder'];
        $currentPath = SiteSetting::get($settingKey);

        if ($request->boolean($this->removeInputName($inputName))) {
            if ($currentPath) {
                Storage::disk('public')->delete($currentPath);
            }

            SiteSetting::set($settingKey, null);
            $currentPath = null;
        }

        if ($request->hasFile($inputName)) {
            $newPath = $request->file($inputName)->store($folder, 'public');

            if ($currentPath && $currentPath !== $newPath) {
                Storage::disk('public')->delete($currentPath);
            }

            SiteSetting::set($settingKey, $newPath);
        }
    }

    /**
     * @return array<int, string>
     */
    private function allSettingKeys(): array
    {
        return array_merge(
            array_map(
                static fn(array $config): string => $config['key'],
                self::IMAGE_SETTING_INPUTS,
            ),
            self::TEXT_SETTING_KEYS,
        );
    }

    private function removeInputName(string $inputName): string
    {
        return 'remove_' . $inputName;
    }
}
