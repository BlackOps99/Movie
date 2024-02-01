<x-layouts.main>
    <div class="flex">
        <div class="w-full max-w-full px-3 mt-6 md:flex-none">
            <div
                class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 px-4 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <h6 class="mb-0">Edit Event</h6>
                </div>
                <div class="flex-auto p-4 pt-6">
                    @if (session('status'))
                        <div class="mt-5 text-red-500">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form x-data="ContactForm()" x-ref="myForm" @submit.prevent="submitForm">
                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Event Name</label>
                        <div class="mb-4">
                            <input type="text" id="name" name="name"
                                value="{{ $event->name }}"
                                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow"
                                placeholder="Event Name" />
                        </div>
                        <template x-if="errors['name']">
                            <div x-text="errors['name']" class="text-red-500"></div>
                        </template>
                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Movie Name</label>
                        <div x-data="{ selectedValue1: '', selectedValue2: '', moviename: '', options: [] }">
                            <div>
                                <select
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow"
                                    id="firstInput" @change="getShowtimes" x-model="selectedValue1">
                                    <option>Select a moive</option>
                                    @foreach ($moives as $moive)
                                        <option value="{{ $moive->id }}">{{ $moive->name }}</option>
                                    @endforeach
                                </select>

                                <div x-show="selectedValue1 !== ''">
                                    <!-- Second Input with dynamic data based on the selection -->
                                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Time</label>
                                    <select
                                        class="mb-5 focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow"
                                        id="secondInput" x-model="selectedValue2">
                                        <option>Select</option>
                                        <template x-for="option in options.data">
                                            <option x-bind:value="option.formatted_time" x-text="option.formatted_time">
                                            </option>
                                        </template>
                                    </select>

                                    <button
                                        class="px-4 py-3 mb-2 font-bold text-center text-white uppercase align-middle transition-all border border-transparent border-solid rounded-lg cursor-pointer xl-max:cursor-not-allowed xl-max:opacity-65 xl-max:pointer-events-none xl-max:bg-gradient-to-tl xl-max:from-purple-700 xl-max:to-pink-500 xl-max:text-white xl-max:border-0 hover:scale-102 hover:shadow-soft-xs active:opacity-85 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 bg-gradient-to-tl from-purple-700 to-pink-500 bg-fuchsia-500 hover:border-fuchsia-500"
                                        type="button" @click="addToSelectedValues">Add</button>
                                </div>
                                <div class="flex-auto px-0 pt-0 pb-2">
                                    <div class="p-0 overflow-x-auto">
                                        <table
                                            class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                                            <thead class="align-bottom">
                                                <tr>
                                                    <th
                                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                                        Movie Name</th>
                                                    <th
                                                        class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                                        Time</th>
                                                    <th
                                                        class="px-6 py-3 font-semibold capitalize align-middle bg-transparent border-b border-gray-200 border-solid shadow-none tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <template x-for="(values, index) in movies" :key="index">
                                                    <tr>
                                                        <td
                                                            class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                                            <div class="flex px-2 py-1">
                                                                <div class="flex flex-col justify-center">
                                                                    <h6 x-text="values.moviename"
                                                                        class="mb-0 text-sm leading-normal"></h6>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                                            <span x-text="values.value2"
                                                                class="text-xs font-semibold leading-tight text-slate-400"></span>
                                                        </td>
                                                        <td
                                                            class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                                            <button type="button" class="text-xs font-semibold leading-tight text-red-500" @click="removeMovie(index)">Delete</button>
                                                        </td>
                                                    </tr>
                                                </template>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <template x-if="errors['movies']">
                            <div x-text="errors['movies']" class="text-red-500"></div>
                        </template>
                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Select Event Date</label>
                        <x-date-input :currentdate="$event->datetime"></x-date-input>
                        <template x-if="errors['date']">
                            <div x-text="errors['date']" class="text-red-500"></div>
                        </template>
                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700" for="active">Event Status</label>
                        <div class="min-h-6 mb-4 ml-1 block pl-12">
                            <input id="active" name="active"
                                class="mt-0.54 rounded-10 duration-250 ease-soft-in-out after:rounded-circle after:shadow-soft-2xl after:duration-250 checked:after:translate-x-5.25 h-5 relative float-left -ml-12 w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-slate-800/95 checked:bg-slate-800/95 checked:bg-none checked:bg-right"
                                type="checkbox" value="1" checked="" />
                        </div>
                        <template x-if="errors['active']">
                            <div x-text="errors['active']" class="text-red-500"></div>
                        </template>
                        <button
                            class="inline-block w-full px-4 py-3 mb-2 font-bold text-center text-white uppercase align-middle transition-all border border-transparent border-solid rounded-lg cursor-pointer xl-max:cursor-not-allowed xl-max:opacity-65 xl-max:pointer-events-none xl-max:bg-gradient-to-tl xl-max:from-purple-700 xl-max:to-pink-500 xl-max:text-white xl-max:border-0 hover:scale-102 hover:shadow-soft-xs active:opacity-85 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 bg-gradient-to-tl from-purple-700 to-pink-500 bg-fuchsia-500 hover:border-fuchsia-500">
                            Update
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function ContactForm() {
            return {
                movies: {!! $moviesJson !!},
                selectedValue1: '',
                selectedValue2: '',
                options: [],
                errors: [],

                getDateInputValue() {
                    var hiddenInput = document.querySelector('[x-ref="date"]');
                    if (hiddenInput) {
                        return hiddenInput.value;
                    }
                },

                addToSelectedValues() {
                    if (this.selectedValue2 === 'Select' || this.selectedValue2 === '')
                        return;

                    this.movies.push({
                        value1: this.selectedValue1,
                        value2: this.selectedValue2,
                        moviename: this.options.data.find(item => item.movie_id == this.selectedValue1)?.movie
                            ?.name || '',
                    });

                    this.selectedValue1 = '';
                    this.selectedValue2 = '';
                },

                removeMovie(index) {
                    this.movies.splice(index, 1);
                },

                getShowtimes() {
                    this.options = [];
                    axios.get('{{ route('show-times.show', ':id') }}'.replace(':id', this.selectedValue1))
                        .then(response => {
                            this.options = response.data;
                        })
                        .catch(error => {
                            console.error('Error fetching data:', error);
                        });
                },

                submitForm() {
                    const formData = {
                        movies: this.movies,
                        name: document.getElementById('name').value,
                        active: document.getElementById('active').checked,
                        date: this.getDateInputValue(),
                    };

                    axios.put('http://127.0.0.1:8000/events/6', formData)
                        .then(response => {
                            window.location.href = response.data.route;
                        })
                        .catch(error => {
                            console.log(error);
                            if (error.response.status === 422) {
                                this.errors = error.response.data.errors;
                            } else {
                                console.error('Error submitting form:', error);
                            }
                        });
                },
            };
        }
    </script>
</x-layouts.main>
