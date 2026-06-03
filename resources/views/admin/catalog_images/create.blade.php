<x-layouts::main-content title="Adicionar Imagem"
                         heading="Enviar Nova Estampa"
                         subheading="Faça o upload de um ficheiro de imagem e associe-o a uma categoria do catálogo">

    <flux:card class="max-w-xl p-6">
        <form action="{{ route('catalog-images.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <flux:input name="name" label="Nome da Imagem" placeholder="Ex: Logótipo Gaming, Caveira Vintage" required />

            <div>
                <flux:label class="mb-2 block">Categoria</flux:label>
                <select name="category_id" class="w-full border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 rounded-lg p-2.5 text-sm">
                    <option value="">-- Escolha uma Categoria (Opcional) --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <flux:textarea name="description" label="Descrição da Estampa" placeholder="Escreva uma breve descrição ou palavras-chave para pesquisa..." rows="3" />

            <div>
                <flux:label class="mb-2 block">Ficheiro de Imagem</flux:label>
                <input type="file" name="image_file" accept="image/*" class="w-full text-sm text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 file:cursor-pointer hover:file:bg-blue-100" required />
            </div>

            <flux:separator />

            <div class="flex items-center gap-2 justify-end">
                <flux:button href="{{ route('catalog-images.index') }}" variant="ghost">Cancelar</flux:button>
                <flux:button type="submit" variant="filled" class="bg-blue-600 hover:bg-blue-700 text-white">Adicionar ao Catálogo</flux:button>
            </div>
        </form>
    </flux:card>

</x-layouts::main-content>