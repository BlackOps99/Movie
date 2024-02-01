@props(['events'])
@foreach ($events as $event)
    <div
        class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border m-2">
        <div class="flex-auto px-1 pt-6">
            <a class="pr-4 mr-4" href="{{ route('events.show', $event->id) }}">
                <h5 class="pr-4">{{ $event->name }}</h5>
            </a>
            <p class="pr-4 mr-4"
                class="relative z-10 mb-2 leading-normal text-transparent bg-gradient-to-tl from-gray-900 to-slate-800 text-sm bg-clip-text">
                Event Time</p>
            <p class="mb-6 leading-normal text-sm">Day: {{ \Carbon\Carbon::parse($event->event_time)->format('d/m/Y') }}</p>
        </div>
    </div>
@endforeach
