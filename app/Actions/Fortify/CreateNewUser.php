<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules; // <-- A importação que faltava!
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        // 1. Validar os dados de entrada
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'gender' => ['required', 'in:M,F'], // Obrigatório na BD FunShirt
        ])->validate();

        // 2. Criar os registos numa transação segura (User + Customer)
        return DB::transaction(function () use ($input) {
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'user_type' => 'C', // Define o utilizador como Cliente
                'gender' => $input['gender'],
                'blocked' => 0,
            ]);

            // Cria o perfil estendido de Cliente associado
            Customer::create([
                'id' => $user->id,
            ]);

            return $user;
        });
    }
}