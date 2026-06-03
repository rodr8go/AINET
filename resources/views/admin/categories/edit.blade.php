<x-layouts::main-content title="Editar Categoria"
                         heading="Modificar Categoria"
                         subheading="Altere o nome da categoria selecionada">

    <flux:card class="max-w-xl p-6">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-6">
            @csrf
            @method('PATCH')

            <flux:input name="name" 
                        label="Nome da Categoria" 
                        value="{{ old('name', $category->name) }}" 
                        required />

            <flux:separator />

            <div class="flex items-center gap-2 justify-end">
                <flux:button href="{{ route('admin.categories.index') }}" variant="ghost">Cancelar</flux:button>
                <flux:button type="submit" variant="filled" class="bg-blue-600 hover:bg-blue-700 text-white">Atualizar Categoria</flux:button>
            </div>
        </form>
    </flux:card>

</x-layouts::main-content>