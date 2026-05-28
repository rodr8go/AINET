<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\View;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use App\Policies\AdministrativePolicy;

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

        Gate::policy(User::class, AdministrativePolicy::class);

        // 🛒 Quem pode usar o carrinho (Visitantes, Clientes normais ou Administradores)
        Gate::define('use-cart', function (?User $user) {
            return $user === null || !$user->isEmployee();
        });

        // ✅ Quem pode finalizar compras
        Gate::define('confirm-cart', function (User $user) {
            return $user->user_type !== 'F'; // Qualquer um menos funcionários
        });

        // 👑 Quem é considerado ADMIN no sistema pelas rotas
        Gate::define('admin', function (User $user) {
            return $user->isAdmin(); // Usa o método helper que está no User.php ('A')
        });

        // 👨‍💻 Quem é considerado FUNCIONÁRIO pelas rotas
        Gate::define('employee', function (User $user) {
            return $user->isEmployee(); // Usa o método helper que está no User.php ('F')
        });

        try {
            // View::share adds data (variables) that are shared through all views
            
        } catch (\Exception $e) {
            // No need to do anything – this just ensures that no exception is
            // thrown if "courses" table does not exist when running
            // "php artisan migrate" for the first time
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
