<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Deposit;
use App\Models\Founder;
use App\Models\Invoice;
use App\Models\Investor;
use Illuminate\View\View;
use App\Models\PoolWallet;
use App\Models\Transactions;
use App\Models\withdraw_settings;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class AdminDashboardController extends Controller
{
    public function index(): View
    {

        $dashboardData = Cache::remember('admin_dashboard_data', now()->hour(1), function () {
            
            $totalShares = 20000;
            $totalSoldShares = Investor::sum('quantity');
            $installmentShares = Investor::where('purchase_type', 'installment')->sum('quantity');

            $withdrawSettings = withdraw_settings::first();
            $chargePercent = $withdrawSettings ? $withdrawSettings->charge : 0;
            $totalNetWithdrawals = Transactions::where('remark', 'withdrawal')->where('status', 'Completed')->sum('amount');
            $withdrawChargeAmount = $chargePercent > 0 ? $totalNetWithdrawals * $chargePercent / (100 - $chargePercent) : 0;
            return [

                // user
                'totalUser' => User::where('role', 'user')->count(),
                'activeUser' => User::where('is_active', 1)->where('role', 'user')->count(),
                'blockUser' => User::where('is_block', 1)->where('role', 'user')->count(),
                'newUser' => User::where('created_at', '>=', now()->startOfDay()->addHours(5))->where('role', 'user')->count(),

                // deposit

                'totalDeposit' => Deposit::where('status', 'approved')->sum('amount'),
                'pendingDeposit' => Deposit::where('status', 'pending')->sum('amount'),
                'todayDeposit' => Deposit::where('status', 'approved')->whereDate('created_at', today())->sum('amount'),
                'last30DaysDeposit' => Deposit::where('status', 'approved')->whereBetween('created_at', [now()->subDays(30), now()])->sum('amount'),


                // pool Wallet
                'poolRank'        => PoolWallet::sum('rank'),
                'poolClub'        => PoolWallet::sum('club'),
                'poolShareholder' => PoolWallet::sum('shareholder'),
                'poolDirector'    => PoolWallet::sum('director'),


                // withdrawal
                'totalWithdrawals' => Transactions::where('remark', 'withdrawal')->where('status', 'Completed')->sum('amount'),
                'todayWithdrawals' => Transactions::where('remark', 'withdrawal')->where('status', 'Completed')->whereDate('created_at', today())->sum('amount'),
                'last30DaysWithdrawals' => Transactions::where('remark', 'withdrawal')->where('status', 'Completed')->whereBetween('created_at', [now()->subDays(30), today()])->sum('amount'),
                'withdrawChargeAmount' => $withdrawChargeAmount,

                // Investment
                'totalFullPayment'       => Investor::where('purchase_type', 'full')->sum('total_amount'),
                'totalInstallmentBuy'    => Investor::where('purchase_type', 'installment')->sum('total_amount'),
                'totalInstallmentPaid'   => Investor::where('purchase_type', 'installment')->sum('paid_amount'),
                'totalPendingInvoice'    => Invoice::where('status', 'pending')->sum('amount'),

                'totalShares'        => $totalShares,
                'totalSoldShares'    => $totalSoldShares,
                'remainingShares'    => $totalShares - $totalSoldShares,
                'installmentShares'  => $installmentShares,


            ];
        });

        return view('admin.dashboard', compact('dashboardData'));
    }
}
