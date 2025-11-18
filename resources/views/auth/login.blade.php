<x-guest-layout>

    <x-auth-session-status class="mb-4 animate-fade" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5 animate-fade">
        @csrf

        <!-- Email -->
        <div class="animate-fade">
            <x-input-label for="email" value="Email" class="dark:text-gray-200" />
            <x-text-input 
                id="email"
                class="mt-1 w-full dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600 focus:ring-indigo-500"
                type="email"
                name="email"
                :value="old('email')"
                required autofocus 
            />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="animate-fade">
            <x-input-label for="password" value="Contraseña" class="dark:text-gray-200" />
            <x-text-input 
                id="password"
                class="mt-1 w-full dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600"
                type="password"
                name="password"
                required
            />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember -->
        <div class="flex items-center animate-fade">
            <input id="remember_me" type="checkbox" name="remember"
                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-500">

            <label for="remember_me" class="ms-2 text-sm text-gray-600 dark:text-gray-300">
                Recuérdame
            </label>
        </div>

        <!-- Links + Button -->
        <div class="flex items-center justify-between mt-4 animate-fade">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   class="text-sm text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif

            <x-primary-button class="px-5 py-2 text-sm font-semibold transition transform active:scale-95">
                Entrar
            </x-primary-button>
        </div>

    </form>

</x-guest-layout>
