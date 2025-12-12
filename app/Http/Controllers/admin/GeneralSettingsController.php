<?php

namespace App\Http\Controllers\admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class GeneralSettingsController extends Controller
{
    public function index()
    {
        $generalSettings = GeneralSetting::first();
        return view('admin.pages.settings.general_settings', compact('generalSettings'));
    }

    public function update(Request $request)
    {
        $request->validate([

            'app_name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
        ]);

        $generalSettings = GeneralSetting::first();

        $data = $request->only([
            'app_name',
        ]);


        if ($request->hasFile('logo')) {
            if ($generalSettings->logo) {
                Storage::disk('public')->delete($generalSettings->logo);
            }
            $data['logo'] = $request->file('logo')->store('logos', 'public');
            $data['logo'] = str_replace('public/', '', $data['logo']);
        }

        if ($request->hasFile('favicon')) {
            if ($generalSettings->favicon) {
                Storage::disk('public')->delete($generalSettings->favicon);
            }
            $data['favicon'] = $request->file('favicon')->store('favicons', 'public');
            $data['favicon'] = str_replace('public/', '', $data['favicon']);
        }

        $generalSettings->update($data);

        return redirect()->route('admin.general.settings')->with('success', 'Settings updated successfully!');
    }

        // Show settings page
    public function settings()
    {
        $settings = Setting::all()->pluck('value','key')->toArray();
        return view('admin.pages.settings.settings', compact('settings'));
    }

    // Update settings
    public function updateSettings(Request $request)
    {
        $input = $request->except('_token');

        foreach ($input as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
