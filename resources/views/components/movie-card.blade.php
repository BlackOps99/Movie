@props(['moives'])
@foreach ($moives as $moive)
    <div
        class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border m-2">
        <div class="relative">
            <a class="block shadow-xl rounded-2xl">
                <img src="{{ $moive->picture }}" alt="img-blur-shadow" class="max-w-full shadow-soft-2xl rounded-2xl" />
            </a>
        </div>
        <div class="flex-auto px-1 pt-6">
            <a href="{{ route('movies.show', $moive->id) }}">
                <h5>{{ $moive->name }}</h5>
            </a>
            <p
                class="relative z-10 mb-2 leading-normal text-transparent bg-gradient-to-tl from-gray-900 to-slate-800 text-sm bg-clip-text">
                Description</p>
            <p class="mb-6 leading-normal text-sm">{{ $moive->description }}.</p>
        </div>
    </div>
@endforeach
