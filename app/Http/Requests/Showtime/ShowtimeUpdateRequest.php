<?php

namespace App\Http\Requests\Showtime;

use Illuminate\Foundation\Http\FormRequest;

class ShowtimeUpdateRequest extends FormRequest
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
            'movie_id' => 'sometimes|required|numeric|exists:movies,id',
            'date' => 'sometimes|required|date',
            'hours' => 'sometimes|required|between:1,12',
            'minutes' => 'sometimes|required|in:00,15,30,45',
            'period' => 'sometimes|required|in:AM,PM',
            'active' => 'sometimes|required'
        ];
    }
}
