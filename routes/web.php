<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProfileController;
use App\Models\Category;
use App\Models\Expense;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
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


    $userId = Auth::id();

    $expensesByCategory = Expense::with('category')
        ->where('user_id', $userId)
        ->selectRaw('category_id, SUM(amount) as total')
        ->groupBy('category_id')
        ->get()
        ->map(fn($item) => [
            'category' => $item->category->name,
            'total' => $item->total,
        ]);

    //Kpis

    $totalExpenses = Expense::where('user_id', $userId)->sum('amount');

    $expensesCount = Expense::where('user_id', $userId)->count();

    $categoriesCount = Category::where('user_id', $userId)->count();

    $expensesThisMonth = Expense::where('user_id', $userId)
        ->whereMonth('date', now()->month)
        ->whereYear('date', now()->year)
        ->sum('amount');

    return Inertia::render('Dashboard', [
        'expensesByCategory' => $expensesByCategory,
        'kpis' => [
            'totalExpenses' => $totalExpenses,
            'expensesCount' => $expensesCount,
            'categoriesCount' => $categoriesCount,
            'expensesThisMonth' => $expensesThisMonth,
        ]
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/Category', CategoryController::class);
    Route::resource('/Expense', ExpenseController::class);
});

require __DIR__ . '/auth.php';
