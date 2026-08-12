<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class AdminSetupTest extends TestCase
{
    use RefreshDatabase;

    private const VALID_TOKEN = 'test-admin-setup-token';

    protected function setUp(): void
    {
        parent::setUp();

        Config::set('services.admin_setup.token', self::VALID_TOKEN);
    }

    private function createAdmin(): User
    {
        $this->seed(RolePermissionSeeder::class);

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        return $admin;
    }

    public function test_setup_page_can_be_rendered_when_no_users_exist(): void
    {
        $response = $this->get(route('setup.admin.create'));

        $response->assertOk();
        $response->assertSee('Token Setup');
    }

    public function test_all_pages_redirect_to_setup_when_no_users_exist(): void
    {
        $this->get('/')->assertRedirect(route('setup.admin.create'));
        $this->get('/login')->assertRedirect(route('setup.admin.create'));
        $this->get('/forgot-password')->assertRedirect(route('setup.admin.create'));
    }

    public function test_admin_can_be_created_with_valid_token(): void
    {
        $response = $this->post(route('setup.admin.store'), [
            'name' => 'Admin Libra',
            'email' => 'admin@libralite.test',
            'password' => 'password',
            'password_confirmation' => 'password',
            'setup_token' => self::VALID_TOKEN,
        ]);

        $response->assertRedirect(route('login'));

        $this->assertDatabaseHas('users', ['email' => 'admin@libralite.test']);

        $admin = User::where('email', 'admin@libralite.test')->first();

        $this->assertTrue($admin->hasRole('admin'));
        $this->assertCount(24, $admin->getAllPermissions());
    }

    public function test_admin_cannot_be_created_with_invalid_token(): void
    {
        $response = $this->from(route('setup.admin.create'))->post(route('setup.admin.store'), [
            'name' => 'Admin Libra',
            'email' => 'admin@libralite.test',
            'password' => 'password',
            'password_confirmation' => 'password',
            'setup_token' => 'wrong-token',
        ]);

        $response->assertRedirect(route('setup.admin.create'));

        $this->assertDatabaseMissing('users', ['email' => 'admin@libralite.test']);
    }

    public function test_admin_cannot_be_created_without_token(): void
    {
        $response = $this->post(route('setup.admin.store'), [
            'name' => 'Admin Libra',
            'email' => 'admin@libralite.test',
            'password' => 'password',
            'password_confirmation' => 'password',
            'setup_token' => '',
        ]);

        $response->assertSessionHasErrors('setup_token');

        $this->assertDatabaseMissing('users', ['email' => 'admin@libralite.test']);
    }

    public function test_setup_page_is_not_accessible_after_admin_exists(): void
    {
        $this->createAdmin();

        $this->get(route('setup.admin.create'))->assertRedirect(route('login'));
        $this->post(route('setup.admin.store'), [
            'name' => 'Another Admin',
            'email' => 'another@libralite.test',
            'password' => 'password',
            'password_confirmation' => 'password',
            'setup_token' => self::VALID_TOKEN,
        ])->assertRedirect(route('login'));

        $this->assertDatabaseMissing('users', ['email' => 'another@libralite.test']);
    }

    public function test_login_is_accessible_after_admin_exists(): void
    {
        $this->createAdmin();

        $this->get('/login')->assertOk();
    }
}
