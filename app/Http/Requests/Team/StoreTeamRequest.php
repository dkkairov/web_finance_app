<?php

namespace App\Http\Requests\Team;

use App\Models\Team;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTeamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check(); // Any authenticated user can attempt to create
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|alpha_dash', // Unique slug, only letters/numbers/hyphen/underscore
            'is_active' => 'sometimes|boolean',
            'owner_id' => 'sometimes|numeric|exists:users,id',
            'type' => ['required', 'string', Rule::in([Team::TYPE_PERSONAL, Team::TYPE_BUSINESS])],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The "Name" field is required.',
            'name.string' => 'The "Name" field must be a string.',
            'name.max' => 'The "Name" field may not be greater than 255 characters.',

            'slug.required' => 'The "Slug" field is required.',
            'slug.string' => 'The "Slug" field must be a string.',
            'slug.max' => 'The "Slug" field may not be greater than 255 characters.',
            'slug.alpha_dash' => 'The "Slug" field may only contain letters, numbers, dashes, and underscores.',

            'type.required' => 'The "Type" field is required.',
            'type.string' => 'The "Type" field must be a string.',
            'type.in' => 'The "Type" field must be one of the following: personal, business.',

            'is_active.boolean' => 'The "Active" field must be a boolean (true or false).',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    // protected function prepareForValidation()
    // {
    // If slug is generated automatically, you can do it here:
    // if ($this->has('name') && !$this->has('slug')) {
    //     $this->merge([
    //         'slug' => \Illuminate\Support\Str::slug($this->input('name'))
    //     ]);
    // }
    // // And then make slug optional in rules() and remove unique (perform uniqueness check during generation)
    // }
}
