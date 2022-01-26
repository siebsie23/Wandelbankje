<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Foto toevoegen') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex items-center">
                        <!-- Foto form -->
                        <form method="POST" action="{{ route('bench.post') }}" enctype="multipart/form-data" class="mx-auto w-full max-w-lg">
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full px-3 mb-6 md:mb-0">
                                    <!-- Validation Errors -->
                                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                                </div>
                            </div>
                            @csrf
                            <input type="hidden" id="bench" name="bench" value="{{$bench->id}}">
                            <div>
                                <h2 class="text-lg -leading-10" id="adress">{{ $address }}</h2>
                                <p class="flex items-center text-sm font-light text-gray-500" id="coordinates">{{ $bench->latitude . ' ' . $bench->longitude }}</p>
                            </div>
                            <hr/>
                            <div class="grid grid-cols-1 mt-5 mx-7">
                                <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold mb-1">Foto toevoegen</label>
                                <div class='flex items-center justify-center w-full'>
                                    <!--for preview purpose -->
                                    <img src="#" id="category-img-tag" class="hidden flex flex-col border-4 border-dashed w-full hover:bg-gray-100 hover:border-purple-300 group" />

                                    <label id="selector" class='flex flex-col border-4 border-dashed w-full h-32 hover:bg-gray-100 hover:border-purple-300 group'>
                                        <div class='flex flex-col items-center justify-center pt-7'>
                                            <svg class="w-10 h-10 text-purple-400 group-hover:text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            <p class='lowercase text-sm text-gray-400 group-hover:text-purple-600 pt-1 tracking-wider'>Selecteer een foto</p>
                                        </div>
                                        <input type='file' class="hidden" name="image" id="image" />
                                    </label>
                                </div>
                            </div>
                            <br/>
                            <div class="flex flex-wrap -mx-3 mb-2">
                                <div class="flex grid grid-cols-2 w-full">
                                    <div class="w-full flex justify-center">
                                        <a href="{{ route('bench.details', $bench->id) }}" class="ml-1 mr-1 p-2 pl-5 pr-5 transition-colors duration-700 transform bg-red-500 hover:bg-red-400 text-gray-100 text-lg rounded-lg focus:border-4 border-red-300 flex justify-center w-full">
                                            Annuleren
                                        </a>
                                    </div>
                                    <div class="w-full flex justify-center">
                                        <button type="submit" class="ml-1 mr-1 p-2 pl-5 pr-5 transition-colors duration-700 transform bg-indigo-500 hover:bg-indigo-400 text-gray-100 text-lg rounded-lg focus:border-4 border-indigo-300 flex justify-center w-full">
                                            Toevoegen
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
