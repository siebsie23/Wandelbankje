<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bankje rapporteren') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <img src="https://via.placeholder.com/1000x500" class="object-scale-down w-full">
                    <br/>
                    <h2>{{ $address }}</h2>
                    <p class="flex items-center text-sm font-light text-gray-500">{{ $bench->latitude . ' ' . $bench->longitude }}</p>
                    <hr/>
                    <p class="text-lg">Waarvoor wil je dit bankje rapporteren?</p>
                    <div class="flex">
                        <form method="POST" action="{{ route('bench.postreport', $bench->id) }}" class="w-full">
                            @csrf
                            <div class="w-full">
                                @foreach(\App\Models\ReportReasons::all() as $reportreason)
                                <div class="form-check">
                                    <input class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="radio" id="{{$reportreason->id}}" value="{{$reportreason->id}}" @if($reportreason->id == 1) checked @endif>
                                    <label class="form-check-label inline-block text-gray-800" for="{{$reportreason->id}}">
                                        {{ $reportreason->reason }}
                                    </label>
                                </div>
                                @endforeach
                                <br/>
                                <div class="flex grid grid-cols-2 w-full">
                                    <div class="w-full flex justify-center">
                                        <a href="{{ route('bench.details', $bench->id) }}" class="ml-1 mr-1 p-2 pl-5 pr-5 transition-colors duration-700 transform bg-red-500 hover:bg-red-400 text-gray-100 text-lg rounded-lg focus:border-4 border-red-300 flex justify-center w-full">
                                            Annuleren
                                        </a>
                                    </div>
                                    <div class="w-full flex justify-center">
                                        <button type="submit" class="ml-1 mr-1 p-2 pl-5 pr-5 transition-colors duration-700 transform bg-indigo-500 hover:bg-indigo-400 text-gray-100 text-lg rounded-lg focus:border-4 border-indigo-300 flex justify-center w-full">
                                            Rapporteren
                                        </button>
                                    </div>

                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
