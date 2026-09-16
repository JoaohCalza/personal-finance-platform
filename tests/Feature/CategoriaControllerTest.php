<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoriaControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_must_log_in(): void
    {
        $this->get(route('categorias.index'))->assertRedirect(route('login'));
        $this->post(route('categorias.store'), [])->assertRedirect(route('login'));
    }

    public function test_list_only_displays_owned_categories_and_escapes_names(): void
    {
        $user = User::factory()->create();
        Categoria::factory()->create(['user_id' => $user->id, 'nome' => '<script>alert(1)</script>']);
        Categoria::factory()->create(['nome' => 'Categoria privada']);

        $this->actingAs($user)->get(route('categorias.index'))
            ->assertSee('<script>alert(1)</script>')
            ->assertDontSee('<script>alert(1)</script>', false)
            ->assertDontSee('Categoria privada');
    }

    public function test_empty_list_and_create_form_are_available(): void
    {
        $this->actingAs(User::factory()->create());
        $this->get(route('categorias.index'))->assertSee('Nenhuma categoria cadastrada.');
        $this->get(route('categorias.create'))->assertSee('Criar categoria')->assertSee('name="_token"', false);
    }

    public function test_category_can_be_created_for_authenticated_user(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();

        $this->actingAs($user)->post(route('categorias.store'), [
            'nome' => 'Salário', 'tipo' => 'receita', 'user_id' => $other->id,
        ])->assertRedirect(route('categorias.index'));

        $this->assertDatabaseHas('categorias', ['nome' => 'Salário', 'tipo' => 'receita', 'user_id' => $user->id]);
    }

    public function test_owned_category_can_be_viewed_edited_updated_and_deleted(): void
    {
        $user = User::factory()->create();
        $categoria = Categoria::factory()->create(['user_id' => $user->id, 'nome' => '<b>Casa</b>']);
        $this->actingAs($user);

        foreach (['show', 'edit'] as $action) {
            $this->get(route('categorias.'.$action, $categoria))
                ->assertSee('<b>Casa</b>')->assertDontSee('<b>Casa</b>', false);
        }

        $this->put(route('categorias.update', $categoria), [
            'nome' => 'Moradia', 'tipo' => 'despesa', 'user_id' => User::factory()->create()->id,
        ])->assertRedirect(route('categorias.index'));
        $this->assertDatabaseHas('categorias', ['id' => $categoria->id, 'nome' => 'Moradia', 'user_id' => $user->id]);

        $this->delete(route('categorias.destroy', $categoria))->assertRedirect(route('categorias.index'));
        $this->assertModelMissing($categoria);
    }

    public function test_authenticated_user_can_update_and_delete_another_users_category(): void
    {
        $categoria = Categoria::factory()->create(['nome' => 'Original']);
        $this->actingAs(User::factory()->create());

        $this->put(route('categorias.update', $categoria), ['nome' => 'Alterada', 'tipo' => 'receita'])
            ->assertRedirect(route('categorias.index'));
        $this->assertDatabaseHas('categorias', ['id' => $categoria->id, 'nome' => 'Alterada', 'tipo' => 'receita']);

        $this->delete(route('categorias.destroy', $categoria))->assertRedirect(route('categorias.index'));
        $this->assertModelMissing($categoria);
    }

    public function test_invalid_category_is_not_saved_and_form_shows_errors_and_old_input(): void
    {
        $this->actingAs(User::factory()->create());
        $this->from(route('categorias.create'))->post(route('categorias.store'), [
            'nome' => 'Alimentação', 'tipo' => 'invalido',
        ])->assertRedirect(route('categorias.create'))->assertSessionHasErrors('tipo');
        $this->withCookie(config('session.cookie'), session()->getId())->get(route('categorias.create'))->assertSee('role="alert"', false)->assertSee('Alimentação');
        $this->assertDatabaseCount('categorias', 0);
    }

    public function test_required_fields_and_name_length_are_validated_for_create_and_update(): void
    {
        $user = User::factory()->create();
        $categoria = Categoria::factory()->create(['user_id' => $user->id, 'nome' => 'Original']);
        $this->actingAs($user);

        $this->post(route('categorias.store'), [])->assertSessionHasErrors(['nome', 'tipo']);
        $this->post(route('categorias.store'), ['nome' => str_repeat('a', 256), 'tipo' => 'despesa'])->assertSessionHasErrors('nome');
        $this->post(route('categorias.store'), ['nome' => ['array'], 'tipo' => 'despesa'])->assertSessionHasErrors('nome');
        $this->put(route('categorias.update', $categoria), ['nome' => '', 'tipo' => 'invalido'])->assertSessionHasErrors(['nome', 'tipo']);
        $this->assertDatabaseCount('categorias', 1);
        $this->assertDatabaseHas('categorias', ['id' => $categoria->id, 'nome' => 'Original']);
    }
}
