<flux:sidebar sticky stashable class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
    <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

    <a href="{{ route('home') }}" class="flex items-center gap-2 px-4 py-2">
        <span class="text-xl font-bold text-indigo-600 dark:text-indigo-400">👕 FunShirt</span>
    </a>

    <flux:navlist variant="outline">
        <flux:navlist.item icon="home" href="{{ route('home') }}">Início</flux:navlist.item>
        <flux:navlist.item icon="layout-grid" href="{{ route('catalog.index') }}">Catálogo</flux:navlist.item>

        @auth
            @if(Auth::user()->user_type === 'C')
                <flux:navlist.group heading="Área do Cliente">
                    <flux:navlist.item icon="shopping-bag" href="{{ route('client.orders.index') }}">Minhas Encomendas</flux:navlist.item>
                    <flux:navlist.item icon="image" href="{{ route('client.images.index') }}">Meus Designs</flux:navlist.item>
                </flux:navlist.group>
            @endif

            @if(Auth::user()->user_type === 'F')
                <flux:navlist.group heading="Logística">
                    <flux:navlist.item icon="inbox" href="{{ route('employee.orders.pending') }}">Encomendas Pendentes</flux:navlist.item>
                </flux:navlist.group>
            @endif

            @if(Auth::user()->user_type === 'A')
                <flux:navlist.group heading="Gestão da Loja">
                    <flux:navlist.item icon="chart-bar" href="{{ route('admin.dashboard') }}">Estatísticas</flux:navlist.item>
                    <flux:navlist.item icon="users" href="{{ route('admin.users.index') }}">Utilizadores</flux:navlist.item>
                </flux:navlist.group>
            @endif
        @endauth
    </flux:navlist>

    <flux:spacer />
</flux:sidebar>