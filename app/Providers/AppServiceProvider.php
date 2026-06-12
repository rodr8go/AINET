<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\View;
use App\Models\User;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Color;
use App\Models\Price;
use App\Models\TshirtImage;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Gate;
use App\Policies\UserPolicy;
use App\Policies\CustomerPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\ColorPolicy;
use App\Policies\PricePolicy;
use App\Policies\TshirtImagePolicy;
use App\Policies\OrderPolicy;
use App\Policies\OrderItemPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
 public function boot(): void
    {
        $this->configureDefaults();

        //POLICIES
        $this->registerPolicies();
        
        //GATES
        $this->registerGates();
        
        //SHARED DATA
        $this->shareGlobalData();

    }

    protected function registerPolicies(): void
    {
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Customer::class, CustomerPolicy::class);
        Gate::policy(Category::class, CategoryPolicy::class);
        Gate::policy(Color::class, ColorPolicy::class);
        Gate::policy(Price::class, PricePolicy::class);
        Gate::policy(TshirtImage::class, TshirtImagePolicy::class);
        Gate::policy(Order::class, OrderPolicy::class);
        Gate::policy(OrderItem::class, OrderItemPolicy::class);
    }

    protected function registerGates(): void
    {
        //Quem tem acesso a dashboard
        Gate::define('view-dashboard', function (User $user) {
            return $user->isAdmin() || $user->isEmployee();
        });
        
        //Quem tem acesso a profile
        Gate::define('view-profile', function (?User $user) {
            if (!$user) return false;
            return $user->isCustomer() || $user->isAdmin();
        });

        //Quem pode usar o carrinho (Visitantes, Clientes normais ou Administradores)
        Gate::define('use-cart', function (?User $user) {
            return $user === null || !$user->isEmployee();
        });
        
        //Quem pode finalizar compras
        Gate::define('confirm-cart', function (User $user) {
            return !$user->isEmployee(); // Qualquer um menos funcionários
        });

        //Utilizadores
        
        //Quem é considerado ADMIN no sistema pelas rotas
        Gate::define('admin', function (User $user) {
            return $user->isAdmin(); // Usa o método helper que está no User.php ('A')
        });
        
        //Quem é considerado FUNCIONÁRIO pelas rotas
        Gate::define('employee', function (User $user) {
            return $user->isEmployee();
        });
    }

    protected function shareGlobalData(): void
    {
        
        try {
            // Share all colors (for dropdowns everywhere)
            View::share('sharedColors', Color::orderBy('name')->get());
            
            // Share all categories (for catalog filtering)
            View::share('sharedCategories', Category::orderBy('name')->get());
            
            // Share current price settings (for cart calculations)
            View::share('sharedPriceSettings', Price::getCurrent());
            
            // Share cart item count (for cart icon badge)
            View::composer('*', function ($view) {
                $cart = session('cart', []);
                $view->with('cartItemCount', count($cart));
            });
            
        } catch (\Exception $e) {
            // Silently fail - database might not exist during migration
        }
        
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
