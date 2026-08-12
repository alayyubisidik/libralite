<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * When no user accounts exist, the application root redirects to the
     * admin setup page.
     */
    public function test_the_application_root_redirects_to_admin_setup(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('setup.admin.create'));
    }
}
