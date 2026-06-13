<x-layouts::main-content title="Meu Perfil"
                         heading="Perfil de Utilizador"
                         subheading="Gerencie os seus dados pessoais e definições de conta">

    <div class="max-w-3xl">
        <div class="space-y-6">
            
            {{-- Mensagens de sucesso/erro --}}
            @if(session('success'))
                <div class="bg-green-100 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg p-4 text-green-800 dark:text-green-300">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Formulário de Perfil --}}
            <flux:card class="p-6">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    {{-- Dados Pessoais --}}
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white border-b pb-2 border-zinc-200 dark:border-zinc-700">
                            Dados Pessoais
                        </h3>

                        {{-- Nome --}}
                        <flux:input 
                            name="name" 
                            label="Nome Completo" 
                            value="{{ old('name', $user->name) }}" 
                            required />

                        {{-- Email --}}
                        <flux:input 
                            name="email" 
                            label="Email" 
                            type="email" 
                            value="{{ old('email', $user->email) }}" 
                            required />

                        {{-- Género --}}
                        <div>
                            <flux:label class="mb-2 block">Género</flux:label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="gender" value="M" {{ old('gender', $user->gender) == 'M' ? 'checked' : '' }} required>
                                    <span>Masculino</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="gender" value="F" {{ old('gender', $user->gender) == 'F' ? 'checked' : '' }} required>
                                    <span>Feminino</span>
                                </label>
                            </div>
                            @error('gender')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Foto / Avatar --}}
                        <div>
                            <flux:label class="mb-2 block">Foto de Perfil</flux:label>
                            
                            <div class="flex items-center gap-4 mb-3">
                                @if($user->photo_url)
                                    <img src="{{ $user->photo_full_url }}" alt="Avatar" class="w-20 h-20 rounded-full object-cover border-2 border-indigo-500">
                                @else
                                    <div class="w-20 h-20 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-3xl font-bold text-gray-500">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                @endif
                            </div>

                            <input type="file" 
                                   name="photo" 
                                   accept="image/*" 
                                   class="w-full text-sm text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 file:cursor-pointer hover:file:bg-blue-100" />
                            @error('photo')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                            <flux:text size="sm" class="mt-1 text-zinc-500">
                                Formatos aceites: JPG, PNG. Tamanho máximo: 2MB.
                            </flux:text>
                        </div>
                    </div>

                    {{-- Dados do Cliente (apenas para clientes) --}}
                    @if($user->isCustomer())
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white border-b pb-2 border-zinc-200 dark:border-zinc-700">
                                Dados de Faturação e Envio
                            </h3>

                            {{-- NIF --}}
                            <flux:input 
                                name="nif" 
                                label="NIF (Número de Identificação Fiscal)" 
                                placeholder="Ex: 123456789" 
                                value="{{ old('nif', $customer->nif ?? '') }}" 
                                maxlength="9" />

                            {{-- Morada --}}
                            <flux:textarea 
                                name="address" 
                                label="Morada de Envio" 
                                placeholder="Rua, Número, Cidade, Código-Postal" 
                                rows="3">{{ old('address', $customer->address ?? '') }}</flux:textarea>

                            {{-- Método de Pagamento Preferencial --}}
                            <div>
                                <flux:label class="mb-2 block">Método de Pagamento Preferencial</flux:label>
                                <select name="default_payment_type" 
                                        class="w-full border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 rounded-lg p-2.5 text-sm">
                                    <option value="">-- Selecione --</option>
                                    <option value="Visa" {{ old('default_payment_type', $customer->default_payment_type ?? '') == 'Visa' ? 'selected' : '' }}>Visa</option>
                                    <option value="PayPal" {{ old('default_payment_type', $customer->default_payment_type ?? '') == 'PayPal' ? 'selected' : '' }}>PayPal</option>
                                    <option value="MB WAY" {{ old('default_payment_type', $customer->default_payment_type ?? '') == 'MB WAY' ? 'selected' : '' }}>MB WAY</option>
                                </select>
                            </div>

                            {{-- Referência de Pagamento Preferencial --}}
                            <flux:input 
                                name="default_payment_ref" 
                                label="Referência de Pagamento" 
                                placeholder="Ex: 1234567890123456 (Visa) / email@exemplo.com (PayPal) / 912345678 (MB WAY)" 
                                value="{{ old('default_payment_ref', $customer->default_payment_ref ?? '') }}" />
                        </div>
                    @endif

                    {{-- Botões --}}
                    <flux:separator />

                    <div class="flex items-center justify-end gap-2">
                        <flux:button href="{{ route('home') }}" variant="ghost">
                            Cancelar
                        </flux:button>
                        <flux:button type="submit" variant="filled" class="bg-blue-600 hover:bg-blue-700 text-white">
                            Guardar Alterações
                        </flux:button>
                    </div>

                </form>
            </flux:card>

            {{-- Separador para alteração de password --}}
            <flux:card class="p-6">
                <form action="{{ route('profile.password') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white border-b pb-2 border-zinc-200 dark:border-zinc-700">
                        Alterar Password
                    </h3>

                    {{-- Password atual --}}
                    <flux:input 
                        name="current_password" 
                        label="Password Atual" 
                        type="password" 
                        required />

                    {{-- Nova password --}}
                    <flux:input 
                        name="password" 
                        label="Nova Password" 
                        type="password" 
                        required />

                    {{-- Confirmar nova password --}}
                    <flux:input 
                        name="password_confirmation" 
                        label="Confirmar Nova Password" 
                        type="password" 
                        required />

                    <div class="flex justify-end">
                        <flux:button type="submit" variant="filled" class="bg-blue-600 hover:bg-blue-700 text-white">
                            Alterar Password
                        </flux:button>
                    </div>

                </form>
            </flux:card>

        </div>
    </div>

</x-layouts::main-content>