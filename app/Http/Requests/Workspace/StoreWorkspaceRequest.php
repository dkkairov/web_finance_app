<?php

namespace App\Http\Requests\Workspace;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreWorkspaceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check(); // Любой авторизованный может пытаться создать
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:workspaces,name', // Имя должно быть глобально уникальным? Или уникальным для пользователя? Пока глобально.
            'slug' => 'required|string|max:255|alpha_dash|unique:workspaces,slug', // Уникальный slug, только буквы/цифры/дефис/подчеркивание
            'is_active' => 'sometimes|boolean',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    // protected function prepareForValidation()
    // {
    // Если slug генерируется автоматически, можно сделать это здесь:
    // if ($this->has('name') && !$this->has('slug')) {
    //     $this->merge([
    //         'slug' => \Illuminate\Support\Str::slug($this->input('name'))
    //     ]);
    // }
    // // И затем сделать slug необязательным в rules() и убрать unique (проверку уникальности делать при генерации)
    // }
}
