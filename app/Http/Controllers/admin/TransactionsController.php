<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Transactions;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $allowedRemarks = [
            'transfer',
            'convert',
            'level_bonus',
            'director_bonus',
            'shareholder_bonus',
            'club_bonus',
            'rank_bonus'
        ];

        $query = Transactions::with('user')
            ->whereIn('remark', $allowedRemarks)
            ->orderBy('id', 'DESC');

        if ($request->filled('email')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('email', 'like', '%' . $request->email . '%');
            });
        }

        if ($request->filled('remark') && in_array($request->remark, $allowedRemarks)) {
            $query->where('remark', $request->remark);
        }

        $transactions = $query->latest()->paginate(10);

        return view('admin.pages.transactions', compact('transactions'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
