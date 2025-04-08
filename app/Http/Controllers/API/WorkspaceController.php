<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Workspace\StoreWorkspaceRequest; // Создадим далее
use App\Http\Requests\Workspace\UpdateWorkspaceRequest; // Создадим далее
use App\Http\Resources\WorkspaceResource;          // Создадим далее
use App\Models\Workspace;
use App\Models\Membership; // <-- Предполагаем, что модель Membership существует
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // <-- Для транзакции в store

class WorkspaceController extends Controller
{
    /**
     * Display a listing of workspaces the user is a member of.
     */
    public function index()
    {
        $user = Auth::user();
        // Используем связь 'workspaces' из модели User
        $workspaces = $user->workspaces()->get();

        return WorkspaceResource::collection($workspaces);
    }

    /**
     * Store a newly created workspace in storage.
     */
    public function store(StoreWorkspaceRequest $request)
    {
        $validatedData = $request->validated();
        $user = Auth::user();

        // Используем транзакцию, чтобы обе операции (создание Workspace и Membership) выполнились успешно
        try {
            DB::beginTransaction();

            // 1. Создаем Workspace
            // owner_id можно не передавать, если он не используется или устанавливается иначе
            $workspace = Workspace::create([
                'name' => $validatedData['name'],
                'slug' => $validatedData['slug'], // Убедись, что slug генерируется или валидируется
                'is_active' => $validatedData['is_active'] ?? true,
                // 'owner_id' => $user->id, // Раскомментируй, если поле owner_id нужно и должно быть заполнено
            ]);

            // 2. Создаем запись о членстве для создателя как владельца
            // Убедись, что модель Membership и ее поля ('user_id', 'workspace_id', 'role') существуют
            Membership::create([
                'user_id' => $user->id,
                'workspace_id' => $workspace->id,
                'role' => 'owner', // Или другая роль по умолчанию для создателя
            ]);

            DB::commit();

            // Загружаем связь owner, чтобы она была доступна в ресурсе, если нужно
            $workspace->load('owner.user'); // Загружаем 'owner', а затем 'user' из Membership

            return (new WorkspaceResource($workspace))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);

        } catch (\Exception $e) {
            DB::rollBack();
            // Логируем ошибку
            \Log::error('Workspace creation failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create workspace.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified workspace if the user is a member.
     */
    public function show(Workspace $workspace) // Route Model Binding
    {
        // Проверка, является ли пользователь членом этого воркспейса
        if (!Auth::user()->workspaces()->where('id', $workspace->id)->exists()) {
            return response()->json(['error' => 'Access denied'], Response::HTTP_FORBIDDEN);
        }
        // Можно загрузить доп. связи, если они нужны в ресурсе
        $workspace->load('owner.user');

        return new WorkspaceResource($workspace);
    }

    /**
     * Update the specified workspace in storage if the user is the owner.
     */
    public function update(UpdateWorkspaceRequest $request, Workspace $workspace) // Route Model Binding
    {
        // Проверка, является ли пользователь владельцем воркспейса
        // Замени 'owner' на актуальное значение роли, если оно другое
        $isOwner = Membership::where('workspace_id', $workspace->id)
            ->where('user_id', Auth::id())
            ->where('role', 'owner')
            ->exists();

        if (!$isOwner) {
            return response()->json(['error' => 'Only the owner can update the workspace'], Response::HTTP_FORBIDDEN);
        }

        $workspace->update($request->validated());
        $workspace->load('owner.user');

        return new WorkspaceResource($workspace->fresh()->load('owner.user')); // fresh() + load()
    }

    /**
     * Remove the specified workspace from storage if the user is the owner.
     */
    public function destroy(Workspace $workspace) // Route Model Binding
    {
        // Проверка, является ли пользователь владельцем воркспейса
        $isOwner = Membership::where('workspace_id', $workspace->id)
            ->where('user_id', Auth::id())
            ->where('role', 'owner')
            ->exists();

        if (!$isOwner) {
            return response()->json(['error' => 'Only the owner can delete the workspace'], Response::HTTP_FORBIDDEN);
        }

        // Дополнительные проверки (например, не удалять воркспейс с проектами/счетами)?
        // if ($workspace->projects()->exists() || $workspace->accounts()->exists()) {
        //     return response()->json(['error' => 'Cannot delete workspace with existing projects or accounts'], Response::HTTP_CONFLICT);
        // }

        // Возможно, нужно удалить связанные memberships перед удалением workspace? Зависит от foreign keys.
        // DB::transaction(function() use ($workspace) {
        //      $workspace->memberships()->delete(); // Удаляем членства
        $workspace->delete(); // Используется SoftDeletes
        // });

        return response()->noContent();
    }
}
