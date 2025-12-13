<?php

namespace App\Http\Controllers\admin;

use App\Models\Kyc;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class KycController extends Controller
{
    /**
     * Display a listing of the KYC applications with caching.
     */
    public function index(Request $request)
    {
        $status = $request->get('status');
        $page   = $request->get('page', 1);

        $cacheKey = "kycs_{$status}_page_{$page}";

        $kycs = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($status) {

            $query = Kyc::with('user')->latest();

            if ($status && in_array($status, ['pending', 'approved', 'rejected'])) {
                $query->where('status', $status);
            }

            return $query->paginate(10);
        });

        return view('admin.pages.kyc.index', compact('kycs', 'status'));
    }

    /**
     * Show the form for editing the specified KYC application.
     */
public function edit(string $id)
{
    // Retrieve the KYC record by ID
    $kyc = Kyc::findOrFail($id);

    // Pass it to the admin edit view
    return view('admin.pages.kyc.edit', compact('kyc'));
}

    /**
     * Update the specified KYC application in storage and clear related cache.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'note'   => 'nullable|string|max:1000',
        ]);

        $kyc = Kyc::findOrFail($id);

        if ($kyc->status === 'approved') {
            return redirect()->route('admin.kyc.index')->with('error', 'This KYC is already approved and cannot be modified.');
        }

        $kyc->status = $request->status;
        $kyc->note   = $request->note;
        $kyc->save();

        $user = User::findOrFail($kyc->user_id);
        $user->kyc_status = $request->status === 'approved' ? 1 : 0;
        $user->save();

        Cache::flush();

        return redirect()
            ->route('admin.kyc.index')
            ->with('success', 'KYC status updated successfully.');
    }



    /**
     * Not used but required for resource controller.
     */
    public function create() {}
    public function store(Request $request) {}
    public function show(string $id) {}
    public function destroy(string $id) {}
}
