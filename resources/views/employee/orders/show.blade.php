<x-layouts::main-content title="Detalhes da Encomenda #{{ $order->id }}"
    heading="Detalhes da Encomenda"
    subheading="Encomenda #{{ $order->id }} — {{ \Carbon\Carbon::parse($order->date)->format('d/m/Y') }}">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Itens da Encomenda --}}
        <div class="lg:col-span-2 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden self-start">
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
                <h3 class="font-semibold text-zinc-900 dark:text-white">Itens da Encomenda</h3>
            </div>
            <table class="w-full text-sm text-left">
                <thead class="bg-zinc-50 dark:bg-zinc-800 text-xs uppercase tracking-wider text-zinc-500">
                    <tr>
                        <th class="p-4">Produto</th>
                        <th class="p-4 text-center">Tamanho</th>
                        <th class="p-4 text-center">Quantidade</th>
                        <th class="p-4 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @foreach($order->items as $item)
                    <tr>
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded bg-zinc-100 dark:bg-zinc-800 overflow-hidden flex-shrink-0">
                                    @if($item->tshirtImage)
                                        @if($item->tshirtImage->customer_id)
                                            <img src="{{ route('my-images.show-image', $item->tshirtImage->id) }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            <img src="{{ asset('storage/tshirt_images/' . $item->tshirtImage->image_url) }}"
                                                 class="w-full h-full object-cover">
                                        @endif
                                    @endif
                                </div>
                                <div>
                                    <p class="font-medium text-zinc-900 dark:text-white">{{ $item->tshirtImage->name ?? 'N/A' }}</p>
                                    <p class="text-xs text-zinc-500">Cor: {{ $item->color->name ?? $item->color_code }}</p>
                                    @if($item->tshirtImage?->customer_id)
                                        <p class="text-xs text-indigo-400">Imagem Personalizada</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="p-4 text-center">
                            <span class="px-2 py-1 rounded bg-zinc-100 dark:bg-zinc-800 text-xs font-bold">{{ $item->size }}</span>
                        </td>
                        <td class="p-4 text-center">{{ $item->qty }}</td>
                        <td class="p-4 text-right font-semibold">€{{ number_format($item->sub_total, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-zinc-50 dark:bg-zinc-800 border-t border-zinc-200 dark:border-zinc-700">
                    <tr>
                        <td colspan="3" class="p-4 text-right font-bold text-zinc-900 dark:text-white">Total:</td>
                        <td class="p-4 text-right font-black text-indigo-500">€{{ number_format($order->total_price, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- Informações + Confirmação --}}
        <div class="space-y-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700 p-5 space-y-3 text-sm">
                <h3 class="font-semibold text-zinc-900 dark:text-white border-b pb-2 border-zinc-200 dark:border-zinc-700">
                    Informações do Cliente
                </h3>
                <div class="flex justify-between">
                    <span class="text-zinc-500">Cliente:</span>
                    <span class="font-medium text-zinc-900 dark:text-white">{{ $order->customer->user->name ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-zinc-500">NIF:</span>
                    <span class="text-zinc-900 dark:text-white">{{ $order->nif ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between gap-4">
                    <span class="text-zinc-500 shrink-0">Morada:</span>
                    <span class="text-zinc-900 dark:text-white text-right">{{ $order->address ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-zinc-500">Pagamento:</span>
                    <span class="text-zinc-900 dark:text-white">{{ $order->payment_type ?? 'N/A' }}</span>
                </div>
                @if($order->payment_ref)
                <div class="flex justify-between gap-4">
                    <span class="text-zinc-500 shrink-0">Referência:</span>
                    <span class="text-zinc-900 dark:text-white text-right break-all">{{ $order->payment_ref }}</span>
                </div>
                @endif
            </div>

            {{-- Botões --}}
            <div class="space-y-2">
                <form action="{{ route('employee.orders.close', $order) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <flux:button type="submit" variant="filled" icon="check"
                        class="w-full bg-green-600 hover:bg-green-700 text-white cursor-pointer justify-center">
                        Confirmar Conclusão e Envio
                    </flux:button>
                </form>

                <flux:button href="{{ route('employee.orders.pending') }}" variant="ghost"
                    class="w-full justify-center">
                    ← Voltar às Pendentes
                </flux:button>
            </div>
        </div>
    </div>

</x-layouts::main-content>