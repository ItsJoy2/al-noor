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

        $userData = [
            'name'           => $user->name,
            'email'          => $user->email,
            'mobile'         => $user->mobile,
            'email_verified' => $user->email_verified_at ? 'Verified' : 'Not Verified',
            'email_verified_badge' => $user->email_verified_at ? 'bg-success' : 'bg-danger',
            'is_block'       => $user->is_block ? 'Yes' : 'No',
            'is_block_badge' => $user->is_block ? 'bg-danger' : 'bg-success',
            'is_active'      => $user->is_active ? 'Yes' : 'No',
            'is_active_badge'=> $user->is_active ? 'bg-success' : 'bg-secondary',
            'kyc_status'     => $user->kyc_status ? 'Verified' : 'Pending',
            'kyc_status_badge'=> $user->kyc_status ? 'bg-success' : 'bg-danger',
            'rank'           => match($user->rank) {
                'rank1' => 'Land Pioneer',
                'rank2' => 'Land Baron',
                'rank3' => 'Land Magnate',
                default => 'No Rank',
            },
            'club'           => match($user->club) {
                'club1' => 'Greenfield Club',
                'club2' => 'Prime Land Club',
                'club3' => 'Elite Land Owners Club',
                default => 'No Club',
            },
            'is_director'    => $user->is_director ? 'Yes' : 'No',
            'is_director_badge' => $user->is_director ? 'bg-success' : 'bg-secondary',
            'registered'     => $user->created_at->format('d-m-Y'),

            // Investment summary
            'total_invested_amount'    => $user->investors->sum('total_amount'),
            'total_paid_amount'        => $user->investors->sum('paid_amount'),
            'total_invest_count'       => $user->investors->count(),
            'total_installment_amount' => $user->investors->where('purchase_type', 'installment')->sum('paid_amount'),
            'total_installment_count'  => $user->investors->where('purchase_type', 'installment')->count(),
        ];

        return view('admin.pages.users.show', compact('user', 'userData'));
    }


    /**
     * Update user basic info
     */

    public function update(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        $rules = [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'mobile'   => 'required|string|max:20',
            'is_block' => 'required|boolean',
        ];

        if ($request->has('is_director')) {
            $rules['is_director'] = 'required|boolean';
        }

        $validated = $request->validate($rules);

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
