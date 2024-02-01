<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class EventStoreRequest extends FormRequest
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
            'name' => 'required|string|unique:events',
            'movies.*.value1' => 'required|numeric|exists:movies,id',
            'movies.*.value2' => 'required|date_format:h:i A',
            'active' => 'required|boolean',
            'date' => 'required|date',
        ];
    }
}
