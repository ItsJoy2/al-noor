<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * Display user list with filters & search
     */
    public function index(Request $request)
    {
        $query = User::query()
            ->where('role', 'user')
            ->with(['referredBy'])
            ->withSum('investors', 'paid_amount');

        // --- Filter ---
        if ($request->filled('filter')) {
            $query->when($request->filter == 'blocked', fn($q) => $q->where('is_block', 1))
                ->when($request->filter == 'unblocked', fn($q) => $q->where('is_block', 0))
                ->when($request->filter == 'active', fn($q) => $q->where('is_active', 1))
                ->when($request->filter == 'inactive', fn($q) => $q->where('is_active', 0));
        }

        // --- Search by email ---
        if ($request->filled('search')) {
            $query->where('email', 'like', "%" . $request->search . "%");
        }

        $users = $query->orderByDesc('id')->paginate(10);

        return view('admin.pages.users.index', compact('users'));
    }

    /**
     * Show single user
     */
    public function show($id)
    {
        $user = User::with(['referredBy', 'investors'])->findOrFail($id);
        return view('admin.pages.users.show', compact('user'));
    }

    /**
     * Update user basic info
     */
    public function update(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'mobile'   => 'required|string|max:20',
            'is_block' => 'required|boolean',
        ]);

        $user->update($validated);

        return back()->with('success', 'User updated successfully!');
    }

    /**
     * Admin wallet update
     */
    public function updateWallet(Request $request)
    {
        $request->validate([
            'user_id'     => 'required|exists:users,id',
            'wallet_type' => 'required|in:funding_wallet,bonus_wallet',
            'action_type' => 'required|in:add,subtract',
            'amount'      => 'required|numeric|min:0.00000001',
        ]);

        $user   = User::findOrFail($request->user_id);
        $wallet = $request->wallet_type;
        $amount = (float)$request->amount;

        if ($request->action_type === 'add') {
            $user->$wallet = bcadd($user->$wallet, $amount, 8);
        } else { 
            if (bccomp($user->$wallet, $amount, 8) < 0) {
                return back()->with('error', 'Insufficient balance in the selected wallet.');
            }
            $user->$wallet = bcsub($user->$wallet, $amount, 8);
        }

        $user->save();

        return back()->with('success', ucfirst(str_replace('_', ' ', $wallet)) . ' updated successfully.');
    }

}
