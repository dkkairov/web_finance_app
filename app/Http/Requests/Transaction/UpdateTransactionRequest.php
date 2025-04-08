<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check(); // Только авторизованные пользователи
    }

    public function rules(): array
    {
        return [
            'amount'                  => 'sometimes|required|numeric',
            'description'             => 'nullable|string',
            'date'                    => 'sometimes|required|date',
            'transaction_category_id' => 'sometimes|required|exists:transaction_categories,id',
            'account_id'              => 'sometimes|required|exists:accounts,id',
            'project_id'              => 'nullable|exists:projects,id',
        ];
    }
}
