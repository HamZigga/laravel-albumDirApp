<div class="d-flex flex-md-row justify-content-between p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">

        <a href="{{ route('home') }}" class="my-0 mr-md-auto font-weight-normal h3">Album Directory</a>
        <div class="sm:flex sm:items-center sm:ml-6">
            <a class="pr-5" href="{{ route('artistList') }}">Исполнители</a>
            <a class="pr-5" href="{{ route('home') }}">Альбомы</a>
        </div>
        @guest
            @if (Route::has('login'))
                    <div class="sm:flex sm:items-center sm:ml-6">
                        <a class="pr-5" href="{{ route('albumCreate') }}">Создать Альбом</a>
                    @auth
                        @else
                            <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Логин</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Регистрация</a>
                            @endif
                        @endauth
                    </div>
            @endif
            @else
            <div class="sm:flex sm:items-center sm:ml-6">
                <a class="pr-5" href="{{ route('albumCreate') }}">Создать Альбом</a>
                <a class="pr-5" href="{{ route('artistCreate') }}">Создать Исполнителя</a>
                    <x-dropdown align="right" width="48">

                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">

                            <x-dropdown-link :href="route('albumCreate')">
                                    Создать Альбом
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('artistCreate')">
                                Создать Исполнителя
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('profile')">
                                    Профиль
                            </x-dropdown-link>
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>


                        </x-slot>
                    </x-dropdown>

        </div>
    @endguest
</div>
