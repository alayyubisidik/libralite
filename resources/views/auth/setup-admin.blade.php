<x-auth-layout>
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-gray-900">Buat Admin Pertama</h1>
        <p class="mt-1 text-sm text-gray-500">Buat akun admin pertama untuk LibraLite.</p>
    </div>

    <form method="POST" action="{{ route('setup.admin.store') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <x-auth.input-label for="name" :value="'Nama'" />
            <x-auth.text-input id="name" class="mt-1" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama lengkap" />
            <x-auth.input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-auth.input-label for="email" :value="'Email'" />
            <x-auth.text-input id="email" class="mt-1" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="nama@contoh.id" />
            <x-auth.input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-auth.input-label for="password" :value="'Kata Sandi'" />
            <x-auth.text-input id="password" class="mt-1" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
            <x-auth.input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-auth.input-label for="password_confirmation" :value="'Konfirmasi Kata Sandi'" />
            <x-auth.text-input id="password_confirmation" class="mt-1" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-auth.input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Setup Token -->
        <div>
            <x-auth.input-label for="setup_token" :value="'Token Setup'" />
            <x-auth.text-input id="setup_token" class="mt-1" type="password" name="setup_token" required autocomplete="off" placeholder="Token setup admin" />
            <x-auth.input-error :messages="$errors->get('setup_token')" class="mt-2" />
        </div>

        <div>
            <x-auth.primary-button class="w-full justify-center">
                Buat Admin
            </x-auth.primary-button>
        </div>
    </form>
</x-auth-layout>
