<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\ActivationSetting;
use App\Http\Controllers\Controller;

class ActivationSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $setting = ActivationSetting::first();
        return view('admin.pages.settings.activation_settings', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'activation_amount' => 'required|numeric|min:0',
            'activation_bonus' => 'required|numeric|min:0',
            'referral_bonus' => 'required|numeric|min:0',
            'activation_duration_months' => 'required|numeric|min:1',
        ]);

        $setting = ActivationSetting::first();
        if (!$setting) {
            $setting = new ActivationSetting();
        }

        $setting->update($request->only(['activation_amount', 'activation_bonus', 'referral_bonus', 'activation_duration_months']));

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
