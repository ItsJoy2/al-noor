<?php

namespace App\Http\Controllers\user;


use Carbon\Carbon;
use App\Models\User;
use App\Models\Deposit;
use App\Models\Investor;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class DashboardController extends Controller
{
    public function index() : view
    {
        $user = auth()->user();

        $totalDeposit = Deposit::where('user_id', $user->id)->where('status', true)->sum('amount');
        $totalWithdraw = Transactions::where('user_id', $user->id)->where('remark', 'withdrawal')->sum('amount');
        $totalTransfer = Transactions::where('user_id', $user->id)->where('remark', 'transfer')->sum('amount');
        $bonusBalance = Transactions::where('user_id', $user->id) ->where('type', '+')->whereIn('remark', ['rank_bonus', 'director_bonus', 'club_bonus', 'shareholder_bonus'])->sum('amount');


        $activeReferrals = User::where('refer_by', $user->id)->where('is_active', 1)->latest()->take(4)->get();
        $inactiveReferrals = User::where('refer_by', $user->id)->where('is_active', 0)->latest()->take(4)->get();


        $transactions = Transactions::where('user_id', $user->id)->orderBy('created_at', 'desc')->take(6)->get();


        $now = Carbon::now();
            $lastMonth = $now->copy()->subMonth();

            $totalInvestment = Investor::where('user_id', $user->id)->sum('total_amount');

            $startOfMonth = $now->copy()->startOfMonth();
            // $previousTotalInvestment = Investor::where('user_id', $user->id)
            //     ->where('start_date', '<', $startOfMonth)
            //     ->sum('amount');
            // $totalInvestmentChange = $this->calculatePercentageChange($totalInvestment, $previousTotalInvestment);

            // $totalInvestmentChangeFormatted = ($totalInvestmentChange >= 0 ? '+' : '') . number_format($totalInvestmentChange, 2) . '%';

            // $totalInvestmentSinceLastMonth = $totalInvestmentChangeFormatted;

            // $runningInvestment = Investor::where('user_id', $user->id)
            //     ->where('status', 'running')
            //     ->sum('amount');
            // $previousRunningInvestment = Investor::where('user_id', $user->id)
            //     ->where('status', 'running')
            //     ->where('start_date', '<', $startOfMonth)
            //     ->sum('amount');

            // $runningInvestmentChange = $this->calculatePercentageChange($runningInvestment, $previousRunningInvestment);
            // $runningInvestmentChangeFormatted = ($runningInvestmentChange >= 0 ? '+' : '') . number_format($runningInvestmentChange, 2) . '%';
            // $maturedInvestment = Investor::where('user_id', $user->id)
            //     ->where('status', 'completed')
            //     ->sum('amount');
            // $previousMaturedInvestment = Investor::where('user_id', $user->id)
            //     ->where('status', 'completed')
            //     ->where('start_date', '<', $startOfMonth)
            //     ->sum('amount');

            // $maturedInvestmentChange = $this->calculatePercentageChange($maturedInvestment, $previousMaturedInvestment);
            // $maturedInvestmentChangeFormatted = ($maturedInvestmentChange >= 0 ? '+' : '') . number_format($maturedInvestmentChange, 2) . '%';


            $lastWithdraw = Transactions::where('user_id', $user->id)->where('remark', 'withdrawal') ->orderBy('created_at', 'desc') ->first();
            $lastTransfer = Transactions::where('user_id', $user->id) ->where('remark', 'transfer')->orderBy('created_at', 'desc')->first();
            $lastDeposit = Deposit::where('user_id', $user->id)->where('status', true)->orderBy('created_at', 'desc')->first();

            $startDate = now()->subDays(30)->startOfDay();

            $depositsData = Deposit::where('user_id', $user->id)->where('status', true)->where('created_at', '>=', $startDate)->selectRaw('DATE(created_at) as date, SUM(amount) as total')->groupBy('date')->orderBy('date')->get();

            $transfersData = Transactions::where('user_id', $user->id)->where('remark', 'transfer')->where('created_at', '>=', $startDate)->selectRaw('DATE(created_at) as date, SUM(amount) as total')->groupBy('date')->orderBy('date')->get();

            $withdrawsData = Transactions::where('user_id', $user->id)->where('remark', 'withdrawal')->where('created_at', '>=', $startDate)->selectRaw('DATE(created_at) as date, SUM(amount) as total')->groupBy('date')->orderBy('date')->get();

            // $totalExpectedReturn = Investor::where('user_id', $user->id)->where('status', 'running')->sum('expected_return');

            $dates = collect(range(0, 29))->map(function ($days) use ($startDate)
            { return $startDate->copy()->addDays($days)->format('Y-m-d');
            })->toArray();

            $depositMap = $depositsData->pluck('total', 'date')->toArray();
            $transferMap = $transfersData->pluck('total', 'date')->toArray();
            $withdrawMap = $withdrawsData->pluck('total', 'date')->toArray();

            $depositSeries = [];
            $transferSeries = [];
            $withdrawSeries = [];

            foreach ($dates as $date) {
                $depositSeries[] = $depositMap[$date] ?? 0;
                $transferSeries[] = $transferMap[$date] ?? 0;
                $withdrawSeries[] = $withdrawMap[$date] ?? 0;
            }



        $dashboard = [
            'totalDeposit' => $totalDeposit,
            'totalWithdraw'   => $totalWithdraw,
            'totalTransfer'   => $totalTransfer,
            'bonusBalance'  => $bonusBalance,
            'totalInvestment' => $totalInvestment,
            // 'runningInvestment' => $runningInvestment,
            // 'maturedInvestment' => $maturedInvestment,
            // 'totalInvestmentChange' => $totalInvestmentChangeFormatted,
            // 'runningInvestmentChange' => $runningInvestmentChangeFormatted,
            // 'maturedInvestmentChange' => $maturedInvestmentChangeFormatted,
            // 'totalInvestmentSinceLastMonth' => $totalInvestmentChangeFormatted,
            // 'runningInvestmentSinceLastMonth' => $runningInvestmentChangeFormatted,
            // 'maturedInvestmentSinceLastMonth' => $maturedInvestmentChangeFormatted,
            'lastWithdraw' => $lastWithdraw,
            'lastTransfer' => $lastTransfer,
            'lastDeposit' => $lastDeposit,
            'chartDates' => $dates,
            'chartDeposits' => $depositSeries,
            'chartTransfers' => $transferSeries,
            'chartWithdraws' => $withdrawSeries,
            'transactions' => $transactions,
            'activeReferrals' => $activeReferrals,
            'inactiveReferrals' => $inactiveReferrals,
            // 'totalExpectedReturn' => $totalExpectedReturn,

         ];

        return view ('user.pages.dashboard', compact('user', 'dashboard' ));
    }
    private function calculatePercentageChange($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }
        return (($current - $previous) / $previous) * 100;
    }
}
