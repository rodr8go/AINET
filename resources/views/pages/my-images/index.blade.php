<x-layouts::main-content title="My Custom Images"
                         heading="As Minhas Imagens Personalizadas"
                         subheading="Faça a gestão das imagens que enviou para as suas t-shirts">
    
    <div class="py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
        
        {{-- 🏷️ Cabeçalho com o Título e o Botão de Upload sempre visível --}}
        <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-700 pb-4">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">As Minhas Imagens 📸</h1>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Envie e gira as suas estampas exclusivas para aplicar nas t-shirts.</p>
            </div>
            <div>
                {{-- 🚀 O BOTÃO DE UPLOAD REASTRUTURADO AQUI NO TOPO --}}
                <flux:button href="{{ route('my-images.create') }}" variant="filled" color="indigo" icon="plus" class="cursor-pointer">
                    Enviar Nova Imagem
                </flux:button>
            </div>
        </div>

        {{-- 📸 ESTADO VAZIO (Se o cliente não tiver imagens na tabela) --}}
        @if($images->isEmpty())
            <div class="py-16 mt-6 text-center bg-white rounded-xl border shadow-sm dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700">
                <flux:icon icon="photo" class="mx-auto w-16 h-16 text-zinc-300 dark:text-zinc-600" />
                <h2 class="mt-4 text-xl font-semibold text-zinc-900 dark:text-zinc-100">Ainda não tem imagens personalizadas</h2>
                <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">Gostava de uma estampa única? Envie o seu primeiro ficheiro.</p>
            </div>
        @else
            {{-- 🗂️ GRELHA DE IMAGENS (Se o cliente já tiver dados) --}}
            <div class="grid grid-cols-1 gap-6 mt-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @foreach($images as $image)
                    <div class="overflow-hidden bg-white rounded-xl border shadow-sm dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700 flex flex-col justify-between">
                        
                        {{-- 🔄 Substitui o asset antigo por esta rota privada que criámos agora --}}
                        <div class="p-4 bg-zinc-50 dark:bg-zinc-900/50 flex items-center justify-center h-48 border-b border-zinc-100 dark:border-zinc-700">
                            <img src="{{ route('my-images.show-image', $image->id) }}" alt="{{ $image->name }}" class="max-h-full max-w-full object-contain">
                        </div>

                        {{-- Detalhes e Formulário de Compra --}}
                        <div class="p-4 space-y-4">
                            <span class="font-bold text-sm text-zinc-900 dark:text-zinc-100 truncate block">
                                {{ $image->name ?? 'Imagem Sem Nome' }}
                            </span>
                            
                            {{-- 🛒 Form adaptado para o CartController original --}}
                            <form action="{{ route('cart.add', $image->id) }}" method="POST" class="space-y-3 border-t border-zinc-100 dark:border-zinc-700 pt-3">
                                @csrf
                                
                                {{-- Envia a Quantidade obrigatória (qty) --}}
                                <input type="hidden" name="qty" value="1">

                                <div class="grid grid-cols-2 gap-2">
                                    {{-- Seleção do Tamanho (size) --}}
                                    <div>
                                        <label class="block text-[10px] font-medium uppercase tracking-wider text-zinc-400">Tamanho</label>
                                        <select name="size" required class="mt-1 block w-full rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-xs px-2 py-1 text-zinc-900 dark:text-zinc-100 focus:outline-none">
                                            <option value="S">S</option>
                                            <option value="M" selected>M</option>
                                            <option value="L">L</option>
                                            <option value="XL">XL</option>
                                        </select>
                                    </div>

                                    {{-- Seleção da Cor pelo Code (color_code) --}}
                                    <div>
                                        <label class="block text-[10px] font-medium uppercase tracking-wider text-zinc-400">Cor</label>
                                        <select name="color_code" required class="mt-1 block w-full rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-xs px-2 py-1 text-zinc-900 dark:text-zinc-100 focus:outline-none">
                                            <option value="1e1e21">Preto</option>
                                            <option value="e7e0ee">Branco sujo</option>
                                            <option value="284d9d">Azul</option>
                                            <option value="73336a">Roxo</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Botões de Ação --}}
                                <div class="flex items-center gap-2 pt-1">
                                    <flux:button type="submit" variant="filled" color="indigo" icon="shopping-cart" size="sm" class="flex-1 cursor-pointer">
                                        Meter no Carrinho
                                    </flux:button>
                                    
                                    <flux:button href="#" onclick="if(confirm('Deseja apagar esta imagem?')) { document.getElementById('delete-form-{{ $image->id }}').submit(); } return false;" variant="ghost" color="red" icon="trash" size="sm" square />
                                </div>
                            </form>

                            {{-- Form oculto para apagar --}}
                            <form id="delete-form-{{ $image->id }}" action="{{ route('my-images.destroy', $image->id) }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </div>

</x-layouts::main-content>