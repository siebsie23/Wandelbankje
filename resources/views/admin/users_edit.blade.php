<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gebruiker bewerken') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex items-center">
                        <!-- Account form -->
                        <form method="POST" action="{{ route('edit-user', $user->id) }}" class="mx-auto w-full max-w-lg">
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full px-3 mb-6 md:mb-0">
                                    <!-- Validation Errors -->
                                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                                </div>
                            </div>
                            @csrf
                            <input value="{{ $user->id }}" type="hidden" name="userId">
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
                                        Naam
                                    </label>
                                    <input value="{{ $user->name }}" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="name" name="name" type="text" placeholder="Voornaam Achternaam" required>
                                </div>
                            </div>
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
                                        Email
                                    </label>
                                    <input value="{{ $user->email }}" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="email" name="email" type="email" placeholder="email@technova.nl" required>
                                </div>
                            </div>
                            <div class="flex flex-wrap -mx-3 mb-2">
                                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-state">
                                        Rol
                                    </label>
                                    <div class="relative">
                                        <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="role" name="role">
                                            <option value="admin" @if($user->role == "admin") selected @endif >Beheerder</option>
                                            <option value="moderator"  @if($user->role == "moderator") selected @endif>Moderator</option>
                                            <option value="user" @if($user->role == "user") selected @endif>Gebruiker</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-wrap -mx-3 mb-2">
                                <div class="flex grid grid-cols-2 w-full">
                                    <div class="w-full flex justify-center">
                                        <a href="{{ route('admin_users') }}" class="ml-1 mr-1 p-2 pl-5 pr-5 transition-colors duration-700 transform bg-red-500 hover:bg-red-400 text-gray-100 text-lg rounded-lg focus:border-4 border-red-300 flex justify-center w-full">
                                            Annuleren
                                        </a>
                                    </div>
                                    <div class="w-full flex justify-center">
                                        <button type="submit" class="ml-1 mr-1 p-2 pl-5 pr-5 transition-colors duration-700 transform bg-indigo-500 hover:bg-indigo-400 text-gray-100 text-lg rounded-lg focus:border-4 border-indigo-300 flex justify-center w-full">
                                            Opslaan
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
