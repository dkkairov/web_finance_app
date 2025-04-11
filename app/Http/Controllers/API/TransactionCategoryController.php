<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionCategory\StoreTransactionCategoryRequest;
use App\Http\Requests\TransactionCategory\UpdateTransactionCategoryRequest;
use App\Http\Resources\TransactionCategoryResource;
use App\Models\TransactionCategory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TransactionCategoryController extends Controller
{
    /**
     * Display a listing of the team's transaction categories.
     */
    public function index()
    {
        // Получаем ID текущей команды пользователя
        $teamId = Auth::user()->current_team_id;

        // Получаем категории, принадлежащие команде
        $categories = TransactionCategory::where('transaction_categories.team_id', $teamId)->get();

        return TransactionCategoryResource::collection($categories);
    }

    /**
     * Store a newly created transaction category in storage.
     */
    public function store(StoreTransactionCategoryRequest $request)
    {
        $data = $request->validated();

        // Получаем ID текущей команды пользователя и добавляем его в данные
        $data['team_id'] = Auth::user()->current_team_id;

        $category = TransactionCategory::create($data);

        return (new TransactionCategoryResource($category))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified transaction category.
     */
    public function show(TransactionCategory $transactionCategory)
    {
        // Получаем ID текущей команды пользователя
        $teamId = Auth::user()->current_team_id;

        // Проверка принадлежности категории команде
        if ($transactionCategory->team_id !== $teamId) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }

        return new TransactionCategoryResource($transactionCategory);
    }

    /**
     * Update the specified transaction category in storage.
     */
    public function update(UpdateTransactionCategoryRequest $request, TransactionCategory $transactionCategory)
    {
        // Получаем ID текущей команды пользователя
        $teamId = Auth::user()->current_team_id;

        // Проверка принадлежности категории команде
        if ($transactionCategory->team_id !== $teamId) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }

        $transactionCategory->update($request->validated());

        return new TransactionCategoryResource($transactionCategory->fresh());
    }

    /**
     * Remove the specified transaction category from storage.
     */
    public function destroy(TransactionCategory $transactionCategory)
    {
        // Получаем ID текущей команды пользователя
        $teamId = Auth::user()->current_team_id;

        // Проверка принадлежности категории команде
        if ($transactionCategory->team_id !== $teamId) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }

        // Дополнительная проверка: возможно, не стоит удалять категорию, если у нее есть транзакции?
        // if ($transactionCategory->transactions()->exists()) {
        //     return response()->json(['error' => 'Cannot delete category with existing transactions'], Response::HTTP_CONFLICT);
        // }

        $transactionCategory->delete();

        return response()->json(['message' => 'Transaction category deleted successfully'], 200);
    }
}
