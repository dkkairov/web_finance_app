<?php

namespace App\Http\Requests\Team;

use App\Models\Team;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTeamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Авторизация (проверка роли 'owner') делается в контроллере
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $teamId = $this->route('team'); // Получаем строковое значение ID из маршрута

        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
            ],
            'slug' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                'alpha_dash',
            ],
            'owner_id' => 'sometimes|exists:users,id',
            'is_active' => 'sometimes|boolean',
            'type' => ['required', 'string', Rule::in([Team::TYPE_PERSONAL, Team::TYPE_BUSINESS])],
        ];
    }
}
