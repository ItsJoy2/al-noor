<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\PoolWallet;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PoolDistributionController extends Controller
{
    // Human-readable names for ranks and clubs
    private $rankNames = [
        'rank1' => 'Land Pioneer',
        'rank2' => 'Land Baron',
        'rank3' => 'Land Magnate',
    ];

    private $clubNames = [
        'club1' => 'Greenfield Club',
        'club2' => 'Prime Land Club',
        'club3' => 'Elite Land Owners Club',
    ];

    //  Show Pool Distribution Page
    public function index()
    {
        $pool = PoolWallet::first();
        if (!$pool) {
            $pool = new PoolWallet([
                'rank' => 0,
                'club' => 0,
                'shareholder' => 0,
                'director' => 0,
            ]);
        }

        return view('admin.pages.distribute.index', compact('pool'));
    }

    // RANK POOL
    public function distributeRankPool()
    {
        DB::transaction(function () {
            $pool = DB::table('pool_wallets')->lockForUpdate()->first();
            if (!$pool || $pool->rank <= 0) return;

            $settings = DB::table('bonus_settings')->first();
            $totalPool = $pool->rank;

            $this->distributeByRank('rank1', $settings->rank1_percent, $totalPool);
            $this->distributeByRank('rank2', $settings->rank2_percent, $totalPool);
            $this->distributeByRank('rank3', $settings->rank3_percent, $totalPool);

            DB::table('pool_wallets')->update(['rank' => 0]);
        });

        return back()->with('success', 'Rank Bonus distributed successfully');
    }

    private function distributeByRank($rank, $percent, $totalPool)
    {
        $users = User::where('rank', $rank)->where('is_active', true)->get();
        if ($users->count() === 0) return;

        $amount = ($totalPool * $percent) / 100;
        $perUser = $amount / $users->count();

        foreach ($users as $user) {
            $user->increment('bonus_wallet', $perUser);

            Transactions::create([
                'transaction_id' => Transactions::generateTransactionId(),
                'user_id' => $user->id,
                'amount' => $perUser,
                'remark' => 'rank_bonus',
                'type' => '+',
                'status' => 'Completed',
                'details' => "Added from Rank Bonus ({$this->rankNames[$rank]})",
                'charge' => 0,
            ]);
        }
    }

    //CLUB POOL
    public function distributeClubPool()
    {
        DB::transaction(function () {
            $pool = DB::table('pool_wallets')->lockForUpdate()->first();
            if (!$pool || $pool->club <= 0) return;

            $settings = DB::table('bonus_settings')->first();
            $totalPool = $pool->club;

            $this->distributeByClub('club1', $settings->club1_percent, $totalPool);
            $this->distributeByClub('club2', $settings->club2_percent, $totalPool);
            $this->distributeByClub('club3', $settings->club3_percent, $totalPool);

            DB::table('pool_wallets')->update(['club' => 0]);
        });

        return back()->with('success', 'Club Bonus distributed successfully');
    }

    private function distributeByClub($club, $percent, $totalPool)
    {
        $users = User::where('club', $club)->where('is_active', true)->get();
        if ($users->count() === 0) return;

        $amount = ($totalPool * $percent) / 100;
        $perUser = $amount / $users->count();

        foreach ($users as $user) {
            $user->increment('bonus_wallet', $perUser);

            Transactions::create([
                'transaction_id' => Transactions::generateTransactionId(),
                'user_id' => $user->id,
                'amount' => $perUser,
                'remark' => 'club_bonus',
                'type' => '+',
                'status' => 'Completed',
                'details' => "Added from Club Bonus ({$this->clubNames[$club]})",
                'charge' => 0,
            ]);
        }
    }

    // SHAREHOLDER POOL
    public function distributeShareholderPool()
    {
        DB::transaction(function () {
            $pool = DB::table('pool_wallets')->lockForUpdate()->first();
            if (!$pool || $pool->shareholder <= 0) return;

            $users = User::where('is_shareholder', true)->where('is_active', true)->get();
            if ($users->count() === 0) return;

            $perUser = $pool->shareholder / $users->count();

            foreach ($users as $user) {
                $user->increment('bonus_wallet', $perUser);

                Transactions::create([
                    'transaction_id' => Transactions::generateTransactionId(),
                    'user_id' => $user->id,
                    'amount' => $perUser,
                    'remark' => 'shareholder_bonus',
                    'type' => '+',
                    'status' => 'Completed',
                    'details' => "Added from Shareholder Bonus",
                    'charge' => 0,
                ]);
            }

            DB::table('pool_wallets')->update(['shareholder' => 0]);
        });

        return back()->with('success', 'Shareholder Bonus distributed successfully');
    }

    //DIRECTOR POOL
    public function distributeDirectorPool()
    {
        DB::transaction(function () {
            $pool = DB::table('pool_wallets')->lockForUpdate()->first();
            if (!$pool || $pool->director <= 0) return;

            $users = User::where('is_director', true)->where('is_active', true)->get();
            if ($users->count() === 0) return;

            $perUser = $pool->director / $users->count();

            foreach ($users as $user) {
                $user->increment('bonus_wallet', $perUser);

                Transactions::create([
                    'transaction_id' => Transactions::generateTransactionId(),
                    'user_id' => $user->id,
                    'amount' => $perUser,
                    'remark' => 'director_bonus',
                    'type' => '+',
                    'status' => 'Completed',
                    'details' => "Added from Director Bonus",
                    'charge' => 0,
                ]);
            }

            DB::table('pool_wallets')->update(['director' => 0]);
        });

        return back()->with('success', 'Director Bonus distributed successfully');
    }
}
