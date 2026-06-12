<?php

namespace App\Http\Controllers;

use App\Models\TshirtImage;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB; // 🎯 Importado para ler a tabela de preços

class CartController extends Controller
{
    // Mostrar os itens do carrinho
    public function show()
    {
        $cart = session()->get('cart', []);
        
        // Vamos passar também as regras de preço para o Blade do carrinho conseguir ler o qty_discount se precisar
        $priceRules = DB::table('prices')->first();
        
        return view('cart.show', compact('cart', 'priceRules'));
    }

    // Adicionar um produto ao carrinho com desconto dinâmico
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

        // Buscar as informações da cor
        $color = Color::where('code', $request->color_code)->first();

        // 💰 BUSCAR REGRAS DE PREÇO DA BASE DE DADOS
        $priceRules = DB::table('prices')->first();
        $basePrice = $priceRules ? (float) $priceRules->unit_price_catalog : 10.00;
        $discountPrice = $priceRules ? (float) $priceRules->unit_price_catalog_discount : 8.50;
        $qtyDiscountLimit = $priceRules ? (int) $priceRules->qty_discount : 5;

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
                'unit_price' => $basePrice, // Será atualizado logo abaixo
            ];
        }

        //RECALCULAR O PREÇO UNITÁRIO BASEADO NA QUANTIDADE ACUMULADA
        //Isto garante que se o utilizador adicionar 3 MAs e depois mais 3 MAs, ele atinge as 6 un. e ganha o desconto!
        if ($cart[$itemKey]['qty'] >= $qtyDiscountLimit) {
            $cart[$itemKey]['unit_price'] = $discountPrice;
        } else {
            $cart[$itemKey]['unit_price'] = $basePrice;
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.show')
            ->with('alert-type', 'success')
            ->with('alert-msg', "T-shirt {$tshirtImage->name} adicionada ao carrinho!");
    }

    //Atualizar quantidade de um item no carrinho
    public function update(Request $request, $itemId)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$itemId])) {
            //Validar a quantidade
            $request->validate([
                'quantity' => 'required|integer|min:1|max:999',
            ]);
            
            //Atualizar a quantidade
            $cart[$itemId]['qty'] = $request->quantity;
            
            //Recalcular o preço unitário baseado na nova quantidade
            $priceRules = DB::table('prices')->first();
            $basePrice = $priceRules ? (float) $priceRules->unit_price_catalog : 10.00;
            $discountPrice = $priceRules ? (float) $priceRules->unit_price_catalog_discount : 8.50;
            $qtyDiscountLimit = $priceRules ? (int) $priceRules->qty_discount : 5;
            
            if ($cart[$itemId]['qty'] >= $qtyDiscountLimit) {
                $cart[$itemId]['unit_price'] = $discountPrice;
            } else {
                $cart[$itemId]['unit_price'] = $basePrice;
            }
            
            session()->put('cart', $cart);
            
            return redirect()->route('cart.show')
                ->with('alert-type', 'success')
                ->with('alert-msg', 'Quantidade atualizada com sucesso!');
        }
        
        return redirect()->route('cart.show')
            ->with('alert-type', 'error')
            ->with('alert-msg', 'Item não encontrado no carrinho.');
    }

    //Remover um item do carrinho (Nome do parâmetro ajustado para bater certo com a rota {itemId})
    public function remove($itemId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$itemId])) {
            unset($cart[$itemId]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.show')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Item removido do carrinho.');
    }

    //Limpar o carrinho todo
    public function destroy()
    {
        session()->forget('cart');
        return redirect()->route('cart.show')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Carrinho vazio.');
    }
}