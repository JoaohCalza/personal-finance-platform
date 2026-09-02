<?php

namespace Tests\Feature\Filament;

use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    public function test_guests_are_redirected_to_the_admin_login_page(): void
    {
        $response = $this->get(route('filament.admin.pages.dashboard'));

        $response->assertRedirect(route('filament.admin.auth.login'));
    }
}
