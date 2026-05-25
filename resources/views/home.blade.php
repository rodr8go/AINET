<x-layouts.app title="Início">
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg text-center py-16 border border-zinc-200 dark:border-zinc-700">
                <h1 class="text-4xl font-bold text-zinc-900 dark:text-zinc-100">Bem-vindo à FunShirt! 👕</h1>
                <p class="mt-4 text-zinc-600 dark:text-zinc-400">A tua plataforma de t-shirts personalizadas.</p>
                
                <div class="mt-8">
                    <a href="{{ route('catalog.index') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-md font-semibold hover:bg-indigo-700 transition shadow-sm">
                        Ver Catálogo
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>