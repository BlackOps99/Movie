<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\EventRegistration\EventRegistrationStoreRequest;
use App\Models\Attende;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventRegistration;

class EventRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::without('event_movies')
                    ->where('active', true)
                    ->latest()
                    ->get(['id', 'name']);

        return view('event-registration', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventRegistrationStoreRequest $request)
    {
        $validatedData = $request->validated();

        $attende = Attende::create([
            'name' => $validatedData['name'],
            'mobile' => $validatedData['mobile'],
            'email' => $validatedData['email'],
            'event_id' => $validatedData['event_id'],
            'movie_id' => $validatedData['movie_id'],
            'show_time' => Carbon::parse($validatedData['showtime'])
        ]);

        Mail::to($validatedData['email'])->send(new EventRegistration($attende));

        return redirect()->route('event-registration.index')->with('success', 'You successfully registered.');
    }
}
