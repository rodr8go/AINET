<?php

namespace App\Http\Controllers;

use App\Models\TshirtImage;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TshirtImageController extends Controller
{
    // 1. Listar todas as imagens do catálogo na área de Admin
    public function index(): View
    {
        // Puxa apenas as imagens que pertencem ao catálogo global (onde o customer_id é nulo)
        $images = TshirtImage::whereNull('customer_id')
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.catalog_images.index', compact('images'));
    }

    // 2. Mostrar formulário para adicionar estampa
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.catalog_images.create', compact('categories'));
    }

    // 3. Gravar a nova imagem e fazer o upload do ficheiro
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'image_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096', // Máx 4MB
        ]);

        $image = new TshirtImage();
        $image->name = $request->name;
        $image->description = $request->description;
        $image->category_id = $request->category_id;
        $image->customer_id = null; // Garante que é uma imagem pública de catálogo

        // Processar o upload do ficheiro para a pasta t_shirt_images
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('tshirt_images', 'public');
            $image->image_url = basename($path); // Guarda apenas o nome do ficheiro na BD
        }

        $image->save();

        return redirect()->route('catalog-images.index')
            ->with('toast', 'Estampa adicionada ao catálogo com sucesso!');
    }

    // 4. Mostrar formulário de edição
    public function edit(TshirtImage $catalogImage): View
    {
        // Nota: O Laravel injeta como $catalogImage devido ao parâmetro mapeado no vosso web.php
        $categories = Category::orderBy('name')->get();
        return view('admin.catalog_images.edit', [
            'image' => $catalogImage,
            'categories' => $categories
        ]);
    }

    // 5. Atualizar os dados da estampa
    public function update(Request $request, TshirtImage $catalogImage): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        $catalogImage->name = $request->name;
        $catalogImage->description = $request->description;
        $catalogImage->category_id = $request->category_id;

        // Se o admin carregar uma nova imagem, apaga a antiga e mete a nova
        if ($request->hasFile('image_file')) {
            if ($catalogImage->image_url) {
                Storage::disk('public')->delete('tshirt_images/' . $catalogImage->image_url);
            }
            $path = $request->file('image_file')->store('tshirt_images', 'public');
            $catalogImage->image_url = basename($path);
        }

        $catalogImage->save();

        return redirect()->route('catalog-images.index')
            ->with('toast', 'Estampa atualizada com sucesso!');
    }

    // 6. Remover a estampa do catálogo e do disco
    public function destroy(TshirtImage $catalogImage): RedirectResponse
    {
        // Apaga o ficheiro físico do storage
        if ($catalogImage->image_url) {
            Storage::disk('public')->delete('tshirt_images/' . $catalogImage->image_url);
        }

        $catalogImage->delete();

        return redirect()->route('catalog-images.index')
            ->with('toast', 'Estampa removida do catálogo com sucesso!');
    }
}