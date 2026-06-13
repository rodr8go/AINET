<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\User;
use App\Models\Customer;
use App\Models\TshirtImage;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //Dashboard
    public function index()
    {
        $user = Auth::user();
        
        //Info geral
        $data = [
            'user' => $user,
            'userType' => $this->getUserTypeLabel($user),
        ];
        
        //Info Especifica
        if ($user->isAdmin()) {
            $data = array_merge($data, $this->getAdminData());
        } elseif ($user->isEmployee()) {
            $data = array_merge($data, $this->getEmployeeData());
        } elseif ($user->isCustomer()) {
            $data = array_merge($data, $this->getCustomerData($user));
        }
        
        return view('dashboard.index', $data);
    }
    
    private function getUserTypeLabel(User $user): string
    {
        if ($user->isAdmin()) return 'Administrator';
        if ($user->isEmployee()) return 'Employee';
        return 'Customer';
    }
    
    private function getAdminData(): array
    {
        //Orders recentes
        $recentOrders = Order::with('customer.user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        //Stats por STATUS
        $orderStats = [
            'pending' => Order::where('status', 'pending')->count(),
            'closed' => Order::where('status', 'closed')->count(),
            'canceled' => Order::where('status', 'canceled')->count(),
        ];
        
        //Vendas totais
        $totalSales = Order::where('status', 'closed')->sum('total_price');
        
        //Vendas mensais
        $salesThisMonth = Order::where('status', 'closed')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('total_price');
        
        //Contador USERS
        $userCounts = [
            'customers' => Customer::count(),
            'employees' => User::where('user_type', 'F')->count(),
            'admins' => User::where('user_type', 'A')->count(),
            'blocked' => User::where('blocked', true)->count(),
        ];
        
        //Stats Catalogo
        $catalogStats = [
            'total_images' => TshirtImage::whereNull('customer_id')->count(),
            'custom_images' => TshirtImage::whereNotNull('customer_id')->count(),
            'categories' => \App\Models\Category::count(),
            'colors' => \App\Models\Color::count(),
        ];
        
        //Vendas mensais para grafico(6meses)
        $monthlySales = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $sales = Order::where('status', 'closed')
                ->whereMonth('date', $month->month)
                ->whereYear('date', $month->year)
                ->sum('total_price');
            
            $monthlySales[] = [
                'month' => $month->format('M Y'),
                'sales' => $sales,
            ];
        }
        
        return [
            'recentOrders' => $recentOrders,
            'orderStats' => $orderStats,
            'totalSales' => $totalSales,
            'salesThisMonth' => $salesThisMonth,
            'userCounts' => $userCounts,
            'catalogStats' => $catalogStats,
            'monthlySales' => $monthlySales,
        ];
    }
    
    private function getEmployeeData(): array
    {
        //Contador Orders PENDENTES
        $pendingOrdersCount = Order::where('status', 'pending')->count();
        
        //Orders PENDENTES
        $pendingOrders = Order::with('customer.user')
            ->where('status', 'pending')
            ->orderBy('date', 'asc')
            ->limit(10)
            ->get();
        
        //Orders fechadas recentemente(7dias)
        $recentClosed = Order::with('customer.user')
            ->where('status', 'closed')
            ->where('date', '>=', now()->subDays(7))
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();
        
        //ORDERS processadas este mes
        $processedThisMonth = Order::where('status', 'closed')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->count();
        
        //ORDERS pendentes de hoje
        $todaysOrders = Order::where('status', 'pending')
            ->whereDate('date', today())
            ->count();
        
        return [
            'pendingOrdersCount' => $pendingOrdersCount,
            'pendingOrders' => $pendingOrders,
            'recentClosed' => $recentClosed,
            'processedThisMonth' => $processedThisMonth,
            'todaysOrders' => $todaysOrders,
        ];
    }
    
    //Obter data clientes
    private function getCustomerData(User $user): array
    {
        $customer = $user->customer;
        
        //ODERS recentes
        $recentOrders = Order::where('customer_id', $customer->id)
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();
        
        //STATS Orders
        $orderStats = [
            'total' => Order::where('customer_id', $customer->id)->count(),
            'pending' => Order::where('customer_id', $customer->id)->where('status', 'pending')->count(),
            'closed' => Order::where('customer_id', $customer->id)->where('status', 'closed')->count(),
            'canceled' => Order::where('customer_id', $customer->id)->where('status', 'canceled')->count(),
        ];
        
        //Total gasto
        $totalSpent = Order::where('customer_id', $customer->id)
            ->where('status', 'closed')
            ->sum('total_price');
        
        //Contador imagens personalizadas
        $customImagesCount = TshirtImage::where('customer_id', $customer->id)->count();
        
        //Ultima ORDER
        $lastOrder = Order::where('customer_id', $customer->id)
            ->orderBy('date', 'desc')
            ->first();
        
        return [
            'customer' => $customer,
            'recentOrders' => $recentOrders,
            'orderStats' => $orderStats,
            'totalSpent' => $totalSpent,
            'customImagesCount' => $customImagesCount,
            'lastOrder' => $lastOrder,
        ];
    }
}