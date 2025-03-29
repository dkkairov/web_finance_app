<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check(); // Только авторизованные пользователи
    }

    public function rules(): array
    {
        return [
            'amount'                  => 'required|numeric',
            'description'             => 'nullable|string',
            'date'                    => 'required|date',
            'transaction_category_id' => 'required|exists:transaction_categories,id',
            'account_id'              => 'required|exists:accounts,id',
            'project_id'              => 'nullable|exists:projects,id',
        ];
    }
}
