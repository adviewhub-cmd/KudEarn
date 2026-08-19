<?php

use Illuminate\Support\Facades\Route;
use App\Models\InvestmentPlan;
use App\Http\Controllers\WithdrawalController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\DailyTaskController;
use App\Http\Controllers\TaskExecutionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserInvestmentController;
use App\Http\Controllers\Member\DashboardController;
use App\Http\Controllers\PaymentAccountController;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard',[
        DashboardController::class,
        'index'
])->name('dashboard');
    Route::view('/ui-test', 'member.dashboard')
    ->name('ui.test');

    /*
    |--------------------------------------------------------------------------
    | Investment Plans
    |--------------------------------------------------------------------------
    */

    Route::get('/plans', function () {

        $plans = InvestmentPlan::where('status', true)
            ->orderBy('investment_amount')
            ->get();

        return view('plans.index', compact('plans'));

    })->name('plans');

    /*
    |--------------------------------------------------------------------------
    | Investments
    |--------------------------------------------------------------------------
    */

    Route::get('/invest/{plan}', [
        UserInvestmentController::class,
        'create',
    ])->name('investments.create');

    Route::post('/invest/{plan}', [
        UserInvestmentController::class,
        'store',
    ])->name('investments.store');

    Route::get('/my-investments', [
        UserInvestmentController::class,
        'index',
    ])->name('investments.index');

    /*
    |--------------------------------------------------------------------------
    | Deposits
    |--------------------------------------------------------------------------
    */

    Route::get('/deposit', [
        DepositController::class,
        'create',
    ])->name('deposits.create');

    Route::post('/deposit', [
        DepositController::class,
        'store',
    ])->name('deposits.store');

    Route::get('/deposits', [
        DepositController::class,
        'index',
    ])->name('deposits.index');

    /*
    |--------------------------------------------------------------------------
    | Transactions
    |--------------------------------------------------------------------------
    */

    Route::get('/transactions', [
        TransactionController::class,
        'index',
    ])->name('transactions.index');

    /*
    |--------------------------------------------------------------------------
    | withdrawals
    |--------------------------------------------------------------------------
    */
    Route::get(
        '/withdraw',
        [WithdrawalController::class, 'create']
    )->name('withdrawals.create');

    Route::post(
        '/withdraw',
        [WithdrawalController::class, 'store']
    )->name('withdrawals.store');

    Route::get(
        '/withdrawals',
        [WithdrawalController::class, 'index']
    )->name('withdrawals.index');

    Route::get(
        '/withdrawals/{withdrawal}',
        [WithdrawalController::class, 'show']
    )->name('withdrawals.show');

    /*
|--------------------------------------------------------------------------
| Payment Accounts
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get(
        '/payment-accounts',
        [PaymentAccountController::class, 'index']
    )->name('payment-accounts.index');

    Route::get(
        '/payment-accounts/create',
        [PaymentAccountController::class, 'create']
    )->name('payment-accounts.create');

    Route::post(
        '/payment-accounts',
        [PaymentAccountController::class, 'store']
    )->name('payment-accounts.store');

    Route::get(
        '/payment-accounts/{paymentAccount}/edit',
        [PaymentAccountController::class, 'edit']
    )->name('payment-accounts.edit');

    Route::put(
        '/payment-accounts/{paymentAccount}',
        [PaymentAccountController::class, 'update']
    )->name('payment-accounts.update');

    Route::delete(
        '/payment-accounts/{paymentAccount}',
        [PaymentAccountController::class, 'destroy']
    )->name('payment-accounts.destroy');

    Route::post(
        '/payment-accounts/{paymentAccount}/default',
        [PaymentAccountController::class, 'setDefault']
    )->name('payment-accounts.default');

    });
    /*
    |--------------------------------------------------------------------------
    | Daily Tasks
    |--------------------------------------------------------------------------
    */

    Route::get('/daily-tasks', [
        DailyTaskController::class,
        'index',
    ])->name('daily-tasks.index');
    Route::post(
        '/daily-tasks/{task}/start',
        [DailyTaskController::class, 'start']
    )->name('daily-tasks.start');

    Route::post(
        '/daily-tasks/{task}/heartbeat',
        [DailyTaskController::class, 'heartbeat']
    )->name('daily-tasks.heartbeat');

    Route::post(
        '/daily-tasks/{task}/complete',
        [DailyTaskController::class, 'complete']
    )->name('daily-tasks.complete');

    /*
    |--------------------------------------------------------------------------
    | Task Execution
    |--------------------------------------------------------------------------
    */

    Route::post('/tasks/{task}/start', [
        TaskExecutionController::class,
        'start',
    ])->name('tasks.start');

    Route::post('/tasks/{task}/complete', [
        TaskExecutionController::class,
        'complete',
    ])->name('tasks.complete');

});

require __DIR__.'/auth.php';