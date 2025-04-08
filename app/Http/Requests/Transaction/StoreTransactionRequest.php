<?php

namespace App\Http\Requests\Transaction;

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
            'transaction_type'        => 'nullable|string',
            'description'             => 'nullable|string',
            'date'                    => 'required|date',
//            'transaction_category_id' => 'required|exists:transaction_categories,id',
            'transaction_category_id' => 'required|numeric',
//            'account_id'              => 'required|exists:accounts,id',
            'account_id'              => 'required|numeric',
//            'project_id'              => 'nullable|exists:projects,id',
            'project_id'              => 'nullable|numeric',
            'is_active'              => 'boolean',
        ];
    }
}
