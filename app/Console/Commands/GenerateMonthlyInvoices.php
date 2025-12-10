<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Investor;
use App\Models\Invoice;
use App\Models\BonusSetting;
use Illuminate\Support\Str;
use Carbon\Carbon;

class GenerateMonthlyInvoices extends Command
{
    protected $signature = 'invoices:generate-monthly';
    protected $description = 'Generate monthly invoices for installment investors and deactivate if pending exceeds max';

    public function handle()
    {
        $today = Carbon::now();
        $settings = BonusSetting::first();
        $maxPending = $settings->max_pending_installments ?? 3;

        $investors = Investor::where('purchase_type', 'installment')->get();

        foreach ($investors as $investor) {

            // Check current pending invoices
            $pendingCount = Invoice::where('investor_id', $investor->id)
                ->where('status', 'pending')
                ->count();

            if ($pendingCount >= $maxPending) {
                // Inactive investor if pending invoices exceed max
                if ($investor->status !== 'inactive') {
                    $investor->status = 'inactive';
                    $investor->save();
                    $this->info("Investor ID {$investor->id} set to inactive due to {$pendingCount} pending invoices");
                }
                continue; // Skip generating new invoices for inactive investor
            }

            // Only generate invoices for active investors
            if ($investor->status !== 'active') {
                continue;
            }

            $package = $investor->package;

            // Skip if all installments are already paid
            if ($investor->paid_installments >= $package->installment_months) {
                continue;
            }

            // Check if invoice already exists for this month
            $existingInvoice = Invoice::where('investor_id', $investor->id)
                ->whereMonth('created_at', $today->month)
                ->whereYear('created_at', $today->year)
                ->first();

            if (!$existingInvoice) {
                $defaultAmount = $package->monthly_installment * $investor->quantity;

                // Calculate remaining amount
                $remainingAmount = $investor->total_amount - $investor->paid_amount;

                // Invoice amount should not exceed remaining amount
                $invoiceAmount = min($defaultAmount, $remainingAmount);

                Invoice::create([
                    'invoice_no' => Str::uuid(),
                    'user_id' => $investor->user_id,
                    'investor_id' => $investor->id,
                    'amount' => $invoiceAmount,
                    'type' => 'installment',
                    'status' => 'pending',
                ]);

                $this->info("Invoice created for Investor ID {$investor->id} with amount {$invoiceAmount}");
            }
        }

        $this->info('Monthly invoices processed successfully.');
    }
}
