<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EventUpdateRequest extends FormRequest
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
            'name' => 'sometimes|required|string|'.Rule::unique('events', 'name')->ignore($this->event),
            'movies.*.value1' => 'required|numeric|exists:movies,id',
            'movies.*.value2' => 'required|date_format:h:i A',
            'active' => 'required|boolean',
            'date' => 'required|date',
        ];
    }
}
