<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_must_log_in(): void
    {
        $this->get(route('usuarios.index'))->assertRedirect(route('login'));
    }

    public function test_admin_sees_the_user_list(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $other = User::factory()->create(['name' => 'Maria Silva']);

        $this->actingAs($admin)->get(route('usuarios.index'))
            ->assertOk()
            ->assertSee('Maria Silva')
            ->assertSee($other->email);
    }

    public function test_non_admin_cannot_see_the_user_list(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('usuarios.index'))
            ->assertForbidden();
    }
}
