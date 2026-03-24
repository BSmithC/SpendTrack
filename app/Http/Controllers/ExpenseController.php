<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expense = Expense::all();
        return Inertia::render('Expense/index', ['expenses' => $expense]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return Inertia::render('Expense/create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|numeric|exists:categories,id',
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);
        $validated['user_id'] = Auth::id();
        Expense::create($validated);
        return redirect()->route('Expense.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $expense = Expense::find($id);
        return Inertia::render('Expense/show', ['expense' => $expense]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $expense = Expense::find($id);
        $expense->load('category');
        return Inertia::render('Expense/edit', [
            'expense' => $expense,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'category_id' => 'required|numeric|exists:categories,id',
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);
        $validated['user_id'] = Auth::id();
        $expense = Expense::find($id);
        $expense->update($validated);
        return redirect()->route('Expense.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
