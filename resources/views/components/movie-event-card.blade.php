@props(['event_movies'])
@foreach ($event_movies as $movie)
    <div
        class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border m-2">
        <div class="relative">
            <a class="block shadow-xl rounded-2xl">
                <img src="{{ $movie->movie->picture }}" alt="img-blur-shadow"
                    class="max-w-full shadow-soft-2xl rounded-2xl" />
            </a>
        </div>
        <div class="flex-auto px-1 pt-6">
            <a href="{{ route('movies.show', $movie->movie->id) }}">
                <h5>{{ $movie->movie->name }}</h5>
            </a>
        </div>
        @if ($movie->movie->showTimes->count() > 0)
            @foreach ($movie->movie->showTimes as $showtime)
                <div class="flex-auto px-1 pt-6">
                    {{$loop->iteration}} Time: {{ \Carbon\Carbon::parse($showtime->time)->format('h:i A') }}
                </div>
            @endforeach
        @else
            <div class="flex-auto px-1 pt-6">
                No show time for this movie
            </div>
        @endif
    </div>
@endforeach
