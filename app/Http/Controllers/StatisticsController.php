<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Customer;
use App\Models\OrderItem;
use App\Models\TshirtImage;
use App\Models\Category;
use App\Models\Color;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StatisticsController extends Controller
{
    /**
     * Mostra o painel de estatísticas para o administrador
     */
    public function index(): View
    {
        // ============================================
        // 1. ESTATÍSTICAS DE ENCOMENDAS
        // ============================================
        
        // Contagem de encomendas por estado
        $estatisticasEncomendas = [
            'pendentes' => Order::where('status', 'pending')->count(),
            'fechadas' => Order::where('status', 'closed')->count(),
            'canceladas' => Order::where('status', 'canceled')->count(),
        ];
        
        // Total de vendas (apenas encomendas fechadas)
        $totalVendas = Order::where('status', 'closed')->sum('total_price');
        
        // Vendas deste mês
        $vendasEsteMes = Order::where('status', 'closed')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('total_price');
        
        // Vendas do mês passado (para comparação)
        $vendasMesPassado = Order::where('status', 'closed')
            ->whereMonth('date', now()->subMonth()->month)
            ->whereYear('date', now()->subMonth()->year)
            ->sum('total_price');
        
        // Calcular percentagem de crescimento
        $crescimentoPercentual = 0;
        if ($vendasMesPassado > 0) {
            $crescimentoPercentual = (($vendasEsteMes - $vendasMesPassado) / $vendasMesPassado) * 100;
        }
        
        // ============================================
        // 2. ESTATÍSTICAS DE UTILIZADORES
        // ============================================
        
        $estatisticasUtilizadores = [
            'clientes' => Customer::count(),
            'funcionarios' => User::where('user_type', 'F')->count(),
            'administradores' => User::where('user_type', 'A')->count(),
            'bloqueados' => User::where('blocked', true)->count(),
        ];
        
        // ============================================
        // 3. ESTATÍSTICAS DO CATÁLOGO
        // ============================================
        
        $estatisticasCatalogo = [
            'total_imagens' => TshirtImage::whereNull('customer_id')->count(),
            'imagens_personalizadas' => TshirtImage::whereNotNull('customer_id')->count(),
            'categorias' => Category::count(),
            'cores' => Color::count(),
        ];
        
        // ============================================
        // 4. VENDAS MENSAIS (últimos 6 meses)
        // ============================================
        
        $vendasMensais = [];
        for ($i = 5; $i >= 0; $i--) {
            $mes = now()->subMonths($i);
            $vendas = Order::where('status', 'closed')
                ->whereMonth('date', $mes->month)
                ->whereYear('date', $mes->year)
                ->sum('total_price');
            
            $vendasMensais[] = [
                'mes' => $mes->format('M Y'),
                'vendas' => $vendas,
                'nome_mes' => $mes->translatedFormat('F Y'), // Nome do mês em português
            ];
        }
        
        // ============================================
        // 5. TOP 5 PRODUTOS MAIS VENDIDOS
        // ============================================
        
        $topProdutos = DB::table('order_items')
            ->join('tshirt_images', 'order_items.tshirt_image_id', '=', 'tshirt_images.id')
            ->select(
                'tshirt_images.id',
                'tshirt_images.name',
                DB::raw('SUM(order_items.qty) as quantidade_total')
            )
            ->groupBy('tshirt_images.id', 'tshirt_images.name')
            ->orderBy('quantidade_total', 'desc')
            ->limit(5)
            ->get();
        
        // ============================================
        // 6. TOP 5 CATEGORIAS MAIS VENDIDAS
        // ============================================
        
        $topCategorias = DB::table('order_items')
            ->join('tshirt_images', 'order_items.tshirt_image_id', '=', 'tshirt_images.id')
            ->leftJoin('categories', 'tshirt_images.category_id', '=', 'categories.id')
            ->select(
                'categories.id',
                'categories.name',
                DB::raw('SUM(order_items.qty) as quantidade_total')
            )
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('quantidade_total', 'desc')
            ->limit(5)
            ->get();
        
        // ============================================
        // 7. TICKET MÉDIO (valor médio por encomenda)
        // ============================================
        
        $ticketMedio = Order::where('status', 'closed')->avg('total_price') ?? 0;
        
        // ============================================
        // 8. VENDAS POR COR (tamanhos e cores populares)
        // ============================================
        
        $vendasPorCor = DB::table('order_items')
            ->join('colors', 'order_items.color_code', '=', 'colors.code')
            ->select(
                'colors.code',
                'colors.name',
                DB::raw('SUM(order_items.qty) as quantidade_total')
            )
            ->groupBy('colors.code', 'colors.name')
            ->orderBy('quantidade_total', 'desc')
            ->limit(5)
            ->get();
        
        $vendasPorTamanho = DB::table('order_items')
            ->select('size', DB::raw('SUM(qty) as quantidade_total'))
            ->groupBy('size')
            ->orderBy('quantidade_total', 'desc')
            ->get();
        
        // ============================================
        // 9. VENDAS CATÁLOGO VS PERSONALIZADAS
        // ============================================
        
        $vendasCatalogo = OrderItem::whereHas('tshirtImage', function($q) {
            $q->whereNull('customer_id');
        })->sum('qty');
        
        $vendasPersonalizadas = OrderItem::whereHas('tshirtImage', function($q) {
            $q->whereNotNull('customer_id');
        })->sum('qty');
        
        $comparacaoVendas = [
            'catalogo' => $vendasCatalogo,
            'personalizadas' => $vendasPersonalizadas,
        ];
        
        // ============================================
        // 10. VENDAS DIÁRIAS (últimos 30 dias)
        // ============================================
        
        $vendasDiarias = DB::table('orders')
            ->where('status', 'closed')
            ->where('date', '>=', now()->subDays(30))
            ->select(DB::raw('DATE(date) as dia'), DB::raw('SUM(total_price) as total'))
            ->groupBy('dia')
            ->orderBy('dia', 'asc')
            ->get();
        
        // ============================================
        // 11. RESUMO RÁPIDO PARA O TOPO DO DASHBOARD
        // ============================================
        
        $resumoRapido = [
            'total_encomendas' => Order::count(),
            'total_encomendas_fechadas' => Order::where('status', 'closed')->count(),
            'valor_medio_encomenda' => $ticketMedio,
            'produto_mais_vendido' => $topProdutos->first()?->name ?? 'Nenhum',
        ];
        
        // ============================================
        // RETORNAR A VISTA COM TODOS OS DADOS
        // ============================================
        
        return view('admin.statistics.index', compact(
            'estatisticasEncomendas',
            'totalVendas',
            'vendasEsteMes',
            'vendasMesPassado',
            'crescimentoPercentual',
            'estatisticasUtilizadores',
            'estatisticasCatalogo',
            'vendasMensais',
            'topProdutos',
            'topCategorias',
            'ticketMedio',
            'vendasPorCor',
            'vendasPorTamanho',
            'comparacaoVendas',
            'vendasDiarias',
            'resumoRapido'
        ));
    }
}
