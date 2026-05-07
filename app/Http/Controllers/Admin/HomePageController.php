<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Support\HomePageSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HomePageController extends Controller
{
    public function edit(): View
    {
        return view('admin.homepage.edit', [
            'settings' => SiteSetting::getMany(HomePageSettings::allSettingKeys()),
            'heroImageFields' => HomePageSettings::heroImageFields(),
            'cityImageFields' => HomePageSettings::cityImageFields(),
            'actionCardFields' => HomePageSettings::actionCardFields(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate(HomePageSettings::validationRules());

        foreach (array_keys(HomePageSettings::imageSettingInputs()) as $inputName) {
            $this->syncImageSetting($request, $inputName);
        }

        foreach (HomePageSettings::textSettingKeys() as $key) {
            SiteSetting::set($key, $data[$key] ?? null);
        }

        return back()->with('status', 'Homepage content updated.');
    }

    private function syncImageSetting(Request $request, string $inputName): void
    {
        $settingConfig = HomePageSettings::imageSettingInputs()[$inputName];
        $settingKey = $settingConfig['key'];
        $folder = $settingConfig['folder'];
        $currentPath = SiteSetting::get($settingKey);

        if ($request->boolean(HomePageSettings::removeInputName($inputName))) {
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
}
