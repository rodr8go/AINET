<x-layouts::main-content title="Upload Image"
                         heading="Enviar Nova Imagem"
                         subheading="Adicione uma estampa personalizada à sua coleção">

    <div class="py-6 mx-auto max-w-3xl sm:px-6 lg:px-8">
        
        <div class="bg-white rounded-xl border shadow-sm dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700 p-6">
            
            {{-- ⚠️ CRITICAL: enctype="multipart/form-data" é obrigatório para enviar ficheiros! --}}
            <form action="{{ route('my-images.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Campo do Nome da Estampa --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Nome da Imagem</label>
                    <input type="text" name="name" id="name" required 
                           class="mt-1 block w-full rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 px-3 py-2 text-zinc-900 dark:text-zinc-100 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                           placeholder="Ex: Logótipo do meu curso, Caveira Rock, etc.">
                    @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Campo do Upload de Ficheiro --}}
                <div>
                    <label for="image_file" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Ficheiro de Imagem (.png ou .jpg)</label>
                    <input type="file" name="image_file" id="image_file" required accept="image/*"
                           class="mt-1 block w-full text-sm text-zinc-500 dark:text-zinc-400
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-lg file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-indigo-50 file:text-indigo-700
                                  hover:file:bg-indigo-100
                                  dark:file:bg-zinc-700 dark:file:text-zinc-200">
                    @error('image_file') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Botões de Ação --}}
                <div class="flex items-center justify-end gap-3 border-t border-zinc-100 dark:border-zinc-700 pt-4">
                    <flux:button href="{{ route('my-images.index') }}" variant="ghost">
                        Cancelar
                    </flux:button>
                    <flux:button type="submit" variant="filled" color="indigo" icon="cloud-arrow-up">
                        Guardar e Enviar
                    </flux:button>
                </div>

            </form>
        </div>
    </div>

</x-layouts::main-content>