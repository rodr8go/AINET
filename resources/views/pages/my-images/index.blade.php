<?php

use function Livewire\Volt\{state};
use App\Models\TshirtImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// Lógica de dados correta integrada no componente
state(['images' => function () {
    $user = Auth::user();
    $customerId = DB::table('customers')->where('id', $user->id)->value('id') ?? $user->id;
    return TshirtImage::where('customer_id', $customerId)->orderBy('id', 'desc')->get();
}]);

?>

<x-layouts.app>
    <div class="space-y-6">
        {{-- 🏷️ Cabeçalho da Página --}}
        <div class="flex items-center justify-between gap-4">
            <div>
                <flux:heading size="xl" level="1">As Minhas Imagens Personalizadas</flux:heading>
                <flux:subheading class="mt-1">Faz a gestão das imagens que enviaste para as tuas t-shirts.</flux:subheading>
            </div>
            
            <div>
                <flux:button icon="plus" variant="primary" class="cursor-pointer">
                    Enviar Nova Imagem
                </flux:button>
            </div>
        </div>

        <flux:separator />

        {{-- 📸 Conteúdo Central: Estado Vazio --}}
        @if($images->isEmpty())
            <div class="flex flex-col items-center justify-center p-16 border border-dashed rounded-2xl border-zinc-200 dark:border-zinc-700 bg-zinc-50/50 dark:bg-zinc-900/50 text-center">
                <div class="p-4 bg-zinc-100 dark:bg-zinc-800 rounded-full mb-4">
                    <flux:icon icon="photo" class="h-8 w-8 text-zinc-500 dark:text-zinc-400" />
                </div>
                <flux:heading size="lg">Ainda não tens imagens</flux:heading>
                <flux:subheading class="max-w-sm mx-auto mt-2 text-zinc-500 dark:text-zinc-400">
                    Envia as tuas próprias estampas e ilustrações para criares t-shirts totalmente personalizadas à tua medida.
                </flux:subheading>
            </div>
        @else
            {{-- 🗂️ Grelha de Imagens --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($images as $image)
                    <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl overflow-hidden bg-white dark:bg-zinc-900 shadow-sm">
                        <img src="{{ asset('storage/my-images/' . $image->path) }}" alt="Custom design" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <flux:text font="medium" class="truncate">{{ $image->name ?? 'Imagem Sem Nome' }}</flux:text>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-layouts.app>