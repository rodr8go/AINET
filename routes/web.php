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
use App\Http\Controllers\MyImageController;
use App\Livewire\ProductShow;
use App\Livewire\MyImagePreview;

//======================================= PUBLIC ROUTES

Route::view('/', 'home')->name('home');

Route::get('catalogo', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('catalogo/{id}', ProductShow::class)->name('catalog.show');

Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('colors', [ColorController::class, 'index'])->name('colors.index');
Route::get('colors/{color}', [ColorController::class, 'show'])->name('colors.show');

Route::controller(CartController::class)->group(function () {
    Route::get('cart', 'show')->name('cart.show');
    Route::post('cart/add/{tshirtImage}', 'add')->name('cart.add');
    Route::delete('cart/remove/{itemId}', 'remove')->name('cart.remove');
    Route::delete('cart/destroy', 'destroy')->name('cart.destroy');
});

require __DIR__ . '/settings.php';

//======================================= AUTHENTICATED ROUTES

Route::middleware(['auth'])->group(function () {

    // Dashboard (mantida mas sem link na sidebar)
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // My Images
    Route::resource('my-images', MyImageController::class)->only([
        'index', 'create', 'store', 'destroy'
    ]);
    Route::get('my-images/{id}/image', [MyImageController::class, 'showImage'])
        ->name('my-images.show-image');
    Route::get('/my-images/{id}/preview', MyImagePreview::class)
        ->name('my-images.preview');

    // Profile
    Route::middleware(['can:view-profile'])->group(function () {
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::patch('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
        Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Customer Orders
    Route::middleware(['verified'])->group(function () {
        Route::get('my-orders', [OrderController::class, 'myOrders'])->name('orders.my');
        Route::get('my-orders/{order}', [OrderController::class, 'show'])
            ->middleware('can:view,order')
            ->name('orders.show');
        Route::get('orders/{order}/receipt', [OrderController::class, 'downloadReceipt'])
            ->middleware('can:downloadReceipt,order')
            ->name('orders.receipt');
    });

    // Checkout
    Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('checkout', [CheckoutController::class, 'store'])
        ->middleware('can:confirm-cart')
        ->name('checkout.store');

    Route::patch('orders/{order}/close', [OrderController::class, 'close'])
    ->name('orders.close')
    ->middleware(['auth', 'can:update,order']);

    // ===== EMPLOYEE =====
    Route::middleware(['can:employee'])->group(function () {
        Route::get('employee/orders/pending', [OrderController::class, 'pending'])->name('employee.orders.pending');
        Route::get('employee/orders/{order}', [OrderController::class, 'employeeShow'])->name('employee.orders.show');
        Route::patch('employee/orders/{order}/close', [OrderController::class, 'close'])->name('employee.orders.close');
        });

    // ===== ADMIN ONLY =====
    Route::middleware(['can:admin'])->group(function () {
        Route::get('admin/orders/pending', [OrderController::class, 'pending'])
            ->name('admin.orders.pending');
        Route::get('admin/orders/pending/{order}', [OrderController::class, 'employeeShow'])
            ->name('admin.orders.show.pending');
        Route::patch('admin/orders/pending/{order}/close', [OrderController::class, 'close'])
            ->name('admin.orders.close');
            
        Route::get('admin/profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
        Route::patch('admin/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
        Route::patch('admin/profile/password', [ProfileController::class, 'updatePassword'])->name('admin.profile.password');

        Route::get('statistics', [StatisticsController::class, 'index'])->name('statistics.index');

        Route::resource('users', UserController::class)->names([
            'index'   => 'admin.users.index',
            'create'  => 'admin.users.create',
            'store'   => 'admin.users.store',
            'edit'    => 'admin.users.edit',
            'update'  => 'admin.users.update',
            'destroy' => 'admin.users.destroy',
        ]);
        Route::patch('users/{user}/toggle-block', [UserController::class, 'toggleBlock'])->name('admin.users.toggle-block');
        // Cria um "alias" (atalho) para a rota antiga não partir o menu do utilizador
        Route::get('admin/users-compat', [UserController::class, 'index'])->name('users.index');
        Route::patch('users/{user}/toggle-block', [UserController::class, 'block'])
            ->name('admin.users.toggle-block');
        Route::get('admin/users-compat', [UserController::class, 'index'])
            ->name('users.index');

        Route::resource('customers', CustomerController::class)->except(['create', 'store'])->names([
            'index'   => 'admin.customers.index',
            'show'    => 'admin.customers.show',
            'edit'    => 'admin.customers.edit',
            'update'  => 'admin.customers.update',
            'destroy' => 'admin.customers.destroy',
        ]);
        Route::patch('customers/{customer}/toggle-block', [CustomerController::class, 'toggleBlock'])
            ->name('admin.customers.toggle-block');
        Route::get('admin/customers-compat', [CustomerController::class, 'index'])
            ->name('customers.index');

        Route::resource('admin/categories', CategoryController::class)->except(['show'])->names([
            'index'   => 'admin.categories.index',
            'create'  => 'admin.categories.create',
            'store'   => 'admin.categories.store',
            'edit'    => 'admin.categories.edit',
            'update'  => 'admin.categories.update',
            'destroy' => 'admin.categories.destroy',
        ]);

        Route::resource('admin/colors', ColorController::class)->except(['show'])->names([
            'index'   => 'admin.colors.index',
            'create'  => 'admin.colors.create',
            'store'   => 'admin.colors.store',
            'edit'    => 'admin.colors.edit',
            'update'  => 'admin.colors.update',
            'destroy' => 'admin.colors.destroy',
        ]);

        Route::get('prices/edit', [PriceController::class, 'edit'])->name('prices.edit');
        Route::put('prices', [PriceController::class, 'update'])->name('prices.update');

        Route::resource('catalog-images', TshirtImageController::class)
            ->except(['show'])
            ->parameters(['catalog-images' => 'tshirtImage']);

        Route::get('admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');
        Route::get('admin/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
        Route::patch('admin/orders/{order}/status', [OrderController::class, 'updateStatus'])
            ->name('admin.orders.status');
        Route::post('admin/orders/{order}/cancel', [OrderController::class, 'cancel'])
            ->middleware('can:cancel,order')
            ->name('admin.orders.cancel');
    });
});