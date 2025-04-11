<?php

namespace App\Http\Requests\TransactionCategory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTransactionCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = auth()->id();
        $categoryId = $this->route('transaction_category')->id;

        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('transaction_categories')
                    ->where(function ($query) use ($userId) {
                        return $query->where('user_id', $userId);
                    })
                    ->ignore($categoryId),
            ],
            // 'is_active' => 'sometimes|boolean', // <--- УБРАЛИ ЭТУ СТРОКУ
            'team_id' => 'sometimes|numeric|exists:teams,id',
            'type' => 'sometimes|string',
            'icon' => 'sometimes|string',
            // Добавь правила для других полей, если они появятся
        ];
    }
}
