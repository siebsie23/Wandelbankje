<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gebruiker verwijderen') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <span class="block tracking-wide text-gray-700 text-lg mb-3">Weet je zeker dat je ({{ ucfirst($user->role) . ') ' . $user->name }} wilt verwijderen?</span>

                    <div class="flex grid grid-cols-2 w-full">
                        <div class="w-full flex justify-center">
                            <a href="{{ route('admin_users') }}" class="ml-1 mr-1 p-2 pl-5 pr-5 transition-colors duration-700 transform bg-red-500 hover:bg-red-400 text-gray-100 text-lg rounded-lg focus:border-4 border-red-300 flex justify-center w-full">
                                Annuleren
                            </a>
                        </div>
                        <div class="w-full flex justify-center">
                            <form method="POST" action="{{ route('admin_users_destroy', $user->id) }}" class="w-full flex justify-center">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ml-1 mr-1 p-2 pl-5 pr-5 transition-colors duration-700 transform bg-indigo-500 hover:bg-indigo-400 text-gray-100 text-lg rounded-lg focus:border-4 border-indigo-300 flex justify-center w-full">
                                    Opslaan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
