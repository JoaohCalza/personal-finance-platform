<?php

namespace Tests\Feature;

use App\Models\Carteira;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarteiraControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_must_log_in(): void
    {
        $this->get(route('carteiras.index'))->assertRedirect(route('login'));
        $this->post(route('carteiras.store'), [])->assertRedirect(route('login'));
    }

    public function test_list_only_displays_owned_wallets_and_escapes_names(): void
    {
        $user = User::factory()->create();
        Carteira::factory()->create(['user_id' => $user->id, 'nome' => '<script>alert(1)</script>']);
        Carteira::factory()->create(['nome' => 'Carteira privada']);

        $this->actingAs($user)->get(route('carteiras.index'))
            ->assertOk()
            ->assertSee('<script>alert(1)</script>')
            ->assertDontSee('<script>alert(1)</script>', false)
            ->assertDontSee('Carteira privada');
    }

    public function test_empty_list_and_create_form_are_available(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('carteiras.index'))->assertOk()->assertSee('Nenhuma carteira cadastrada.');
        $this->get(route('carteiras.create'))->assertOk()->assertSee('Criar carteira')->assertSee('name="_token"', false);
    }

    public function test_wallet_is_created_for_authenticated_user(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('carteiras.store'), [
            'nome' => 'Binance', 'user_id' => User::factory()->create()->id,
        ])->assertRedirect(route('carteiras.index'));

        $this->assertDatabaseHas('carteiras', ['nome' => 'Binance', 'user_id' => $user->id]);
    }

    public function test_owned_wallet_can_be_viewed_edited_updated_and_deleted(): void
    {
        $user = User::factory()->create();
        $carteira = Carteira::factory()->create(['user_id' => $user->id, 'nome' => 'Binance']);
        $this->actingAs($user);

        $this->get(route('carteiras.show', $carteira))->assertOk()->assertSee('Binance');
        $this->get(route('carteiras.edit', $carteira))->assertOk()->assertSee('Binance');

        $this->put(route('carteiras.update', $carteira), ['nome' => 'Coinbase'])
            ->assertRedirect(route('carteiras.index'));
        $this->assertDatabaseHas('carteiras', ['id' => $carteira->id, 'nome' => 'Coinbase', 'user_id' => $user->id]);

        $this->delete(route('carteiras.destroy', $carteira))->assertRedirect(route('carteiras.index'));
        $this->assertModelMissing($carteira);
    }

    public function test_users_cannot_access_another_users_wallet(): void
    {
        $carteira = Carteira::factory()->create(['nome' => 'Original']);
        $this->actingAs(User::factory()->create());

        $this->get(route('carteiras.show', $carteira))->assertForbidden();
        $this->get(route('carteiras.edit', $carteira))->assertForbidden();
        $this->put(route('carteiras.update', $carteira), ['nome' => 'Alterada'])->assertForbidden();
        $this->delete(route('carteiras.destroy', $carteira))->assertForbidden();

        $this->assertDatabaseHas('carteiras', ['id' => $carteira->id, 'nome' => 'Original']);
    }

    public function test_name_is_validated_for_create_and_update(): void
    {
        $user = User::factory()->create();
        $carteira = Carteira::factory()->create(['user_id' => $user->id, 'nome' => 'Original']);
        $this->actingAs($user);

        $this->post(route('carteiras.store'), [])->assertSessionHasErrors('nome');
        $this->post(route('carteiras.store'), ['nome' => str_repeat('a', 256)])->assertSessionHasErrors('nome');
        $this->put(route('carteiras.update', $carteira), ['nome' => ''])->assertSessionHasErrors('nome');

        $this->assertDatabaseCount('carteiras', 1);
        $this->assertDatabaseHas('carteiras', ['id' => $carteira->id, 'nome' => 'Original']);
    }
}
