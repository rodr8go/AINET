<x-layouts::main-content title="Estatísticas"
                         heading="Painel de Estatísticas"
                         subheading="Análise completa do desempenho da FunShirt">

    {{-- ============================================ --}}
    {{-- CARDS DE RESUMO RÁPIDO --}}
    {{-- ============================================ --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <p class="text-sm text-gray-500">Total de Vendas</p>
            <p class="text-2xl font-bold text-green-600">€{{ number_format($totalVendas ?? 0, 2, ',', '.') }}</p>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <p class="text-sm text-gray-500">Vendas Este Mês</p>
            <p class="text-2xl font-bold text-blue-600">€{{ number_format($vendasEsteMes ?? 0, 2, ',', '.') }}</p>
            @if(isset($crescimentoPercentual) && $crescimentoPercentual != 0)
                <p class="text-xs {{ $crescimentoPercentual > 0 ? 'text-green-500' : 'text-red-500' }} mt-1">
                    {{ $crescimentoPercentual > 0 ? '↑' : '↓' }} {{ number_format(abs($crescimentoPercentual), 1) }}%
                </p>
            @endif
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <p class="text-sm text-gray-500">Ticket Médio</p>
            <p class="text-2xl font-bold text-purple-600">€{{ number_format($ticketMedio ?? 0, 2, ',', '.') }}</p>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <p class="text-sm text-gray-500">Encomendas Pendentes</p>
            <p class="text-2xl font-bold text-orange-600">{{ $estatisticasEncomendas['pendentes'] ?? 0 }}</p>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- GRÁFICO DE VENDAS MENSAIS --}}
    {{-- ============================================ --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-medium mb-4">📈 Evolução Mensal de Vendas</h3>
        @if(empty($vendasMensais))
            <p class="text-gray-500 text-center py-4">Sem dados disponíveis</p>
        @else
            <div class="space-y-3">
                @foreach($vendasMensais as $dados)
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span>{{ $dados['nome_mes'] ?? $dados['mes'] }}</span>
                            <span class="font-semibold">€{{ number_format($dados['vendas'], 2, ',', '.') }}</span>
                        </div>
                        @php
                            $maxVendas = max(array_column($vendasMensais, 'vendas'));
                            $percentagem = $maxVendas > 0 ? ($dados['vendas'] / $maxVendas) * 100 : 0;
                        @endphp
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-indigo-600 h-3 rounded-full transition-all duration-500" style="width: {{ $percentagem }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        
        {{-- ============================================ --}}
        {{-- TOP 5 PRODUTOS MAIS VENDIDOS --}}
        {{-- ============================================ --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-medium mb-4">🏆 Top 5 Estampas Mais Vendidas</h3>
            @if($topProdutos->isEmpty())
                <p class="text-gray-500 text-center py-4">Sem dados disponíveis</p>
            @else
                <div class="space-y-3">
                    @foreach($topProdutos as $produto)
                        <div class="flex justify-between items-center border-b pb-2">
                            <div class="flex-1">
                                <p class="font-medium">{{ $produto->name }}</p>
                            </div>
                            <div class="text-right">
                                <span class="font-semibold text-indigo-600">{{ $produto->quantidade_total }}</span>
                                <span class="text-sm text-gray-500"> unidades</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- ============================================ --}}
        {{-- TOP 5 CATEGORIAS MAIS VENDIDAS --}}
        {{-- ============================================ --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-medium mb-4">📂 Top 5 Categorias Mais Vendidas</h3>
            @if($topCategorias->isEmpty())
                <p class="text-gray-500 text-center py-4">Sem dados disponíveis</p>
            @else
                <div class="space-y-3">
                    @foreach($topCategorias as $categoria)
                        <div class="flex justify-between items-center border-b pb-2">
                            <div class="flex-1">
                                <p class="font-medium">{{ $categoria->name ?? 'Sem Categoria' }}</p>
                            </div>
                            <div class="text-right">
                                <span class="font-semibold text-green-600">{{ $categoria->quantidade_total }}</span>
                                <span class="text-sm text-gray-500"> unidades</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        
        {{-- ============================================ --}}
        {{-- VENDAS POR COR --}}
        {{-- ============================================ --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-medium mb-4">🎨 Cores Mais Vendidas</h3>
            @if($vendasPorCor->isEmpty())
                <p class="text-gray-500 text-center py-4">Sem dados disponíveis</p>
            @else
                <div class="space-y-3">
                    @foreach($vendasPorCor as $cor)
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 rounded-full border" style="background-color: {{ $cor->code }}"></div>
                                <span>{{ $cor->name }}</span>
                            </div>
                            <span class="font-semibold">{{ $cor->quantidade_total }} unidades</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- ============================================ --}}
        {{-- VENDAS POR TAMANHO --}}
        {{-- ============================================ --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-medium mb-4">📏 Tamanhos Mais Vendidos</h3>
            @if($vendasPorTamanho->isEmpty())
                <p class="text-gray-500 text-center py-4">Sem dados disponíveis</p>
            @else
                <div class="flex justify-around items-center py-4">
                    @foreach($vendasPorTamanho as $tamanho)
                        @php
                            $maxQtd = $vendasPorTamanho->max('quantidade_total');
                            $altura = $maxQtd > 0 ? ($tamanho->quantidade_total / $maxQtd) * 100 : 0;
                        @endphp
                        <div class="text-center">
                            <div class="w-12 bg-indigo-100 rounded-t-lg mx-auto" style="height: {{ max(20, $altura) }}px">
                                <div class="bg-indigo-600 w-full rounded-t-lg" style="height: {{ max(4, $altura) }}px"></div>
                            </div>
                            <p class="mt-2 font-bold">{{ $tamanho->size }}</p>
                            <p class="text-xs text-gray-500">{{ $tamanho->quantidade_total }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        {{-- ============================================ --}}
        {{-- CATÁLOGO VS PERSONALIZADAS --}}
        {{-- ============================================ --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-medium mb-4">🖼️ Catálogo vs Imagens Personalizadas</h3>
            <div class="flex justify-around items-center py-6">
                <div class="text-center">
                    <div class="w-24 h-24 rounded-full bg-blue-100 flex items-center justify-center mx-auto mb-2">
                        <span class="text-2xl font-bold text-blue-600">{{ $comparacaoVendas['catalogo'] ?? 0 }}</span>
                    </div>
                    <p class="font-medium">Catálogo</p>
                    <p class="text-sm text-gray-500">unidades vendidas</p>
                </div>
                <div class="text-center">
                    <div class="w-24 h-24 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-2">
                        <span class="text-2xl font-bold text-purple-600">{{ $comparacaoVendas['personalizadas'] ?? 0 }}</span>
                    </div>
                    <p class="font-medium">Personalizadas</p>
                    <p class="text-sm text-gray-500">unidades vendidas</p>
                </div>
            </div>
        </div>

        {{-- ============================================ --}}
        {{-- ESTADO DAS ENCOMENDAS --}}
        {{-- ============================================ --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-medium mb-4">📋 Estado das Encomendas</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span>🟡 Pendentes</span>
                    <span class="font-semibold text-amber-600">{{ $estatisticasEncomendas['pendentes'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span>🟢 Fechadas</span>
                    <span class="font-semibold text-green-600">{{ $estatisticasEncomendas['fechadas'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span>🔴 Canceladas</span>
                    <span class="font-semibold text-red-600">{{ $estatisticasEncomendas['canceladas'] ?? 0 }}</span>
                </div>
                <div class="border-t pt-3 mt-2 flex justify-between items-center">
                    <span class="font-bold">Total de Encomendas</span>
                    <span class="font-bold text-lg">{{ $resumoRapido['total_encomendas'] ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- UTILIZADORES E CATÁLOGO (RODAPÉ) --}}
    {{-- ============================================ --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-medium mb-4">👥 Utilizadores da Plataforma</h3>
            <div class="grid grid-cols-2 gap-3">
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 text-center">
                    <p class="text-2xl font-bold text-blue-600">{{ $estatisticasUtilizadores['clientes'] ?? 0 }}</p>
                    <p class="text-sm text-gray-500">Clientes</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 text-center">
                    <p class="text-2xl font-bold text-green-600">{{ $estatisticasUtilizadores['funcionarios'] ?? 0 }}</p>
                    <p class="text-sm text-gray-500">Funcionários</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 text-center">
                    <p class="text-2xl font-bold text-purple-600">{{ $estatisticasUtilizadores['administradores'] ?? 0 }}</p>
                    <p class="text-sm text-gray-500">Administradores</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 text-center">
                    <p class="text-2xl font-bold text-red-600">{{ $estatisticasUtilizadores['bloqueados'] ?? 0 }}</p>
                    <p class="text-sm text-gray-500">Bloqueados</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-medium mb-4">🏪 Catálogo da Loja</h3>
            <div class="grid grid-cols-2 gap-3">
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 text-center">
                    <p class="text-2xl font-bold text-indigo-600">{{ $estatisticasCatalogo['total_imagens'] ?? 0 }}</p>
                    <p class="text-sm text-gray-500">Imagens Catálogo</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 text-center">
                    <p class="text-2xl font-bold text-pink-600">{{ $estatisticasCatalogo['imagens_personalizadas'] ?? 0 }}</p>
                    <p class="text-sm text-gray-500">Imagens Personalizadas</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 text-center">
                    <p class="text-2xl font-bold text-amber-600">{{ $estatisticasCatalogo['categorias'] ?? 0 }}</p>
                    <p class="text-sm text-gray-500">Categorias</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 text-center">
                    <p class="text-2xl font-bold text-cyan-600">{{ $estatisticasCatalogo['cores'] ?? 0 }}</p>
                    <p class="text-sm text-gray-500">Cores</p>
                </div>
            </div>
        </div>
    </div>

</x-layouts::main-content>