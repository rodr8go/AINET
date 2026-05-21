<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CartController;

/* ----- ROTAS PÚBLICAS (Anónimos / Todos) ----- */
Route::view('/', 'home')->name('home');

// Catálogo da Loja
Route::get('catalogo', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('catalogo/{tshirtImage}', [CatalogController::class, 'show'])->name('catalog.show');

// Carrinho de Compras (Sessão)
Route::get('cart', [CartController::class, 'show'])->name('cart.show');
Route::post('cart/add/{tshirtImage}', [CartController::class, 'add'])->name('cart.add');
Route::delete('cart/remove/{itemKey}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('cart/clear', [CartController::class, 'destroy'])->name('cart.destroy');


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