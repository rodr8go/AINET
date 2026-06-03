<x-layouts::main-content title="Criar Categoria"
                         heading="Nova Categoria"
                         subheading="Insira o nome da nova categoria para o catálogo">

    <flux:card class="max-w-xl p-6">
        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6">
            @csrf

            <flux:input name="name" 
                        label="Nome da Categoria" 
                        placeholder="Ex: Desporto, Cinema, Humor" 
                        value="{{ old('name') }}" 
                        required />

            <flux:separator />

            <div class="flex items-center gap-2 justify-end">
                <flux:button href="{{ route('admin.categories.index') }}" variant="ghost">Cancelar</flux:button>
                <flux:button type="submit" variant="filled" class="bg-blue-600 hover:bg-blue-700 text-white">Gravar Categoria</flux:button>
            </div>
        </form>
    </flux:card>

</x-layouts::main-content>