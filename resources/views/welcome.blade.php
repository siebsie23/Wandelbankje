<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bankjes in je omgeving') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div id="map" class="h-80 z-0"></div>
                    <br />
                    <div class="bg-white shadow overflow-hidden sm:rounded-md">
                        <ul id="bench-list" class="divide-y divide-gray-200">

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
