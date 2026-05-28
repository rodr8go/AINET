<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TshirtImageController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\PriceController;

//======================================= PUBLIC ROUTES

//HOME PAGE
Route::view('/', 'home')->name('home');

// Catálogo da Loja
Route::get('catalogo', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('catalogo/{tshirtImage}', [CatalogController::class, 'show'])->name('catalog.show');

//CATEGORIAS
Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

//CORES
Route::get('colors', [ColorController::class, 'index'])->name('colors.index');
Route::get('colors/{color}', [ColorController::class, 'show'])->name('colors.show');

//CART
Route::controller(CartController::class)->group(function () {
    Route::get('cart', 'show')->name('cart.show');
    Route::post('cart/add/{tshirtImage}', 'add')->name('cart.add');
    Route::patch('cart/update/{itemId}', 'update')->name('cart.update');
    Route::delete('cart/remove/{itemId}', 'remove')->name('cart.remove');
    Route::delete('cart/destroy', 'destroy')->name('cart.destroy');
});

require __DIR__.'/settings.php';

//================================== AUTHENTICATED ROUTES
Route::middleware(['auth'])->group(function () {
    //DASHBOARD
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //CUSTOMER PROFILE
    Route::middleware(['can:view-profile'])->group(function () {
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::patch('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
        Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
    
    //CUSTOMER IMAGES
    Route::resource('my-images', TshirtImageController::class)
    ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
    ->parameters(['my-images' => 'tshirtImage'])
    ->middleware('can:createCustom,App\Models\TshirtImage');

    //CUSTOMER ORDER HISTORY
    Route::get('my-orders', [OrderController::class, 'myOrders'])->name('orders.my');
    Route::get('my-orders/{order}', [OrderController::class, 'show'])
        ->middleware('can:view,order')
        ->name('orders.show');

    //CUSTOMER RECEIPT
    Route::get('orders/{order}/receipt', [OrderController::class, 'downloadReceipt'])
        ->middleware('can:downloadReceipt,order')
        ->name('orders.receipt');

    //CUSTOMER CHECKOUT
    Route::middleware(['verified'])->group(function () {
    Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('checkout', [CheckoutController::class, 'store'])
        ->middleware('can:confirm-cart')
        ->name('checkout.store');
    });

    //EMPLOYEE
    Route::middleware(['can:employee'])->group(function () {
    
        Route::get('employee/orders/pending', [OrderController::class, 'pending'])
            ->name('employee.orders.pending');
        
        Route::patch('employee/orders/{order}/close', [OrderController::class, 'close'])
            ->middleware('can:update,order')
            ->name('employee.orders.close');
    });
    
    // ===== ADMIN ONLY ROUTES =================================================
    Route::middleware(['can:admin'])->group(function () {
        
        // Admin can manage their OWN profile (unlike employees)
        Route::get('admin/profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
        Route::patch('admin/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
        Route::patch('admin/profile/password', [ProfileController::class, 'updatePassword'])->name('admin.profile.password');
        
        // Statistics dashboard
        Route::get('statistics', [StatisticsController::class, 'index'])->name('statistics.index');
        
        // User management (CRUD for all users)
        Route::resource('users', UserController::class);
        Route::patch('users/{user}/block', [UserController::class, 'block'])->name('users.block');
        Route::patch('users/{user}/unblock', [UserController::class, 'unblock'])->name('users.unblock');
        
        // Customer management (with soft delete)
        Route::resource('customers', CustomerController::class);
        Route::delete('customers/{customer}/force', [CustomerController::class, 'forceDelete'])
            ->name('customers.force-delete');
        Route::patch('customers/{customer}/restore', [CustomerController::class, 'restore'])
            ->name('customers.restore');
        
        // Category management (full CRUD)
        Route::resource('admin/categories', CategoryController::class)->except(['index', 'show'])
            ->names([
                'index' => 'admin.categories.index',
                'create' => 'admin.categories.create',
                'store' => 'admin.categories.store',
                'edit' => 'admin.categories.edit',
                'update' => 'admin.categories.update',
                'destroy' => 'admin.categories.destroy',
            ]);
        
        // Color management (full CRUD)
        Route::resource('admin/colors', ColorController::class)->except(['index', 'show'])
            ->names([
                'index' => 'admin.colors.index',
                'create' => 'admin.colors.create',
                'store' => 'admin.colors.store',
                'edit' => 'admin.colors.edit',
                'update' => 'admin.colors.update',
                'destroy' => 'admin.colors.destroy',
            ]);
        
        // Price configuration (singleton)
        Route::get('prices/edit', [PriceController::class, 'edit'])->name('prices.edit');
        Route::put('prices', [PriceController::class, 'update'])->name('prices.update');
        
        // Catalog image management (admin only)
        Route::resource('catalog-images', TshirtImageController::class)
            ->except(['show'])
            ->parameters(['catalog-images' => 'tshirtImage']);
        
        // Order management (admin full access)
        Route::get('admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');
        Route::get('admin/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
        Route::patch('admin/orders/{order}/status', [OrderController::class, 'updateStatus'])
            ->name('admin.orders.status');
        Route::post('admin/orders/{order}/cancel', [OrderController::class, 'cancel'])
            ->middleware('can:cancel,order')
            ->name('admin.orders.cancel');
    });
});
