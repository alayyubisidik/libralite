<x-auth-layout>
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Konfirmasi Kata Sandi</h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Ini adalah area aman aplikasi. Konfirmasikan kata sandi Anda sebelum melanjutkan.
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="'Kata Sandi'" />
            <x-text-input id="password" class="mt-1" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-primary-button class="w-full justify-center">
                Konfirmasi
            </x-primary-button>
        </div>
    </form>
</x-auth-layout>
