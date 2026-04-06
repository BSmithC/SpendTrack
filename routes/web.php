<?php

use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProfileController;
use App\Models\Category;
use App\Models\Expense;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    $expense_total = Expense::where('status', true)->sum('price');
    $expense_count = Expense::where('status', true)->count();
    $categories_count = Category::count();
    $expenses_this_month = Expense::where('status', true)
        ->whereMonth('created_at', now()->month)
        ->sum('price');

    $expenses_by_category = Expense::where('status', true)
        ->with('category')
        ->get()
        ->groupBy('category.name')
        ->map(fn ($items) => $items->sum('price'));

    return Inertia::render('Dashboard', [
        'expense_total' => $expense_total,
        'expense_count' => $expense_count,
        'categories_count' => $categories_count,
        'expenses_this_month' => $expenses_this_month,
        'expenses_by_category' => $expenses_by_category,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/Category', CategoryController::class);
    Route::resource('/Budget', BudgetController::class);
    Route::resource('/Expense', ExpenseController::class);
});

require __DIR__.'/auth.php';
