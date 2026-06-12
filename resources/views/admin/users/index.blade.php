<x-layouts::main-content title="Management"
    heading="Manage Users"
    subheading="Faça a gestão de administradores e funcionários (criar, alterar, bloquear ou remover)">

    <div class="space-y-6">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <flux:card class="p-4 flex-1">
                <form action="{{ request()->url() }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
                    <div>
                        <flux:input name="name"
                            label="Name"
                            placeholder="Procurar por nome..."
                            value="{{ request('name') }}" />
                    </div>

                    <div>
                        <flux:label class="mb-2 block text-sm">Role (Type)</flux:label>
                        <select name="type" class="w-full border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 rounded-lg p-2.5 text-sm text-zinc-800 dark:text-zinc-200">
                            <option value="">-- All Roles --</option>
                            <option value="A" {{ request('type') == 'A' ? 'selected' : '' }}>Administrator</option>
                            <option value="F" {{ request('type') == 'F' ? 'selected' : '' }}>Employee</option>
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <flux:button type="submit" variant="filled" class="bg-blue-600 hover:bg-blue-700 text-white flex-1 cursor-pointer">
                            Filter
                        </flux:button>
                        @if(request()->anyFilled(['name', 'type']))
                        <flux:button href="{{ request()->url() }}" variant="subtle" icon="x-mark" />
                        @endif
                    </div>
                </form>
            </flux:card>

            <div>
                <flux:button href="{{ route('admin.users.create') }}" variant="filled" class="bg-green-600 hover:bg-green-700 text-white w-full md:w-auto h-[48px]" icon="user-plus">
                    Add New User
                </flux:button>
            </div>
        </div>

        @if($users->isEmpty())
        <flux:card class="p-6 text-center text-zinc-500">
            No administrative users found.
        </flux:card>
        @else
        <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden bg-white dark:bg-zinc-900">
            <table class="w-full text-left border-collapse text-sm text-zinc-800 dark:text-zinc-200">
                <thead class="bg-zinc-50 dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 font-medium">
                    <tr>
                        <th class="p-4 w-16">ID</th>
                        <th class="p-4">Name</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Role</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-center w-32">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @foreach($users as $user)
                    <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/50">
                        <td class="p-4 font-mono text-zinc-500">#{{ $user->id }}</td>
                        <td class="p-4 font-medium text-zinc-900 dark:text-white flex items-center gap-3">
                            @if($user->photo_url)
                            <img src="{{ asset('storage/photos/' . $user->photo_url) }}" class="w-8 h-8 rounded-full object-cover border">
                            @else
                            <div class="w-8 h-8 rounded-full bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center text-xs font-bold">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                            @endif
                            {{ $user->name }}
                        </td>
                        <td class="p-4 text-zinc-600 dark:text-zinc-400">{{ $user->email }}</td>
                        <td class="p-4">
                            @if($user->user_type == 'A')
                            <flux:badge size="sm" color="purple" variant="solid">Admin</flux:badge>
                            @else
                            <flux:badge size="sm" color="blue" variant="subtle">Employee</flux:badge>
                            @endif
                        </td>

                        <td class="p-4 text-center">
                            @if($user->blocked)
                            <flux:badge size="sm" color="red" variant="subtle">Blocked</flux:badge>
                            @else
                            <flux:badge size="sm" color="green" variant="subtle">Active</flux:badge>
                            @endif
                        </td>

                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-2">

                                <form action="{{ route('admin.users.toggle-block', $user) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <flux:button type="submit" size="sm" variant="subtle"
                                        icon="{{ $user->blocked ? 'lock-open' : 'lock-closed' }}"
                                        class="{{ $user->blocked ? 'text-green-600' : 'text-amber-600' }}"
                                        title="{{ $user->blocked ? 'Unblock User' : 'Block User' }}" />
                                </form>

                                <flux:button href="{{ route('admin.users.edit', $user) }}" variant="subtle" icon="pencil" size="sm" />

                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Deseja mesmo remover este utilizador?')">
                                    @csrf
                                    @method('DELETE')
                                    <flux:button type="submit" size="sm" variant="subtle" icon="trash" class="text-red-600 hover:text-red-700" title="Delete User" />
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
        @endif
    </div>

</x-layouts::main-content>