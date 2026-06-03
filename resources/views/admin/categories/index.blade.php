<x-layouts::main-content title="Gestão de Categorias"
                         heading="Categorias do Catálogo"
                         subheading="Gerite as categorias disponíveis para organizar as imagens das t-shirts">

    <div class="space-y-6">
        <div class="flex justify-end">
            <flux:button href="{{ route('admin.categories.create') }}" variant="filled" icon="plus" class="bg-blue-600 hover:bg-blue-700 text-white cursor-pointer">
                Adicionar Nova Categoria
            </flux:button>
        </div>

        @if($categories->isEmpty())
            <flux:card class="p-6 text-center text-zinc-500 dark:text-zinc-400">
                Não existem categorias registadas no sistema.
            </flux:card>
        @else
            <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden bg-white dark:bg-zinc-900">
                <table class="w-full text-left border-collapse text-sm text-zinc-800 dark:text-zinc-200">
                    <thead class="bg-zinc-50 dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 font-medium">
                        <tr>
                            <th class="p-4 w-20">ID</th>
                            <th class="p-4">Nome da Categoria</th>
                            <th class="p-4 w-32 text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @foreach($categories as $category)
                            <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/50">
                                <td class="p-4 font-mono text-zinc-500">#{{ $category->id }}</td>
                                <td class="p-4 font-medium text-zinc-900 dark:text-white">{{ $category->name }}</td>
                                <td class="p-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <flux:button href="{{ route('admin.categories.edit', $category) }}" variant="subtle" icon="pencil" size="sm" />

                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Tem a certeza que deseja remover esta categoria?')">
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