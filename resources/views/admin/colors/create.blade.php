<x-layouts::main-content title="Criar Cor"
                         heading="Adicionar Nova Cor"
                         subheading="Insira os dados da nova cor para as t-shirts do catálogo">

    <flux:card class="max-w-xl p-6">
        <form action="{{ route('admin.colors.store') }}" method="POST"
              enctype="multipart/form-data" class="space-y-6">
            @csrf

            <flux:input name="code"
                        label="Código da Cor (Max 6 caracteres)"
                        placeholder="Ex: PT, FA, BR"
                        maxlength="6"
                        value="{{ old('code') }}"
                        required />

            <flux:input name="name"
                        label="Nome da Cor"
                        placeholder="Ex: Preto, Azul Fantasia, Branco"
                        value="{{ old('name') }}"
                        required />

            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                    Imagem da T-Shirt Base (.jpg)
                </label>
                <input type="file" name="tshirt_img" accept="image/jpeg"
                       class="block w-full text-sm text-zinc-500 dark:text-zinc-400
                              file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0
                              file:text-sm file:font-semibold
                              file:bg-indigo-50 file:text-indigo-700
                              hover:file:bg-indigo-100
                              dark:file:bg-zinc-700 dark:file:text-zinc-200">
                @error('tshirt_img') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <flux:separator />

            <div class="flex items-center gap-2 justify-end">
                <flux:button href="{{ route('admin.colors.index') }}" variant="ghost">Cancelar</flux:button>
                <flux:button type="submit" variant="filled" class="bg-blue-600 hover:bg-blue-700 text-white">Gravar Cor</flux:button>
            </div>
        </form>
    </flux:card>

</x-layouts::main-content>