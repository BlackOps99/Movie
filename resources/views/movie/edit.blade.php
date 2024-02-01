<x-layouts.main>
    @if ($message = Session::get('success'))
        <div class="relative w-full p-4 mb-4 text-white rounded-lg bg-lime-500">{{ $message }}</div>
    @endif
    @if ($message = Session::get('error'))
        <div alert
            class="relative w-full p-4 mb-4 text-white border border-red-300 border-solid rounded-lg bg-gradient-to-tl from-red-600 to-rose-400">
            {{ $message }}</div>
    @endif
    <div class="flex">
        <div class="w-full max-w-full px-3 mt-6 md:flex-none">
            <div
                class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 px-4 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <h6 class="mb-0">Edit Movie</h6>
                </div>
                <div class="flex-auto p-4 pt-6">
                    @if (session('status'))
                        <div class="mt-5 text-red-500">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('movies.update', $movie->id) }}" enctype="multipart/form-data">     
                        @csrf
                        @method('PUT')
                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Movie Name</label>
                        <div class="mb-4">
                            <input type="text" id="name" name="name" value="{{ $movie->name }}"
                                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow"
                                placeholder="Movie Name" />
                        </div>
                        @error('name')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                        <div class="py-4 pr-1 mb-4 rounded-xl">
                            <div>
                                <img src="{{ $movie->picture }}"
                                    class="inline-flex items-center justify-center mr-4 text-sm text-white transition-all duration-200 ease-soft-in-out h-50 w-50 object-contain rounded-xl"
                                    alt="movie-image" />
                            </div>
                        </div>
                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Movie Image</label>
                        <input
                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow mb-5"
                            type="file" id="picture" name="picture">
                        @error('picture')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700" for="active">Movie Status</label>
                        <div class="min-h-6 mb-4 ml-1 block pl-12">
                            <input id="active" name="active" class="mt-0.54 rounded-10 duration-250 ease-soft-in-out after:rounded-circle after:shadow-soft-2xl after:duration-250 checked:after:translate-x-5.25 h-5 relative float-left -ml-12 w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-slate-800/95 checked:bg-slate-800/95 checked:bg-none checked:bg-right"
                            type="checkbox" {{ $movie->active ? 'checked' : '' }} />
                        </div>
                        @error('active')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Description</label>
                        <textarea id="description" name="description"
                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow mb-5"
                            rows="4" cols="50">{{ $movie->description }}</textarea>
                        @error('description')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                        <button type="submit"
                            class="inline-block w-full px-4 py-3 mb-2 font-bold text-center text-white uppercase align-middle transition-all border border-transparent border-solid rounded-lg cursor-pointer xl-max:cursor-not-allowed xl-max:opacity-65 xl-max:pointer-events-none xl-max:bg-gradient-to-tl xl-max:from-purple-700 xl-max:to-pink-500 xl-max:text-white xl-max:border-0 hover:scale-102 hover:shadow-soft-xs active:opacity-85 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 bg-gradient-to-tl from-purple-700 to-pink-500 bg-fuchsia-500 hover:border-fuchsia-500">
                            Edit </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.main>
