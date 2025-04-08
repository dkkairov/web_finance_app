<?php

use App\Http\Controllers\API\AccountController;
use App\Http\Controllers\API\AuthController;
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
    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::post('/transactions', [TransactionController::class, 'store']);
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show']);
    Route::put('/transactions/{transaction}', [TransactionController::class, 'update']);
    Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy']);

    //Account
    Route::get('/accounts', [AccountController::class, 'index']);
    Route::post('/accounts', [AccountController::class, 'store']);
    Route::get('/accounts/{account}', [AccountController::class, 'show']);
    Route::put('/accounts/{account}', [AccountController::class, 'update']);
    Route::delete('/accounts/{account}', [AccountController::class, 'destroy']);

    // TransactionCategory CRUD routes (используем kebab-case для URL)
    Route::get('/transaction-categories', [TransactionCategoryController::class, 'index']);
    Route::post('/transaction-categories', [TransactionCategoryController::class, 'store']);
    Route::get('/transaction-categories/{transaction_category}', [TransactionCategoryController::class, 'show']); // Route Model Binding
    Route::put('/transaction-categories/{transaction_category}', [TransactionCategoryController::class, 'update']); // Route Model Binding
    Route::delete('/transaction-categories/{transaction_category}', [TransactionCategoryController::class, 'destroy']); // Route Model Binding

    // Project CRUD routes
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::get('/projects/{project}', [ProjectController::class, 'show']);       // Route Model Binding
    Route::put('/projects/{project}', [ProjectController::class, 'update']);       // Route Model Binding
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy']);     // Route Model Binding

    // Workspace CRUD routes
    Route::get('/workspaces', [WorkspaceController::class, 'index']);
    Route::post('/workspaces', [WorkspaceController::class, 'store']);
    Route::get('/workspaces/{workspace}', [WorkspaceController::class, 'show']);    // Route Model Binding
    Route::put('/workspaces/{workspace}', [WorkspaceController::class, 'update']);    // Route Model Binding
    Route::delete('/workspaces/{workspace}', [WorkspaceController::class, 'destroy']);  // Route Model Binding
});
