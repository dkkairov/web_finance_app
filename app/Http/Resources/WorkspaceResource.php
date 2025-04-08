<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkspaceResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'isActive' => (bool) $this->is_active,
            // Информация о владельце (если связь 'owner' загружена)
            // 'owner' => new UserResource($this->whenLoaded('owner') ? $this->owner->user : null), // Пример, если есть UserResource
            'ownerId' => $this->whenLoaded('owner', function() { // Пример получения ID владельца
                // Убедись, что связь owner загружена и у membership есть user_id
                return $this->owner ? $this->owner->user_id : null;
            }),
            // Можно добавить другую информацию, например, роль текущего пользователя в этом воркспейсе
            // 'currentUserRole' => $this->when(Auth::check(), function() {
            //      $membership = $this->users()->where('user_id', Auth::id())->first();
            //      return $membership ? $membership->pivot->role : null;
            // }),
            'createdAt' => $this->created_at, // Пример добавления дат
            'updatedAt' => $this->updated_at,
        ];
    }
}
