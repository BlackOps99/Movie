<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Showtime;
use Illuminate\Http\Request;
use App\Http\Requests\Showtime\ShowtimeStoreRequest;
use App\Http\Requests\Showtime\ShowtimeUpdateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;

class ShowtimeController extends Controller
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
        $showtimes = Showtime::with('movie')
            ->latest()
            ->paginate(10);

        return view('show-time.index', compact('showtimes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $movies = Movie::without('showTimes')->select('id', 'name')->get();

        $data = [
            'data' => $movies->pluck('name', 'id')->toArray(),
            'emptyOptionsMessage' => 'No movie match your search.',
            'name' => 'movie',
            'placeholder' => 'Select a movie',
        ];

        $json = json_encode($data);

        return view('show-time.create', compact('json'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShowtimeStoreRequest $request)
    {
        $data = [
            "hours" => $request->hours,
            "minutes" => $request->minutes,
            "period" => $request->period,
        ];

        // Convert 12-hour time to 24-hour format if needed
        if ($data['period'] === "PM" && $data['hours'] !== "12") {
            $data['hours'] = (string)((int)$data['hours'] + 12);
        } elseif ($data['period'] === "AM" && $data['hours'] === "12") {
            $data['hours'] = "00";
        }

        $resultDatetime = Carbon::parse($request->date)->addHours($data['hours'])->addMinutes($request->minutes);

        Showtime::create([
            'datetime' => $request->date,
            'time' => $resultDatetime,
            'movie_id' => $request->movie_id,
            'active' => $request->input('active') === '1'
        ]);

        return redirect()->route('show-times.index')->with('success', 'Showtime created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        try {

            if($request->ajax())
            {
                $showtimes = Showtime::with('movie')->where('movie_id', '=', $id)->get();
            
                $formattedShowtimes = $showtimes->map(function ($showtime) {
                    $showtime->formatted_datetime = Carbon::parse($showtime->datetime)->format('Y-m-d');
                    $showtime->formatted_time = Carbon::parse($showtime->time)->format('h:i A');
                    return $showtime;
                });

                return \response()->json(['data' => $formattedShowtimes]);
            }

            $showtime = Showtime::with('movie')->findOrFail($id);
            return view('show-time.show', compact('showtime'));
        } catch (ModelNotFoundException) {
            return redirect()->route('show-times.index')->with('error', 'Showtime not found');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {           
            $showtime = Showtime::with('movie')->findOrFail($id);

            $movies = Movie::without('showTimes')->select('id', 'name')->get();

            $timeCarbon = Carbon::parse($showtime->time);

            $date = [
                'datetime' => Carbon::parse($showtime->datetime)->format('Y-m-d'),
                "hours" => $timeCarbon->format('h'),
                "minutes" => $timeCarbon->format('i'),
                "period" => $timeCarbon->format('A')
            ];

            $data = [
                'data' => $movies->pluck('name', 'id')->toArray(),
                'value' => $showtime->movie->id,
                'emptyOptionsMessage' => 'No movie match your search.',
                'name' => 'movie',
                'placeholder' => 'Select a movie',
            ];

            $json = json_encode($data);

            return view('show-time.edit', compact('showtime', 'date', 'json'));
        } catch (ModelNotFoundException) {
            return redirect()->route('show-times.index')->with('error', 'Showtime not found');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ShowtimeUpdateRequest $request, string $id)
    {
        try {
            $showtime = Showtime::findOrFail($id);

            $data = [
                "hours" => $request->hours,
                "minutes" => $request->minutes,
                "period" => $request->period,
            ];

            // Convert 12-hour time to 24-hour format if needed
            if ($data['period'] === "PM" && $data['hours'] !== "12") {
                $data['hours'] = (string)((int)$data['hours'] + 12);
            } elseif ($data['period'] === "AM" && $data['hours'] === "12") {
                $data['hours'] = "00";
            }

            $resultDatetime = Carbon::parse($request->date)->addHours($data['hours'])->addMinutes($request->minutes);

            $showtime->update([
                'datetime' => $request->date,
                'time' => $resultDatetime,
                'movie_id' => $request->movie_id,
                'active' => $request->input('active') === '1'
            ]);

            return redirect()->route('show-times.index')->with('success', 'Showtime updated successfully.');
        } catch (ModelNotFoundException) {
            return redirect()->route('show-times.index')->with('error', 'Showtime not found');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $showtime = Showtime::without('movie')->findOrFail($id);
            $showtime->delete();
            return redirect()->route('show-times.index')->with('success', 'Showtime delete successfully.');
        } catch (ModelNotFoundException) {
            return redirect()->route('show-times.index')->with('error', 'Showtime not found');
        }
    }
}
