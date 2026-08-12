<x-auth-layout>
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-gray-900">Konfirmasi Kata Sandi</h1>
        <p class="mt-1 text-sm text-gray-500">
            Ini adalah area aman aplikasi. Konfirmasikan kata sandi Anda sebelum melanjutkan.
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <!-- Password -->
        <div>
            <x-auth.input-label for="password" :value="'Kata Sandi'" />
            <x-auth.text-input id="password" class="mt-1" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-auth.input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-auth.primary-button class="w-full justify-center">
                Konfirmasi
            </x-auth.primary-button>
        </div>
    </form>
</x-auth-layout>
