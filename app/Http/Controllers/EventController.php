<?php

namespace App\Http\Controllers;

use App\Http\Requests\Event\EventStoreRequest;
use App\Http\Requests\Event\EventUpdateRequest;
use App\Models\Movie;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::without('event_movies')->when(
            auth()->guard('admin')->check(),
            fn ($query) => $query->latest(),
            fn ($query) => $query->where('active', true)->latest()
        )
            ->withCount('event_movies')
            ->paginate(10);

        return view('event.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $moives = Movie::without('showTimes')
            ->select('id', 'name')
            ->get();

        return view('event.create', compact('moives'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $validatedData = $request->validated();

            $event = Event::create([
                'name' => $validatedData['name'],
                'event_time' => $validatedData['date'],
                'active' => $validatedData['active'],
            ]);

            foreach ($validatedData['movies'] as $movie) {
                $event->event_movies()->create([
                    'movie_id' => $movie['value1'],
                    'movie_time' => Carbon::createFromFormat('h:i A', $movie['value2']),
                ]);
            }

            DB::commit();

            session()->flash('success', 'Event created successfully.');

            return response()->json(['status' => true, 'route' => route('events.index')]);
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', 'An error occurred. Please try again.' . $e->getMessage());
            return response()->json(['status' => false, 'route' => route('events.index')]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        try {
            $event = Event::with('event_movies')->findOrFail($id);
            if ($request->ajax()) {
                return \response()->json(['data' => $event->event_movies]);
            }
            return view('event.show', compact('event'));
        } catch (ModelNotFoundException) {
            return redirect()->route('events.index')->with('error', 'Event not found');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $moives = Movie::without('showTimes')
                ->select('id', 'name')
                ->get();

            $event = Event::with('event_movies')->findOrFail($id);

            $moviesData = [];
            foreach ($event->event_movies as $mo) {
                $moviesData[$mo->movie->id] = [
                    "value1" => $mo->movie->id,
                    "value2" => Carbon::parse($mo->movie_time)->format('h:i A'),
                    "moviename" => $mo->movie->name
                ];
            }

            $moviesJson = json_encode(array_values($moviesData));

            return view('event.edit', compact('event', 'moives', 'moviesJson'));
        } catch (ModelNotFoundException) {
            return redirect()->route('events.index')->with('error', 'Event not found');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventUpdateRequest $request, Event $event)
    {
        try {
            DB::beginTransaction();

            $validatedData = $request->validated();

            $event->update([
                'name' => $validatedData['name'],
                'event_time' => $validatedData['date'],
                'active' => $validatedData['active'],
            ]);

            $event->event_movies()->delete();

            foreach ($validatedData['movies'] as $movie) {
                $event->event_movies()->create([
                    'movie_id' => $movie['value1'],
                    'movie_time' => Carbon::createFromFormat('h:i A', $movie['value2']),
                ]);
            }

            DB::commit();

            session()->flash('success', 'Event updated successfully.');

            return response()->json(['status' => true, 'route' => route('events.index')]);
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', 'An error occurred. Please try again.' . $e->getMessage());
            return response()->json(['status' => false, 'route' => route('events.index')]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $event = Event::findOrFail($id);
            $event->event_movies()->delete();
            $event->delete();
            return redirect()->route('events.index')->with('success', 'Event delete successfully.');
        } catch (ModelNotFoundException) {
            return redirect()->route('events.index')->with('error', 'Event not found');
        }
    }
}
