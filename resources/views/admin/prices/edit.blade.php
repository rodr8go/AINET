<x-layouts::main-content title="Configuração de Preços"
                         heading="Tabela de Preços Globais"
                         subheading="Defina os preços base que serão aplicados às t-shirts e estampas do catálogo">

    <div class="max-w-2xl">
        <flux:card class="p-6">
            <form action="{{ route('prices.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <flux:input type="number" 
                                    step="0.01" 
                                    name="unit_price_catalog" 
                                    label="Preço Unitário (Catálogo) (€)" 
                                    placeholder="Ex: 15.00" 
                                    value="{{ old('unit_price_catalog', $prices->unit_price_catalog ?? '') }}" 
                                    required />
                        <flux:text size="sm" class="mt-1 text-zinc-500">
                            Preço aplicado quando o cliente escolhe uma estampa predefinida da loja.
                        </flux:text>
                    </div>

                    <div>
                        <flux:input type="number" 
                                    step="0.01" 
                                    name="unit_price_own" 
                                    label="Preço Unitário (Imagem Própria) (€)" 
                                    placeholder="Ex: 18.50" 
                                    value="{{ old('unit_price_own', $prices->unit_price_own ?? '') }}" 
                                    required />
                        <flux:text size="sm" class="mt-1 text-zinc-500">
                            Preço aplicado quando o cliente faz upload da sua própria imagem personalizada.
                        </flux:text>
                    </div>
                </div>

                <flux:separator />

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <flux:input type="number" 
                                    step="0.01" 
                                    name="unit_price_catalog_discount" 
                                    label="Preço de Catálogo com Desconto (€)" 
                                    placeholder="Ex: 13.00" 
                                    value="{{ old('unit_price_catalog_discount', $prices->unit_price_catalog_discount ?? '') }}" />
                        <flux:text size="sm" class="mt-1 text-zinc-500">
                            Preço unitário do catálogo a partir da quantidade limite.
                        </flux:text>
                    </div>

                    <div>
                        <flux:input type="number" 
                                    step="0.01" 
                                    name="unit_price_own_discount" 
                                    label="Preço Imagem Própria com Desconto (€)" 
                                    placeholder="Ex: 10.00" 
                                    value="{{ old('unit_price_own_discount', $prices->unit_price_own_discount ?? '') }}" />
                        <flux:text size="sm" class="mt-1 text-zinc-500">
                            Preço unitário da imagem própria a partir da quantidade limite.
                        </flux:text>
                    </div>

                    <div>
                        <flux:input type="number" 
                                    name="qty_discount" 
                                    label="Quantidade Mínima para Desconto" 
                                    placeholder="Ex: 5" 
                                    value="{{ old('qty_discount', $prices->qty_discount ?? '') }}" />
                        <flux:text size="sm" class="mt-1 text-zinc-500">
                            Número de t-shirts necessárias para ativar o desconto.
                        </flux:text>
                    </div>
                </div>

                <flux:separator />

                <div class="flex items-center justify-end gap-2">
                    <flux:button type="submit" variant="filled" class="bg-blue-600 hover:bg-blue-700 text-white cursor-pointer">
                        Atualizar Preços Globais
                    </flux:button>
                </div>
            </form>
        </flux:card>
    </div>

</x-layouts::main-content>