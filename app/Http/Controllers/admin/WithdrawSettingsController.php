<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\WithdrawSetting;
use App\Http\Controllers\Controller;

class WithdrawSettingsController extends Controller
{
    public function index()
    {
        $settings = WithdrawSetting::first();
        return view('admin.pages.withdraw.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'min_withdraw' => 'required|numeric|min:0',
            'max_withdraw' => 'required|numeric|gte:min_withdraw',
            'charge' => 'required|numeric|min:0',
            'status' => 'required|in:0,1',
        ]);

        $settings = WithdrawSetting::first(); // Assuming only 1 row
        $settings->update($request->only(['min_withdraw', 'max_withdraw', 'charge', 'status']));

        return redirect()->back()->with('success', 'Withdraw settings updated successfully.');
    }
}
