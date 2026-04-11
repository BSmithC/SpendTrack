<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function generateReport() {}

    public function index(Request $request)
    {
        $query = Expense::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('description', 'like'."%{$request->search}%")
                    ->orWhere('created_at', 'like'."%{$request->search}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status != 'all') {
                $query->where('status', $request->status);
            }
        }

        $expense = $query->with('category')->latest()->paginate(10);

        return Inertia::render('Expense/index', [
            'expenses' => $expense,
            'filters' => $request->only(['search', 'status']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return Inertia::render('Expense/create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);
        Expense::create($validated);

        return redirect()->route('Expense.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $expense = Expense::find($id);
        $expense->load('category');

        return Inertia::render('Expense/show', ['expense' => $expense]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $expense = Expense::findOrFail($id);
        $categories = Category::all();

        return Inertia::render('Expense/edit', [
            'expense' => $expense,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);
        $expense = Expense::findOrFail($id);
        $expense->update($validated);

        return redirect()->route('Expense.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();

        return redirect()->route('Expense.index')->with('success', 'Expense deleted successfully');
    }
}
