<x-layouts::main-content title="Gestão de Cores"
    heading="Cores de T-Shirts"
    subheading="Gerite as cores que estão disponíveis para venda no catálogo">

    <div class="space-y-6">
        <div class="flex justify-end">
            <flux:button href="{{ route('admin.colors.create') }}" variant="filled" icon="plus" class="bg-blue-600 hover:bg-blue-700 text-white cursor-pointer">
                Adicionar Nova Cor
            </flux:button>
        </div>

        @if($colors->isEmpty())
        <flux:card class="p-6 text-center text-zinc-500 dark:text-zinc-400">
            Não existem cores registadas no sistema.
        </flux:card>
        @else
        <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden bg-white dark:bg-zinc-900">
            <table class="w-full text-left border-collapse text-sm text-zinc-800 dark:text-zinc-200">
                <thead class="bg-zinc-50 dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 font-medium">
                    <tr>
                        <th class="p-4 w-20">Código</th>
                        <th class="p-4">Nome da Cor</th>
                        <th class="p-4 w-32 text-center">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @foreach($colors as $color)
                    <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/50">
                        <td class="p-4 font-mono font-semibold text-zinc-600 dark:text-zinc-400">
                            {{ $color->code }}
                        </td>
                        <td class="p-4 flex items-center gap-3">
                            <span class="w-5 h-5 rounded-full border border-zinc-400 inline-block flex-shrink-0" style="background-color: #{{ $color->code }};"></span>
                            {{ $color->name }}
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <flux:button href="{{ route('admin.colors.edit', $color) }}" variant="subtle" icon="pencil" size="sm" />

                                <form action="{{ route('admin.colors.destroy', $color) }}" method="POST" onsubmit="return confirm('Tem a certeza que deseja remover esta cor?')">
                                    @csrf
                                    @method('DELETE')
                                    <flux:button type="submit" variant="subtle" icon="trash" size="sm" class="text-red-600 hover:text-red-700" />
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

</x-layouts::main-content>