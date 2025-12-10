<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TransferSetting;
use Illuminate\Http\Request;

class TransferSettingsController extends Controller
{
    public function index()
    {
        $settings = TransferSetting::first();
        return view('admin.pages.settings.transfer_settings', compact('settings'));
    }

    public function update(Request $request)
    {
        // Validate only the existing fields
        $validated = $request->validate([
            'min_transfer' => 'required|numeric|min:0',
            'max_transfer' => 'required|numeric|min:0|gte:min_transfer',
            'status' => 'required|boolean',
        ]);

        $settings = TransferSetting::first();

        if ($settings) {
            $settings->update($validated);
            return redirect()->back()->with('success', 'Transfer settings updated successfully.');
        }

        return redirect()->back()->with('error', 'Transfer settings not found.');
    }
}
