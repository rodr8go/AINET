<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ColorController extends Controller
{
    // 1. Listar todas as cores
    public function index(): View
    {
        $colors = Color::orderBy('name')->get();
        return view('admin.colors.index', compact('colors'));
    }

    // 2. Mostrar formulário de criação
    public function create(): View
    {
        return view('admin.colors.create');
    }

    // 3. Gravar nova cor na BD
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:colors,code|size:6', // Ex: 'FA'
            'name' => 'required|string|max:50',
        ]);

        Color::create($validated);

        return redirect()->route('admin.colors.index')
            ->with('toast', 'Cor criada com sucesso!');
    }

    // 4. Mostrar formulário de edição
    public function edit(Color $color): View
    {
        return view('admin.colors.edit', compact('color'));
    }

    // 5. Atualizar a cor na BD
    public function update(Request $request, Color $color): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
        ]);

        $color->update($validated);

        return redirect()->route('admin.colors.index')
            ->with('toast', 'Cor atualizada com sucesso!');
    }

    // 6. Remover a cor
    public function destroy(Color $color): RedirectResponse
    {
        // Opcional: Validar se existem t-shirts a usar esta cor antes de apagar
        $color->delete();

        return redirect()->route('admin.colors.index')
            ->with('toast', 'Cor removida com sucesso!');
    }
}
