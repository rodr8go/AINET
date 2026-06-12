<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UserFormRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller implements HasMiddleware
{
    use \App\Traits\UserPhotoFileStorage;

    public static function middleware(): array
    {
        return [
            new Middleware('can:viewAny,App\Models\User', only: ['index']),
            new Middleware('can:create,App\Models\User', only: ['create', 'store']),
            new Middleware('can:view,user', only: ['show']),
            new Middleware('can:update,user', only: ['edit', 'update']),
            new Middleware('can:delete,user', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of users (employees and admins only)
     */
    public function index(Request $request): \Illuminate\View\View
    {
        // 1. IMPORTANTE: Começa com a query limpa (Sem filtros fixos por Employee!)
        $query = User::query();

        // 2. Filtro por Nome (se preenchido)
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // 3. Filtro por Role/Type (repara que no URL está 'type')
        if ($request->filled('type')) {
            // Mapeia o valor do select ('Administrator', etc.) para a letra da BD ('A', 'F', 'C')
            $typeValue = match ($request->type) {
                'Administrator' => 'A',
                'Employee'      => 'F',
                'Customer'      => 'C',
                default         => $request->type,
            };

            $query->where('user_type', $typeValue);
        } else {
            // Se não houver filtro de tipo selecionado, garante que traz Admins e Employees (ignora apenas os clientes se for essa a vossa regra)
            $query->whereIn('user_type', ['A', 'F']);
        }

        // 4. Executa a paginação acumulando os filtros no URL
        $users = $query->orderBy('name', 'asc')->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users')); // ajusta para o nome exato da tua vista se for diferente
    }

    /**
     * Show the form for creating a new user
     */
    public function create(): View
    {
        $newUser = new User();
        return view('admin.users.create')->with('user', $newUser);
    }

    /**
     * Store a newly created user
     */
        public function store(UserFormRequest $request): RedirectResponse
        {
            $validatedData = $request->validated();

            $newUser = new User();
            $newUser->user_type = $validatedData['user_type'];
            $newUser->name = $validatedData['name'];
            $newUser->email = $validatedData['email'];
            $newUser->gender = $validatedData['gender'];
            $newUser->blocked = false;
            $newUser->password = bcrypt('123');

            $newUser->save();

            if ($request->hasFile('photo_file')) {
                $this->storeUserPhoto($request->photo_file, $newUser);
            }

            $newUser->sendEmailVerificationNotification();

            // CORRIGIDO: redirecionar para admin.users.index
            return redirect()->route('admin.users.index')
                ->with('alert-type', 'success')
                ->with('alert-msg', "Utilizador {$newUser->name} criado com sucesso!");
        }

    /**
     * Display the specified user
     */
    public function show(User $user): View
    {
        return view('users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit')->with('user', $user);
    }

    /**
     * Update the specified user
     */
    public function update(UserFormRequest $request, User $user): RedirectResponse
    {
        try {
            $validatedData = $request->validated();

            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->gender = $validatedData['gender'];
            
            if ($request->filled('password')) {
                $user->password = bcrypt($request->password);
            }
            
            $user->save();

            if ($request->hasFile('photo_file')) {
                if ($user->photo_url && Storage::disk('public')->exists('photos/' . $user->photo_url)) {
                    Storage::disk('public')->delete('photos/' . $user->photo_url);
                }
                $path = $request->file('photo_file')->store('photos', 'public');
                $user->photo_url = basename($path);
                $user->save();
            }

            return redirect()->route('admin.users.index')
                ->with('alert-type', 'success')
                ->with('alert-msg', "Utilizador {$user->name} atualizado com sucesso!");
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('alert-type', 'error')
                ->with('alert-msg', 'Erro: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified user (soft delete)
     */
    public function destroy(User $user): RedirectResponse
    {
        try {
            $url = route('users.show', ['user' => $user]);
            $fileName = $user->photo_url;
            $user->delete(); // Soft delete
            $this->deletePhotoFile($fileName);

            $alertType = 'success';
            $alertMsg = "User {$user->name} has been deleted successfully!";

            return redirect()->route('users.index')
                ->with('alert-type', $alertType)
                ->with('alert-msg', $alertMsg);
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the user {$user->name}!";

            return redirect()->back()
                ->with('alert-type', $alertType)
                ->with('alert-msg', $alertMsg);
        }
    }

    /**
     * Block a user
     */
    public function block(User $user): RedirectResponse
    {
        if (!Gate::allows('block', $user)) {
            abort(403);
        }

        $user->blocked = true;
        $user->save();

        return redirect()->back()
            ->with('alert-type', 'success')
            ->with('alert-msg', "User {$user->name} has been blocked.");
    }

    /**
     * Unblock a user
     */
    public function unblock(User $user): RedirectResponse
    {
        if (!Gate::allows('block', $user)) {
            abort(403);
        }

        $user->blocked = false;
        $user->save();

        return redirect()->back()
            ->with('alert-type', 'success')
            ->with('alert-msg', "User {$user->name} has been unblocked.");
    }

    /**
     * Toggle user block status (convenience method)
     */
    public function toggleBlock(User $user): RedirectResponse
    {
        if (!Gate::forUser(auth()->user())->allows('block', $user)) {
            abort(403);
        }

        if (auth()->id() === $user->id && !$user->blocked) {
            return redirect()->back()
                ->with('alert-type', 'warning')
                ->with('alert-msg', "You cannot block yourself.");
        }

        if ($user->blocked) {
            return $this->unblock($user);
        } else {
            return $this->block($user);
        }
    }

    /**
     * Delete user photo
     */
    public function destroyPhoto(User $user): RedirectResponse
    {
        if ($this->deleteUserPhoto($user)) {
            return redirect()->back()
                ->with('alert-type', 'success')
                ->with('alert-msg', "Photo of user {$user->name} has been deleted.");
        }

        return redirect()->back()
            ->with('alert-type', 'warning')
            ->with('alert-msg', "Photo of user {$user->name} does not exist.");
    }
}
