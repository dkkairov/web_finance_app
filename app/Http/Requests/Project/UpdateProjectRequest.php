<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Проверка принадлежности проекта (через workspace) делается в контроллере
        // Здесь достаточно проверить, что пользователь авторизован
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Получаем текущий проект из маршрута
        $project = $this->route('project');

        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                // Имя должно быть уникально в ЭТОМ ЖЕ воркспейсе, игнорируя текущий проект
                Rule::unique('projects')
                    ->where('workspace_id', $project->workspace_id) // Ищем только в текущем воркспейсе
                    ->ignore($project->id), // Игнорируем сам проект
            ],
            'description' => 'nullable|string',
            // 'workspace_id' => 'sometimes|required|...', // НЕ РАЗРЕШАЕМ МЕНЯТЬ ДЛЯ MVP
            'is_active' => 'sometimes|boolean',
        ];
    }
}
