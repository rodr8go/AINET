<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TshirtImage; // <-- Garante que aponta para o modelo certo
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;

use Illuminate\Routing\Controllers\Middleware;class TshirtImageController extends Controller implements HasMiddleware
{
    use \App\Traits\CourseImageFileStorage;

    /**
     * Define a segurança de acesso para este controlador.
     */
    public static function middleware(): array
    {
        return [
            // Apenas Administradores ('A') ou Funcionários ('F') gerem o catálogo global
            new Middleware('can:admin', only: ['index', 'create', 'store', 'edit', 'update', 'destroy']),
        ];
    }

    /**
     * Lista todas as imagens do catálogo global (Painel do Admin)
     */
    public function index(): View
    {
        $allTshirtImages = TshirtImage::orderBy('name')->paginate(20);

        return view('pages.catalog-images.index', compact('allTshirtImages'));
    }
}