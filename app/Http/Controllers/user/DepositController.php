<?php

namespace App\Http\Controllers\user;

use Carbon\Carbon;
use App\Models\User;
use GuzzleHttp\Client;
use App\Models\Deposit;
use App\Models\Transactions;
use Illuminate\Http\Request;
use App\Models\UserWalletData;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Service\TransactionService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;

class DepositController extends Controller
{

    public function index()
    {
        return view ('user.pages.deposit.index');
    }
    public function showInvoice($invoice_id)
    {
        // Fetch local deposit data using invoice_id (transaction_id)
        $deposit = Deposit::where('transaction_id', $invoice_id)->first();

        if (!$deposit) {
            abort(404, "Deposit record not found.");
        }

        // Return view with only deposit data
        return view('user.pages.deposit.invoice', [
            'deposit' => $deposit,
        ]);
    }

    public function Store(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'wallet' => 'required',
            'amount' => 'required|numeric|min:10',
        ]);

        $client = new Client();

        $headers = [
            'x-api-key'      => '9S3WW3P-JRB43DN-PBCJ23E-P9W96H3',
            'Content-Type'   => 'application/json',
        ];

        $payload = [
            "amount"          => $request->amount,
            "chain_id"        => 9996,
            "type"            => "native",
            "token_name"      => "MIND",
            "user_id"         => 14,
            // "contract_address"=> "0x55d398326f99059ff775485246999027b3197955",
            "webhook_url"     => "https://yeeo.finance/api/deposit-check",
        ];

        $payment = $client->request('POST', 'https://evm.blockmaster.info/api/create_invoice', [
            'headers' => $headers,
            'json'    => $payload
        ]);

        $response = json_decode($payment->getBody()->getContents(), true);


        $deposit = new Deposit();
        $deposit->user_id       = $user->id;
        $deposit->amount        = $request->amount;
        $deposit->wallet        = $request->wallet;
        $deposit->transaction_id= $response['data']['invoice_id'];
        $deposit->save();


        return redirect()->route('user.deposit.invoice', ['invoice_id' => $response['data']['invoice_id']]);

    }
    public function webHook(Request $request){
        $data = $request->input();

        if (isset($data['status']) && ($data['status'] === true || $data['status'] === "completed")) {

            $invoice = new Deposit();

            $customerData = $invoice->where('transaction_id', $data['invoice_id'])->where('status', 0)->first();

            if(!$customerData){
                return "no data";
            }

            $customerData->amount = $data['amount'];
            $customerData->status = 1;
            $customerData->save();

            $user = User::where('id', $customerData->user_id)->first();
            if ($customerData->wallet == "funding"){
                $user->funding_wallet += $data['amount'];
                $user->save();


            return response()->json([
                'success' => true,
                'message' => 'Deposit added successfully.',
                'deposit_id' => $customerData->id
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Deposit not added, status is false.'
        ]);
    }
    }

    public function history(Request $request)
    {
        $user = $request->user();

        $deposits = Deposit::where('user_id', $user->id)
            ->where('status', true)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('user.pages.deposit.histories', compact('deposits'));
    }

}
