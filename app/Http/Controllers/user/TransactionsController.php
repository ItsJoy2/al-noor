<?php

namespace App\Http\Controllers\user;

use App\Models\User;
use App\Models\Withdrawal;
use App\Models\Transactions;
use Illuminate\Http\Request;
use App\Models\TransferSetting;
use App\Models\WithdrawSetting;
use Illuminate\Support\Facades\DB;
use App\Service\TransactionService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class TransactionsController extends Controller
{
    protected TransactionService $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function transactions(Request $request)
    {
        $keyword = $request->get('keyword');

        $allowedTypes = ['transfer', 'convert', 'level_bonus', 'director_bonus', 'shareholder_bonus', 'club_bonus', 'rank_bonus'];

        $query = Transactions::where('user_id', $request->user()->id)
                            ->whereIn('remark', $allowedTypes);

        if ($keyword && in_array($keyword, $allowedTypes)) {
            $query->where('remark', $keyword);
        }

        $transactions = $query->orderBy('id', 'desc')->paginate(15);

        return view('user.pages.transactions.index', compact('transactions', 'keyword'));
    }

    public function showWithdrawForm()
    {
        $withdrawSettings = WithdrawSetting::first();
        return view('user.pages.withdraw.index', compact('withdrawSettings'));
    }

    public function withdraw(Request $request)
    {
        $user = auth()->user();

        if(!$user->kyc_status) {
            return back()->with('error', 'You must complete KYC verification before request for a withdrawal.');
        }

        $settings = WithdrawSetting::first();

        $request->validate([
            'amount' => 'required|numeric|min:' . $settings->min_withdraw . '|max:' . $settings->max_withdraw,
            'method' => 'required|in:bkash,nagad,bank,crypto',
        ]);

        $details = [];

        if($request->method === 'bkash' || $request->method === 'nagad') {
            $request->validate([
                'account' => 'required|regex:/^\d+$/',
            ]);
            $details['account'] = $request->account;

        } elseif($request->method === 'bank') {
            $request->validate([
                'details.bank_name' => 'required|string|max:255',
                'details.account_number' => 'required|regex:/^\d+$/',
            ]);
            $details = $request->details;

        } elseif($request->method === 'crypto') {
            $request->validate([
                'details.wallet_address' => 'required|string|max:255',
                'details.network' => 'required|string|max:50',
            ]);
            $details = $request->details;
        }

        if($user->funding_wallet < $request->amount) {
            return back()->with('error', 'Insufficient balance in Funding Wallet.');
        }

        DB::transaction(function() use ($user, $request, $settings, $details) {
            $amount = $request->amount;
            $charge = ($settings->charge / 100) * $amount;
            $netAmount = $amount - $charge;

            $user->funding_wallet -= $amount;
            $user->save();

            Withdrawal::create([
                'user_id' => $user->id,
                'method' => $request->method,
                'amount' => $amount,
                'charge' => $charge,
                'total_amount' => $netAmount,
                'details' => $details,
                'status' => 'pending',
            ]);
        });

        return back()->with('success', 'Withdrawal request has been successfully submitted.');
    }
    public function withdrawalHistory()
    {
        $withdrawals = auth()->user()->withdrawals()->latest()->paginate(10);
        return view('user.pages.withdraw.histories', compact('withdrawals'));
    }

    // public function withdraw(Request $request)
    // {
    //     $withdrawSettings = withdraw_settings::first();

    //     if (!$withdrawSettings) {
    //         return back()->with('error', 'Withdraw settings not found.');
    //     }

    //     if ($withdrawSettings->status == 0) {
    //         return back()->with('error', 'Withdrawals are temporarily disabled. Please contact support.');
    //     }

    //     $user = $request->user();
    //     if ($user->is_block == 1) {
    //         return back()->with('error', 'Your account is blocked. Please contact admin.');
    //     }

    //     $min = $withdrawSettings->min_withdraw;
    //     $max = $withdrawSettings->max_withdraw;
    //     $charge = $withdrawSettings->charge;

    //     $validatedData = $request->validate([
    //         'amount' => ['required', 'numeric', "min:$min", "max:$max"],
    //         'wallet' => ['required', 'string', 'min:10', 'max:70'],
    //     ]);

    //     $amount = $validatedData['amount'];
    //     $chargeAmount = $amount * $charge / 100;
    //     $finalAmount = $amount - $chargeAmount;
    //     $wallet = $validatedData['wallet'];

    //     if ($user->spot_wallet < $amount) {
    //         return back()->with('error', 'Insufficient balance.');
    //     }

    //     $response = Http::post('https://evm.blockmaster.info/api/payout', [
    //         'amount' => $finalAmount,
    //         'type' => 'native',
    //         'to' => $wallet,
    //         // 'token_address' => env('TOKEN'),
    //         'chain_id' => env('CHAIN_ID'),
    //         'rpc_url' => env('RPC'),
    //         'user_id' => 14,
    //     ]);

    //     $response = json_decode($response->body());

    //     if ($response && $response->status && $response->txHash != null) {

    //         $this->transactionService->addNewTransaction(
    //             $user->id,
    //             $finalAmount,
    //             'withdrawal',
    //             '-',
    //             "{$response->txHash}",
    //             'Completed',
    //             $chargeAmount
    //         );

    //         $user->spot_wallet -= $amount;
    //         $user->save();

    //         return redirect()->route('user.withdraw.index')->with('success', 'Withdrawal successful.');
    //     }

    //     return back()->with('error', 'Withdrawal failed, please contact support.');
    // }

    public function showTransferForm()
    {
        $transferSettings = TransferSetting::first();
        return view('user.pages.transfer.index', compact('transferSettings'));
    }

    public function transfer(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric',
            'email'  => 'required|exists:users,email',
        ]);

        $sender = $request->user();
        $receiver = User::where('email', $validated['email'])->first();

        if ($sender->id === $receiver->id) {
            return redirect()->back()->with('error', "You cannot transfer to yourself");
        }

        if ($sender->is_block == 1) {
            return redirect()->back()->with('error', "Your account is blocked by admin.");
        }

        $setting = TransferSetting::first();
        if (!$setting || $setting->status == 0) {
            return redirect()->back()->with('error', "Transfer is currently disabled by Admin");
        }

        if ($validated['amount'] < $setting->min_transfer) {
            return redirect()->back()->with('error', "Minimum transfer amount is {$setting->min_transfer}");
        }

        if ($validated['amount'] > $setting->max_transfer) {
            return redirect()->back()->with('error', "Maximum transfer amount is {$setting->max_transfer}");
        }

        if ($sender->funding_wallet < $validated['amount']) {
            return redirect()->back()->with('error', "You don't have enough balance in Funding Wallet");
        }

        DB::beginTransaction();

        try {
            $sender->decrement('funding_wallet', $validated['amount']);
            $receiver->increment('funding_wallet', $validated['amount']);

            Transactions::create([
                'transaction_id' => Transactions::generateTransactionId(),
                'user_id'        => $sender->id,
                'amount'         => $validated['amount'],
                'wallet_type'    => 'funding_wallet',
                'type'           => '-',
                'status'         => 'Completed',
                'details'        => "Transfer to {$receiver->email}",
                'remark'         => 'transfer',
            ]);

            Transactions::create([
                'transaction_id' => Transactions::generateTransactionId(),
                'user_id'        => $receiver->id,
                'amount'         => $validated['amount'],
                'wallet_type'    => 'funding_wallet',
                'type'           => '+',
                'status'         => 'Completed',
                'details'        => "Received from {$sender->email}",
                'remark'         => 'transfer',
            ]);

            DB::commit();

            return redirect()->back()->with('success', "Transfer successful to  $receiver->email");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', "Transaction failed: " . $e->getMessage());
        }
    }

    public function showConvertForm()
    {
        $user = auth()->user();
        return view('user.pages.convert.index', compact('user'));
    }
public function convert(Request $request)
{
    $request->validate([
        'amount' => 'required|numeric|min:1',
    ]);

    $user = auth()->user();

    if (!$user->kyc_status) {
        return back()->with('error', 'You cannot convert wallet amounts until your KYC is verified.');
    }

    if ($user->bonus_wallet < $request->amount) {
        return back()->with('error', 'Insufficient bonus wallet balance.');
    }

    DB::transaction(function () use ($user, $request) {

        $amount = $request->amount;

        $user->bonus_wallet   -= $amount;
        $user->funding_wallet += $amount;
        $user->save();

        Transactions::create([
            'transaction_id' => Transactions::generateTransactionId(),
            'user_id'        => $user->id,
            'amount'         => $amount,
            'remark'         => 'convert',
            'type'           => '+',
            'status'         => 'Completed',
            'details'        => 'Converted from bonus wallet to funding wallet',
            'charge'         => 0,
        ]);
    });

    return back()->with('success', 'Bonus wallet amount successfully converted to funding wallet.');
}




}
