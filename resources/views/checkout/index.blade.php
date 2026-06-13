<x-layouts::main-content title="Checkout"
    heading="Finalizar Encomenda 💳"
    subheading="Preencha os seus dados de envio e pagamento para concluir o pedido.">

    <div class="space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            <div class="lg:col-span-2">
                <flux:card class="p-6">
                    <form action="{{ route('checkout.store') }}" method="POST" class="space-y-6">
                        @csrf

                        //Dados do Cliente(pré-preenchidos)
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white border-b pb-2 border-zinc-100 dark:border-zinc-800">
                                Informação do Cliente
                            </h3>
                            
                            <div>
                                <flux:label class="mb-2 block">Nome</flux:label>
                                <input type="text" 
                                       value="{{ Auth::user()->name }}" 
                                       class="w-full border-zinc-200 dark:border-zinc-700 bg-zinc-100 dark:bg-zinc-800 rounded-lg p-2.5 text-sm text-zinc-600 dark:text-zinc-400 cursor-not-allowed"
                                       readonly disabled>
                            </div>

                            <div>
                                <flux:label class="mb-2 block">Email</flux:label>
                                <input type="email" 
                                       value="{{ Auth::user()->email }}" 
                                       class="w-full border-zinc-200 dark:border-zinc-700 bg-zinc-100 dark:bg-zinc-800 rounded-lg p-2.5 text-sm text-zinc-600 dark:text-zinc-400 cursor-not-allowed"
                                       readonly disabled>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white border-b pb-2 border-zinc-100 dark:border-zinc-800">
                                Informação de Envio
                            </h3>
                            
                            <div>
                                <flux:input name="address"
                                    label="Morada de Envio"
                                    placeholder="Ex: Rua das Camisetas, 123, 2400-000 Leiria"
                                    value="{{ old('address', Auth::user()->customer->address ?? '') }}" />
                                @error('address')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <flux:input name="notes"
                                    label="Notas da Encomenda (Opcional)"
                                    placeholder="Ex: Deixar na portaria, observações sobre a t-shirt..."
                                    value="{{ old('notes') }}" />
                            </div>
                        </div>

                        <div class="space-y-4 pt-4">
                            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white border-b pb-2 border-zinc-100 dark:border-zinc-800">
                                Método de Pagamento
                            </h3>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <flux:label class="mb-2 block text-sm">Tipo de Pagamento</flux:label>
                                    <select name="payment_type" 
                                            class="w-full border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 rounded-lg p-2.5 text-sm text-zinc-800 dark:text-zinc-200">
                                        <option value="Visa" {{ old('payment_type', Auth::user()->customer->default_payment_type ?? '') == 'Visa' ? 'selected' : '' }}>Visa</option>
                                        <option value="PayPal" {{ old('payment_type', Auth::user()->customer->default_payment_type ?? '') == 'PayPal' ? 'selected' : '' }}>PayPal</option>
                                        <option value="MB WAY" {{ old('payment_type', Auth::user()->customer->default_payment_type ?? '') == 'MB WAY' ? 'selected' : '' }}>MB WAY</option>
                                    </select>
                                    @error('payment_type')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <flux:input name="payment_ref"
                                        label="Referência / Nº Cartão"
                                        placeholder="Ex: 1234567890123456"
                                        value="{{ old('payment_ref', Auth::user()->customer->default_payment_ref ?? '') }}" />
                                    @error('payment_ref')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <flux:input name="nif"
                                        label="NIF para Faturação"
                                        placeholder="Ex: 999999999"
                                        value="{{ old('nif', Auth::user()->customer->nif ?? '') }}" />
                                    @error('nif')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="pt-4">
                            <flux:button type="submit" variant="filled" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 cursor-pointer">
                                Confirmar e Pagar Encomenda
                            </flux:button>
                        </div>
                    </form>
                </flux:card>
            </div>

            <flux:card class="p-6 space-y-6 bg-zinc-50/50 dark:bg-zinc-900/50">
                <h3 class="text-lg font-bold text-zinc-900 dark:text-white border-b pb-3 border-zinc-100 dark:border-zinc-800">
                    Artigos a Pedir
                </h3>

                <div class="divide-y divide-zinc-100 dark:divide-zinc-800 max-h-60 overflow-y-auto pr-2 space-y-3">
                    @foreach($cart as $item)
                    <div class="flex items-center justify-between pt-3 text-sm">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-zinc-200 rounded flex items-center justify-center text-xs text-zinc-600 font-mono">
                                {{ $item['qty'] }}x
                            </div>
                            <div class="flex flex-col">
                                <span class="font-medium text-zinc-900 dark:text-white">{{ $item['name'] ?? 'T-shirt' }}</span>
                                <span class="text-xs text-zinc-400">Tam: {{ $item['size'] }} | {{ $item['color_name'] ?? 'Cor N/A' }}</span>
                            </div>
                        </div>
                        <span class="font-semibold text-zinc-800 dark:text-zinc-200">
                            {{ number_format(($item['unit_price'] ?? 0) * ($item['qty'] ?? 1), 2, ',', '.') }} €
                        </span>
                    </div>
                    @endforeach
                </div>

                <div class="border-t pt-4 space-y-3 text-sm border-zinc-200 dark:border-zinc-700">
                    <div class="flex justify-between text-zinc-600 dark:text-zinc-400">
                        <span>Subtotal</span>
                        <span class="font-medium text-zinc-900 dark:text-white">{{ number_format($totalPrice, 2, ',', '.') }} €</span>
                    </div>
                    <div class="flex justify-between text-zinc-600 dark:text-zinc-400">
                        <span>Portes</span>
                        <span class="text-green-600 font-medium">Grátis</span>
                    </div>
                    <div class="border-t pt-3 flex justify-between text-base font-bold text-zinc-900 dark:text-white border-zinc-200 dark:border-zinc-700">
                        <span>Total a Pagar</span>
                        <span class="text-blue-600 dark:text-blue-400">{{ number_format($totalPrice, 2, ',', '.') }} €</span>
                    </div>
                </div>
            </flux:card>

        </div>
    </div>
</x-layouts::main-content>