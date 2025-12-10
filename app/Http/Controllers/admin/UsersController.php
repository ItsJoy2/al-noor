<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Transactions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        $search = $request->search;

         $query = User::query()->where('role', 'user')->with('referredBy')->withSum('investors', 'amount');

        if ($filter) {
            switch ($filter) {
                case 'blocked':
                    $query->where('is_block', 1);
                    break;
                case 'unblocked':
                    $query->where('is_block', 0);
                    break;
                case 'active':
                    $query->where('is_active', 1);
                    break;
                case 'inactive':
                    $query->where('is_active', 0);
                    break;
            }
        }

        if (!empty($search)) {
            $query->where('email', 'like', '%' . $search . '%');
        }

        $users = $query->orderByDesc('id')->paginate(10);

        return view('admin.pages.users.index', compact('users'));
    }


    public function show($id)
    {
        $user = User::with(['referredBy', 'investors'])->findOrFail($id);

        return view('admin.pages.users.show', compact('user'));
    }
    public function update(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'mobile'   => 'required|string|max:20',
            'is_block' => 'required|boolean',
        ]);

        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->mobile   = $request->mobile;
        $user->is_block = $request->is_block;

        $user->save();

        return redirect()->back()->with('success', 'User updated successfully!');
    }

    public function updateWallet(Request $request)
    {
        $request->validate([
            'user_id'     => 'required|exists:users,id',
            'wallet_type' => 'required|in:funding_wallet,spot_wallet,token_wallet',
            'action_type' => 'required|in:add,subtract',
            'amount'      => 'required|numeric|min:0.01',
        ]);

        $user = User::findOrFail($request->user_id);
        $wallet = $request->wallet_type;
        $amount = $request->amount;

        if (!in_array($wallet, ['funding_wallet', 'spot_wallet', 'token_wallet'])) {
            return redirect()->back()->with('error', 'Invalid wallet type selected.');
        }

        if ($request->action_type === 'add') {
            $user->$wallet += $amount;
        } elseif ($request->action_type === 'subtract') {
            if ($user->$wallet < $amount) {
                return redirect()->back()->with('error', 'Insufficient balance in selected wallet.');
            }
            $user->$wallet -= $amount;
        }

        $user->save();

        return redirect()->back()->with('success', 'Wallet updated successfully.');
    }

}
