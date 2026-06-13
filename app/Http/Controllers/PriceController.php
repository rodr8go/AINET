<?php

namespace App\Http\Controllers;

use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PriceController extends Controller
{
    // Mostrar o formulário com os preços atuais
    public function edit(): View
    {
        // Puxa o primeiro registo de preços da tabela de configuração
        $prices = Price::first() ?? new Price();
        return view('admin.prices.edit', compact('prices'));
    }

    // Guardar os novos valores (Preço base, preço com estampa, etc.)
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'unit_price_catalog' => 'required|numeric|min:0',
            'unit_price_own' => 'required|numeric|min:0',
            'unit_price_catalog_discount' => 'nullable|numeric|min:0',
            'qty_discount' => 'nullable|integer|min:1',
            'unit_price_own_discount' => 'nullable|numeric|min:0',
        ]);

        $prices = Price::first();
        if ($prices) {
            $prices->update($validated);
        } else {
            Price::create($validated);
        }

        return redirect()->back()
            ->with('toast', 'Tabela de preços atualizada com sucesso!');
    }
}
