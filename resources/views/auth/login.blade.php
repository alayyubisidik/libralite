<x-auth-layout>
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Masuk</h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Masuk untuk mengelola perpustakaan Anda.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="'Email'" />
            <x-text-input id="email" class="mt-1" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@contoh.id" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="'Kata Sandi'" />
            <x-text-input id="password" class="mt-1" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center text-sm text-gray-600 dark:text-gray-400">
                <input id="remember_me" type="checkbox" name="remember" value="1"
                    class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-900 dark:focus:ring-blue-500" />
                <span class="ms-2">Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400">
                    Lupa kata sandi?
                </a>
            @endif
        </div>

        <div>
            <x-primary-button class="w-full justify-center">
                Masuk
            </x-primary-button>
        </div>
    </form>
</x-auth-layout>
