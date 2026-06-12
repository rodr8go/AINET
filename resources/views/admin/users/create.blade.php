<x-layouts::main-content title="Criar Utilizador"
                         heading="Adicionar Novo Utilizador"
                         subheading="Crie contas para funcionários ou administradores da plataforma">

    <div class="max-w-2xl">
        @if($errors->any())
            <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-800">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <flux:card class="p-6">
           
            <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Dados Pessoais --}}
                <div class="space-y-4">
                    <h3 class="text-md font-semibold text-zinc-900 dark:text-white border-b pb-2">
                        Dados Pessoais
                    </h3>

                    <flux:input 
                        name="name" 
                        label="Nome Completo" 
                        placeholder="Ex: João Silva" 
                        value="{{ old('name') }}" 
                        required />

                    <flux:input 
                        name="email" 
                        label="Endereço de Email" 
                        type="email"
                        placeholder="exemplo@funshirt.com" 
                        value="{{ old('email') }}" 
                        required />

                    <div>
                        <flux:label class="mb-2 block">Género</flux:label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="gender" value="M" {{ old('gender') == 'M' ? 'checked' : '' }} required>
                                <span>Masculino</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="gender" value="F" {{ old('gender') == 'F' ? 'checked' : '' }} required>
                                <span>Feminino</span>
                            </label>
                        </div>
                        @error('gender')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <flux:label class="mb-2 block">Foto / Avatar (Opcional)</flux:label>
                        <input type="file" 
                               name="photo_file" 
                               accept="image/*" 
                               class="w-full text-sm text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 file:cursor-pointer hover:file:bg-blue-100" />
                        @error('photo_file')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Dados de Acesso --}}
                <div class="space-y-4">
                    <h3 class="text-md font-semibold text-zinc-900 dark:text-white border-b pb-2">
                        Dados de Acesso
                    </h3>

                    <div>
                        <flux:label class="mb-2 block">Tipo de Utilizador</flux:label>
                        <select name="user_type" 
                                class="w-full border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 rounded-lg p-2.5 text-sm"
                                required>
                            <option value="">-- Selecione --</option>
                            <option value="F" {{ old('user_type') == 'F' ? 'selected' : '' }}>Funcionário</option>
                            <option value="A" {{ old('user_type') == 'A' ? 'selected' : '' }}>Administrador</option>
                        </select>
                        @error('user_type')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-zinc-500 mt-1">
                            Funcionários podem processar encomendas. Administradores têm acesso total à gestão da plataforma.
                        </p>
                    </div>

                    <div class="bg-blue-50 dark:bg-blue-900/30 rounded-lg p-3">
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="text-sm text-blue-700 dark:text-blue-300">
                                <p class="font-medium">Informação sobre a Password</p>
                                <p class="mt-1">A password inicial será <strong>123</strong>. O utilizador deverá alterar a password após o primeiro acesso.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <flux:separator />

                <div class="flex items-center justify-end gap-2">
                    <flux:button href="{{ route('admin.users.index') }}" variant="ghost">
                        Cancelar
                    </flux:button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Criar Utilizador
                    </button>
                </div>

            </form>
        </flux:card>
    </div>

</x-layouts::main-content>