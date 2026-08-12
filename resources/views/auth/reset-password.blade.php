<x-auth-layout>
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-gray-900">Atur Ulang Kata Sandi</h1>
        <p class="mt-1 text-sm text-gray-500">Buat kata sandi baru untuk akun Anda.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-auth.input-label for="email" :value="'Email'" />
            <x-auth.text-input id="email" class="mt-1" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-auth.input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-auth.input-label for="password" :value="'Kata Sandi Baru'" />
            <x-auth.text-input id="password" class="mt-1" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
            <x-auth.input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-auth.input-label for="password_confirmation" :value="'Konfirmasi Kata Sandi'" />
            <x-auth.text-input id="password_confirmation" class="mt-1" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-auth.input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div>
            <x-auth.primary-button class="w-full justify-center">
                Setel Ulang Kata Sandi
            </x-auth.primary-button>
        </div>
    </form>
</x-auth-layout>
