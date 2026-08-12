<x-auth-layout>
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Lupa Kata Sandi</h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Masukkan alamat email Anda. Tautan untuk mengatur ulang kata sandi akan kami kirimkan ke email Anda.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="'Email'" />
            <x-text-input id="email" class="mt-1" type="email" name="email" :value="old('email')" required autofocus autocomplete="email" placeholder="nama@contoh.id" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-primary-button class="w-full justify-center">
                Kirim Tautan Reset
            </x-primary-button>
        </div>

        <p class="text-center text-sm text-gray-500 dark:text-gray-400">
            Ingat kata sandi?
            <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400">
                Masuk
            </a>
        </p>
    </form>
</x-auth-layout>
