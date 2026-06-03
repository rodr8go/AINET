<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('home') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            {{-- Public Menu Items --}}
            <flux:navlist.item icon="home" href="{{ route('home') }}">Início</flux:navlist.item>
            <flux:navlist.item icon="layout-grid" href="{{ route('catalog.index') }}">Catálogo</flux:navlist.item>

            {{-- Shopping Cart with Badge --}}
            @can('use-cart')
                @if(count(session('cart', [])) > 0)
                    <flux:navlist.item 
                        icon="shopping-cart" 
                        icon:variant="solid" 
                        :href="route('cart.show')" 
                        :current="request()->routeIs('cart.show')" 
                        wire:navigate
                    >
                        <div class="flex items-center justify-between w-full">
                            <span>Shopping Cart</span>
                            <span class="ml-2 flex h-5 min-w-5 items-center justify-center rounded-full bg-red-500 px-1 text-xs font-bold text-white shadow-sm">
                                {{ count(session('cart', [])) }}
                            </span>
                        </div>
                    </flux:navlist.item>
                @endif
            @endcan

            {{-- ===== CUSTOMER MENU SECTION ===== --}}
            @auth
                @can('use-cart')
                    <flux:sidebar.nav>
                        <flux:sidebar.group heading="My Account" class="grid">
                            {{-- My Custom Images --}}
                            <flux:sidebar.item 
                                icon="photo" 
                                :href="route('my-images.index')" 
                                :current="request()->routeIs('my-images.*')" 
                                wire:navigate>
                                My Custom Images
                            </flux:sidebar.item>
                            
                            {{-- My Orders --}}
                            <flux:sidebar.item 
                                icon="shopping-bag" 
                                :href="route('orders.my')" 
                                :current="request()->routeIs('orders.my')" 
                                wire:navigate>
                                My Orders
                            </flux:sidebar.item>
                        </flux:sidebar.group>
                    </flux:sidebar.nav>
                @endcan
            @endauth

            {{-- Admin Dashboard Link --}}
            @can('admin')
                <flux:sidebar.nav>
                    <flux:sidebar.group heading="Platform" class="grid">
                        <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                            Dashboard
                        </flux:sidebar.item>
                    </flux:sidebar.group>
                </flux:sidebar.nav>
            @endcan

            {{-- Admin Management Section --}}
            @can('admin')
                <flux:sidebar.nav>
                    <flux:sidebar.group heading="Management" class="grid">
                        <flux:sidebar.item icon="users" :href="route('users.index')" wire:navigate>
                            Manage Users
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="shopping-bag" :href="route('customers.index')" wire:navigate>
                            Manage Customers
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="photo" :href="route('catalog-images.index')" wire:navigate>
                            Catalog Images
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="tag" :href="route('categories.index')" wire:navigate>
    Categories
</flux:sidebar.item>
                        <flux:sidebar.item icon="swatch" :href="route('colors.index')" wire:navigate>
                            Colors
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="currency-euro" :href="route('prices.edit')" wire:navigate>
                            Price Settings
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="chart-bar" :href="route('statistics.index')" wire:navigate>
                            Statistics
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="truck" :href="route('admin.orders.index')" wire:navigate>
                            All Orders
                        </flux:sidebar.item>
                    </flux:sidebar.group>
                </flux:sidebar.nav>
            @endcan

            <flux:spacer />

            @auth
                <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
            @else
                <flux:sidebar.item icon="user" :href="route('login')" :current="request()->routeIs('login')" wire:navigate>
                    Login
                </flux:sidebar.item>
            @endauth
        </flux:sidebar>

        {{-- Mobile User Menu --}}
        @auth
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
            <flux:spacer />
            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    :avatar="auth()->user()->photo_url ? auth()->user()->photo_full_url : null"
                    icon-trailing="chevron-down"
                />
                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                    :src="auth()->user()->photo_url ? auth()->user()->photo_full_url : null"
                                />
                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    {{-- Mobile Customer Menu Items --}}
                    @can('use-cart')
                        <flux:menu.radio.group>
                            <flux:menu.item :href="route('my-images.index')" icon="photo" wire:navigate>
                                My Custom Images
                            </flux:menu.item>
                            <flux:menu.item :href="route('orders.my')" icon="shopping-bag" wire:navigate>
                                My Orders
                            </flux:menu.item>
                        </flux:menu.radio.group>
                        <flux:menu.separator />
                    @endcan

                    {{-- Employee Mobile Items --}}
                    @can('employee')
                        <flux:menu.radio.group>
                            <flux:menu.item :href="route('employee.orders.pending')" icon="truck" wire:navigate>
                                Pending Orders
                            </flux:menu.item>
                        </flux:menu.radio.group>
                        <flux:menu.separator />
                    @endcan

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            Settings
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            Log out
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>
        @else
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
            <flux:spacer />
            <flux:sidebar.item position="top" align="end" icon="user" :href="route('login')" :current="request()->routeIs('login')" wire:navigate>
                Login
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