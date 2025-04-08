<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\StoreAccountRequest; // <--- Создадим далее
use App\Http\Requests\Account\UpdateAccountRequest; // <--- Создадим далее
use App\Http\Resources\AccountResource;       // <--- Создадим далее
use App\Models\Account;
use Illuminate\Http\Request; // Не используется напрямую, можно убрать если чисто
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

// Для статуса 204

class AccountController extends Controller
{
    /**
     * Display a listing of the user's accounts.
     */
    public function index()
    {
        $user = Auth::user();

        // Получаем ID всех рабочих пространств, к которым принадлежит текущий пользователь
        $workspaceIds = $user->workspaces()->pluck('workspaces.id'); // Указываем 'workspaces.id' для ясности

        // Получаем все аккаунты, связанные с этими рабочими пространствами
        $accounts = Account::whereIn('workspace_id', $workspaceIds)->get();

        return AccountResource::collection($accounts);
    }

    public function store(StoreAccountRequest $request)
    {
        $data = $request->validated();
        $workspaceId = $data['workspace_id']; // Предполагается, что workspace_id передается в запросе

        $user = Auth::user();

        // Проверяем, является ли пользователь членом указанного рабочего пространства
        if (!$user->workspaces()->where('workspaces.id', $workspaceId)->exists()) {
            return response()->json(['error' => 'Unauthorized to create account in this workspace'], Response::HTTP_FORBIDDEN);
        }

        $account = Account::create($data);

        return (new AccountResource($account))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified account.
     */
    public function show(Account $account) // Route Model Binding
    {
        $user = Auth::user();

        // Проверяем, принадлежит ли рабочее пространство, к которому относится аккаунт, к рабочим пространствам пользователя
        if (!$user->workspaces()->where('workspaces.id', $account->workspace_id)->exists()) {
            return response()->json(['error' => 'Unauthorized to view this account'], Response::HTTP_FORBIDDEN);
        }

        return new AccountResource($account);
    }

    /**
     * Update the specified account in storage.
     */
    public function update(UpdateAccountRequest $request, Account $account) // Route Model Binding
    {
//        $user = Auth::user();
//
//        // Проверяем, принадлежит ли рабочее пространство, к которому относится аккаунт, к рабочим пространствам пользователя
//        if (!$user->workspaces()->where('workspaces.id', $account->workspace_id)->exists()) {
//            return response()->json(['error' => 'Unauthorized to update this account'], Response::HTTP_FORBIDDEN);
//        }
//        dd($request->validated());
        $account->update($request->validated());

        $account->currency_id = 2;
        $account->save();
        return new AccountResource($account->fresh());
    }

    /**
     * Remove the specified account from storage.
     */
    public function destroy(Account $account) // Route Model Binding
    {
        $user = Auth::user();

        // Проверяем, принадлежит ли рабочее пространство, к которому относится аккаунт, к рабочим пространствам пользователя
        if (!$user->workspaces()->where('workspaces.id', $account->workspace_id)->exists()) {
            return response()->json(['error' => 'Unauthorized to delete this account'], Response::HTTP_FORBIDDEN);
        }

        $account->delete();

        return response()->noContent();
    }
}
