<?php

namespace App\Http\Controllers\admin;

use App\Models\Package;
use App\Models\Category;
use App\Models\Investor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class PlansController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages = Package::paginate(10);
        return view('admin.pages.plan.index', compact('packages'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
        {
            return view('admin.pages.plan.create');
        }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'share_name'           => 'required|string|max:255',
            'amount'               => 'required|numeric|min:0',
            'total_share_quantity' => 'required|integer|min:1',
            'per_purchase_limit'   => 'required|integer|min:1',
            'first_installment'    => 'nullable|numeric|min:0',
            'monthly_installment'  => 'nullable|numeric|min:0',
            'installment_months'   => 'nullable|integer|min:0',
            'status'               => 'required|in:active,inactive',
        ]);

        $data = $request->only([
            'share_name',
            'amount',
            'total_share_quantity',
            'per_purchase_limit',
            'first_installment',
            'monthly_installment',
            'installment_months',
            'status'
        ]);

        Package::create($data);

        return redirect()->route('admin.plans.index')->with('success', 'Share Package created successfully.');
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
    public function edit($id)
    {
        $plan = Package::findOrFail($id);

        return view('admin.pages.plan.edit', compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'share_name'            => 'required|string|max:255',
            'amount'                => 'required|numeric|min:0',
            'total_share_quantity'  => 'required|integer|min:1',
            'per_purchase_limit'    => 'required|integer|min:1',
            'first_installment'     => 'nullable|numeric|min:0',
            'monthly_installment'   => 'nullable|numeric|min:0',
            'installment_months'    => 'nullable|integer|min:0',
            'status'                => 'required|in:active,inactive',
        ]);

        $package = Package::findOrFail($id);

        $package->update($request->only([
            'share_name',
            'amount',
            'total_share_quantity',
            'per_purchase_limit',
            'first_installment',
            'monthly_installment',
            'installment_months',
            'status',
        ]));

        return redirect()->route('admin.plans.index')
                        ->with('success', 'Package updated successfully.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $items = Package::findorfail($id);
        $items->delete();
        $this->clearPackageCache();
        return back()->with('success', 'Item has been deleted');
    }

    private function clearPackageCache()
    {
        $filters = ['active', 'inactive', null];
        for ($page = 1; $page <= 10; $page++) {
            foreach ($filters as $filter) {
                $key = "packages_{$filter}_page_{$page}";
                Cache::forget($key);
            }
        }
    }


    public function allInvestment(Request $request)
    {
        $query = Investor::with(['user', 'package']);

            if ($request->filled('email')) {
                $query->whereHas('user', function ($q) use ($request) {
                    $q->where('email', 'like', "%{$request->email}%");
                });
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            $investors = $query->latest()->paginate(15);

            return view('admin.pages.investment.index', compact('investors'));
    }

}
