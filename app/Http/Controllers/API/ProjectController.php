<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest; // Создадим далее
use App\Http\Requests\Project\UpdateProjectRequest; // Создадим далее
use App\Http\Resources\ProjectResource;          // Создадим далее
use App\Models\Project;
use Illuminate\Http\Request; // для auth()->user()
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isEmpty;

// Для типизации Auth::user()

class ProjectController extends Controller
{
    /**
     * Display a listing of the projects accessible by the user.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        // Получаем ID воркспейсов, к которым пользователь имеет доступ
        // Замени 'teams' на имя реальной связи в модели User, если оно другое
        $accessibleTeamIds = $user->teams()->pluck('teams.id');

        $projects = Project::whereIn('team_id', $accessibleTeamIds)->get();
//        $projects = Project::all();


        return ProjectResource::collection($projects);
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        // Валидация (включая проверку доступа к team_id) происходит в StoreProjectRequest
        $data = $request->validated();

        // Не нужно добавлять user_id, т.к. его нет в модели Project
        $project = Project::create($data);

        return (new ProjectResource($project))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project) // Route Model Binding
    {
        // Проверка, имеет ли пользователь доступ к воркспейсу проекта
        if (!Auth::user()->teams()->where('teams.id', $project->team_id)->exists()) {
            return response()->json(['error' => 'Access to this project teams denied'], Response::HTTP_FORBIDDEN);
        }

        return new ProjectResource($project);
    }

    /**
     * Update the specified project in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project) // Route Model Binding
    {
        // Проверка, имеет ли пользователь доступ к воркспейсу проекта
        if (!Auth::user()->teams()->where('teams.id', $project->team_id)->exists()) {
            return response()->json(['error' => 'Access to this project team denied'], Response::HTTP_FORBIDDEN);
        }

        // Валидация происходит в UpdateProjectRequest
        $project->update($request->validated());

        return new ProjectResource($project->fresh());
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(Project $project) // Route Model Binding
    {
        // Проверка, имеет ли пользователь доступ к воркспейсу проекта
        if (!Auth::user()->teams()->where('teams.id', $project->team_id)->exists()) {
            return response()->json(['error' => 'Access to this project team denied'], Response::HTTP_FORBIDDEN);
        }

        // Дополнительная проверка: возможно, не удалять проект с транзакциями?
        // if ($project->transactions()->exists()) {
        //     return response()->json(['error' => 'Cannot delete project with existing transactions'], Response::HTTP_CONFLICT); // 409 Conflict
        // }

        $project->delete(); // Используется SoftDeletes

        return response()->json(['message' => 'Transaction deleted successfully'], 200);
    }
}
