<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Listar e filtrar todos os utilizadores [cite: 68]
    public function index(Request $request)
    {
        $query = User::query();

        // Filtro por tipo de utilizador
        if ($request->filled('type')) {
            $query->where('user_type', $request->type);
        }

        // Filtro por nome
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $users = $query->paginate(15);
        return view('users.index', compact('users'));
    }

    // Editar dados ou permissões de um funcionário/cliente [cite: 67-68]
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'user_type' => 'required|in:C,F,A',
            'blocked' => 'required|boolean',
        ]);

        $user->update($request->only('name', 'user_type', 'blocked'));

        return redirect()->route('admin.users.index')->with('success', 'Conta atualizada com sucesso.');
    }

    // Bloquear/Desbloquear acesso rapidamente [cite: 67-68]
    public function toggleBlock(User $user)
    {
        $user->blocked = !$user->blocked;
        $user->save();
        
        $estado = $user->blocked ? 'bloqueada' : 'desbloqueada';
        return back()->with('success', "A conta foi {$estado}.");
    }

    // Remover conta (Soft Delete automático gerido pela framework) [cite: 68-69, 420-422]
    public function destroy(User $user)
    {
        $user->delete(); 
        return back()->with('success', 'Utilizador removido do sistema (Soft Delete aplicado).');
    }
}