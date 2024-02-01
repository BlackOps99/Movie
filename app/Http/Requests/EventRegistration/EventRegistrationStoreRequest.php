<?php

namespace App\Http\Requests\EventRegistration;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Event;
use Carbon\Carbon;

class EventRegistrationStoreRequest extends FormRequest
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
            'name' => 'required|string',
            'mobile' => 'required|string',
            'email' => 'required|email',
            'event_id' => 'required|numeric|exists:events,id',
            'movie_id' => 'required|numeric|exists:movies,id',
            'showtime' => 'required|date_format:h:i a',
        ];
    }

    public function messages()
    {
        return [
            'event_id' => 'The event select field is required.',
            'movie_id' => 'The movie select field is required.',
            'showtime' => 'The :attribute select field is required.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $eventId = $this->input('event_id');
            $event = Event::find($eventId);

            if (!$event) {
                $validator->errors()->add('event_id', 'Event not found.');
                return;
            }

            $registrationDeadline = Carbon::parse($event->event_time)->addDays(7);

            if (Carbon::now()->gt($registrationDeadline)) {
                $validator->errors()->add('event_id', 'Event registration is closed.');
            }
        });
    }
}
