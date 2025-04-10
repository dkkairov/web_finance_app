<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Team\StoreTeamRequest; // Создадим далее
use App\Http\Requests\Team\UpdateTeamRequest; // Создадим далее
use App\Http\Resources\TeamResource;          // Создадим далее
use App\Models\Team;
use App\Models\Membership; // <-- Предполагаем, что модель Membership существует
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

// <-- Для транзакции в store

class TeamController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Используем связь 'teams' из модели User
        $teams = $user->teams()->get();

        return TeamResource::collection($teams);
    }

    public function store(StoreTeamRequest $request)
    {
        $validatedData = $request->validated();
        $user = Auth::user();

        // Используем транзакцию, чтобы обе операции (создание Team и Membership) выполнились успешно
        try {
            DB::beginTransaction();

            // 1. Создаем Team
            // owner_id можно не передавать, если он не используется или устанавливается иначе
            $team = Team::create([
                'name' => $validatedData['name'],
                'slug' => $validatedData['slug'], // Убедись, что slug генерируется или валидируется
                'type' => $validatedData['type'],
                'is_active' => $validatedData['is_active'] ?? true,
                'owner_id' => $user->id, // Раскомментируй, если поле owner_id нужно и должно быть заполнено
            ]);

            // 2. Создаем запись о членстве для создателя как владельца
            // Убедись, что модель Membership и ее поля ('user_id', 'team_id', 'role') существуют
            Membership::create([
                'user_id' => $user->id,
                'team_id' => $team->id,
                'role' => 'owner', // Или другая роль по умолчанию для создателя
            ]);

            DB::commit();

            // Загружаем связь owner, чтобы она была доступна в ресурсе, если нужно
            $team->load('owner.user'); // Загружаем 'owner', а затем 'user' из Membership

            return (new TeamResource($team))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);

        } catch (\Exception $e) {
            DB::rollBack();
            // Логируем ошибку
            Log::error('Team creation failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create team. Error: '.$e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified team if the user is a member.
     */
    public function show(Team $team) // Route Model Binding
    {
        // Проверка, является ли пользователь членом этого воркспейса
        if (!Auth::user()->teams()->where('teams.id', $team->id)->exists()) {
            return response()->json(['error' => 'Access denied'], Response::HTTP_FORBIDDEN);
        }
        // Можно загрузить доп. связи, если они нужны в ресурсе
        $team->load('owner.user');

        return new TeamResource($team);
    }

    /**
     * Update the specified team in storage if the user is the owner.
     */
    public function update(UpdateTeamRequest $request, Team $team)
    {
        $isOwner = Membership::where('memberships.team_id', $team->id)
            ->where('memberships.user_id', Auth::id())
            ->where('memberships.role', 'owner')
            ->exists();

        if (!$isOwner) {
            return response()->json(['error' => 'Only the owner can update the team'], Response::HTTP_FORBIDDEN);
        }

        $team->update($request->validated());
        $team->load('owner.user');

        return new TeamResource($team->fresh()->load('owner.user'));
    }

    /**
     * Remove the specified team from storage if the user is the owner.
     */
    public function destroy(Team $team) // Route Model Binding
    {
        // Проверка, является ли пользователь владельцем воркспейса
        $isOwner = Membership::where('team_id', $team->id)
            ->where('user_id', Auth::id())
            ->where('role', 'owner')
            ->exists();

        if (!$isOwner) {
            return response()->json(['error' => 'Only the owner can delete the team'], Response::HTTP_FORBIDDEN);
        }

        // Дополнительные проверки (например, не удалять воркспейс с проектами/счетами)?
        // if ($team->projects()->exists() || $team->accounts()->exists()) {
        //     return response()->json(['error' => 'Cannot delete team with existing projects or accounts'], Response::HTTP_CONFLICT);
        // }

        // Возможно, нужно удалить связанные memberships перед удалением team? Зависит от foreign keys.
        // DB::transaction(function() use ($team) {
        //      $team->memberships()->delete(); // Удаляем членства
        $team->delete(); // Используется SoftDeletes
        // });

        return response()->json(['message' => 'Team deleted successfully'], 200);
    }
}
