<?php

namespace App\Http\Requests\Currency;

use Illuminate\Foundation\Http\FormRequest;

class StoreCurrencyRequest extends FormRequest
{
    /**
     * Определяет, авторизован ли пользователь для выполнения этого запроса.
     */
    public function authorize(): bool
    {
        return auth()->check(); // Настройте логику авторизации по мере необходимости
    }

    /**
     * Возвращает правила валидации, которые применяются к запросу.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'code' => 'required|string|unique:currencies|max:3',
            'name' => 'required|string|unique:currencies|max:255',
            'symbol' => 'nullable|string|max:10',
        ];
    }
}
