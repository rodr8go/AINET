<x-layouts::main-content title="Editar Utilizador"
                         heading="Editar Utilizador: {{ $user->name }}"
                         subheading="Altere os dados do utilizador">

    <div class="max-w-2xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            
            @if(session('alert-msg'))
                <div class="mb-4 p-3 rounded {{ session('alert-type') == 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {!! session('alert-msg') !!}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Formulário de Atualização --}}
            <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                {{-- Dados Pessoais --}}
                <div class="space-y-4">
                    <h3 class="text-md font-semibold text-zinc-900 dark:text-white border-b pb-2">
                        Dados Pessoais
                    </h3>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Nome Completo</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                               class="w-full border border-zinc-300 dark:border-zinc-600 rounded-lg p-2 bg-white dark:bg-zinc-800" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                               class="w-full border border-zinc-300 dark:border-zinc-600 rounded-lg p-2 bg-white dark:bg-zinc-800" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Género</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="gender" value="M" {{ old('gender', $user->gender) == 'M' ? 'checked' : '' }}>
                                <span>Masculino</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="gender" value="F" {{ old('gender', $user->gender) == 'F' ? 'checked' : '' }}>
                                <span>Feminino</span>
                            </label>
                        </div>
                    </div>

                    {{-- Foto Atual --}}
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Foto Atual</label>
                        <div class="flex items-center gap-4">
                            @if($user->photo_url)
                                <img src="{{ asset('storage/photos/' . $user->photo_url) }}" alt="Avatar" class="w-16 h-16 rounded-full object-cover border">
                            @else
                                <div class="w-16 h-16 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-2xl font-bold">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Nova Foto --}}
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Nova Foto (Opcional)</label>
                        <input type="file" 
                               name="photo_file" 
                               accept="image/*" 
                               class="w-full text-sm text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 file:cursor-pointer hover:file:bg-blue-100">
                    </div>
                </div>

                {{-- Dados de Acesso --}}
                <div class="space-y-4 mt-6">
                    <h3 class="text-md font-semibold text-zinc-900 dark:text-white border-b pb-2">
                        Dados de Acesso
                    </h3>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Tipo de Utilizador</label>
                        <div class="p-2.5 bg-gray-100 dark:bg-gray-800 rounded-lg text-sm">
                            @if($user->isAdmin())
                                👑 Administrador
                            @elseif($user->isEmployee())
                                👨‍💻 Funcionário
                            @else
                                👤 Cliente
                            @endif
                        </div>
                        <p class="text-xs text-zinc-500 mt-1">O tipo de utilizador não pode ser alterado.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Estado da Conta</label>
                        <div class="flex items-center gap-4">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                {{ $user->blocked ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                {{ $user->blocked ? '🔴 Bloqueado' : '🟢 Ativo' }}
                            </span>
                        </div>
                        <p class="text-xs text-zinc-500 mt-1">
                            Para bloquear/desbloquear, utilize a lista de utilizadores.
                        </p>
                    </div>
                </div>

                {{-- Alterar Password --}}
                <div class="space-y-4 mt-6">
                    <h3 class="text-md font-semibold text-zinc-900 dark:text-white border-b pb-2">
                        Alterar Password
                    </h3>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Nova Password (deixar vazio para manter)</label>
                        <input type="password" name="password" class="w-full border border-zinc-300 dark:border-zinc-600 rounded-lg p-2 bg-white dark:bg-zinc-800">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Confirmar Nova Password</label>
                        <input type="password" name="password_confirmation" class="w-full border border-zinc-300 dark:border-zinc-600 rounded-lg p-2 bg-white dark:bg-zinc-800">
                    </div>
                </div>

                {{-- Botões --}}
                <div class="border-t pt-4 mt-6 flex items-center justify-end gap-2">
                    <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-100">
                        Cancelar
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Atualizar Utilizador
                    </button>
                </div>
            </form>

            {{-- Formulário de Eliminar (fora do form principal) --}}
            @if(auth()->id() !== $user->id)
                <div class="border-t pt-4 mt-6">
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Tem a certeza que deseja eliminar este utilizador?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Eliminar Utilizador
                        </button>
                    </form>
                </div>
            @endif

        </div>
    </div>

</x-layouts::main-content>