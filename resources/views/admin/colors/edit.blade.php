<x-layouts::main-content title="Editar Cor"
                         heading="Modificar Cor #{{ $color->code }}"
                         subheading="Altere as informações da cor selecionada">

    <flux:card class="max-w-xl p-6">
        <form action="{{ route('admin.colors.update', $color) }}" method="POST" class="space-y-6">
            @csrf
            @method('PATCH')

            <flux:input label="Código da Cor" value="{{ $color->code }}" disabled />

            <flux:input name="name" 
                        label="Nome da Cor" 
                        value="{{ old('name', $color->name) }}" 
                        required />

            <flux:separator />

            <div class="flex items-center gap-2 justify-end">
                <flux:button href="{{ route('admin.colors.index') }}" variant="ghost">Cancelar</flux:button>
                <flux:button type="submit" variant="filled" class="bg-blue-600 hover:bg-blue-700 text-white">Atualizar Cor</flux:button>
            </div>
        </form>
    </flux:card>

</x-layouts::main-content>