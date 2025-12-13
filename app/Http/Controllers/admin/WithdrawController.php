<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class WithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Withdrawal::query();

        if ($request->filled('filter')) {
            $query->where('status', $request->filter);
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                  ->orWhere('details', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'LIKE', "%{$search}%")
                                ->orWhere('email', 'LIKE', "%{$search}%");
                  });
            });
        }

        $withdrawals = $query->with('user')->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.pages.withdraw.index', compact('withdrawals'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'note' => 'nullable|string|max:1000',
        ]);

        $withdraw = Withdrawal::findOrFail($id);

        if ($request->status == 'rejected' && $withdraw->status != 'rejected') {
            User::where('id', $withdraw->user_id)->increment('funding_wallet', $withdraw->amount);
        }

        $withdraw->status = $request->status;
        $withdraw->note = $request->note;
        $withdraw->save();

        return redirect()->route('admin.withdraw.index')->with('success', 'Withdrawal updated successfully.');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
