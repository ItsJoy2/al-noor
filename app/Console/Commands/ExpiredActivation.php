<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use App\Models\ActivationSetting;

class ExpiredActivation extends Command
{
    protected $signature = 'accounts:activation-expired';
    protected $description = 'Active accounts that have expired based on activation duration';

    public function handle()
    {
        $settings = ActivationSetting::first();
        if (!$settings || !$settings->activation_duration_months) {
            $this->info('No activation duration set in settings.');
            return 0;
        }

        $duration = $settings->activation_duration_months;

        $expiredUsers = User::where('is_active', true)
            ->whereNotNull('last_activated_at')
            ->where('last_activated_at', '<', now()->subMonths($duration))
            ->get();

        foreach ($expiredUsers as $user) {
            $user->update(['is_active' => false]);
            $this->info("User ID {$user->id} has been inactivated.");
        }

        $this->info("Total expired users processed: " . $expiredUsers->count());

        return 0;
    }
}
