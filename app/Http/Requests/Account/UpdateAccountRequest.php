<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Разрешаем только авторизованным пользователям
        return auth()->check();
        // В будущем здесь можно добавить проверку, может ли пользователь редактировать *именно этот* счет,
        // но пока проверка принадлежности остается в контроллере (или лучше вынести в Policy).
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // 'sometimes' означает, что поле будет проверяться, только если оно присутствует в запросе
        return [
            'name' => 'sometimes|required|string|max:255',
            'balance' => 'sometimes|required|numeric',
            // Проверяем, что ID валюты и воркспейса существуют в соответствующих таблицах
            'currency_id' => 'sometimes|required|exists:currencies,id',
            'team_id' => 'sometimes|required|exists:teams,id', // Считаем обязательным, если нет - убери 'required'
            'is_active' => 'sometimes|boolean',
        ];
    }
}
