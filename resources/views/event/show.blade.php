<x-layouts.main>
    <div class="flex mt-6 -mx-3">
        <div class="w-full max-w-full px-3 mt-0 lg:flex-none">
            <div
                class="border-black/12.5 shadow-soft-xl relative z-20 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                <div class="border-black/12.5 mb-0 rounded-t-2xl border-b-0 border-solid bg-white p-6 pb-0">
                    <h6>{{ $event->name }}</h6>
                </div>
                <div class="flex-auto p-5">
                    Event Time: {{ \Carbon\Carbon::parse($event->event_time)->format('d/m/Y') }}
                </div>
            </div>
            <div
                class="border-black/12.5 shadow-soft-xl relative z-20 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border mt-4">
                <div class="flex border-black/12.5 mb-0 justify-center items-center rounded-t-2xl border-b-0 border-solid bg-white p-6 pb-0">
                    <h6>Movies</h6>
                </div>
                <div class="flex-auto p-4">

                </div>
            </div>
        </div>
    </div>
    <div class="lg:grid lg:grid-cols-4 mt-6 -mx-3">
        <x-movie-event-card :event_movies="$event->event_movies"></x-movie-event-card>
    </div>
</x-layouts.main>
