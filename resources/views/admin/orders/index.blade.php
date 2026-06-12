<x-layouts::main-content title="Gestão de Encomendas"
                         heading="Todas as Encomendas"
                         subheading="Visualize, filtre e faça a gestão dos estados de todas as encomendas da plataforma">

    <div class="space-y-6">
        
        <flux:card class="p-4">
            <form action="{{ request()->url() }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 items-end">
                
                <div>
                    <flux:input name="customer_name" 
                                label="Nome do Cliente" 
                                placeholder="Procurar por nome..." 
                                value="{{ request('customer_name') }}" />
                </div>

                <div>
                    <flux:label class="mb-2 block text-sm">Estado</flux:label>
                    <select name="status" class="w-full border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 rounded-lg p-2.5 text-sm text-zinc-800 dark:text-zinc-200">
                        <option value="">-- Todos os Estados --</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendente (Pending)</option>
                            <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Fechada (Closed)</option>
                            <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>Cancelada (Canceled)</option>
                    </select>
                </div>

                <div>
                    <flux:input type="date" 
                                name="date_from" 
                                label="De (Data)" 
                                value="{{ request('date_from') }}" />
                </div>

                <div class="flex gap-2">
                    <div class="flex-1">
                        <flux:input type="date" 
                                    name="date_to" 
                                    label="Até (Data)" 
                                    value="{{ request('date_to') }}" />
                    </div>
                    <div class="flex gap-1 h-[38px]">
                        <flux:button type="submit" variant="filled" class="bg-blue-600 hover:bg-blue-700 text-white cursor-pointer" icon="magnifying-glass" title="Filtrar" />
                        @if(request()->anyFilled(['customer_name', 'status', 'date_from', 'date_to']))
                            <flux:button href="{{ request()->url() }}" variant="subtle" icon="x-mark" title="Limpar Filtros" />
                        @endif
                    </div>
                </div>

            </form>
        </flux:card>

        @if($orders->isEmpty())
            <flux:card class="p-6 text-center text-zinc-500 dark:text-zinc-400">
                Nenhuma encomenda encontrada com os filtros selecionados.
            </flux:card>
        @else
            <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden bg-white dark:bg-zinc-900">
                <table class="w-full text-left border-collapse text-sm text-zinc-800 dark:text-zinc-200">
                    <thead class="bg-zinc-50 dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 font-medium">
                        <tr>
                            <th class="p-4 w-24">ID</th>
                            <th class="p-4">Cliente</th>
                            <th class="p-4">Data de Criação</th>
                            <th class="p-4">Preço Total</th>
                            <th class="p-4 text-center">Estado</th>
                            <th class="p-4 w-24 text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @foreach($orders as $order)
                            <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/50">
                                <td class="p-4 font-mono font-semibold text-zinc-600 dark:text-zinc-400">
                                    #{{ $order->id }}
                                </td>
                                <td class="p-4 font-medium text-zinc-900 dark:text-white">
                                    {{ $order->customer->user->name ?? 'Cliente Desconhecido' }}
                                </td>
                                <td class="p-4 text-zinc-600 dark:text-zinc-400">
                                    {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}
                                </td>
                                <td class="p-4 font-semibold text-zinc-900 dark:text-white">
                                    {{ number_format($order->total_price, 2, ',', '.') }} €
                                </td>
                                <td class="p-4 text-center">
                                    @php
                                        $statusColors = [
                                        'pending' => 'amber',
                                        'closed'  => 'green',
                                        'canceled'=> 'red',
                                    ];
                                        $color = $statusColors[$order->status] ?? 'zinc';
                                    @endphp
                                    <flux:badge size="sm" color="{{ $color }}" variant="subtle">
                                        {{ ucfirst($order->status) }}
                                    </flux:badge>
                                </td>
                                <td class="p-4 text-center">
                                    <flux:button href="{{ route('admin.orders.show', $order) }}" variant="subtle" icon="eye" size="sm" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

</x-layouts::main-content>