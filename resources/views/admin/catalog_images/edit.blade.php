<x-layouts::main-content title="Editar Imagem"
                         heading="Modificar Estampa #{{ $image->id }}"
                         subheading="Altere os dados ou substitua o ficheiro gráfico da estampa">

    <flux:card class="max-w-xl p-6">
<form action="{{ route('catalog-images.update', $image) }}" method="POST" enctype="multipart/form-data" class="space-y-6">            @csrf
            @method('PUT')

            <flux:input name="name" label="Nome da Imagem" value="{{ old('name', $image->name) }}" required />

            <div>
                <flux:label class="mb-2 block">Categoria</flux:label>
                <select name="category_id" class="w-full border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 rounded-lg p-2.5 text-sm">
                    <option value="">-- Sem Categoria --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $image->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <flux:textarea name="description" label="Descrição" rows="3">{{ old('description', $image->description) }}</flux:textarea>

            <div class="space-y-2">
                <flux:label>Imagem Atual</flux:label>
                <div class="w-32 h-32 bg-zinc-100 dark:bg-zinc-800 rounded-lg overflow-hidden border border-zinc-200 flex items-center justify-center p-2">
                    <img src="{{ asset('storage/t_shirt_images/' . $image->image_url) }}" alt="Atual" class="object-contain max-h-full">
                </div>
            </div>

            <div>
                <flux:label class="mb-2 block">Substituir Ficheiro (Deixar vazio para manter a atual)</flux:label>
                <input type="file" name="image_file" accept="image/*" class="w-full text-sm text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 file:cursor-pointer hover:file:bg-blue-100" />
            </div>

            <flux:separator />

            <div class="flex items-center gap-2 justify-end">
                <flux:button href="{{ route('catalog-images.index') }}" variant="ghost">Cancelar</flux:button>
                <flux:button type="submit" variant="filled" class="bg-blue-600 hover:bg-blue-700 text-white">Atualizar Estampa</flux:button>
            </div>
        </form>
    </flux:card>

</x-layouts::main-content>