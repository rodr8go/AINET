<x-layouts::main-content title="Shopping Cart"
                         heading="Carrinho de Compras 🛒"
                         subheading="Reveja as suas t-shirts antes de avançar para a finalização da encomenda.">

    <div class="space-y-6">
        
        

        @if(empty($cart) || count($cart) === 0)
            <flux:card class="p-8 text-center text-zinc-500 dark:text-zinc-400 space-y-4">
                <div class="text-4xl">🛒</div>
                <p>O seu carrinho de compras está vazio de momento.</p>
                <flux:button href="{{ route('catalog.index') }}" variant="filled" class="bg-blue-600 text-white cursor-pointer">
                    Voltar ao Catálogo
                </flux:button>
            </flux:card>
        @else
            @php
                // Inicializa a variável para somar o total acumulado do carrinho
                $totalPrice = 0;
            @endphp

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                
                <div class="lg:col-span-2 space-y-4">
                    <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden bg-white dark:bg-zinc-900">
                        <table class="w-full text-left border-collapse text-sm text-zinc-800 dark:text-zinc-200">
                            <thead class="bg-zinc-50 dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 font-medium">
                                <tr>
                                    <th class="p-4">Produto</th>
                                    <th class="p-4">Especificações</th>
                                    <th class="p-4 text-center">Quantidade</th>
                                    <th class="p-4">Subtotal</th>
                                    <th class="p-4 text-center w-24">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                @foreach($cart as $id => $item)
                                    @php
                                        // Calcula o subtotal deste item usando as chaves certas do teu Controller ('unit_price' e 'qty')
                                        $itemSubtotal = ($item['unit_price'] ?? 0) * ($item['qty'] ?? 1);
                                        $totalPrice += $itemSubtotal;
                                    @endphp
                                    <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/50">
                                        <td class="p-4 font-medium text-zinc-900 dark:text-white flex items-center gap-3">
                                            @if(isset($item['image_url']))
    @if(!empty($item['customer_id']))
        {{-- Imagem privada do cliente --}}
        <img src="{{ route('my-images.show-image', $item['tshirt_image_id']) }}" 
             class="w-12 h-12 rounded object-cover border bg-zinc-100">
    @else
        {{-- Imagem pública do catálogo --}}
        <img src="{{ asset('storage/tshirt_images/' . $item['image_url']) }}" 
             class="w-12 h-12 rounded object-cover border bg-zinc-100">
    @endif
@else
    <div class="w-12 h-12 rounded bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-xs text-zinc-400">No Img</div>
@endif
                                            <span>{{ $item['name'] ?? 'T-shirt' }}</span>
                                        </td>
                                        
                                        <td class="p-4 text-zinc-600 dark:text-zinc-400">
                                            <div class="flex items-center gap-2">
                                                <flux:badge size="sm" variant="subtle" color="zinc">
                                                    {{ $item['size'] ?? 'M' }}
                                                </flux:badge>
                                                <span class="text-xs text-zinc-500">
                                                    {{ $item['color_name'] ?? 'N/A' }}
                                                </span>
                                            </div>
                                        </td>
                                        
                                        <td class="p-4 text-center">
    <span class="font-medium text-zinc-900 dark:text-white">{{ $item['qty'] ?? 1 }}</span>
</td>
                                        
                                        <td class="p-4 font-semibold text-zinc-900 dark:text-white">
                                            {{ number_format($itemSubtotal, 2, ',', '.') }} €
                                        </td>
                                        
                                        <td class="p-4 text-center">
                                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <flux:button type="submit" size="sm" variant="subtle" icon="trash" class="text-red-600 hover:text-red-700" title="Remover" />
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-start">
                        <form action="{{ route('cart.destroy') }}" method="POST" onsubmit="return confirm('Deseja mesmo esvaziar todo o seu carrinho?')">
                            @csrf
                            @method('DELETE')
                            <flux:button type="submit" variant="subtle" icon="x-mark" class="text-zinc-500 hover:text-red-600">
                                Esvaziar Carrinho
                            </flux:button>
                        </form>
                    </div>
                </div>

                <flux:card class="p-6 space-y-6">
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white border-b pb-3 border-zinc-100 dark:border-zinc-800">
                        Resumo do Pedido
                    </h3>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between text-zinc-600 dark:text-zinc-400">
                            <span>Subtotal de itens</span>
                            <span class="font-medium text-zinc-900 dark:text-white">
                                {{ number_format($totalPrice, 2, ',', '.') }} €
                            </span>
                        </div>
                        <div class="flex justify-between text-zinc-600 dark:text-zinc-400">
                            <span>Portes de envio</span>
                            <span class="text-green-600 font-medium">Grátis</span>
                        </div>
                        <div class="border-t pt-3 flex justify-between text-base font-bold text-zinc-900 dark:text-white border-zinc-100 dark:border-zinc-800">
                            <span>Total Estimado</span>
                            <span class="text-blue-600 dark:text-blue-400">
                                {{ number_format($totalPrice, 2, ',', '.') }} €
                            </span>
                        </div>
                    </div>

                    <div class="mt-6">
                        @can('confirm-cart')
                        @auth
                            <div>
                                <flux:button href="{{ route('checkout.index') }}" 
                                             variant="filled" 
                                             class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 flex items-center justify-center gap-2 cursor-pointer">
                                    <flux:icon.credit-card size="sm" />
                                    Finalizar Encomenda
                                </flux:button>
                            </div>
                        @else
                            <div class="space-y-3">
                                <flux:button href="{{ route('login') }}" 
                                             variant="filled" 
                                             color="zinc" 
                                             class="w-full text-center font-semibold py-3 flex items-center justify-center gap-2 cursor-pointer">
                                    Faça login para Comprar 🔒
                                </flux:button>
                                <p class="text-center text-xs text-zinc-400 dark:text-zinc-500 leading-normal">
                                    Apenas clientes registados podem fechar encomendas.
                                </p>
                            </div>
                        @endauth
                        @endcan
                    </div>
                </flux:card>

            </div>
        @endif
    </div>

</x-layouts::main-content>