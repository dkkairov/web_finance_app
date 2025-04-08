<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class StoreAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Разрешаем только авторизованным пользователям
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'balance' => 'required|numeric', // Валидация числа
            // Проверяем, что ID валюты и воркспейса существуют в соответствующих таблицах
            // Замени 'currencies' и 'workspaces' на реальные имена таблиц, если они другие
            'currency_id' => 'required|exists:currencies,id',
            'workspace_id' => 'required|exists:workspaces,id', // Считаем обязательным, если нет - убери 'required'
            'is_active' => 'sometimes|boolean', // Необязательное поле, по умолчанию может быть true в БД
        ];
    }
}
