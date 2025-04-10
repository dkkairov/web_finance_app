<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth; // Используем Auth
use Illuminate\Validation\Rule;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Просто проверяем, что пользователь авторизован
        // Проверка доступа к team_id будет в правилах валидации
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Получаем ID доступных пользователю воркспейсов
        $userTeamIds = Auth::user()->teams()->pluck('teams.id')->toArray();

        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => 'nullable|string',
            'team_id' => [
                'required',
                'integer',
                'exists:teams,id', // Убедимся, что воркспейс существует
                Rule::in($userTeamIds) // Проверяем, что пользователь имеет доступ к этому воркспейсу
            ],
            'is_active' => 'sometimes|boolean',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'team_id.in' => 'You do not have access to the selected team.',
        ];
    }
}
