<x-layouts::main-content title="Pending Orders"
    heading="Encomendas Pendentes"
    subheading="Lista de t-shirts aguardando estampagem e expedição logística">

    @if($orders->isEmpty())
    <flux:card class="p-6 text-center text-zinc-500 dark:text-zinc-400">
        Não existem encomendas pendentes de momento. Bom trabalho!
    </flux:card>
    @else
    <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden bg-white dark:bg-zinc-900">
        <table class="w-full text-left border-collapse text-sm text-zinc-800 dark:text-zinc-200">
            <thead class="bg-zinc-50 dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 font-medium">
                <tr>
                    <th class="p-4">ID</th>
                    <th class="p-4">Data</th>
                    <th class="p-4">Cliente</th>
                    <th class="p-4 text-center">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                @foreach($orders as $order)
                <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/50">
                    <td class="p-4 font-semibold">#{{ $order->id }}</td>


                    <td class="p-4">{{ \Carbon\Carbon::parse($order->date)->format('d/m/Y') }}</td>

                    
                    <td class="p-4">{{ $order->customer->user->name ?? 'Cliente Desconhecido' }}</td>

                    <td class="p-4 flex items-center justify-center">
                        {{-- Formulário para transitar o estado para "closed" --}}
                        <form action="{{ route('employee.orders.close', $order) }}" method="POST" onsubmit="return confirm('Confirmas a conclusão da estampagem e expedição desta encomenda?')">
                            @csrf
                            @method('PATCH')

                            <flux:button type="submit" variant="filled" icon="check" class="bg-green-600 hover:bg-green-700 text-white cursor-pointer">
                                Concluir e Enviar
                            </flux:button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

</x-layouts::main-content>