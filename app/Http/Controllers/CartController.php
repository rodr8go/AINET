<?php

namespace App\Http\Controllers;

use App\Models\TshirtImage;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class CartController extends Controller
{
    // Mostrar os itens do carrinho
    public function show()
    {
        $cart = session()->get('cart', []);
        return view('cart.show', compact('cart'));
    }

    // Adicionar um produto ao carrinho
    public function add(Request $request, TshirtImage $tshirtImage)
    {
        $request->validate([
            'color_code' => 'required|exists:colors,code',
            'size' => 'required|in:XS,S,M,L,XL',
            'qty' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        // Criar uma chave única para o item baseada na imagem, cor e tamanho
        $itemKey = $tshirtImage->id . '-' . $request->color_code . '-' . $request->size;

        $color = Color::find($request->color_code);

        // Se o item já existe no carrinho, incrementa a quantidade
        if (isset($cart[$itemKey])) {
            $cart[$itemKey]['qty'] += $request->qty;
        } else {
            // Caso contrário, adiciona o novo item
            $cart[$itemKey] = [
                'tshirt_image_id' => $tshirtImage->id,
                'name' => $tshirtImage->name,
                'image_url' => $tshirtImage->image_url,
                'color_code' => $color->code,
                'color_name' => $color->name,
                'size' => $request->size,
                'qty' => $request->qty,
                // O preço unitário real será calculado dinamicamente com base nos descontos na Fase 4
                'unit_price' => 10.00, 
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.show')->with('success', 'T-shirt adicionada ao carrinho!');
    }

    // Remover um item do carrinho
    public function remove($itemKey)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$itemKey])) {
            unset($cart[$itemKey]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.show')->with('success', 'Item removido do carrinho.');
    }

    // Limpar o carrinho todo
    public function destroy()
    {
        session()->forget('cart');
        return redirect()->route('cart.show')->with('success', 'Carrinho vazio.');
    }
}