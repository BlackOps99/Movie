<x-layouts.main>
    @if ($message = Session::get('success'))
        <div class="relative w-full p-4 mb-4 text-white rounded-lg bg-lime-500">{{ $message }}</div>
    @endif
    <div class="flex">
        <div class="w-full max-w-full px-3 mt-6 md:flex-none">
            <div
                class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 px-4 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <h6 class="mb-0">Registration</h6>
                </div>
                <div class="flex-auto p-4 pt-6">
                    @if (session('status'))
                        <div class="mt-5 text-red-500">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('event-registration.store') }}">
                        @csrf
                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Name</label>
                        <div class="mb-4">
                            <input type="text" 
                                id="name" 
                                name="name" 
                                value="{{ old('name') }}"
                                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow"
                                placeholder="Name" />
                        </div>
                        @error('name')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror

                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Mobile</label>
                        <div class="mb-4">
                            <input type="text" id="mobile" name="mobile" value="{{ old('mobile') }}"
                                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow"
                                placeholder="Mobile" />
                        </div>
                        @error('mobile')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror

                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Email</label>
                        <div class="mb-4">
                            <input type="text" id="email" name="email" value="{{ old('email') }}"
                                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow"
                                placeholder="Email" />
                        </div>
                        @error('email')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror

                        <div x-data="{ movies: [], showtimes: [], datas:[], selectedEvent: '', selectedMovie: '' }">
                            <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Event</label>
                            <div class="mb-4">
                                <select
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow"
                                    x-model="selectedEvent"
                                    id="event_id"
                                    name="event_id"
                                    @change="getEventMovies">
                                    <option>Select a event</option>
                                    @foreach ($events as $event)
                                        <option value="{{ $event->id }}">{{ $event->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('event_id')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror

                            <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Movie</label>
                            <div class="mb-4">
                                <select
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow"
                                    x-model="selectedMovie"
                                    id="movie_id"
                                    name="movie_id"
                                    @change="getMovieShowTime">
                                    <option>Select a movie</option>
                                    <template x-for="(values, index) in movies" :key="index">
                                        <option :value="values.id" x-text="values.name"></option>
                                    </template>
                                </select>
                            </div>
                            @error('movie_id')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror

                            <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Show time</label>
                            <div class="mb-4">
                                <select
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow"
                                    id="showtime"
                                    name="showtime">
                                    <option>Select a show time</option>
                                    <template x-for="(values, index) in showtimes" :key="index">
                                        <option :value="values" x-text="values"></option>
                                    </template>
                                </select>
                            </div>
                            @error('showtime')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit"
                            class="inline-block w-full px-4 py-3 mb-2 font-bold text-center text-white uppercase align-middle transition-all border border-transparent border-solid rounded-lg cursor-pointer xl-max:cursor-not-allowed xl-max:opacity-65 xl-max:pointer-events-none xl-max:bg-gradient-to-tl xl-max:from-purple-700 xl-max:to-pink-500 xl-max:text-white xl-max:border-0 hover:scale-102 hover:shadow-soft-xs active:opacity-85 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 bg-gradient-to-tl from-purple-700 to-pink-500 bg-fuchsia-500 hover:border-fuchsia-500">
                            Register </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function getEventMovies() {
            this.movies = [];
            axios.get('{{ route('events.show', ':id') }}'.replace(':id', this.selectedEvent))
                .then(response => {
                    this.datas = response.data;
                    this.movies = response.data.data.map(item => item.movie);
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        };

        function getMovieShowTime() {
            this.showtimes = [];
            this.datas.data.forEach(item => {
                if (item.movie_id === Number(this.selectedMovie)) {
                    const formattedTime = new Date(item.movie_time).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true });
                    this.showtimes.push(formattedTime)
                }
            });
        }
    </script>
</x-layouts.main>
