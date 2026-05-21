<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes - Loja FunShirt
|--------------------------------------------------------------------------
*/

/* ----- ROTAS PÚBLICAS (Anónimos / Todos) ----- */
Route::view('/', 'home')->name('home');

// Catálogo (Fase 3)
Route::get('catalogo', function () { return 'Catálogo de Imagens'; })->name('catalog.index');

// Carrinho de Compras (Acessível a Anónimos)
Route::get('cart', function () { return 'Visualizar Carrinho'; })->name('cart.show');


/* ----- ROTAS PROTEGIDAS (Apenas Utilizadores Autenticados e Verificados) ----- */
Route::middleware(['auth', 'verified'])->group(function () {

    /* --- Espaço do CLIENTE (user_type = C) --- */
    Route::middleware(['role:C'])->prefix('cliente')->name('client.')->group(function () {
        Route::get('/encomendas', function () { return 'Histórico de Encomendas'; })->name('orders.index');
        Route::get('/imagens-privadas', function () { return 'Gestão de Imagens Próprias'; })->name('images.index');
    });

    /* --- Espaço do FUNCIONÁRIO (user_type = F) --- */
    Route::middleware(['role:F'])->prefix('funcionario')->name('employee.')->group(function () {
        Route::get('/encomendas-pendentes', function () { return 'Lista de Encomendas Pendentes'; })->name('orders.pending');
    });

    /* --- Espaço do ADMINISTRADOR (user_type = A) --- */
    Route::middleware(['role:A'])->prefix('admin')->name('admin.')->group(function () {
        Route::view('dashboard', 'dashboard')->name('dashboard');
        Route::get('/estatisticas', function () { return 'Painel de Estatísticas'; })->name('stats');
    });
});

require __DIR__.'/settings.php';