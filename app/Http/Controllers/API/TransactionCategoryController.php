<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionCategory\StoreTransactionCategoryRequest; // Создадим далее
use App\Http\Requests\TransactionCategory\UpdateTransactionCategoryRequest; // Создадим далее
use App\Http\Resources\TransactionCategoryResource;                      // Создадим далее
use App\Models\TransactionCategory;
use Illuminate\Http\Response;

class TransactionCategoryController extends Controller
{
    /**
     * Display a listing of the user's transaction categories.
     */
    public function index()
    {
        // Если категории глобальные, убери ->where(...)

        $categories = TransactionCategory::where('transaction_categories.user_id', auth()->id())->get();

        return TransactionCategoryResource::collection($categories);
    }

    /**
     * Store a newly created transaction category in storage.
     */
    public function store(StoreTransactionCategoryRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id(); // Убери эту строку, если категории глобальные

        $category = TransactionCategory::create($data);

        return (new TransactionCategoryResource($category))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified transaction category.
     */
    public function show(TransactionCategory $transactionCategory) // Route Model Binding
    {
        // Проверка принадлежности категории пользователю
        // Убери эту проверку, если категории глобальные
        if ($transactionCategory->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }

        return new TransactionCategoryResource($transactionCategory);
    }

    /**
     * Update the specified transaction category in storage.
     */
    public function update(UpdateTransactionCategoryRequest $request, TransactionCategory $transactionCategory) // Route Model Binding
    {
        // Проверка принадлежности категории пользователю
        // Убери эту проверку, если категории глобальные
        if ($transactionCategory->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }

        $transactionCategory->update($request->validated());

        return new TransactionCategoryResource($transactionCategory->fresh());
    }

    /**
     * Remove the specified transaction category from storage.
     */
    public function destroy(TransactionCategory $transactionCategory) // Route Model Binding
    {
        // Проверка принадлежности категории пользователю
        // Убери эту проверку, если категории глобальные
        if ($transactionCategory->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }

        // Дополнительная проверка: возможно, не стоит удалять категорию, если у нее есть транзакции?
        // if ($transactionCategory->transactions()->exists()) {
        //     return response()->json(['error' => 'Cannot delete category with existing transactions'], Response::HTTP_CONFLICT); // 409 Conflict
        // }

        $transactionCategory->delete(); // Используется SoftDeletes

        return response()->noContent();
    }
}
