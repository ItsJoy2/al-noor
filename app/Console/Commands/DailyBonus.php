<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Investor;
use App\Models\Transactions;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Scheduling\Schedule;

class DailyBonus extends Command
{
    protected $signature = 'investment:daily-bonus';

    protected $description = 'Distribute daily/monthly returns to users and referral bonuses';

    public function handle()
    {
        $now = Carbon::now()->toDateString();

        $investments = Investor::where('status', 'running')
            ->where('next_return_date', '<=', $now)
            ->get();

        foreach ($investments as $investment) {
            DB::beginTransaction();

            try {
                $user = User::find($investment->user_id);
                $package = $investment->package;

                if (!$user || !$package) {
                    DB::rollBack();
                    continue;
                }
                // main user bonus
                // $dailyReturn = round(
                //     ($investment->amount * ($package->pnl_return / 100)),
                //     8
                // );

                $dailyReturn = round($investment->expected_return, 8);

                $user->increment('spot_wallet', $dailyReturn);

                Transactions::create([
                    'transaction_id' => Transactions::generateTransactionId(),
                    'user_id' => $user->id,
                    'amount' => $dailyReturn,
                    'remark' => "daily_pnl",
                    'type' => '+',
                    'status' => 'Paid',
                    'details' => ucfirst($investment->return_type) . " Bonus from investment Plan: {$package->plan_name}",
                    'charge' => 0,
                ]);

                // Referral return bonus
                if ($user->refer_by) {
                    $referrer = User::find($user->refer_by);

                    if ($referrer) {
                        $referral_bonus = round($dailyReturn * ($investment->referral_bonus / 100), 8);
                        $referrer->increment('spot_wallet', $referral_bonus);

                        Transactions::create([
                            'transaction_id' => Transactions::generateTransactionId(),
                            'user_id' => $referrer->id,
                            'amount' => $referral_bonus,
                            'remark' => "pnl_bonus",
                            'type' => '+',
                            'status' => 'Paid',
                            'details' => "PNL bonus from referral user {$user->name}",
                            'charge' => 0,
                        ]);
                    }
                }

                $investment->received_count += 1;

                if ($package->duration > 0 && $investment->received_count >= $investment->duration) {
                    $investment->status = 'completed';
                } else {
                    $investment->next_return_date = $investment->return_type === 'daily'
                        ? Carbon::parse($investment->next_return_date)->addDay()
                        : Carbon::parse($investment->next_return_date)->addMonth();
                }

                $investment->save();

                DB::commit();

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Return distribution failed: ' . $e->getMessage());
                continue;
            }
        }

        $this->info('Returns distributed successfully.');
    }

    public function schedule(Schedule $schedule): void
    {
        $schedule->daily();
    }
}
