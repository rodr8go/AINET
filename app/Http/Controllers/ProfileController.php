<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Mostrar a página de edição de perfil
    public function edit()
    {
        $user = Auth::user();
        $customer = $user->customer; // Carrega os dados específicos de cliente
        
        return view('profile.edit', compact('user', 'customer'));
    }

    // Atualizar os dados submetidos
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validação dos dados comuns e específicos
        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:M,F',
            'photo' => 'nullable|image|max:2048',
            'nif' => 'nullable|digits:9',
            'address' => 'nullable|string',
            'default_payment_type' => 'nullable|in:Visa,PayPal,MB WAY',
            'default_payment_ref' => 'nullable|string',
        ]);

        // 1. Atualizar dados na tabela users
        $user->name = $request->name;
        $user->gender = $request->gender;

        // Gestão do upload da fotografia [cite: 62, 325]
        if ($request->hasFile('photo')) {
            if ($user->photo_url && Storage::disk('public')->exists('photos/' . $user->photo_url)) {
                Storage::disk('public')->delete('photos/' . $user->photo_url);
            }
            $path = $request->file('photo')->store('photos', 'public');
            $user->photo_url = basename($path);
        }
        $user->save();

        // 2. Atualizar dados na tabela customers (se for Cliente)
        if ($user->user_type === 'C' && $user->customer) {
            $user->customer->update([
                'nif' => $request->nif,
                'address' => $request->address,
                'default_payment_type' => $request->default_payment_type,
                'default_payment_ref' => $request->default_payment_ref,
            ]);
        }

        return back()->with('success', 'Perfil atualizado com sucesso!');
    }
}