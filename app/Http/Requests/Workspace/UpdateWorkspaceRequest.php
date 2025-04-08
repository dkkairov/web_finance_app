<?php

namespace App\Http\Requests\Workspace;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateWorkspaceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Авторизация (проверка роли 'owner') делается в контроллере
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $workspaceId = $this->route('workspace')->id;

        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('workspaces', 'name')->ignore($workspaceId), // Уникальное имя, игнорируя текущий воркспейс
            ],
            // Slug обычно не меняют, но если нужно, добавь похожее правило:
            // 'slug' => [
            //     'sometimes',
            //     'required',
            //     'string',
            //     'max:255',
            //     'alpha_dash',
            //     Rule::unique('workspaces', 'slug')->ignore($workspaceId),
            // ],
            'is_active' => 'sometimes|boolean',
        ];
    }
}
