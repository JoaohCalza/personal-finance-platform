<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_sees_the_welcome_page_with_login_and_register_links(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertViewIs('welcome')
            ->assertSee(route('login'))
            ->assertSee(route('register'))
            ->assertDontSee('Telegram');
    }

    public function test_authenticated_user_sees_a_link_to_the_dashboard(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('home'))
            ->assertOk()
            ->assertSee(route('dashboard'))
            ->assertDontSee(route('register'));
    }
}
