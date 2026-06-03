<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    // 1. Listar todas as categorias (Visão do Admin)
    public function index(): View
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.categories.index', compact('categories'));
    }

    // 2. Mostrar formulário para criar nova categoria
    public function create(): View
    {
        return view('admin.categories.create');
    }

    // 3. Gravar a nova categoria na BD
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:categories,name|max:50',
        ]);

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('toast', 'Categoria criada com sucesso!');
    }

    // 4. Mostrar formulário de edição
    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    // 5. Atualizar a categoria na BD
    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:categories,name,' . $category->id . '|max:50',
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('toast', 'Categoria atualizada com sucesso!');
    }

    // 6. Remover a categoria
    public function destroy(Category $category): RedirectResponse
    {
        // Opcional: Impedir de apagar se houver t-shirts associadas a esta categoria
        if ($category->tshirtImages()->exists()) {
            return redirect()->back()->with('error', 'Não podes apagar uma categoria que tem t-shirts associadas!');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('toast', 'Categoria removida com sucesso!');
    }
}