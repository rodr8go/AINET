<x-layouts::main-content title="Gestão do Catálogo"
                         heading="Imagens do Catálogo"
                         subheading="Gerite as estampas oficiais que os clientes podem escolher para personalizar t-shirts">

    <div class="space-y-6">
        <div class="flex justify-end">
            <flux:button href="{{ route('catalog-images.create') }}" variant="filled" icon="plus" class="bg-blue-600 hover:bg-blue-700 text-white cursor-pointer">
                Adicionar Nova Estampa
            </flux:button>
        </div>

        @if($images->isEmpty())
            <flux:card class="p-6 text-center text-zinc-500 dark:text-zinc-400">
                Não existem imagens públicas no catálogo de momento.
            </flux:card>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($images as $img)
                    <flux:card class="p-4 flex flex-col justify-between space-y-4">
                        <div class="flex flex-col space-y-2">
                            <div class="w-full h-48 bg-zinc-100 dark:bg-zinc-800 rounded-lg flex items-center justify-center overflow-hidden border border-zinc-200 dark:border-zinc-700">
                                @if($img->image_url)
                                    <img src="{{ asset('storage/tshirt_images/' . $img->image_url) }}" alt="{{ $img->name }}" class="object-contain max-h-full w-full">
                                @else
                                    <flux:icon name="photo" class="text-zinc-400 w-12 h-12" />
                                @endif
                            </div>
                            <flux:heading size="lg" class="truncate">{{ $img->name }}</flux:heading>
                            <flux:badge size="sm" variant="subtle" class="w-max">
                                {{ $img->category->name ?? 'Sem Categoria' }}
                            </flux:badge>
                            <flux:text size="sm" class="line-clamp-2 min-h-[2.5rem]">{{ $img->description ?? 'Sem descrição disponível.' }}</flux:text>
                        </div>

                        <flux:separator />

                        <div class="flex items-center justify-end gap-2">
                            <flux:button href="{{ route('catalog-images.edit', $img) }}" variant="subtle" icon="pencil" size="sm" />
                            
                            <form action="{{ route('catalog-images.destroy', $img) }}" method="POST" onsubmit="return confirm('Tens a certeza que desejas remover esta imagem do catálogo?')">
                                @csrf
                                @method('DELETE')
                                <flux:button type="submit" variant="subtle" icon="trash" size="sm" class="text-red-600 hover:text-red-700" />
                            </form>
                        </div>
                    </flux:card>
                @endforeach
            </div>
        @endif
    </div>

</x-layouts::main-content>