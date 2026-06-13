{{-- resources/views/admin/orders/cancel.blade.php --}}

<x-layouts::main-content 
    title="Cancelar Encomenda" 
    heading="Cancelar Encomenda #{{ $order->id }}"
    subheading="Preencha o motivo do cancelamento (opcional)">

    <div class="max-w-2xl">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            {{-- Formulário de Cancelamento --}}
            <div class="lg:col-span-2">
                <flux:card class="p-6">
                    <form action="{{ route('admin.orders.cancel', $order) }}" method="POST" class="space-y-6">
                        @csrf
                        
                        {{-- Aviso --}}
                        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                <flux:icon.exclamation-triangle class="text-red-600 dark:text-red-400 w-5 h-5 flex-shrink-0 mt-0.5" />
                                <div>
                                    <h4 class="text-sm font-semibold text-red-800 dark:text-red-300">Atenção!</h4>
                                    <p class="text-sm text-red-700 dark:text-red-400 mt-1">
                                        Esta ação irá cancelar a encomenda <strong>#{{ $order->id }}</strong> e não pode ser revertida.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Informação da Encomenda --}}
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white border-b pb-2">
                                Informação da Encomenda
                            </h3>
                            
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-zinc-500">Cliente:</span>
                                    <p class="font-medium text-zinc-900 dark:text-white mt-1">
                                        {{ $order->customer->user->name ?? 'N/A' }}
                                    </p>
                                </div>
                                <div>
                                    <span class="text-zinc-500">Data:</span>
                                    <p class="font-medium text-zinc-900 dark:text-white mt-1">
                                        {{ \Carbon\Carbon::parse($order->date)->format('d/m/Y') }}
                                    </p>
                                </div>
                                <div>
                                    <span class="text-zinc-500">Total:</span>
                                    <p class="font-medium text-zinc-900 dark:text-white mt-1">
                                        €{{ number_format($order->total_price, 2, ',', '.') }}
                                    </p>
                                </div>
                                <div>
                                    <span class="text-zinc-500">Status:</span>
                                    <p class="mt-1">
                                        <flux:badge size="sm" color="amber" variant="subtle">Pendente</flux:badge>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Motivo do Cancelamento --}}
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white border-b pb-2">
                                Motivo do Cancelamento
                            </h3>
                            
                            <div>
                                <flux:textarea 
                                    name="reason" 
                                    label="Motivo (opcional)"
                                    placeholder="Ex: Produto fora de stock, Cliente solicitou cancelamento, Erro no pagamento, Problema com o fornecedor..."
                                    rows="4"
                                    value="{{ old('reason') }}" />
                                
                                <flux:text size="sm" class="mt-1 text-zinc-500">
                                    O motivo ficará visível para o cliente no detalhe da encomenda.
                                </flux:text>
                                @error('reason')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        {{-- Itens da Encomenda (opcional - para referência) --}}
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white border-b pb-2">
                                Itens da Encomenda
                            </h3>
                            
                            <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
                                <table class="w-full text-sm">
                                    <thead class="bg-zinc-50 dark:bg-zinc-800">
                                        <tr>
                                            <th class="p-3 text-left">Produto</th>
                                            <th class="p-3 text-center">Tamanho</th>
                                            <th class="p-3 text-center">Qtd</th>
                                            <th class="p-3 text-right">Preço</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                        @foreach($order->items as $item)
                                        <tr>
                                            <td class="p-3">
                                                {{ $item->tshirtImage->name ?? 'Produto' }}
                                                @if($item->tshirtImage && !$item->tshirtImage->isCatalogImage())
                                                    <span class="text-xs text-purple-500 ml-2">(Personalizada)</span>
                                                @endif
                                            </td>
                                            <td class="p-3 text-center">{{ $item->size }}</td>
                                            <td class="p-3 text-center">{{ $item->qty }}</td>
                                            <td class="p-3 text-right">€{{ number_format($item->sub_total, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-zinc-50 dark:bg-zinc-800">
                                        <tr>
                                            <td colspan="3" class="p-3 text-right font-bold">Total:</td>
                                            <td class="p-3 text-right font-bold">€{{ number_format($order->total_price, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        
                        {{-- Botões --}}
                        <flux:separator />
                        
                        <div class="flex items-center justify-end gap-2">
                            <flux:button href="{{ route('admin.orders.show', $order) }}" variant="ghost">
                                Voltar
                            </flux:button>
                            
                            <form action="{{ route('admin.orders.cancel', $order) }}" method="POST" class="inline" onsubmit="return confirm('Tem a certeza que deseja cancelar esta encomenda?')">
                                @csrf
                                <flux:button type="submit" variant="danger" icon="x-circle">
                                    Confirmar Cancelamento
                                </flux:button>
                            </form>
                        </div>
                        
                    </form>
                </flux:card>
            </div>
            
        </div>
    </div>
    
</x-layouts::main-content>