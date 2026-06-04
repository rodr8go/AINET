<x-layouts::main-content title="Management"
                         heading="Manage Customers"
                         subheading="Consulte, filtre, bloqueie ou remova contas de clientes da plataforma">

    <div class="space-y-6">
        
        <flux:card class="p-4">
            <form action="{{ request()->url() }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 items-end">
                <div>
                    <flux:input name="name" 
                                label="Customer Name" 
                                placeholder="Procurar por nome..." 
                                value="{{ request('name') }}" />
                </div>
                
                <div>
                    <flux:input name="nif" 
                                label="NIF" 
                                placeholder="Procurar por NIF..." 
                                value="{{ request('nif') }}" />
                </div>

                <div class="flex gap-2">
                    <flux:button type="submit" variant="filled" class="bg-blue-600 hover:bg-blue-700 text-white flex-1 cursor-pointer">
                        Filter
                    </flux:button>
                    @if(request()->anyFilled(['name', 'nif']))
                        <flux:button href="{{ request()->url() }}" variant="subtle" icon="x-mark" title="Limpar" />
                    @endif
                </div>
            </form>
        </flux:card>

        @if($customers->isEmpty())
            <flux:card class="p-6 text-center text-zinc-500">
                No customers found matching the criteria.
            </flux:card>
        @else
            <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden bg-white dark:bg-zinc-900">
                <table class="w-full text-left border-collapse text-sm text-zinc-800 dark:text-zinc-200">
                    <thead class="bg-zinc-50 dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 font-medium">
                        <tr>
                            <th class="p-4 w-16">ID</th>
                            <th class="p-4">Name</th>
                            <th class="p-4">Email</th>
                            <th class="p-4">NIF</th>
                            <th class="p-4 text-center">Status</th>
                            <th class="p-4 text-center w-32">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @foreach($customers as $customer)
                            <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/50">
                                <td class="p-4 font-mono text-zinc-500">#{{ $customer->id }}</td>
                                <td class="p-4 font-medium text-zinc-900 dark:text-white">
                                    {{ $customer->user->name ?? 'N/A' }}
                                </td>
                                <td class="p-4 text-zinc-600 dark:text-zinc-400">
                                    {{ $customer->user->email ?? 'N/A' }}
                                </td>
                                <td class="p-4 font-mono">
                                    {{ $customer->nif ?? '—' }}
                                </td>
                                <td class="p-4 text-center">
                                    @if($customer->user && $customer->user->blocked)
                                        <flux:badge size="sm" color="red" variant="subtle">Blocked</flux:badge>
                                    @else
                                        <flux:badge size="sm" color="green" variant="subtle">Active</flux:badge>
                                    @endif
                                </td>
                                <td class="p-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <form action="{{ route('admin.customers.toggle-block', $customer) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <flux:button type="submit" size="sm" variant="subtle" 
                                                         icon="{{ ($customer->user && $customer->user->blocked) ? 'lock-open' : 'lock-closed' }}" 
                                                         class="{{ ($customer->user && $customer->user->blocked) ? 'text-green-600' : 'text-amber-600' }}"
                                                         title="{{ ($customer->user && $customer->user->blocked) ? 'Unblock' : 'Block' }}" />
                                        </form>

                                        <flux:button href="{{ route('admin.customers.edit', $customer) }}" variant="subtle" icon="pencil" size="sm" />

                                        <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" onsubmit="return confirm('Apply soft delete to this customer?')">
                                            @csrf
                                            @method('DELETE')
                                            <flux:button type="submit" size="sm" variant="subtle" icon="trash" class="text-red-600 hover:text-red-700" title="Soft Delete" />
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $customers->links() }}
            </div>
        @endif
    </div>

</x-layouts::main-content>