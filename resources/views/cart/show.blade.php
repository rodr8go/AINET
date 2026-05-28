<x-layouts::main-content title="Cart"
                        heading="Shopping Cart"
                        subheading="Disciplines to register for a student">
<div class="py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">Carrinho de Compras 🛒</h1>
        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Reveja as suas t-shirts antes de avançar para a finalização da encomenda.</p>

        @if(empty($cart))
            <div class="py-16 mt-6 text-center bg-white rounded-xl border shadow-sm dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700">
                <flux:icon icon="shopping-bag" class="mx-auto w-16 h-16 text-zinc-300 dark:text-zinc-600" />
                <h2 class="mt-4 text-xl font-semibold text-zinc-900 dark:text-zinc-100">O seu carrinho está vazio</h2>
                <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">Visite o nosso catálogo para encontrar estampas incríveis.</p>
                <div class="mt-6">
                    <flux:button href="{{ route('catalog.index') }}" variant="filled" color="indigo">
                        Explorar Catálogo
                    </flux:button>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 gap-8 mt-6 lg:grid-cols-3">
                
                <div class="lg:col-span-2 space-y-4">
                    <div class="bg-white rounded-xl border shadow-sm dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700 overflow-hidden">
                        <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700 text-left text-sm">
                            <thead class="bg-zinc-50 dark:bg-zinc-900/50 text-zinc-500 dark:text-zinc-400 font-medium">
                                <tr>
                                    <th class="px-6 py-4">Produto</th>
                                    <th class="px-6 py-4 text-center">Especificações</th>
                                    <th class="px-6 py-4 text-center">Quantidade</th>
                                    <th class="px-6 py-4 text-right">Subtotal</th>
                                    <th class="px-6 py-4 text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700 text-zinc-800 dark:text-zinc-200">
                                @php $totalGlobal = 0; @endphp
                                @foreach($cart as $key => $item)
                                    @php 
                                        $subtotal = $item['qty'] * $item['unit_price']; 
                                        $totalGlobal += $subtotal;
                                    @endphp
                                    <tr>
                                        <td class="px-6 py-4 flex items-center gap-4">
                                            <div class="w-12 h-12 bg-zinc-100 dark:bg-zinc-900 rounded p-1 flex items-center justify-center border border-zinc-200 dark:border-zinc-700 shrink-0">
                                                <img src="{{ asset('storage/tshirt_images/' . $item['image_url']) }}" alt="{{ $item['name'] }}" class="max-h-full max-w-full object-contain">
                                            </div>
                                            <span class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $item['name'] }}</span>
                                        </td>
                                        
                                        <td class="px-6 py-4 text-center">
                                            <div class="text-xs">
                                                <span class="px-2 py-0.5 bg-zinc-100 dark:bg-zinc-700 rounded text-zinc-600 dark:text-zinc-300 font-mono">{{ $item['size'] }}</span>
                                                <span class="ml-2">{{ $item['color_name'] }}</span>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 text-center font-mono">
                                            {{ $item['qty'] }}
                                        </td>

                                        <td class="px-6 py-4 text-right font-semibold font-mono">
                                            {{ number_format($subtotal, 2, ',', '.') }} €
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            <form action="{{ route('cart.remove', $key) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <flux:button type="submit" variant="ghost" color="red" icon="trash" size="sm" square />
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-start">
                        <form action="{{ route('cart.destroy') }}" method="POST" onsubmit="return confirm('Tem a certeza que deseja esvaziar o carrinho?')">
                            @csrf
                            @method('DELETE')
                            <flux:button type="submit" variant="outline" color="red" icon="x-mark">
                                Esvaziar Carrinho
                            </flux:button>
                        </form>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="p-6 bg-white rounded-xl border shadow-sm dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700">
                        <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-100 border-b border-zinc-100 dark:border-zinc-700 pb-3">Resumo do Pedido</h3>
                        
                        <div class="mt-4 space-y-2 text-sm">
                            <div class="flex justify-between text-zinc-500 dark:text-zinc-400">
                                <span>Subtotal de itens</span>
                                <span class="font-mono font-medium text-zinc-800 dark:text-zinc-200">{{ number_format($totalGlobal, 2, ',', '.') }} €</span>
                            </div>
                            <div class="flex justify-between text-zinc-500 dark:text-zinc-400">
                                <span>Portes de envio</span>
                                <span class="text-green-600 font-medium">Grátis</span>
                            </div>
                            <div class="flex justify-between text-base font-bold text-zinc-900 dark:text-zinc-100 border-t border-zinc-100 dark:border-zinc-700 pt-3 mt-3">
                                <span>Total Estimado</span>
                                <span class="font-mono text-indigo-600 dark:text-indigo-400">{{ number_format($totalGlobal, 2, ',', '.') }} €</span>
                            </div>
                        </div>

                        <div class="mt-6">
                            @auth
                                <flux:button type="submit" variant="filled" color="indigo" icon="shopping-cart" class="w-full mt-2">
    Adicionar ao Carrinho
</flux:button>
                            @else
                                <flux:button href="{{ route('login') }}" variant="filled" color="zinc" class="w-full text-center font-semibold">
    Faça login para Comprar 🔐
</flux:button>
                                <p class="mt-2 text-center text-xs text-zinc-400">Apenas clientes registados podem fechar encomendas.</p>
                            @endauth
                        </div>
                    </div>
                </div>

            </div>
        @endif
    </div>
</x-layouts::main-content>
