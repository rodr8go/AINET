<x-layouts::main-content title="Editar Cor"
                         heading="Modificar Cor #{{ $color->code }}"
                         subheading="Altere as informações da cor selecionada">

    <div class="flex gap-8 items-start max-w-3xl">
        <flux:card class="flex-1 p-6">
            <form action="{{ route('admin.colors.update', $color) }}" method="POST"
                  enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PATCH')

                <flux:input label="Código da Cor" value="{{ $color->code }}" disabled />

                <flux:input name="name"
                            label="Nome da Cor"
                            value="{{ old('name', $color->name) }}"
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
                    <p class="mt-1 text-xs text-zinc-400">Deixe em branco para manter a imagem atual.</p>
                    @error('tshirt_img') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <flux:separator />

                <div class="flex items-center gap-2 justify-end">
                    <flux:button href="{{ route('admin.colors.index') }}" variant="ghost">Cancelar</flux:button>
                    <flux:button type="submit" variant="filled" class="bg-blue-600 hover:bg-blue-700 text-white">Atualizar Cor</flux:button>
                </div>
            </form>
        </flux:card>

        <div class="shrink-0 w-48">
            <p class="text-xs font-bold uppercase tracking-wider text-zinc-400 mb-2">T-Shirt Base Atual</p>
            @if(file_exists(storage_path('app/public/tshirt_base/' . $color->code . '.jpg')))
                <img src="{{ asset('storage/tshirt_base/' . $color->code . '.jpg') }}"
                     alt="{{ $color->name }}"
                     class="w-full rounded-xl border border-zinc-700 bg-zinc-900 object-contain p-2">
            @else
                <div class="w-full h-48 rounded-xl border border-zinc-700 bg-zinc-900 flex items-center justify-center text-xs text-zinc-500">
                    Sem imagem associada
                </div>
            @endif
        </div>
    </div>

</x-layouts::main-content>