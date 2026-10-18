<?php

namespace App\Http\Controllers;

use App\Models\Carteira;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CarteiraController extends Controller
{
    public function index(Request $request): View
    {
        $carteiras = $request->user()->carteiras()->orderBy('nome')->get();

        return view('carteiras.index', compact('carteiras'));
    }

    public function create(): View
    {
        return view('carteiras.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->user()->carteiras()->create($this->validateCarteira($request));

        return redirect()->route('carteiras.index')->with('success', 'Carteira criada com sucesso.');
    }

    public function show(Request $request, Carteira $carteira): View
    {
        $this->ensureUserOwnsCarteira($request, $carteira);

        return view('carteiras.show', compact('carteira'));
    }

    public function edit(Request $request, Carteira $carteira): View
    {
        $this->ensureUserOwnsCarteira($request, $carteira);

        return view('carteiras.edit', compact('carteira'));
    }

    public function update(Request $request, Carteira $carteira): RedirectResponse
    {
        $this->ensureUserOwnsCarteira($request, $carteira);

        $carteira->update($this->validateCarteira($request));

        return redirect()->route('carteiras.index')->with('success', 'Carteira atualizada com sucesso.');
    }

    public function destroy(Request $request, Carteira $carteira): RedirectResponse
    {
        $this->ensureUserOwnsCarteira($request, $carteira);

        $carteira->delete();

        return redirect()->route('carteiras.index')->with('success', 'Carteira excluída com sucesso.');
    }

    private function ensureUserOwnsCarteira(Request $request, Carteira $carteira): void
    {
        abort_unless($carteira->user_id === $request->user()->id, 403);
    }

    /** @return array{nome: string} */
    private function validateCarteira(Request $request): array
    {
        return $request->validate([
            'nome' => 'required|string|max:255',
        ]);
    }
}
