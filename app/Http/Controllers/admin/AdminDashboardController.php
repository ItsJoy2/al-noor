<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\View\View;
use App\Models\Transactions;
use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Founder;
use App\Models\Investor;
use App\Models\withdraw_settings;
use Illuminate\Support\Facades\Cache;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $dashboardData = Cache::remember('admin_dashboard_data', now()->hour(1), function () {

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
                'totalDeposits' => Deposit::where('status', 1)->sum('amount'),
                'todayDeposits' => Deposit::where('status', 1)->whereDate('created_at', today())->sum('amount'),
                'last7DaysDeposits' => Deposit::where('status', 1)->whereBetween('created_at', [now()->subDays(7), today()])->sum('amount'),
                'last30DaysDeposits' => Deposit::where('status', 1)->whereBetween('created_at', [now()->subDays(30), today()])->sum('amount'),

                // withdrawal
                'totalWithdrawals' => Transactions::where('remark', 'withdrawal')->where('status', 'Completed')->sum('amount'),
                'todayWithdrawals' => Transactions::where('remark', 'withdrawal')->where('status', 'Completed')->whereDate('created_at', today())->sum('amount'),
                'last30DaysWithdrawals' => Transactions::where('remark', 'withdrawal')->where('status', 'Completed')->whereBetween('created_at', [now()->subDays(30), today()])->sum('amount'),
                'withdrawChargeAmount' => $withdrawChargeAmount,

                // Investment
                'totalInvestmentAmount'   => Investor::sum('amount'),
                'runningInvestmentAmount' => Investor::where('status', 'running')->sum('amount'),
                'canceledInvestmentAmount' => Investor::where('status', 'cancelled')->sum('amount'),
                'expiredInvestmentAmount' => Investor::where('status', 'completed')->sum('amount'),



            ];
        });

        return view('admin.dashboard', compact('dashboardData'));
    }
}
