<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionCategoryResource extends JsonResource
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
            'teamId' => (int) $this->team_id, // По-прежнему опционально
            'name' => $this->name,
            // 'isActive' => (bool) $this->is_active, // <--- УБРАЛИ ЭТУ СТРОКУ
            'icon' => (string) $this->icon,
            'type' => (string) $this->type,
            // Добавь другие поля (icon, color), если они есть в модели
        ];
    }
}
