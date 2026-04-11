<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function generatereport() {}

    public function index(Request $request)
    {
        $query = Budget::query()->with(['details']);

        if ($request->filled('search')) {
            if ($request->filled('search')) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('total', 'like', "%{$search}%")
                        ->orWhere('created_at', 'like', "%{$search}%")
                        ->orWhere('type', 'like', "%{$search}%")
                        ->orWhereHas('details', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%")
                                ->orWhere('amount', 'like', "%{$search}%");
                        });
                });
            }
        }

        if ($request->filled('status')) {
            if ($request->status != 'all') {
                $query->where('status', $request->status);
            }
        }

        $budgets = $query->with('details')->latest()->paginate(10);

        return Inertia::render('Budget/index', [
            'budgets' => $budgets,
            'filters' => $request->only(['search', 'status']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Budget/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'amount_of_payments' => 'nullable|numeric',
            'initial' => 'nullable|numeric',
            'total' => 'required|numeric',
            'status' => 'required|boolean',
            'details.*.name' => 'required|string|max:255',
            'details.*.amount' => 'required|numeric',
            'details.*.quantity' => 'required|numeric',
        ]);

        $budget = Budget::create([
            'user_id' => Auth::id(),
            'type' => $validated['type'],
            'amount_of_payments' => $validated['amount_of_payments'],
            'initial' => $validated['initial'],
            'total' => $validated['total'],
            'status' => $validated['status'],
        ]);

        foreach ($validated['details'] as $detail) {
            $budget->details()->create([
                'budget_id' => $budget->id,
                'name' => $detail['name'],
                'amount' => $detail['amount'],
                'total' => $detail['amount'] * $detail['quantity'],
                'quantity' => $detail['quantity'],
            ]);
        }

        return redirect()->route('Budget.index')->with('success', 'Se guardado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $budget = Budget::with('details')->find($id);

        return Inertia::render('Budget/show', [
            'budget' => $budget,
        ]);
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
        $budget = Budget::find($id);
        $budget->status = 0;
        $budget->save();
    }
}
