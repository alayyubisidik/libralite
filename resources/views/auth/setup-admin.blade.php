<x-auth-layout>
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Buat Admin Pertama</h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Buat akun admin pertama untuk LibraLite.</p>
    </div>

    <form method="POST" action="{{ route('setup.admin.store') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="'Nama'" />
            <x-text-input id="name" class="mt-1" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama lengkap" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="'Email'" />
            <x-text-input id="email" class="mt-1" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="nama@contoh.id" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="'Kata Sandi'" />
            <x-text-input id="password" class="mt-1" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="'Konfirmasi Kata Sandi'" />
            <x-text-input id="password_confirmation" class="mt-1" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Setup Token -->
        <div>
            <x-input-label for="setup_token" :value="'Token Setup'" />
            <x-text-input id="setup_token" class="mt-1" type="password" name="setup_token" required autocomplete="off" placeholder="Token setup admin" />
            <x-input-error :messages="$errors->get('setup_token')" class="mt-2" />
        </div>

        <div>
            <x-primary-button class="w-full justify-center">
                Buat Admin
            </x-primary-button>
        </div>
    </form>
</x-auth-layout>
