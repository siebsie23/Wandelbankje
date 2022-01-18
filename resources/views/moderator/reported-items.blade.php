<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gerapporteerde items') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('alert'))
                <div class="text-center py-4 lg:px-4">
                    <div class="p-2 bg-red-800 items-center text-red-100 leading-none lg:rounded-full flex lg:inline-flex" role="alert">
                        <span class="font-semibold mr-2 text-left flex-auto">{{ session('alert') }}</span>
                    </div>
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <ul id="bench-list" class="divide-y divide-gray-200">
                        @foreach(\App\Models\ReportedBench::all()->sortByDesc('amount_reported') as $reported_bench)
                            @php
                                // IDE may give error but code is working.
                                $bench = \App\Models\Bench::find($reported_bench->bench);
                                $reason = \App\Models\ReportReasons::find($reported_bench->reason)->reason;
                            @endphp
                            <li>
                                <div class="px-4 py-4 sm:px-6">
                                    <div class="grid grid-cols-2 flex items-center justify-between">
                                        <p class="truncate">{{ \App\Http\Controllers\BenchController::getReverseLocationAddress($bench->latitude, $bench->longitude) }}</p>
                                        <div class="flex justify-end">
                                            <a href="{{ route('bench.reset', [$bench->id, $reported_bench->id, 1]) }}" class="ml-1 mr-1 p-2 pl-5 pr-5 transition-colors duration-700 transform bg-indigo-500 hover:bg-blue-400 text-gray-100 text-lg rounded-lg focus:border-4 border-indigo-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('bench.reset', [$bench->id, $reported_bench->id, 0]) }}" class="ml-1 mr-1 p-2 pl-5 pr-5 transition-colors duration-700 transform bg-red-500 hover:bg-red-400 text-gray-100 text-lg rounded-lg focus:border-4 border-red-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="mt-2 sm:flex sm:justify-between">
                                        <div class="sm:flex">
                                            <p class="flex items-center text-sm font-light text-gray-500">
                                                {{ $bench->latitude . ' ' . $bench->longitude }} <br/>
                                                {{ $reported_bench->amount_reported . 'x ' . $reason }}
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
