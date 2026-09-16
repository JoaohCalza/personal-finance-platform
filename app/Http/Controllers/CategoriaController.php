<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index(Request $request): View
    {
        $categorias = Categoria::where('user_id', $request->user()->id)->orderBy('nome')->get();

        return view('categorias.index', compact('categorias'));
    }

    public function create(): View
    {
        return view('categorias.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $categoria = new Categoria($this->validateCategoria($request));
        $categoria->user_id = $request->user()->id;
        $categoria->save();

        return redirect()->route('categorias.index')->with('success', 'Categoria criada com sucesso.');
    }

    public function show(Categoria $categoria): View
    {

        return view('categorias.show', compact('categoria'));
    }

    public function edit(Categoria $categoria): View
    {

        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria): RedirectResponse
    {
        $categoria->update($this->validateCategoria($request));

        return redirect()->route('categorias.index')->with('success', 'Categoria atualizada com sucesso.');
    }

    public function destroy(Categoria $categoria): RedirectResponse
    {
        $categoria->delete();

        return redirect()->route('categorias.index')->with('success', 'Categoria excluída com sucesso.');
    }

    /** @return array{nome: string, tipo: string} */
    private function validateCategoria(Request $request): array
    {
        return $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'required|in:receita,despesa',
        ]);
    }
}
