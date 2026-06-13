<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <flux:sidebar sticky collapsible="mobile"
        class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.header>
            <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-2 px-1 py-2">
    <span class="text-2xl font-black tracking-tight text-white">Fun<span class="text-indigo-400">Shirt</span></span>
</a>
            <flux:sidebar.collapse class="lg:hidden" />
        </flux:sidebar.header>

        {{-- MENU PÚBLICO --}}
        <flux:navlist.item icon="home" href="{{ route('home') }}">Início</flux:navlist.item>
        <flux:navlist.item icon="layout-grid" href="{{ route('catalog.index') }}">Catálogo</flux:navlist.item>

        {{-- Shopping Cart --}}
        @can('use-cart')
            @if(count(session('cart', [])) > 0)
                <flux:navlist.item icon="shopping-cart" icon:variant="solid" :href="route('cart.show')"
                    :current="request()->routeIs('cart.show')" wire:navigate>
                    <div class="flex items-center justify-between w-full">
                        <span>Shopping Cart</span>
                        <span class="ml-2 flex h-5 min-w-5 items-center justify-center rounded-full bg-red-500 px-1 text-xs font-bold text-white shadow-sm">
                            {{ count(session('cart', [])) }}
                        </span>
                    </div>
                </flux:navlist.item>
            @else
                <flux:navlist.item icon="shopping-cart" :href="route('cart.show')"
                    :current="request()->routeIs('cart.show')" wire:navigate>
                    Shopping Cart
                </flux:navlist.item>
            @endif
        @endcan

        {{-- MENU DO CLIENTE --}}
        @auth
            @if(auth()->user()->isCustomer())
                <flux:sidebar.nav>
                    <flux:sidebar.group heading="Minha Conta" class="grid">
                        <flux:sidebar.item icon="photo" :href="route('my-images.index')"
                            :current="request()->routeIs('my-images.*')" wire:navigate>
                            As Minhas Imagens
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="shopping-bag" :href="route('orders.my')"
                            :current="request()->routeIs('orders.my')" wire:navigate>
                            As Minhas Encomendas
                        </flux:sidebar.item>
                    </flux:sidebar.group>
                </flux:sidebar.nav>
            @endif
        @endauth

        {{-- MENU DO FUNCIONÁRIO --}}
        @can('employee')
            <flux:sidebar.nav>
                <flux:sidebar.group heading="Área de Funcionário" class="grid">
                    <flux:sidebar.item icon="truck" :href="route('employee.orders.pending')"
                        :current="request()->routeIs('employee.orders.pending')" wire:navigate>
                        Encomendas Pendentes
                    </flux:sidebar.item>
                </flux:sidebar.group>
            </flux:sidebar.nav>
        @endcan

        {{-- MENU DO ADMIN --}}
        @can('admin')
            <flux:sidebar.nav>
                <flux:sidebar.group heading="Encomendas" class="grid">
                    <flux:sidebar.item icon="truck" :href="route('admin.orders.pending')"
                        :current="request()->routeIs('admin.orders.pending')" wire:navigate>
                        Encomendas Pendentes
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="queue-list" :href="route('admin.orders.index')"
                        :current="request()->routeIs('admin.orders.index')" wire:navigate>
                        Todas as Encomendas
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="chart-bar" :href="route('statistics.index')"
                        :current="request()->routeIs('statistics.index')" wire:navigate>
                        Estatísticas
                    </flux:sidebar.item>
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:sidebar.nav>
                <flux:sidebar.group heading="Gestão de Utilizadores" class="grid">
                    <flux:sidebar.item icon="user-group" href="{{ route('admin.users.index') }}"
                        :current="request()->routeIs('admin.users.*')">
                        Gerir Utilizadores
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="users" href="{{ route('admin.customers.index') }}"
                        :current="request()->routeIs('admin.customers.*')">
                        Gerir Clientes
                    </flux:sidebar.item>
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:sidebar.nav>
                <flux:sidebar.group heading="Catálogo" class="grid">
                    <flux:sidebar.item icon="photo" :href="route('catalog-images.index')"
                        :current="request()->routeIs('catalog-images.*')" wire:navigate>
                        Imagens do Catálogo
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="tag" :href="route('admin.categories.index')"
                        :current="request()->routeIs('admin.categories.*')" wire:navigate>
                        Categorias
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="swatch" :href="route('admin.colors.index')"
                        :current="request()->routeIs('admin.colors.*')" wire:navigate>
                        Cores
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="currency-euro" :href="route('prices.edit')"
                        :current="request()->routeIs('prices.edit')" wire:navigate>
                        Preços
                    </flux:sidebar.item>
                </flux:sidebar.group>
            </flux:sidebar.nav>
        @endcan

        <flux:spacer />

        @auth
            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
        @else
            <flux:sidebar.item icon="user" :href="route('login')"
                :current="request()->routeIs('login')" wire:navigate>
                Iniciar Sessão
            </flux:sidebar.item>
        @endauth
    </flux:sidebar>

    {{-- MENU MOBILE --}}
    @auth
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
            <flux:spacer />
            <flux:dropdown position="top" align="end">
                <flux:profile :initials="auth()->user()->initials()"
                    :avatar="auth()->user()->photo_url ? auth()->user()->photo_full_url : null"
                    icon-trailing="chevron-down" />
                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar :name="auth()->user()->name" :initials="auth()->user()->initials()"
                                    :src="auth()->user()->photo_url ? auth()->user()->photo_full_url : null" />
                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    @if(auth()->user()->isCustomer())
                        <flux:menu.radio.group>
                            <flux:menu.item :href="route('my-images.index')" icon="photo" wire:navigate>
                                As Minhas Imagens
                            </flux:menu.item>
                            <flux:menu.item :href="route('orders.my')" icon="shopping-bag" wire:navigate>
                                As Minhas Encomendas
                            </flux:menu.item>
                        </flux:menu.radio.group>
                        <flux:menu.separator />
                    @endif

                    @can('employee')
                        <flux:menu.radio.group>
                            <flux:menu.item :href="route('employee.orders.pending')" icon="truck" wire:navigate>
                                Encomendas Pendentes
                            </flux:menu.item>
                        </flux:menu.radio.group>
                        <flux:menu.separator />
                    @endcan

                    @can('admin')
                        <flux:menu.radio.group>
                            <flux:menu.item :href="route('admin.orders.pending')" icon="truck" wire:navigate>
                                Encomendas Pendentes
                            </flux:menu.item>
                            <flux:menu.item :href="route('admin.orders.index')" icon="queue-list" wire:navigate>
                                Todas as Encomendas
                            </flux:menu.item>
                            <flux:menu.item :href="route('statistics.index')" icon="chart-bar" wire:navigate>
                                Estatísticas
                            </flux:menu.item>
                            <flux:menu.item :href="route('admin.users.index')" icon="user-group" wire:navigate>
                                Gerir Utilizadores
                            </flux:menu.item>
                            <flux:menu.item :href="route('admin.customers.index')" icon="users" wire:navigate>
                                Gerir Clientes
                            </flux:menu.item>
                            <flux:menu.item :href="route('catalog-images.index')" icon="photo" wire:navigate>
                                Imagens do Catálogo
                            </flux:menu.item>
                        </flux:menu.radio.group>
                        <flux:menu.separator />
                    @endcan

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            Configurações
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer" data-test="logout-button">
                            Terminar Sessão
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>
    @else
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
            <flux:spacer />
            <flux:sidebar.item position="top" align="end" icon="user" :href="route('login')"
                :current="request()->routeIs('login')" wire:navigate>
                Iniciar Sessão
            </flux:sidebar.item>
        </flux:header>
    @endauth

    {{ $slot }}

    @persist('toast')
    <flux:toast.group>
        <flux:toast />
    </flux:toast.group>
    @endpersist

    @fluxScripts
</body>

</html>