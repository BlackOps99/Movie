<?php

namespace App\Http\Requests\Movie;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MovieUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|'.Rule::unique('movies', 'name')->ignore($this->movie),
            'picture' => 'sometimes|nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'sometimes|required|string',
            'active' => 'sometimes|required',
        ];
    }
}
