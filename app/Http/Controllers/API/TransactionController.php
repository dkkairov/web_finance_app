<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\StoreTransactionRequest;
use App\Http\Requests\Transaction\UpdateTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('user_id', auth()->id())->get();

        return TransactionResource::collection($transactions);
    }

    public function store(StoreTransactionRequest $request)
    {
//        return response()->json(['error' => 'error'], 403);
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $transaction = Transaction::create($data); // Сохраняем созданную модель
        return (new TransactionResource($transaction)) // Возвращаем ресурс
            ->response()
            ->setStatusCode(201); // Статус 201 Created

    }

    public function show(Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return new TransactionResource($transaction); // Используем ресурс
    }

    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $transaction->update($request->validated());
        return new TransactionResource($transaction->fresh()); // Используем ресурс (fresh() чтобы получить обновленные данные, если нужно)
    }

    public function destroy(Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $transaction->delete();
        return response()->json(['message' => 'Transaction deleted successfully'], 200);
    }
}
