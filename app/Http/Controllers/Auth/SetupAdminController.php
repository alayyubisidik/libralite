<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AlertService;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class SetupAdminController extends Controller
{
    /**
     * Display the admin setup view.
     */
    public function create(): View
    {
        return view('auth.setup-admin');
    }

    /**
     * Create the initial admin account.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'setup_token' => ['required', 'string'],
            ],
            [
                'name.required' => 'Nama wajib diisi.',
                'name.string' => 'Nama harus berupa teks.',
                'name.max' => 'Nama maksimal 255 karakter.',

                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Email tidak valid.',
                'email.max' => 'Email maksimal 255 karakter.',
                'email.unique' => 'Email sudah digunakan.',

                'password.required' => 'Kata sandi wajib diisi.',
                'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',

                'setup_token.required' => 'Token setup wajib diisi.',
            ]
        );

        $token = (string) config('services.admin_setup.token');

        if ($token === '' || ! hash_equals($token, $request->string('setup_token')->toString())) {
            AlertService::error('Token setup tidak valid.');

            return back();
        }

        (new RolePermissionSeeder)->run();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        $user->assignRole('admin');

        AlertService::success('Admin berhasil dibuat. Silakan login.');

        return to_route('login');
    }
}
