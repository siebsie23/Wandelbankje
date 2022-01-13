<nav x-data="{ open: false }" class="bg-red-500">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center text-white text-xl">
                    <!-- Hamburger -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white transition duration-150 ease-in-out">
                            <svg class="h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div style="border-left:2px solid #ffffff;height:60%; padding-right: 10px; margin-left: 5px;"></div>

                    Wandelbankje.nl
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('welcome')" :active="request()->routeIs('welcome')">
                        {{ __('Bankjes in je omgeving') }}
                    </x-nav-link>
                    <x-nav-link :href="route('global')" :active="request()->routeIs('global')">
                        {{ __('Alle bankjes') }}
                    </x-nav-link>
                    @if(isset(Auth::user()->name))
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('admin_dashboard')||request()->routeIs('moderator_dashboard')||request()->routeIs('user_dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                        <x-nav-link :href="route('bankjestoevoegen')" :active="request()->routeIs('bankjestoevoegen')">
                            {{ __('Bankje toevoegen') }}
                        </x-nav-link>
                        @if(Auth::user()->role == 'admin')
                            <x-nav-link :href="route('admin_users')" :active="request()->routeIs('admin_users')">
                                {{ __('Gebruikers') }}
                            </x-nav-link>
                        @endif
                    @else
                    <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                        {{ __('Inloggen') }}
                    </x-nav-link>
                    <x-nav-link :href="route('register')" :active="request()->routeIs('register')">
                        {{ __('Registreren') }}
                    </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            @if(isset(Auth::user()->name))
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-white hover:border-gray-300 focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Uitloggen') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            @endif
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="bg-red-500 fixed w-full h-full top-0 left-0 flex justify-center z-10">
            <div class="pt-2 pb-3 w-full space-y-1 text-center justify-center">
                <div class="flex-shrink-0 flex items-center text-white text-xl">
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button @click="open = ! open" class="inline-flex items-center justify-center p-2 pl-6 rounded-md text-white transition duration-150 ease-in-out">
                            <svg class="h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
                <x-responsive-nav-link :href="route('welcome')" :active="request()->routeIs('welcome')">
                    {{ __('Bankjes in je omgeving') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('global')" :active="request()->routeIs('global')">
                    {{ __('Alle bankjes') }}
                </x-responsive-nav-link>
                @if(isset(Auth::user()->name))
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('bankjestoevoegen')" :active="request()->routeIs('bankjestoevoegen')">
                    {{ __('Bankje toevoegen') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin_users')" :active="request()->routeIs('admin_users')">
                    {{ __('Gebruikers') }}
                </x-responsive-nav-link>
                @endif

                <!-- Responsive Settings Options -->
                @if(isset(Auth::user()->name))
                <div class="pt-4 pb-1 border-t border-white">
                    <div class="px-4">
                        <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-white">{{ Auth::user()->email }}</div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-responsive-nav-link :href="route('logout')"
                                                   onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                {{ __('Uitloggen') }}
                            </x-responsive-nav-link>
                        </form>
                    </div>
                </div>
                @else
                    <hr/>
                    <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">
                        {{ __('Inloggen') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')">
                        {{ __('Registreren') }}
                    </x-responsive-nav-link>
                @endif
            </div>
        </div>
</nav>
