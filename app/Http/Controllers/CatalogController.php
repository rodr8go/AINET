<?php

namespace App\Http\Controllers;

use App\Models\TshirtImage;
use App\Models\Category;
use App\Models\Color;
use Illuminate\Http\Request;
 use Illuminate\Routing\Controller;



class CatalogController extends Controller
{
    public function index(Request $request)
    {

    
        // 1. Ir buscar apenas as imagens PÚBLICAS do catálogo (customer_id nulo)
        $query = TshirtImage::whereNull('customer_id');

        // Filtro por Categoria
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filtro por termo de pesquisa (Nome ou Descrição)
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $images = $query->paginate(12);
        $categories = Category::all();
        $colors = Color::all(); // Necessário para o utilizador escolher na montra

        return view('catalog.index', compact('images', 'categories', 'colors'));
    }

    public function show(TshirtImage $tshirtImage)
    {
        // Garante que o utilizador não tenta aceder a uma imagem privada de outro cliente pela rota
        if ($tshirtImage->customer_id !== null) {
            abort(403, 'Esta imagem é privada.');
        }

        $colors = Color::all();
        return view('catalog.show', compact('tshirtImage', 'colors'));
    }
}