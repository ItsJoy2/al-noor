<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\DepositMethod;
use App\Http\Controllers\Controller;

class DepositMethodController extends Controller
{
    public function index()
    {
        $methods = DepositMethod::paginate(10);
        return view('admin.pages.deposit-method.index', compact('methods'));
    }

    public function create()
    {
        return view('admin.pages.deposit-method.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:mobile_banking,bank,crypto',
            'details' => 'nullable|array',
        ]);

        DepositMethod::create([
            'name' => $request->name,
            'type' => $request->type,
            'details' => $request->details,
            'status' => $request->status ?? true,
        ]);

        return redirect()->route('admin.deposit_methods.index')->with('success', 'Deposit method added!');
    }

    public function edit($id)
    {
        $method = DepositMethod::findOrFail($id);
        return view('admin.pages.deposit-method.edit', compact('method'));
    }

    public function update(Request $request, DepositMethod $depositMethod)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:mobile_banking,bank,crypto',
            'details' => 'nullable|array',
        ]);

        $depositMethod->update([
            'name' => $request->name,
            'type' => $request->type,
            'details' => $request->details,
            'status' => $request->status ?? true,
        ]);

        return redirect()->route('admin.deposit_methods.index')->with('success', 'Deposit method updated!');
    }

    public function show($id)
    {
        $method = DepositMethod::findOrFail($id);
        return view('admin.pages.deposit-method.show', compact('method'));
    }

    public function destroy(DepositMethod $depositMethod)
    {
        $depositMethod->delete();
        return redirect()->route('admin.deposit_methods.index')->with('success', 'Deposit method deleted!');
    }
}
