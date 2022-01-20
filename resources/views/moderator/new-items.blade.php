<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nieuwe Items') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <ul id="bench-list" class="divide-y divide-gray-200">
                        <!-- New Benches -->
                        @foreach(\App\Models\Bench::where('is_new', true)->get() as $bench)
                            <li>
                                <div class="px-4 py-4 sm:px-6">
                                    <div class="grid grid-cols-2 flex items-center justify-between">
                                        <p class="truncate">{{ \App\Http\Controllers\BenchController::getReverseLocationAddress($bench->latitude, $bench->longitude) }}</p>
                                        <div class="flex justify-end">
                                            <a href="{{ route('bench.approve', [$bench->id, 1]) }}" class="ml-1 mr-1 p-2 pl-5 pr-5 transition-colors duration-700 transform bg-indigo-500 hover:bg-blue-400 text-gray-100 text-lg rounded-lg focus:border-4 border-indigo-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('bench.approve', [$bench->id, 0]) }}" class="ml-1 mr-1 p-2 pl-5 pr-5 transition-colors duration-700 transform bg-red-500 hover:bg-red-400 text-gray-100 text-lg rounded-lg focus:border-4 border-red-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="mt-2 sm:flex sm:justify-between">
                                        <div class="sm:flex">
                                            <p class="flex items-center text-sm font-light text-gray-500">
                                                {{ $bench->latitude . ' ' . $bench->longitude }} | Ingezonden door: {{ \App\Models\User::find($bench->added_by)->email }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach

                        <!-- New Photos -->
                        @foreach(\App\Models\Photo::where('is_new', true)->get() as $photo)
                            <li>
                                <div class="px-4 py-4 sm:px-6">
                                    <div class="grid grid-cols-2 flex items-center justify-between">
                                        <img src="{{ asset('images/benches/' . $photo->path) }}" class="object-cover h-32">
                                        <div class="flex justify-end">
                                            <a href="{{ route('photo.approve', [$photo->id, 1]) }}" class="ml-1 mr-1 p-2 pl-5 pr-5 transition-colors duration-700 transform bg-indigo-500 hover:bg-blue-400 text-gray-100 text-lg rounded-lg focus:border-4 border-indigo-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('photo.approve', [$photo->id, 0]) }}" class="ml-1 mr-1 p-2 pl-5 pr-5 transition-colors duration-700 transform bg-red-500 hover:bg-red-400 text-gray-100 text-lg rounded-lg focus:border-4 border-red-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="mt-2 sm:flex sm:justify-between">
                                        <div class="sm:flex">
                                            <p class="flex items-center text-sm font-light text-gray-500">
                                                Ingezonden door: {{ \App\Models\User::find($photo->added_by)->email }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <br/>
                    <p class="flex justify-center text-sm font-light text-gray-500">
                        Dit is het einde van de lijst!
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
