<div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">

    <div class="mb-8">
        <flux:button href="{{ route('catalog.index') }}" icon="arrow-left" variant="subtle" class="text-zinc-400 hover:text-zinc-200 bg-transparent border-transparent hover:bg-zinc-800/50">
            Voltar ao Catálogo
        </flux:button>
    </div>

    <div class="bg-zinc-900/60 border border-transparent rounded-3xl p-6 lg:p-8 w-full shadow-2xl backdrop-blur-md">
        
        <div class="flex flex-col lg:flex-row items-start justify-between gap-12 lg:gap-24 w-full">

            <div class="shrink-0 mx-auto lg:mx-0" style="width: 400px;">
                <div class="bg-zinc-950/40 rounded-2xl border border-transparent shadow-inner flex items-center justify-center p-8 relative"
                     style="height: 420px;">
                    
                    <div class="relative w-full h-full flex items-center justify-center">
                        <img src="{{ asset('storage/tshirt_base/' . $selectedColor . '.jpg') }}"
                             class="absolute inset-0 w-full h-full object-contain z-10"
                             alt="T-shirt Base">
                        
                        <div class="absolute z-20 flex items-center justify-center"
                             style="top: 22%; left: 30%; width: 40%; height: 40%;">
                            <img src="{{ asset('storage/tshirt_images/' . $tshirt->image_url) }}"
                                 alt="{{ $tshirt->name }}"
                                 class="max-w-full max-h-full object-contain drop-shadow-md">
                        </div>
                    </div>

                    <div wire:loading class="absolute inset-0 bg-zinc-950/80 flex items-center justify-center z-30 rounded-2xl backdrop-blur-xs">
                        <flux:icon icon="arrow-path" class="w-8 h-8 animate-spin text-indigo-500" />
                    </div>
                </div>
            </div>

            <div class="flex-1 w-full space-y-6 pt-2 lg:max-w-xl">

                <div class="space-y-3 pb-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold tracking-wide bg-indigo-600/20 text-indigo-400 border border-indigo-500/30">
                        {{ $tshirt->category?->name ?? 'Música' }}
                    </span>
                    
                    <h1 class="text-4xl font-black tracking-tight text-zinc-100">
                        {{ $tshirt->name }}
                    </h1>
                    
                    <p class="text-sm text-zinc-400 leading-relaxed">
                        {{ $tshirt->description ?? 'Dê vida ao seu estilo com este design exclusivo. Algodão premium de alta durabilidade e estampa com definição reforçada.' }}
                    </p>
                </div>

                <form action="{{ route('cart.add', $tshirt->id) }}" method="POST" class="space-y-6 w-full max-w-md">
                    @csrf

                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-zinc-400">Cor da T-Shirt</label>
                        <select wire:model.live="selectedColor" name="color_code"
                                class="block w-full rounded-xl text-sm font-semibold border border-zinc-800 bg-zinc-800 text-zinc-100 py-3 px-4 focus:ring-2 focus:ring-indigo-500 transition cursor-pointer shadow-md" required>
                            @foreach($colors as $color)
                                <option value="{{ $color->code }}">{{ $color->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2.5">
                        <label class="block text-xs font-bold uppercase tracking-wider text-zinc-400">Tamanho</label>
                        <div class="flex gap-2">
                            @foreach(['XS','S','M','L','XL'] as $size)
                            <label class="relative cursor-pointer select-none">
                                <input type="radio" id="size_{{ $size }}" name="size" value="{{ $size }}" class="sr-only" wire:model.live="selectedSize">
                                <span class="flex items-center justify-center w-12 h-12 rounded-xl border border-zinc-800 text-sm font-bold transition-all duration-150
                                    {{ $selectedSize === $size 
                                        ? 'border-indigo-500 bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' 
                                        : 'bg-zinc-800 text-zinc-300 hover:bg-zinc-700/50' 
                                    }}">
                                    {{ $size }}
                                </span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="space-y-2" x-data="{ count: @entangle('qty').live }">
                        <label class="block text-xs font-bold uppercase tracking-wider text-zinc-400">Quantidade</label>
                        <div class="flex items-center bg-zinc-800 border border-zinc-800 w-fit rounded-xl p-1 shadow-md">
                            <button type="button" @click="if(count > 1) count--" 
                                    class="w-10 h-10 flex items-center justify-center text-zinc-400 hover:text-zinc-100 hover:bg-zinc-700 rounded-lg font-bold transition select-none">
                                -
                            </button>
                            
                            <input type="number" name="qty" x-model="count" min="1" max="10" readonly
                                   class="w-12 text-center bg-transparent border-0 text-zinc-100 font-black focus:ring-0 p-0 text-sm [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                            
                            <button type="button" @click="if(count < 10) count++" 
                                    class="w-10 h-10 flex items-center justify-center text-zinc-400 hover:text-zinc-100 hover:bg-zinc-700 rounded-lg font-bold transition select-none">
                                +
                            </button>
                        </div>
                    </div>

                    <div class="pt-2">
                        <p class="text-xs font-bold tracking-wider uppercase text-zinc-400">Preço unitário:</p>
                        <div class="flex items-baseline gap-3 mt-1">
                            @if($priceRules && $qty >= $priceRules->qty_discount && $priceRules->unit_price_catalog_discount < $priceRules->unit_price_catalog)
                                <p class="text-4xl font-black text-emerald-400 tracking-tight tabular-nums">
                                    {{ number_format($priceRules->unit_price_catalog_discount, 2, ',', '.') }} €
                                </p>
                                <p class="text-base font-semibold text-zinc-500 line-through tabular-nums">
                                    {{ number_format($priceRules->unit_price_catalog, 2, ',', '.') }} €
                                </p>
                            @else
                                <p class="text-4xl font-black text-zinc-100 tracking-tight tabular-nums">
                                    {{ $priceRules ? number_format($priceRules->unit_price_catalog, 2, ',', '.') : '10,00' }} €
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="pt-2">
                        <flux:button type="submit" variant="filled" color="zinc" icon="shopping-cart"
                                     class="w-full bg-white hover:bg-zinc-200 text-zinc-950 font-extrabold text-base py-4 rounded-xl shadow-lg border-transparent transition-all transform active:scale-[0.99] justify-center">
                            Adicionar ao Carrinho
                        </flux:button>
                    </div>
                </form>

            </div>
        </div>
        
    </div>
</div>