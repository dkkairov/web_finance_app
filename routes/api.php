<?php

use App\Http\Controllers\API\AccountController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CurrencyController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\TransactionCategoryController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\WorkspaceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    //Transaction
    Route::apiResource('transactions', TransactionController::class);

    //Account
    Route::apiResource('accounts', AccountController::class);

    // TransactionCategory CRUD routes (используем kebab-case для URL)
    Route::apiResource('transaction-categories', TransactionCategoryController::class);

    // Project CRUD routes
    Route::apiResource('projects', ProjectController::class);

    // Workspace CRUD routes
    Route::apiResource('workspaces', WorkspaceController::class);

    // Currency CRUD routes
    Route::get('/currencies', [CurrencyController::class, 'index']);
    Route::post('/currencies', [CurrencyController::class, 'store']);
    Route::get('/currencies/{currency}', [CurrencyController::class, 'show']);    // Route Model Binding
    Route::put('/currencies/{currency}', [CurrencyController::class, 'update']);    // Route Model Binding
    Route::delete('/currencies/{currency}', [CurrencyController::class, 'destroy']);  // Route Model Binding
});
