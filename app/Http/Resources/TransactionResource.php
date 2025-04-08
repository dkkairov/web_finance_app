<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'userId' => (int) $this->user_id,
            'transactionType' => $this->transaction_type,
            'transactionCategoryId' => $this->transaction_category_id ? (int) $this->transaction_category_id : null,
            'amount' => (float) $this->amount, // ✅ обязательно число!
            'accountId' => $this->account_id ? (int) $this->account_id : null,
            'projectId' => $this->project_id ? (int) $this->project_id : null,
            'description' => $this->description,
            'date' => $this->date,
            'isActive' => (bool) $this->is_active,
        ];
    }
}
