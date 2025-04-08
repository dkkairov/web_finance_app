<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'workspace_id' => (int) $this->workspace_id, // Предполагаем, что workspace_id всегда есть
            'name' => $this->name,
            'balance' => (float) $this->balance, // Приводим к float для JSON
            'currency_id' => (int) $this->currency_id, // Предполагаем, что currency_id всегда есть
            'is_active' => (bool) $this->is_active,
            // Можно добавить связанные данные при необходимости, например:
            // 'currency' => new CurrencyResource($this->whenLoaded('currency')),
            // 'workspace' => new WorkspaceResource($this->whenLoaded('workspace')),
        ];
    }
}
