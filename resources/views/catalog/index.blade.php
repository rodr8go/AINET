<x-layouts.app title="Catálogo de T-shirts">
    <div class="py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
        
        <div class="flex flex-col justify-between gap-4 pb-6 border-b border-zinc-200 dark:border-zinc-700 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">Catálogo FunShirt 👕</h1>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Escolha o seu design favorito e personalize a sua t-shirt.</p>
            </div>
            
            <form action="{{ route('catalog.index') }}" method="GET" class="flex gap-2 w-full sm:w-auto">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <flux:input name="search" placeholder="Pesquisar t-shirts..." value="{{ request('search') }}" icon="magnifying-glass" class="w-full sm:w-64" />
                <flux:button type="submit" variant="filled" color="indigo">Buscar</flux:button>
            </form>
        </div>

        <div class="grid grid-cols-1 gap-8 mt-6 lg:grid-cols-4">
            
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-zinc-800 dark:text-zinc-200">Categorias</h3>
                <flux:navlist variant="outline" class="p-2 bg-white rounded-lg border shadow-sm dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700">
                    <flux:navlist.item href="{{ route('catalog.index', request()->only('search')) }}" :current="!request('category')">
                        Todas as Categorias
                    </flux:navlist.item>
                    @foreach($categories as $cat)
                        <flux:navlist.item href="{{ route('catalog.index', ['category' => $cat->id] + request()->only('search')) }}" :current="request('category') == $cat->id">
                            {{ $cat->name }}
                        </flux:navlist.item>
                    @endforeach
                </flux:navlist>
            </div>

            <div class="lg:col-span-3">
                @if($images->isEmpty())
                    <div class="py-12 text-center bg-white rounded-lg border shadow-sm dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700">
                        <flux:icon icon="document-magnifying-glass" class="mx-auto w-12 h-12 text-zinc-400" />
                        <h3 class="mt-2 text-sm font-medium text-zinc-900 dark:text-zinc-100">Nenhuma t-shirt encontrada.</h3>
                    </div>
                @else
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3">
                        @foreach($images as $img)
                            <div class="flex flex-col bg-white rounded-xl border shadow-sm dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700 overflow-hidden">
                                
                                <div class="relative bg-zinc-100 aspect-square dark:bg-zinc-900 flex items-center justify-center p-4">
                                    <img src="{{ asset('storage/tshirt_images/' . $img->image_url) }}" alt="{{ $img->name }}" class="object-contain max-h-full rounded-md shadow-sm">
                                </div>

                                <div class="flex flex-col flex-1 p-4">
                                    <h4 class="text-base font-bold text-zinc-900 dark:text-zinc-100">{{ $img->name }}</h4>
                                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400 line-clamp-2 flex-1">{{ $img->description ?? 'Sem descrição' }}</p>

                                    <form action="{{ route('cart.add', $img->id) }}" method="POST" class="mt-4 pt-4 border-t border-zinc-100 dark:border-zinc-700 space-y-3">
                                        @csrf
                                        <div class="grid grid-cols-2 gap-2">
                                            <div>
                                                <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300">Cor:</label>
                                                <select name="color_code" class="mt-1 block w-full rounded-md text-sm border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900" required>
                                                    @foreach($colors as $color)
                                                        <option value="{{ $color->code }}">{{ $color->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300">Tamanho:</label>
                                                <select name="size" class="mt-1 block w-full rounded-md text-sm border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900" required>
                                                    <option value="XS">XS</option>
                                                    <option value="S">S</option>
                                                    <option value="M" selected>M</option>
                                                    <option value="L">L</option>
                                                    <option value="XL">XL</option>
                                                </select>
                                            </div>
                                        </div>
                                        <input type="hidden" name="qty" value="1">
                                        <flux:button type="submit" variant="filled" color="indigo" icon="shopping-cart" class="w-full mt-2">
                                            Adicionar
                                        </flux:button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-6">
                        {{ $images->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>