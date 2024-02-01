<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Http\Requests\Movie\MovieStoreRequest;
use App\Http\Requests\Movie\MovieUpdateRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MovieController extends Controller
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
        $moives = Movie::when(auth()->guard('admin')->check(), 
            fn ($query) => $query->latest(),
            fn ($query) => $query->where('active', true)->latest())
            ->paginate(10);
        return view('movie.index', compact('moives'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('movie.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MovieStoreRequest $request)
    {
        try
        {
            $file = $request->file('picture');
            $filename = $file->getClientOriginalName();
            Storage::disk('public')->put('movies/images/'.$filename, file_get_contents($file));

            Movie::create([
                'name' => $request->name,
                'picture' => 'movies/images/'.$filename,
                'description' => $request->description,
                'active' => $request->input('active') === 'on'
            ]);

            return redirect()->route('movies.index')->with('success', 'Movie created successfully.');
        }
        catch(\Exception $e)
        {
            return redirect()->route('movies.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try 
        {
            $movie = Movie::findOrFail($id);
            return view('movie.show', compact('movie'));
        }
        catch (ModelNotFoundException) {
            return redirect()->route('movies.index')->with('error', 'Movie not found');
        }   
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try 
        {
            $movie = Movie::findOrFail($id);
            return view('movie.edit', compact('movie'));
        }
        catch (ModelNotFoundException) {
            return redirect()->route('movies.index')->with('error', 'Movie not found');
        } 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MovieUpdateRequest $request, string $id)
    {
        try 
        {
            $movie = Movie::findOrFail($id);

            if ($request->hasFile('picture')) {

                if (Storage::disk('public')->exists($movie->picture)) {
                    Storage::disk('public')->delete($movie->picture);
                }

                $file = $request->file('picture');
                $filename = $file->getClientOriginalName();
                Storage::disk('public')->put('movies/images/'.$filename, $file->getContent());
                $movie->picture = 'movies/images/'.$filename;
            }

            $movie->update([
                'name' => $request->name,
                'description' => $request->description,
                'active' => $request->input('active') === 'on'
            ]);

            return redirect()->route('movies.index')->with('success', 'Movie edit successfully.');
        }
        catch (ModelNotFoundException) {
            return redirect()->route('movies.index')->with('error', 'Movie not found');
        } 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try 
        {
            $movie = Movie::findOrFail($id);
            $movie->delete();
            return redirect()->route('movies.index')->with('success', 'Movie delete successfully.');
        }
        catch (ModelNotFoundException) {
            return redirect()->route('movies.index')->with('error', 'Movie not found');
        } 
    }
}
