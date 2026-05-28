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

            <flux:navlist.item icon="home" href="{{ route('home') }}">Início</flux:navlist.item>
            <flux:navlist.item icon="layout-grid" href="{{ route('catalog.index') }}">Catálogo</flux:navlist.item>

            @can('use-cart')
                @if(count(session('cart', [])) > 0)
                <flux:sidebar.nav variant="outline">
                    <div class="relative inline-flex items-center mr-4">
                        <div class="-top-0.5 absolute left-6 z-10">                     
                                {{ count(session('cart', [])) }}
                            </p>
                        </div>
                        <flux:navlist.item icon="shopping-cart" icon:variant="solid"  :href="route('cart.show')" :current="request()->routeIs('cart.show')" wire:navigate>
                            <span class="pl-2">Shopping Cart</span>
                        </flux:navlist.item>
                    </div>
                </flux:sidebar.nav>
                @endif
            @endcan

            @can('admin')
            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Platform')" class="grid">
                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>
            </flux:sidebar.nav>
            @endcan

            @if(Gate::check('index', \App\Models\TshirtImage::class))
                <flux:sidebar.nav>
                    <flux:sidebar.group heading="Academics" class="grid">
                        @can('index', \App\Models\TshirtImage::class)
                            <flux:sidebar.item icon="academic-cap" :href="route('Tshirt_image.index')" :current="request()->routeIs('Tshirt_image.index')" wire:navigate>
                                Tshirt
                            </flux:sidebar.item>
                        @endcan
                    </flux:sidebar.group>
                </flux:sidebar.nav>
            @endif

            <flux:spacer />

            @auth
                <!-- Desktop User Menu -->
                <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
                
                <!-- Mobile User Menu (inside sidebar) -->
                <div class="lg:hidden border-t border-zinc-200 dark:border-zinc-700 pt-4 mt-4">
                    <div class="flex items-center gap-3 px-2 py-2">
                        <flux:avatar
                            :name="auth()->user()->name"
                            :initials="auth()->user()->initials()"
                            size="md"
                        />
                        <div class="flex-1 text-sm">
                            <div class="font-medium">{{ auth()->user()->name }}</div>
                            <div class="text-zinc-500 dark:text-zinc-400 text-xs">{{ auth()->user()->email }}</div>
                        </div>
                    </div>
                    
                    <div class="mt-2">
                        <flux:navlist.item icon="cog" :href="route('profile.edit')" wire:navigate>
                            {{ __('Settings') }}
                        </flux:navlist.item>
                        
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <flux:navlist.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full text-left">
                                {{ __('Log out') }}
                            </flux:navlist.item>
                        </form>
                    </div>
                </div>
            @else
                <!-- Mobile Login (inside sidebar) -->
                <div class="lg:hidden">
                    <flux:navlist.item icon="user" :href="route('login')" wire:navigate>
                        Login
                    </flux:navlist.item>
                </div>
            @endauth
        </flux:sidebar>

        <!-- Main content area - no duplicate headers needed -->
        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>