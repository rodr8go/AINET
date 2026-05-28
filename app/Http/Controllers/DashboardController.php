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
    /**
     * Show dashboard - adapts to user type
     */
    public function index()
    {
        $user = Auth::user();
        
        // Common data for all users
        $data = [
            'user' => $user,
            'userType' => $this->getUserTypeLabel($user),
        ];
        
        // Add role-specific data
        if ($user->isAdmin()) {
            $data = array_merge($data, $this->getAdminData());
        } elseif ($user->isEmployee()) {
            $data = array_merge($data, $this->getEmployeeData());
        } elseif ($user->isCustomer()) {
            $data = array_merge($data, $this->getCustomerData($user));
        }
        
        return view('dashboard.index', $data);
    }
    
    /**
     * Get user type label for display
     */
    private function getUserTypeLabel(User $user): string
    {
        if ($user->isAdmin()) return 'Administrator';
        if ($user->isEmployee()) return 'Employee';
        return 'Customer';
    }
    
    /**
     * Get admin-specific dashboard data
     */
    private function getAdminData(): array
    {
        // Recent orders (last 10)
        $recentOrders = Order::with('customer.user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Order statistics by status
        $orderStats = [
            'pending' => Order::where('status', 'pending')->count(),
            'closed' => Order::where('status', 'closed')->count(),
            'canceled' => Order::where('status', 'canceled')->count(),
        ];
        
        // Total sales (closed orders only)
        $totalSales = Order::where('status', 'closed')->sum('total_price');
        
        // Sales this month
        $salesThisMonth = Order::where('status', 'closed')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('total_price');
        
        // User counts
        $userCounts = [
            'customers' => Customer::count(),
            'employees' => User::where('user_type', 'F')->count(),
            'admins' => User::where('user_type', 'A')->count(),
            'blocked' => User::where('blocked', true)->count(),
        ];
        
        // Catalog statistics
        $catalogStats = [
            'total_images' => TshirtImage::whereNull('customer_id')->count(),
            'custom_images' => TshirtImage::whereNotNull('customer_id')->count(),
            'categories' => \App\Models\Category::count(),
            'colors' => \App\Models\Color::count(),
        ];
        
        // Monthly sales for chart (last 6 months)
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
    
    /**
     * Get employee-specific dashboard data
     */
    private function getEmployeeData(): array
    {
        // Pending orders count
        $pendingOrdersCount = Order::where('status', 'pending')->count();
        
        // Pending orders (for processing)
        $pendingOrders = Order::with('customer.user')
            ->where('status', 'pending')
            ->orderBy('date', 'asc')
            ->limit(10)
            ->get();
        
        // Recent closed orders (last 7 days)
        $recentClosed = Order::with('customer.user')
            ->where('status', 'closed')
            ->where('date', '>=', now()->subDays(7))
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();
        
        // Orders processed this month
        $processedThisMonth = Order::where('status', 'closed')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->count();
        
        // Today's orders (pending)
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
    
    /**
     * Get customer-specific dashboard data
     */
    private function getCustomerData(User $user): array
    {
        $customer = $user->customer;
        
        // Recent orders (last 5)
        $recentOrders = Order::where('customer_id', $customer->id)
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();
        
        // Order statistics
        $orderStats = [
            'total' => Order::where('customer_id', $customer->id)->count(),
            'pending' => Order::where('customer_id', $customer->id)->where('status', 'pending')->count(),
            'closed' => Order::where('customer_id', $customer->id)->where('status', 'closed')->count(),
            'canceled' => Order::where('customer_id', $customer->id)->where('status', 'canceled')->count(),
        ];
        
        // Total spent
        $totalSpent = Order::where('customer_id', $customer->id)
            ->where('status', 'closed')
            ->sum('total_price');
        
        // Custom images count
        $customImagesCount = TshirtImage::where('customer_id', $customer->id)->count();
        
        // Last order
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