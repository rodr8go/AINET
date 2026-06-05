<x-layouts::main-content title="Criar Cor"
                         heading="Adicionar Nova Cor"
                         subheading="Insira os dados da nova cor para as t-shirts do catálogo">

    <flux:card class="max-w-xl p-6">
        <form action="{{ route('admin.colors.store') }}" method="POST" class="space-y-6">
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

            <flux:separator />

            <div class="flex items-center gap-2 justify-end">
                <flux:button href="{{ route('admin.colors.index') }}" variant="ghost">Cancelar</flux:button>
                <flux:button type="submit" variant="filled" class="bg-blue-600 hover:bg-blue-700 text-white">Gravar Cor</flux:button>
            </div>
        </form>
    </flux:card>

</x-layouts::main-content>